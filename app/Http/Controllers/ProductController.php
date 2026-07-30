<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function show($id)
    {
        $this->data['product'] = Product::with('category', 'brand', 'images', 'specifications.specificationType', 'reviews.user')
            ->findOrFail($id);

        $this->data['relatedProducts'] = Product::with('primaryImage')
            ->where('category_id', $this->data['product']->category_id)
            ->where('id', '!=', $id)
            ->get();

        $this->data['reviews'] = $this->data['product']->reviews;
        $this->data['averageRating'] = round($this->data['reviews']->avg('rating'), 1);

        $userId = session('user')['id'] ?? null;
        $this->data['eligibleOrders']= collect();
        $deliveredStatus = OrderStatus::where('name', OrderStatusEnum::Delivered)->first();

        if($userId){
            $this->data['eligibleOrders'] =
                Order::where('user_id', $userId)
                    ->where('status_id', $deliveredStatus->id)
                    ->whereHas('orderItems', fn ($q) => $q->where('product_id', $id))
                    ->whereDoesntHave('reviews', fn($q) => $q->where('product_id', $id))
                    ->where('user_id', $userId)
                    ->get();
        }
        return view('pages.product', $this->data);
    }
}
