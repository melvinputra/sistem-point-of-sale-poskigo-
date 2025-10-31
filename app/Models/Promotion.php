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
        $today = Carbon::today();
        
        return $this->is_active 
               && $today->between($this->valid_from, $this->valid_until)
               && ($this->max_usage === null || $this->usage_count < $this->max_usage);
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
