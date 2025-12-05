<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\LogsActivity;

class Promotion extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'code',
        'type',
        'discount_value',
        'min_purchase',
        'max_usage',
        'usage_count',
        'valid_from',
        'valid_until',
        'is_active'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean'
    ];

    public function voucherUsages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function isValid()
    {
        // Pastikan promo aktif
        if (!$this->is_active) {
            return false;
        }
        
        // Cek tanggal berlaku (gunakan Carbon untuk parsing yang lebih baik)
        $today = Carbon::now()->startOfDay();
        $validFrom = Carbon::parse($this->valid_from)->startOfDay();
        $validUntil = Carbon::parse($this->valid_until)->endOfDay();
        
        // Cek apakah hari ini dalam rentang tanggal berlaku
        if ($today->lt($validFrom) || $today->gt($validUntil)) {
            return false;
        }
        
        // Cek max usage (jika diset)
        if ($this->max_usage !== null && $this->usage_count >= $this->max_usage) {
            return false;
        }
        
        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if (!$this->isValid() || $subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'percentage') {
            return ($subtotal * $this->discount_value) / 100;
        }

        return $this->discount_value;
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}
