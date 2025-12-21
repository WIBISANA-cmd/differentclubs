<?php

namespace Database\Seeders;

use App\Enums\DiscountType;
use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::firstOrCreate(
            ['code' => 'NOIR10'],
            [
                'type' => DiscountType::PERCENTAGE,
                'value' => 10,
                'max_uses' => 500,
                'min_order_total' => 100,
                'is_active' => true,
                'starts_at' => now()->subDay(),
                'ends_at' => now()->addMonth(),
            ]
        );

        Discount::firstOrCreate(
            ['code' => 'FREESHIP'],
            [
                'type' => DiscountType::FIXED,
                'value' => 50,
                'max_uses' => null,
                'min_order_total' => 0,
                'is_active' => true,
            ]
        );
    }
}
