<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(15);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:promotions,code',
            'type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_usage' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
        ]);

        DB::beginTransaction();
        try {
            $promotion = Promotion::create([
                'title' => $request->title,
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'discount_value' => $request->discount_value,
                'min_purchase' => $request->min_purchase ?? 0,
                'max_usage' => $request->max_usage,
                'usage_count' => 0,
                'valid_from' => $request->valid_from,
                'valid_until' => $request->valid_until,
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            // Log activity
            ActivityLog::logActivity(
                'create',
                'Promotion',
                $promotion->id,
                'Membuat promo baru: ' . $promotion->title . ' (' . $promotion->code . ')',
                null,
                $promotion->toArray()
            );

            DB::commit();

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promo berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menambahkan promo: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:promotions,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_usage' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $promotion->toArray();

            $promotion->update([
                'title' => $request->title,
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'discount_value' => $request->discount_value,
                'min_purchase' => $request->min_purchase ?? 0,
                'max_usage' => $request->max_usage,
                'valid_from' => $request->valid_from,
                'valid_until' => $request->valid_until,
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            // Log activity
            ActivityLog::logActivity(
                'update',
                'Promotion',
                $promotion->id,
                'Mengupdate promo: ' . $promotion->title,
                $oldData,
                $promotion->toArray()
            );

            DB::commit();

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promo berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate promo: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $promotion = Promotion::findOrFail($id);
            $promoData = $promotion->toArray();

            $promotion->delete();

            // Log activity
            ActivityLog::logActivity(
                'delete',
                'Promotion',
                $id,
                'Menghapus promo: ' . $promoData['title'] . ' (' . $promoData['code'] . ')',
                $promoData,
                null
            );

            DB::commit();

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promo berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus promo: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        DB::beginTransaction();
        try {
            $promotion = Promotion::findOrFail($id);
            $oldStatus = $promotion->is_active;
            
            $promotion->update(['is_active' => !$oldStatus]);

            // Log activity
            ActivityLog::logActivity(
                'update',
                'Promotion',
                $promotion->id,
                ($promotion->is_active ? 'Mengaktifkan' : 'Menonaktifkan') . ' promo: ' . $promotion->title,
                ['is_active' => $oldStatus],
                ['is_active' => $promotion->is_active]
            );

            DB::commit();

            $status = $promotion->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->route('admin.promotions.index')
                ->with('success', "Promo berhasil {$status}!");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
