<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Traits\CartTrait;

class OrderController extends Controller
{
    use CartTrait;
    public function confirmation($id)
    {
        try
        {
            $order = Order::with('orderItems.product')->findOrFail($id);
            $this->data['order'] = $order;
            return view('pages.confirmation', $this->data);
        }
        catch (\Exception $e)
        {
            return redirect()->route('home');
        }
    }

    public function myOrders()
    {
        try
        {
            $this->data['orders'] = Order::with('orderItems.product')
                ->where('user_id', session('user')['id'])
                ->latest()
                ->get();
            return view('pages.orders', $this->data);
        }
        catch (\Exception $e)
        {
            return redirect()->route('home');
        }
    }
    public function cancel($id)
    {
        try {
            $order = Order::with('orderItems.product')->findOrFail($id);

            if ($order->user_id !== session('user')['id']) {
                return response()->json(['success' => false, 'message' => 'Unauthorized!']);
            }

            if ($order->status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Only pending orders can be cancelled!']);
            }

            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);

            return response()->json(['success' => true, 'message' => 'Order cancelled successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}
