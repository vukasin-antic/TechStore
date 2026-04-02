<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;


class LoginController extends Controller
{

    public function login(LoginRequest $request) {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !password_verify($request->password, $user->password)) {
                return redirect()->back()->withErrors(['credentials' => 'Invalid credentials!']);
            }
            if ($user->is_banned) {
                return redirect()->back()->withErrors(['credentials' => 'Your account has been banned. Please contact support.']);
            }

            session(['user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
            ]]);

            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            session(['cart_count' => $cart->cartItems()->sum('quantity')]);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');

        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong, please try again!']);
        }
    }

    public function logout() {
        try{
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('home');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong, please try again!']);
        }

    }
}
