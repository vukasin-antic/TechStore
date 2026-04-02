<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function show($id)
    {
        $this->data['product'] = Product::with('category', 'brand', 'images', 'specifications.specificationType')
            ->findOrFail($id);

        $this->data['relatedProducts'] = Product::with('primaryImage')
            ->where('category_id', $this->data['product']->category_id)
            ->where('id', '!=', $id)
            ->get();

        return view('pages.product', $this->data);
    }
}
