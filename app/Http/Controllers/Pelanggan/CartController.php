<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Promotion;
use App\Models\VoucherUsage;
use App\Models\Notification;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $itemId => $quantity) {
            $item = Item::find($itemId);
            if ($item) {
                $cartItems[] = [
                    'item' => $item,
                    'quantity' => $quantity,
                    'subtotal' => $item->price * $quantity
                ];
                $subtotal += $item->price * $quantity;
            }
        }

        $promotions = Promotion::where('is_active', true)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->get();

        return view('pelanggan.cart', compact('cartItems', 'subtotal', 'promotions'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = Item::findOrFail($request->item_id);

        // Check stock
        if ($item->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi! Tersedia: ' . $item->stock);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$request->item_id])) {
            $newQuantity = $cart[$request->item_id] + $request->quantity;
            if ($newQuantity > $item->stock) {
                return back()->with('error', 'Stok tidak mencukupi! Tersedia: ' . $item->stock);
            }
            $cart[$request->item_id] = $newQuantity;
        } else {
            $cart[$request->item_id] = $request->quantity;
        }

        Session::put('cart', $cart);

        return back()->with('success', $item->name . ' berhasil ditambahkan ke keranjang!');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $item = Item::findOrFail($request->item_id);
        $cart = Session::get('cart', []);

        if ($request->quantity == 0) {
            unset($cart[$request->item_id]);
        } else {
            if ($request->quantity > $item->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi! Tersedia: ' . $item->stock
                ]);
            }
            $cart[$request->item_id] = $request->quantity;
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate!'
        ]);
    }

    public function removeFromCart($itemId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);
            return back()->with('success', 'Item berhasil dihapus dari keranjang!');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang!');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'promotion_code' => 'nullable|string',
            'payment_method' => 'required|in:cash,wallet'
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $items = [];

            // Validate stock and calculate subtotal
            foreach ($cart as $itemId => $quantity) {
                $item = Item::findOrFail($itemId);
                
                if ($item->stock < $quantity) {
                    throw new \Exception("Stok {$item->name} tidak mencukupi! Tersedia: {$item->stock}");
                }

                $items[] = [
                    'item' => $item,
                    'quantity' => $quantity
                ];
                $subtotal += $item->price * $quantity;
            }

            // Check promo
            $promotion = null;
            $discountAmount = 0;

            if ($request->promotion_code) {
                $promotion = Promotion::where('code', $request->promotion_code)
                    ->where('is_active', true)
                    ->whereDate('valid_from', '<=', now())
                    ->whereDate('valid_until', '>=', now())
                    ->first();

                if ($promotion) {
                    if (!$promotion->isValid()) {
                        throw new \Exception("Kode promo tidak valid atau sudah habis!");
                    }
                    
                    if ($subtotal < $promotion->min_purchase) {
                        throw new \Exception("Minimal pembelian untuk promo ini: Rp " . number_format($promotion->min_purchase, 0, ',', '.'));
                    }

                    $discountAmount = $promotion->calculateDiscount($subtotal);
                }
            }

            // Tax 10%
            $taxRate = 10;
            $taxAmount = ($subtotal - $discountAmount) * ($taxRate / 100);
            $totalAmount = $subtotal - $discountAmount + $taxAmount;

            // Get or create customer
            $customer = Customer::where('phone', auth()->user()->email)
                ->orWhere('name', auth()->user()->name)
                ->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => auth()->user()->name,
                    'phone' => auth()->user()->email,
                    'address' => '-'
                ]);
            }

            // Generate pickup code
            $pickupCode = 'PKG-' . now()->format('Ymd') . '-' . str_pad(Sale::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

            // Create sale (user_id adalah pelanggan yang checkout sendiri)
            $sale = Sale::create([
                'user_id' => auth()->id(), // Pelanggan checkout sendiri
                'customer_id' => $customer->id,
                'pickup_code' => $pickupCode,
                'order_type' => 'online',
                'order_status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'promotion_id' => $promotion ? $promotion->id : null,
                'total_amount' => $totalAmount,
                'cash_paid' => $totalAmount, // Diasumsikan sudah bayar penuh
                'change_amount' => 0
            ]);

            // Create sale items and update stock
            foreach ($items as $itemData) {
                $item = $itemData['item'];
                $quantity = $itemData['quantity'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $quantity
                ]);

                // Update stock
                $item->decrement('stock', $quantity);

                // Cek stok rendah
                if ($item->stock < 5) {
                    $admins = User::where('role', 'admin')->get();
                    foreach ($admins as $admin) {
                        Notification::create([
                            'user_id' => $admin->id,
                            'type' => 'stock_alert',
                            'title' => 'Stok Rendah!',
                            'message' => "Stok {$item->name} tinggal {$item->stock}. Segera isi ulang!",
                            'data' => json_encode(['item_id' => $item->id, 'stock' => $item->stock])
                        ]);
                    }
                }
            }

            // Voucher usage
            if ($promotion) {
                VoucherUsage::create([
                    'promotion_id' => $promotion->id,
                    'user_id' => $customer->id,
                    'sale_id' => $sale->id,
                    'discount_amount' => $discountAmount
                ]);
                
                $promotion->incrementUsage();
            }

            // Notification to admin and kasir
            $staffs = User::whereIn('role', ['admin', 'kasir'])->get();
            foreach ($staffs as $staff) {
                Notification::create([
                    'user_id' => $staff->id,
                    'type' => 'online_order',
                    'title' => 'Pesanan Online Baru',
                    'message' => 'Pesanan online ' . $pickupCode . ' sebesar Rp ' . number_format($totalAmount, 0, ',', '.') . ' oleh ' . auth()->user()->name,
                    'data' => json_encode([
                        'sale_id' => $sale->id,
                        'pickup_code' => $pickupCode,
                        'total' => $totalAmount,
                        'customer' => auth()->user()->name,
                        'time' => now()->format('d/m/Y H:i')
                    ])
                ]);
            }

            // Clear cart
            Session::forget('cart');

            DB::commit();

            return redirect()->route('pelanggan.order.confirmation', $sale->id)
                ->with('success', 'Checkout berhasil! Kode pickup: ' . $pickupCode);
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
