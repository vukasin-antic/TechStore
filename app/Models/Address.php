<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use softDeletes;

    protected $fillable = [
        'user_id',
        'label',
        'address',
        'city',
        'country',
        'phone_number',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
