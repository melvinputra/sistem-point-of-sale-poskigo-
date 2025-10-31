<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            [
                'title' => 'Diskon Akhir Tahun',
                'code' => 'NEWYEAR2025',
                'type' => 'percentage',
                'discount_value' => 20,
                'min_purchase' => 100000,
                'max_usage' => 100,
                'usage_count' => 0,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addDays(30),
                'is_active' => true
            ],
            [
                'title' => 'Potongan Rp 50.000',
                'code' => 'HEMAT50K',
                'type' => 'fixed',
                'discount_value' => 50000,
                'min_purchase' => 200000,
                'max_usage' => 50,
                'usage_count' => 0,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addDays(60),
                'is_active' => true
            ],
            [
                'title' => 'Member Baru 15%',
                'code' => 'WELCOME15',
                'type' => 'percentage',
                'discount_value' => 15,
                'min_purchase' => 50000,
                'max_usage' => null, // unlimited
                'usage_count' => 0,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addMonths(3),
                'is_active' => true
            ]
        ];

        foreach ($promotions as $promo) {
            Promotion::create($promo);
        }
    }
}

