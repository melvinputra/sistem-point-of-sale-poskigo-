<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard()
    {
        // Penjualan hari ini oleh kasir ini
        $todaySales = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->sum('total_amount');
        
        // Jumlah transaksi hari ini oleh kasir ini
        $todayTransactions = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->count();

        // Penjualan bulan ini oleh kasir ini
        $monthlySales = Sale::where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Total transaksi bulan ini oleh kasir ini
        $monthlyTransactions = Sale::where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Riwayat transaksi terbaru
        $recentSales = Sale::where('user_id', auth()->id())
            ->with('customer')
            ->latest()
            ->take(10)
            ->get();

        // Item terlaris hari ini oleh kasir ini
        $topItems = SaleItem::select('item_id', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('sale', function($query) {
                $query->where('user_id', auth()->id())
                    ->whereDate('created_at', today());
            })
            ->with('item.category')
            ->groupBy('item_id')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact(
            'todaySales', 
            'todayTransactions', 
            'monthlySales',
            'monthlyTransactions',
            'recentSales',
            'topItems'
        ));
    }

    public function reports(Request $request)
    {
        $date = $request->input('date', today()->toDateString());
        
        // Total penjualan kasir di tanggal tertentu
        $totalSales = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', $date)
            ->sum('total_amount');
        
        // Jumlah transaksi
        $totalTransactions = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', $date)
            ->count();

        // Detail transaksi
        $sales = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', $date)
            ->with(['customer', 'saleItems.item'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Barang terlaris hari ini
        $topItems = SaleItem::select('item_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('sale', function($query) use ($date) {
                $query->where('user_id', auth()->id())
                    ->whereDate('created_at', $date);
            })
            ->with('item')
            ->groupBy('item_id')
            ->orderBy('total_qty', 'desc')
            ->take(10)
            ->get();

        // Total Cash, Discount, Tax
        $totalCash = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', $date)
            ->sum('cash_paid');

        $totalDiscount = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', $date)
            ->sum('discount_amount');

        $totalTax = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', $date)
            ->sum('tax_amount');

        return view('kasir.reports', compact(
            'date',
            'totalSales',
            'totalTransactions',
            'sales',
            'topItems',
            'totalCash',
            'totalDiscount',
            'totalTax'
        ));
    }
}
