<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'is_primary'];

    public function getUrlAttribute()
    {
        if (file_exists(public_path('img/products/' . $this->image))) {
            return asset('img/products/' . $this->image);
        }
        return asset('storage/uploads/' . $this->image);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
