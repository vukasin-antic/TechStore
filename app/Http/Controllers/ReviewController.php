<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'order_id' => 'required|exists:orders,id',
        ]);

        $userId = session('user')['id'];

        $order = Order::where('id', $request->order_id)
                      ->where('user_id', $userId)
                      ->whereHas('status', fn($q) => $q->where('name', OrderStatusEnum::Delivered))
                      ->firstOrFail();

        $boughtProduct = $order->orderItems()->where('product_id', $productId)->exists();

        if(!$boughtProduct){
            return redirect()->back()->with('error', 'You can only review products you have purchased');
        }

        $exist = Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('order_id', $request->order_id)
            ->exists();

        if($exist){
            return redirect()->back()->with('error', 'You have already reviewed this product');
        }

        Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully');

    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== session('user')['id']) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Review deleted.');
    }
}
