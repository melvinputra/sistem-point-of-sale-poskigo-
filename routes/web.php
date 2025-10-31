<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TopupRequestController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Kasir\SaleController;
use App\Http\Controllers\Kasir\CustomerController as KasirCustomerController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\Pelanggan\WalletController;
use App\Http\Controllers\Pelanggan\CartController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Items CRUD
    Route::resource('items', ItemController::class);
    
    // Users CRUD
    Route::resource('users', UserController::class);
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    
    // Top-Up Requests Management
    Route::get('/topup', [TopupRequestController::class, 'index'])->name('topup.index');
    Route::get('/topup/{id}', [TopupRequestController::class, 'show'])->name('topup.show');
    Route::post('/topup/{id}/approve', [TopupRequestController::class, 'approve'])->name('topup.approve');
    Route::post('/topup/{id}/reject', [TopupRequestController::class, 'reject'])->name('topup.reject');
    
    // Promotions Management
    Route::resource('promotions', PromotionController::class);
    Route::post('/promotions/{id}/toggle', [PromotionController::class, 'toggleStatus'])->name('promotions.toggle');
    
    // Notifications
    Route::post('/notifications/{id}/read', [AdminController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [AdminController::class, 'markAllNotificationsRead'])->name('notifications.mark-all-read');
    
    // Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
});

// Kasir Routes
Route::prefix('kasir')->name('kasir.')->middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
    
    // Sales
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{id}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/api/items/{id}/price', [SaleController::class, 'getItemPrice'])->name('items.price');
    
    // Reports - untuk tutup kasir harian
    Route::get('/reports', [KasirController::class, 'reports'])->name('reports');
    
    // Customers CRUD
    Route::resource('customers', KasirCustomerController::class);
    
    // Online Orders - Pickup System
    Route::get('/online-orders', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'index'])->name('online-orders');
    Route::get('/online-orders/verify', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'verify'])->name('online-orders.verify');
    Route::post('/online-orders/search', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'searchByCode'])->name('online-orders.search');
    Route::get('/online-orders/{id}', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'show'])->name('online-orders.show');
    Route::post('/online-orders/{id}/prepare', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'prepare'])->name('online-orders.prepare');
    Route::post('/online-orders/{id}/complete', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'complete'])->name('online-orders.complete');
    Route::post('/online-orders/{id}/cancel', [\App\Http\Controllers\Kasir\OnlineOrderController::class, 'cancel'])->name('online-orders.cancel');
});

// Pelanggan Routes
Route::prefix('pelanggan')->name('pelanggan.')->middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', [PelangganController::class, 'transactions'])->name('transactions');
    Route::get('/shop', [PelangganController::class, 'shop'])->name('shop');
    
    // Cart & Checkout
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    
    // Order Confirmation
    Route::get('/order/confirmation/{id}', function($id) {
        $sale = \App\Models\Sale::with(['saleItems.item', 'customer', 'promotion'])->findOrFail($id);
        return view('pelanggan.order-confirmation', compact('sale'));
    })->name('order.confirmation');
    
    // Wallet & Top-Up
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup', [WalletController::class, 'requestTopup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'storeTopupRequest'])->name('wallet.topup.store');
});
