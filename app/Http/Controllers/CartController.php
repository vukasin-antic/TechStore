<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Traits\CartTrait;

class CartController extends Controller
{
    use CartTrait;
    private function updateCartSession()
    {
        $cart = $this->getOrCreateCart();
        $count = $cart->cartItems()->sum('quantity');
        session(['cart_count' => $count]);
    }

    public function index()
    {
        try{

            $cart = $this->getOrCreateCart();
            $this->data['cartItems'] = $cart->cartItems()->with('product.primaryImage')->get();
            $this->data['total'] = $this->data['cartItems']->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $this->updateCartSession();

            return view('pages.cart', $this->data);
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function add(Request $request)
    {
        try{

            $product = Product::findOrFail($request->product_id);

            $cart = $this->getOrCreateCart();

            $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

            $currentQuantityInCart = $cartItem ? $cartItem->quantity : 0;
            $totalQuantity = $currentQuantityInCart + $request->quantity;
            $q = $request->quantity;


            if ($product->stock < $totalQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock! Only ' . ($product->stock - $currentQuantityInCart) . ' available.'
                ]);
            }

            if ($cartItem) {
                $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
            }
            else {
                $cart->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                ]);
            }

            $cartCount = $cart->cartItems()->sum('quantity');
            $cartTotal = $cart->cartItems()->with('product')->get()->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $this->updateCartSession();



            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $cartCount,
                'cartTotal' => round($cartTotal, 2),
            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        try {
            if ($cartItem->quantity + $request->change < 1) {
                return response()->json(['success' => false, 'message' => 'Quantity cannot be less than 1']);
            }

            if ($cartItem->product->stock < $cartItem->quantity + $request->change) {
                return response()->json(['success' => false, 'message' => 'Not enough stock!']);
            }

            if ($request->has('quantity')) {
                $cartItem->update(['quantity' => $request->quantity]);
            }
            else {
                $cartItem->update(['quantity' => $cartItem->quantity + $request->change]);
            }

            $cart = $cartItem->cart;
            $cartTotal = $cart->cartItems()->with('product')->get()->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            $cartCount = $cart->cartItems()->sum('quantity');
            $itemTotal = $cartItem->product->price * $cartItem->quantity;

            $this->updateCartSession();

            return response()->json([
                'success' => true,
                'quantity' => $cartItem->quantity,
                'itemTotal' => round($itemTotal, 2),
                'cartTotal' => round($cartTotal, 2),
                'cartCount' => $cartCount,
            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function remove(CartItem $cartItem)
    {
        try{
            $cart = $cartItem->cart;
            $cartItem->delete();

            $cartTotal = $cart->cartItems()->with('product')->get()->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            $cartCount = $cart->cartItems()->sum('quantity');

            $this->updateCartSession();

            return response()->json([
                'success' => true,
                'cartTotal' => round($cartTotal, 2),
                'cartCount' => $cartCount,
            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function promoCode(Request $request){
        try{
            $code = strtoupper($request->code);

            if ($code !== 'ICT20') {
                session()->forget('promo_applied');
                session()->forget('promo_discount');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid promo code!'
                ]);
            }

            session(['promo_applied' => true]);
            session(['promo_discount' => 20]);
            $cart = $this->getOrCreateCart();
            $total = $cart->cartItems()->with('product')->get()->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $discount = $total * 0.20;
            $finalTotal = $total - $discount;

            return response()->json([
                'success' => true,
                'message' => 'Promo code applied!',
                'discount' => round($discount, 2),
                'finalTotal' => round($finalTotal, 2),
            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

}
