<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SalesReportExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $customerId = $request->input('customer_id');
        $itemId = $request->input('item_id');
        $categoryId = $request->input('category_id');

        // Query dasar untuk sales
        $salesQuery = Sale::whereBetween('created_at', [$startDate, $endDate]);

        // Filter by customer
        if ($customerId) {
            $salesQuery->where('customer_id', $customerId);
        }

        // Filter by item
        if ($itemId) {
            $salesQuery->whereHas('saleItems', function($query) use ($itemId) {
                $query->where('item_id', $itemId);
            });
        }

        // Filter by category
        if ($categoryId) {
            $salesQuery->whereHas('saleItems.item', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        // Total penjualan dalam periode dengan filter
        $totalSales = (clone $salesQuery)->sum('total_amount');

        // Jumlah transaksi dengan filter
        $totalTransactions = (clone $salesQuery)->count();

        // Barang terlaris dengan filter
        $topItemsQuery = SaleItem::select('item_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('sale', function($query) use ($startDate, $endDate, $customerId, $itemId, $categoryId) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                }
                if ($itemId) {
                    $query->whereHas('saleItems', function($q) use ($itemId) {
                        $q->where('item_id', $itemId);
                    });
                }
                if ($categoryId) {
                    $query->whereHas('saleItems.item', function($q) use ($categoryId) {
                        $q->where('category_id', $categoryId);
                    });
                }
            })
            ->with('item');

        if ($itemId) {
            $topItemsQuery->where('item_id', $itemId);
        }

        if ($categoryId) {
            $topItemsQuery->whereHas('item', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $topItems = $topItemsQuery->groupBy('item_id')
            ->orderBy('total_qty', 'desc')
            ->take(10)
            ->get();

        // Kasir dengan penjualan terbanyak
        $topCashiers = Sale::select('user_id', DB::raw('COUNT(*) as total_transactions'), DB::raw('SUM(total_amount) as total_sales'))
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($customerId) {
            $topCashiers->where('customer_id', $customerId);
        }

        if ($itemId) {
            $topCashiers->whereHas('saleItems', function($query) use ($itemId) {
                $query->where('item_id', $itemId);
            });
        }

        if ($categoryId) {
            $topCashiers->whereHas('saleItems.item', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $topCashiers = $topCashiers->with('user')
            ->groupBy('user_id')
            ->orderBy('total_sales', 'desc')
            ->take(10)
            ->get();

        // Penjualan per hari
        $dailySales = Sale::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($customerId) {
            $dailySales->where('customer_id', $customerId);
        }

        if ($itemId) {
            $dailySales->whereHas('saleItems', function($query) use ($itemId) {
                $query->where('item_id', $itemId);
            });
        }

        if ($categoryId) {
            $dailySales->whereHas('saleItems.item', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $dailySales = $dailySales->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Data untuk dropdown filter
        $customers = Customer::orderBy('name')->get();
        $items = Item::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.reports.index', compact(
            'totalSales', 
            'totalTransactions', 
            'topItems', 
            'topCashiers', 
            'dailySales',
            'startDate',
            'endDate',
            'customers',
            'items',
            'categories',
            'customerId',
            'itemId',
            'categoryId'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $customerId = $request->input('customer_id');
        $itemId = $request->input('item_id');
        $categoryId = $request->input('category_id');

        $fileName = 'laporan-penjualan-' . $startDate . '-to-' . $endDate . '.xlsx';

        return Excel::download(new SalesReportExport($startDate, $endDate, $customerId, $itemId, $categoryId), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $customerId = $request->input('customer_id');
        $itemId = $request->input('item_id');
        $categoryId = $request->input('category_id');

        // Query dengan filter
        $salesQuery = Sale::whereBetween('created_at', [$startDate, $endDate]);

        if ($customerId) {
            $salesQuery->where('customer_id', $customerId);
        }

        if ($itemId) {
            $salesQuery->whereHas('saleItems', function($query) use ($itemId) {
                $query->where('item_id', $itemId);
            });
        }

        if ($categoryId) {
            $salesQuery->whereHas('saleItems.item', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        // Get data
        $totalSales = (clone $salesQuery)->sum('total_amount');
        $totalTransactions = (clone $salesQuery)->count();
        
        $sales = (clone $salesQuery)
            ->with(['user', 'customer', 'saleItems.item'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $topItems = SaleItem::select('item_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('sale', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('item')
            ->groupBy('item_id')
            ->orderBy('total_qty', 'desc')
            ->take(10)
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'sales', 
            'totalSales', 
            'totalTransactions', 
            'topItems',
            'startDate',
            'endDate'
        ));

        $fileName = 'laporan-penjualan-' . $startDate . '-to-' . $endDate . '.pdf';

        return $pdf->download($fileName);
    }
}

