<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\CartTrait;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    use CartTrait;
    public function index(){
        try{
            $this->data['user'] = [
                'first_name' => session('user')['first_name'],
                'last_name' => session('user')['last_name'],
            ];

            $cart = $this->getOrCreateCart();

            $this->data['cartItems'] = $cart->cartItems()->with('product')->get();
            $this->data['total'] = $this->data['cartItems']->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            $this->data['promoApplied'] = session('promo_applied', false); // correct key
            $this->data['discount'] = session('promo_applied') ? $this->data['total'] * 0.20 : 0;
            $this->data['finalTotal'] = $this->data['total'] - $this->data['discount'];

            return view('pages.checkout', $this->data);

        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    public function store(CheckoutRequest $request){
        try{
            $cart = $this->getOrCreateCart();
            $cartItems = $cart->cartItems()->with('product')->get();
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            if (session('promo_applied')) {
                $total = $total - ($total * 0.20);
            }
            $order = Order::create([
                'user_id' => session('user')['id'],
                'order_number' => 'TS' . date('Y') . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
                'total_price' => $total,
                'discount' => (bool) session('promo_applied'),
                'status' => 'pending',
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->cartItems()->delete();
            session()->forget('promo_applied');
            session()->forget('cart_count');

            return redirect()->route('order.confirmation', $order->id);
        }
        catch (\Exception $exception){
            dd($exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
