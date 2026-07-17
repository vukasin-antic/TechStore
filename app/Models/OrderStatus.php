<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name',
        'label',
        'color',
    ];

    protected $casts = [
        'name' => OrderStatusEnum::class,
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
