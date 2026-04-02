<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => password_hash($request->password, PASSWORD_BCRYPT)
            ]);

            session(['user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
            ]]);

            session(['cart_count' => 0]);

            return redirect()->route('home');

        }
        catch (\Exception $exception){
            return redirect()->back()->withErrors(['error' => 'Something went wrong, please try again!']);
        }

    }
    public function messages(): array
    {
        return [
            'first_name.regex' => 'First name can only contain letters!',
            'last_name.regex' => 'Last name can only contain letters!',
            'email.unique' => 'User with this email already exists!',
        ];
    }
}
