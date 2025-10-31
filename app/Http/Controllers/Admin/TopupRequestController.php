<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopupRequest;
use App\Models\Wallet;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupRequestController extends Controller
{
    public function index()
    {
        $pendingRequests = TopupRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
        
        $allRequests = TopupRequest::with('user', 'approver')
            ->latest()
            ->paginate(15);
        
        return view('admin.topup.index', compact('pendingRequests', 'allRequests'));
    }

    public function show($id)
    {
        $topupRequest = TopupRequest::with('user')->findOrFail($id);
        return view('admin.topup.show', compact('topupRequest'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $topupRequest = TopupRequest::findOrFail($id);
            
            if ($topupRequest->status !== 'pending') {
                throw new \Exception('Request ini sudah diproses sebelumnya!');
            }

            // Update status request
            $topupRequest->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'admin_notes' => $request->admin_notes,
                'approved_at' => now()
            ]);

            // Tambah saldo ke wallet pelanggan
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $topupRequest->user_id],
                ['balance' => 0]
            );
            
            $wallet->addBalance($topupRequest->amount);

            // Kirim notifikasi ke pelanggan
            Notification::create([
                'user_id' => $topupRequest->user_id,
                'type' => 'topup_approved',
                'title' => 'Top-Up Disetujui',
                'message' => 'Top-up Anda sebesar Rp ' . number_format($topupRequest->amount, 0, ',', '.') . ' telah disetujui. Saldo Anda sekarang: Rp ' . number_format($wallet->balance, 0, ',', '.'),
                'data' => json_encode([
                    'topup_request_id' => $topupRequest->id,
                    'amount' => $topupRequest->amount,
                    'new_balance' => $wallet->balance
                ])
            ]);

            // Log activity
            ActivityLog::logActivity(
                'approve',
                'TopupRequest',
                $topupRequest->id,
                'Menyetujui top-up request #' . $topupRequest->id . ' sebesar Rp ' . number_format($topupRequest->amount, 0, ',', '.'),
                ['status' => 'pending'],
                ['status' => 'approved', 'approved_by' => auth()->id()]
            );

            DB::commit();

            return redirect()->route('admin.topup.index')
                ->with('success', 'Top-up request berhasil disetujui! Saldo pelanggan telah ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyetujui request: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $topupRequest = TopupRequest::findOrFail($id);
            
            if ($topupRequest->status !== 'pending') {
                throw new \Exception('Request ini sudah diproses sebelumnya!');
            }

            // Update status request
            $topupRequest->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'admin_notes' => $request->admin_notes,
                'approved_at' => now()
            ]);

            // Kirim notifikasi ke pelanggan
            Notification::create([
                'user_id' => $topupRequest->user_id,
                'type' => 'topup_rejected',
                'title' => 'Top-Up Ditolak',
                'message' => 'Top-up Anda sebesar Rp ' . number_format($topupRequest->amount, 0, ',', '.') . ' ditolak. Alasan: ' . $request->admin_notes,
                'data' => json_encode([
                    'topup_request_id' => $topupRequest->id,
                    'amount' => $topupRequest->amount,
                    'reason' => $request->admin_notes
                ])
            ]);

            // Log activity
            ActivityLog::logActivity(
                'reject',
                'TopupRequest',
                $topupRequest->id,
                'Menolak top-up request #' . $topupRequest->id . ' sebesar Rp ' . number_format($topupRequest->amount, 0, ',', '.'),
                ['status' => 'pending'],
                ['status' => 'rejected', 'approved_by' => auth()->id()]
            );

            DB::commit();

            return redirect()->route('admin.topup.index')
                ->with('success', 'Top-up request berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menolak request: ' . $e->getMessage());
        }
    }
}
