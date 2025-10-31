<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\TopupRequest;
use App\Models\Notification;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Auto-create wallet jika belum ada
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );
        
        $topupHistory = TopupRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
        
        return view('pelanggan.wallet.index', compact('wallet', 'topupHistory'));
    }

    public function requestTopup()
    {
        return view('pelanggan.wallet.topup');
    }

    public function storeTopupRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:transfer,cash,e-wallet',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $proofPath = null;
            
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            $topupRequest = TopupRequest::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_proof' => $proofPath,
                'status' => 'pending'
            ]);

            // Kirim notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'topup_request',
                    'title' => 'Request Top-Up Baru',
                    'message' => auth()->user()->name . ' meminta top-up sebesar Rp ' . number_format($request->amount, 0, ',', '.'),
                    'data' => json_encode([
                        'topup_request_id' => $topupRequest->id,
                        'user_name' => auth()->user()->name,
                        'amount' => $request->amount,
                        'payment_method' => $request->payment_method
                    ])
                ]);
            }

            // Log activity
            ActivityLog::logActivity(
                'create',
                'TopupRequest',
                $topupRequest->id,
                'Request top-up sebesar Rp ' . number_format($request->amount, 0, ',', '.'),
                null,
                $topupRequest->toArray()
            );

            DB::commit();

            return redirect()->route('pelanggan.wallet.index')
                ->with('success', 'Request top-up berhasil dikirim! Menunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengirim request: ' . $e->getMessage())->withInput();
        }
    }
}
