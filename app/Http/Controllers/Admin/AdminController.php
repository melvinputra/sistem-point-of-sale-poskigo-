<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use App\Models\Notification;
use App\Models\TopupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik Umum
        $totalItems = Item::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalSales = Sale::sum('total_amount');
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount');
        
        // Transaksi Terbaru
        $recentSales = Sale::with(['user', 'customer'])->latest()->take(10)->get();
        
        // Notifikasi Unread
        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->latest()
            ->take(10)
            ->get();
        
        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
        
        // Stok Rendah (< 5)
        $lowStockItems = Item::where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->get();
        
                // Pending Top-up Requests
        $pendingTopups = TopupRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalItems',
            'totalUsers', 
            'totalSales',
            'todaySales',
            'recentSales',
            'notifications',
            'unreadCount',
            'lowStockItems',
            'pendingTopups'
        ));
    }
    
    public function markNotificationRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllNotificationsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca');
    }
}
