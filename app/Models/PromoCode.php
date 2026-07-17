<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'discount_percent',
        'expires_at',
        'max_uses',
        'used_count',
        'is_active',
    ];

    public function isValid(): bool{
        if(!$this->is_active) return false;

        if($this->expires_at && $this->expires_at < now()) return false;

        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;

        return true;
    }
}
