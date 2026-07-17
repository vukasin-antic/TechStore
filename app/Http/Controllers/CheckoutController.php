<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PromoCode;
use App\Models\Product;
use App\Traits\CartTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use CartTrait;
    public function index(){
        try{
            $this->data['user'] = [
                'first_name' => session('user')['first_name'],
                'last_name' => session('user')['last_name'],
            ];
            $this->data['addresses'] = Address::where('user_id', session('user')['id'])->get();

            $cart = $this->getOrCreateCart();
            $cartItems = $cart->cartItems()->with('product')->get();
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty   !');
            }

            $this->data['cartItems'] = $cartItems;

            $this->data = array_merge($this->data, $this->getCartTotalInfo($cart, $cartItems));

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
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
            }
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            $discount = 0;
            $promoCode = null;

            if ($cart->promo_code) {
                $promoCode = PromoCode::where('code', $cart->promo_code)->first();
                if ($promoCode && $promoCode->isValid()) {
                    $discount = $total * ($cart->discount_percent / 100);
                } else {
                    $cart->update(['promo_code' => null, 'discount_percent' => null]);
                    return redirect()->back()->with('error', 'Promo code is no longer valid. Please review your order.');
                }
            }

            $finalTotal = $total - $discount;

            if ($request->filled('selected_address_id')) {
                $address = Address::where('id', $request->selected_address_id)
                    ->where('user_id', session('user')['id'])
                    ->firstOrFail();
            }
            else{
                $address = Address::create([
                    'user_id' => (session('user')['id']),
                    'label' => $request->label,
                    'address' => $request->address,
                    'city' => $request->city,
                    'country' => $request->country,
                    'phone_number' => $request->phone_number,
                ]);
            }

            $pendingStatus = OrderStatus::where('name', OrderStatusEnum::Pending)->first();

            $order = DB::transaction(function () use ($cartItems, $request, $address, $pendingStatus, $finalTotal, $discount, $cart, $promoCode) {
                $products = [];
                foreach ($cartItems as $item) {
                    $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                    if (!$product || $product->stock < $item->quantity) {
                        throw new \RuntimeException('Not enough stock for "' . ($product->name ?? 'a product') . '". Please review your cart.');
                    }
                    $products[$item->product_id] = $product;
                }

                $order = Order::create([
                    'user_id' => session('user')['id'],
                    'order_number' => 'TS' . date('Y') . '-TEMP-' . Str::random(10),
                    'total_price'  => round($finalTotal, 2),
                    'discount' => $discount > 0,
                    'status_id' => $pendingStatus->id,
                    'address' => $address->address,
                    'city' => $address->city,
                    'country' => $address->country,
                    'phone_number' => $address->phone_number,
                    'notes' => $request->notes,
                    'promo_code' => $cart->promo_code,
                    'discount_percent' => $cart->discount_percent
                ]);

                $order->update([
                    'order_number' => 'TS' . date('Y') . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                ]);

                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $products[$item->product_id]->price,
                    ]);
                    $products[$item->product_id]->decrement('stock', $item->quantity);
                }

                $cart->cartItems()->delete();
                $promoCode?->increment('used_count');
                $cart->update(['promo_code' => null, 'discount_percent' => null]);

                return $order;
            });

            return redirect()->route('order.confirmation', $order->id);
        }
        catch (\RuntimeException $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
