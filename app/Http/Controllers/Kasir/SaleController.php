<?php

namespace App\Http\Controllers\Kasir;

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

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::where('user_id', auth()->id())
            ->with('customer')
            ->latest()
            ->paginate(15);
        
        return view('kasir.sales.index', compact('sales'));
    }

    public function create()
    {
        $items = Item::where('stock', '>', 0)->get();
        $customers = Customer::all();
        $promotions = Promotion::where('is_active', true)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->get();
        
        return view('kasir.sales.create', compact('items', 'customers', 'promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'promotion_code' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'cash_paid' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $taxRate = $request->tax_rate ?? 0; // Default 0% pajak
            $promotion = null;
            $discountAmount = 0;

            // Hitung subtotal dulu
            foreach ($request->items as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                
                // Check stock
                if ($item->stock < $itemData['quantity']) {
                    throw new \Exception("Stok {$item->name} tidak mencukupi! Tersedia: {$item->stock}");
                }

                $subtotal += $item->price * $itemData['quantity'];
            }

            // Cek promo/voucher jika ada
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
                } else {
                    throw new \Exception("Kode promo tidak ditemukan!");
                }
            }

            // Hitung pajak dan total
            $taxAmount = ($subtotal - $discountAmount) * ($taxRate / 100);
            $totalAmount = $subtotal - $discountAmount + $taxAmount;
            $changeAmount = $request->cash_paid - $totalAmount;

            if ($changeAmount < 0) {
                throw new \Exception("Uang yang dibayarkan kurang! Total: Rp " . number_format($totalAmount, 0, ',', '.'));
            }

            // Create sale
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'promotion_id' => $promotion ? $promotion->id : null,
                'total_amount' => $totalAmount,
                'cash_paid' => $request->cash_paid,
                'change_amount' => $changeAmount
            ]);

            // Process items dan kurangi stok
            foreach ($request->items as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                
                $itemSubtotal = $item->price * $itemData['quantity'];

                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $item->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $item->price,
                    'subtotal' => $itemSubtotal
                ]);

                // Update stock OTOMATIS
                $item->decrement('stock', $itemData['quantity']);

                // Cek stok rendah (< 5) -> kirim notifikasi ke admin
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

            // Jika pakai voucher, simpan penggunaannya
            if ($promotion) {
                VoucherUsage::create([
                    'promotion_id' => $promotion->id,
                    'user_id' => auth()->id(), // User yang login (kasir)
                    'sale_id' => $sale->id,
                    'discount_amount' => $discountAmount
                ]);
                
                $promotion->incrementUsage();
            }

            // Kirim notifikasi ke ADMIN tentang transaksi baru
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'transaction',
                    'title' => 'Transaksi Baru',
                    'message' => 'Transaksi #' . $sale->id . ' sebesar Rp ' . number_format($totalAmount, 0, ',', '.') . ' oleh ' . auth()->user()->name,
                    'data' => json_encode([
                        'sale_id' => $sale->id,
                        'total' => $totalAmount,
                        'kasir' => auth()->user()->name,
                        'time' => now()->format('d/m/Y H:i')
                    ])
                ]);
            }

            // Log aktivitas
            ActivityLog::logActivity(
                'create',
                'Sale',
                $sale->id,
                'Transaksi baru sebesar Rp ' . number_format($totalAmount, 0, ',', '.'),
                null,
                $sale->toArray()
            );

            DB::commit();

            return redirect()->route('kasir.sales.show', $sale->id)
                ->with('success', 'Transaksi berhasil! Total: Rp ' . number_format($totalAmount, 0, ',', '.') . ' | Kembalian: Rp ' . number_format($changeAmount, 0, ',', '.'));
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $sale = Sale::with(['saleItems.item', 'customer', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('kasir.sales.show', compact('sale'));
    }

    public function getItemPrice($id)
    {
        $item = Item::findOrFail($id);
        return response()->json([
            'price' => $item->price,
            'stock' => $item->stock,
            'name' => $item->name
        ]);
    }
}
