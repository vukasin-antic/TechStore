<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
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
            $cartItems = $cart->cartItems()->with('product.primaryImage')->get();
            $this->data['cartItems'] = $cartItems;

            $this->data = array_merge($this->data, $this->getCartTotalInfo($cart, $cartItems));

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

            $cartItems = $cart->cartItems()->with('product')->get();
            $cartInfo = $this->getCartTotalInfo($cart, $cartItems);

            $this->updateCartSession();

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $cartItems->sum('quantity'),
                'cartTotal' => round($cartInfo['total'], 2),
            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        try {
            if ($request->has('quantity')) {
                $newQuantity = (int) $request->quantity;
            } else {
                $newQuantity = $cartItem->quantity + (int) $request->change;
            }

            if ($newQuantity < 1) {
                return response()->json(['success' => false, 'message' => 'Quantity cannot be less than 1']);
            }

            if ($cartItem->product->stock < $newQuantity) {
                return response()->json(['success' => false, 'message' => 'Not enough stock!']);
            }

            $cartItem->update(['quantity' => $newQuantity]);

            $cart = $cartItem->cart;
            $cartItems = $cart->cartItems()->with('product')->get();
            $cartInfo = $this->getCartTotalInfo($cart, $cartItems);
            $itemTotal = $cartItem->product->price * $cartItem->quantity;

            $this->updateCartSession();

            return response()->json([
                'success' => true,
                'quantity' => $cartItem->quantity,
                'itemTotal' => round($itemTotal, 2),
                'cartTotal' => round($cartInfo['total'], 2),
                'cartCount' => $cartItems->sum('quantity'),
                'discount' => round($cartInfo['discount'], 2),
                'finalTotal' => round($cartInfo['finalTotal'], 2),
                'discountPercent' => $cartInfo['discountPercent']
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

            $cartItems = $cart->cartItems()->with('product')->get();
            $cartInfo = $this->getCartTotalInfo($cart, $cartItems);

            $this->updateCartSession();
            return response()->json([
                'success' => true,
                'cartTotal' => round($cartInfo['total'], 2),
                'cartCount' => $cartItems->sum('quantity'),
                'discount' => round($cartInfo['discount'], 2),
                'finalTotal' => round($cartInfo['finalTotal'], 2),
                'discountPercent' => $cartInfo['discountPercent'],
            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function promoCode(Request $request){
        try {
            $code = strtoupper($request->code);
            $promo = PromoCode::where('code', $code)->first();

            if(!$promo){
                $cart = $this->getOrCreateCart();
                $cart->update(['promo_code' => null, 'discount_percent' => null]);

                return response()->json([
                    'success' => false,
                    'message' => 'Promo code does not exist!'
                ]);
            }

            if(!$promo->isValid()){
                $cart = $this->getOrCreateCart();
                $cart->update(['promo_code' => null, 'discount_percent' => null]);

                return response()->json([
                    'success' => false,
                    'message' => 'Promo code is expired or no longer active!'
                ]);
            }

            $cart = $this->getOrCreateCart();
            $cart->update([
                'promo_code' => $promo->code,
                'discount_percent' => $promo->discount_percent,
            ]);

            $cartItems = $cart->cartItems()->with('product')->get();
            $cartInfo = $this->getCartTotalInfo($cart, $cartItems);

            return response()->json([
                'success' => true,
                'message' => 'Promo code applied! '. $promo->discount_percent .' % off',
                'discountPercent' => $cartInfo['discountPercent'],
                'discount' => round($cartInfo['discount'], 2),
                'finalTotal' => round($cartInfo['finalTotal'], 2),

            ]);
        }
        catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

}
