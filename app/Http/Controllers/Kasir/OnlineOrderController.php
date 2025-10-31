<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Sale::with(['customer', 'user', 'saleItems.item'])
            ->where('order_type', 'online');

        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->latest()->paginate(20);

        // Count by status for badges
        $counts = [
            'pending' => Sale::where('order_type', 'online')->where('order_status', 'pending')->count(),
            'ready' => Sale::where('order_type', 'online')->where('order_status', 'ready')->count(),
            'completed' => Sale::where('order_type', 'online')->where('order_status', 'completed')->count(),
        ];

        return view('kasir.online-orders.index', compact('orders', 'status', 'counts'));
    }

    public function show($id)
    {
        $order = Sale::with(['customer', 'user', 'saleItems.item.category', 'promotion'])
            ->where('order_type', 'online')
            ->findOrFail($id);

        return view('kasir.online-orders.show', compact('order'));
    }

    public function verify()
    {
        return view('kasir.online-orders.verify');
    }

    public function searchByCode(Request $request)
    {
        $request->validate([
            'pickup_code' => 'required|string'
        ]);

        $order = Sale::with(['customer', 'user', 'saleItems.item.category'])
            ->where('pickup_code', strtoupper($request->pickup_code))
            ->where('order_type', 'online')
            ->first();

        if (!$order) {
            return back()->with('error', 'Kode pickup tidak ditemukan!');
        }

        return redirect()->route('kasir.online-orders.show', $order->id);
    }

    public function prepare($id)
    {
        $order = Sale::where('order_type', 'online')
            ->where('order_status', 'pending')
            ->findOrFail($id);

        $order->update([
            'order_status' => 'ready',
            'prepared_at' => now()
        ]);

        // Notify customer
        if ($order->user) {
            Notification::create([
                'user_id' => $order->user->id,
                'type' => 'order_ready',
                'title' => 'Pesanan Siap Diambil!',
                'message' => 'Pesanan Anda dengan kode ' . $order->pickup_code . ' sudah siap diambil di toko.',
                'data' => json_encode([
                    'sale_id' => $order->id,
                    'pickup_code' => $order->pickup_code
                ])
            ]);
        }

        return back()->with('success', 'Pesanan berhasil disiapkan! Status: Siap Diambil');
    }

    public function complete($id)
    {
        $order = Sale::where('order_type', 'online')
            ->where('order_status', 'ready')
            ->findOrFail($id);

        $order->update([
            'order_status' => 'completed',
            'completed_at' => now()
        ]);

        // Notify customer
        if ($order->user) {
            Notification::create([
                'user_id' => $order->user->id,
                'type' => 'order_completed',
                'title' => 'Pesanan Selesai',
                'message' => 'Pesanan Anda dengan kode ' . $order->pickup_code . ' telah diserahkan. Terima kasih!',
                'data' => json_encode([
                    'sale_id' => $order->id,
                    'pickup_code' => $order->pickup_code
                ])
            ]);
        }

        return redirect()->route('kasir.online-orders.show', $order->id)
            ->with('success', 'Pesanan berhasil diserahkan ke pelanggan!');
    }

    public function cancel($id, Request $request)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $order = Sale::where('order_type', 'online')
                ->whereIn('order_status', ['pending', 'ready'])
                ->findOrFail($id);

            // Restore stock
            foreach ($order->saleItems as $saleItem) {
                $saleItem->item->increment('stock', $saleItem->quantity);
            }

            $order->update([
                'order_status' => 'cancelled'
            ]);

            // Notify customer
            if ($order->user) {
                Notification::create([
                    'user_id' => $order->user->id,
                    'type' => 'order_cancelled',
                    'title' => 'Pesanan Dibatalkan',
                    'message' => 'Pesanan Anda dengan kode ' . $order->pickup_code . ' telah dibatalkan. Alasan: ' . $request->cancel_reason,
                    'data' => json_encode([
                        'sale_id' => $order->id,
                        'pickup_code' => $order->pickup_code,
                        'reason' => $request->cancel_reason
                    ])
                ]);
            }

            DB::commit();
            return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }
}
