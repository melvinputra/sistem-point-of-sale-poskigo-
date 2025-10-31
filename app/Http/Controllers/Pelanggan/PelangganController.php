<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function dashboard()
    {
        // Get customer linked to user email or phone
        $customer = Customer::where('phone', auth()->user()->email)
            ->orWhere('phone', auth()->user()->phone ?? '')
            ->orWhere('name', auth()->user()->name)
            ->first();

        $recentTransactions = [];
        if ($customer) {
            $recentTransactions = Sale::where('customer_id', $customer->id)
                ->with(['saleItems.item', 'user'])
                ->latest()
                ->take(10)
                ->get();
        }

        return view('pelanggan.dashboard', compact('recentTransactions'));
    }

    public function transactions()
    {
        // Get customer linked to user
        $customer = Customer::where('phone', auth()->user()->email)
            ->orWhere('phone', auth()->user()->phone ?? '')
            ->orWhere('name', auth()->user()->name)
            ->first();

        $transactions = [];
        if ($customer) {
            $transactions = Sale::where('customer_id', $customer->id)
                ->with(['saleItems.item', 'user'])
                ->latest()
                ->paginate(15);
        }

        return view('pelanggan.transactions', compact('transactions', 'customer'));
    }

    public function shop()
    {
        $items = Item::where('stock', '>', 0)->paginate(12);
        return view('pelanggan.shop', compact('items'));
    }
}
