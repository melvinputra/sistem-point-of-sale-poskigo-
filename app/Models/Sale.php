<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id', 
        'customer_id',
        'pickup_code',
        'order_type',
        'order_status',
        'prepared_at',
        'completed_at',
        'total_amount',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'promotion_id',
        'cash_paid',
        'change_amount'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'cash_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'prepared_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function voucherUsage()
    {
        return $this->hasOne(VoucherUsage::class);
    }
}
