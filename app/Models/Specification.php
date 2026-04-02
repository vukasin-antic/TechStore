<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $fillable = [
        'product_id',
        'specification_type_id',
        'value',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specificationType()
    {
        return $this->belongsTo(SpecificationType::class);
    }
}
