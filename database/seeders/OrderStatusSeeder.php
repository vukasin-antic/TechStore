<?php

namespace Database\Seeders;

use App\Enums\OrderStatusEnum;
use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private array $statuses = [
        [
            'name' => OrderStatusEnum::Pending,
            'label' => 'Pending',
            'color' => 'badge-pending'
        ],
        [
            'name' => OrderStatusEnum::Processing,
            'label' => 'Processing',
            'color' => 'bg-info'
        ],
        [
            'name' => OrderStatusEnum::Shipped,
            'label' => 'Shipped',
            'color' => 'bg-primary'
        ],
        [
            'name' => OrderStatusEnum::Delivered,
            'label' => 'Delivered',
            'color' => 'badge-success'
        ],
        [
            'name' => OrderStatusEnum::Cancelled,
            'label' => 'Cancelled',
            'color' => 'badge-cancelled'
        ],

    ];

    public function run(): void
    {
        foreach ($this->statuses as $s) {
            OrderStatus::create($s);
        }
    }

}
