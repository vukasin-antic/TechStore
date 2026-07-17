<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [
            [
                'code' => 'ict20',
                'discount_percent' => 20,
            ],
            [
                'code' => 'spring10',
                'discount_percent' => 10,
                'expires_at' => now()->addMonths(3),
                'max_uses' => 25,
            ],
            [
                'code' => 'techstore30',
                'discount_percent' => 30,
                'expires_at' => now()->addMonths(6),
                'max_uses' => 10,
            ],
            [
                'code' => 'expired40',
                'discount_percent' => 40,
                'expires_at' => now()->subDay(),
            ],
            [
                'code' => 'disabled15',
                'discount_percent' => 15,
                'is_active' => false,
            ]
        ];

        foreach ($codes as $code) {
            PromoCode::create($code);
        }
    }
}
