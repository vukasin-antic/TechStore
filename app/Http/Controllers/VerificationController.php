<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function show() {
        if (!session('verify_email')) {
            return redirect()->route('login');
        }

        return view('auth.verify', ['email' => session('verify_email')]);
    }

    public function verify(Request $request) {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', session('verify_email'))->first();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->email_verified_at) {
            session()->forget('verify_email');
            return redirect()->route('login')->with('status', 'Your account is already verified, you can log in!');
        }

        if ($user->verification_code !== $request->code) {
            return redirect()->back()->withErrors(['code' => 'Invalid verification code!']);
        }

        $user->update([
            'verification_code' => null,
            'email_verified_at' => now(),
        ]);

        session()->forget('verify_email');

        return redirect()->route('login')->with('status', 'Your account has been activated, you can now log in!');
    }

    public function resend() {
        $user = User::where('email', session('verify_email'))->first();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->email_verified_at) {
            session()->forget('verify_email');
            return redirect()->route('login')->with('status', 'Your account is already verified, you can log in!');
        }

        try {
            $user->update(['verification_code' => (string) random_int(100000, 999999)]);
            Mail::to($user->email)->send(new VerificationCodeMail($user));

            return redirect()->route('verify.show')->with('status', 'A new code has been sent to your email.');
        }
        catch (\Exception $e) {
            return redirect()->route('verify.show')->withErrors(['resend' => 'We could not send the email, please try again!']);
        }
    }
}
