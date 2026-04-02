<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SpecificationType extends Model
{
    use softDeletes;

    protected $fillable = [
        'name',
    ];

    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
}
