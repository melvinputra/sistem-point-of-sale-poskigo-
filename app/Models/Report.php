<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['type', 'data', 'generated_at'];

    protected $casts = [
        'data' => 'array',
        'generated_at' => 'datetime',
    ];
}
