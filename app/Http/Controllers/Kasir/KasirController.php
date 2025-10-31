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
        $todaySales = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->sum('total_amount');
        
        $todayTransactions = Sale::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->count();

        $recentSales = Sale::where('user_id', auth()->id())
            ->with('customer')
            ->latest()
            ->take(10)
            ->get();

        return view('kasir.dashboard', compact('todaySales', 'todayTransactions', 'recentSales'));
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
