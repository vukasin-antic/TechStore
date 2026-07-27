<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = trim($request->q ?? '');

        if (mb_strlen($query) < 2) {
            return response()->json(['total' => 0, 'products' => []]);
        }

        $builder = Product::where('name', 'like', '%' . $query . '%');

        $total = (clone $builder)->count();

        $products = $builder->with('primaryImage')
            ->limit(8)
            ->get();

        return response()->json([
            'total'    => $total,
            'products' => $products->map(fn($product) => [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $product->primaryImage?->url,
                'url'   => route('product.show', $product->id),
            ]),
        ]);
    }
}
