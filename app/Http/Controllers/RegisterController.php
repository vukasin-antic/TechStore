<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => password_hash($request->password, PASSWORD_BCRYPT),
                'verification_code' => (string) random_int(100000, 999999),
            ]);

            session(['verify_email' => $user->email]);

            try {
                Mail::to($user->email)->send(new VerificationCodeMail($user));
            }
            catch (\Exception $exception) {
                return redirect()->route('verify.show')
                    ->withErrors(['resend' => 'We could not send the email, please use the resend button below!']);
            }

            return redirect()->route('verify.show');

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
