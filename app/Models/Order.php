<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'discount',
        'status_id',
        'cancel_reason',
        'address',
        'city',
        'country',
        'phone_number',
        'notes',
        'promo_code',
        'discount_percent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
