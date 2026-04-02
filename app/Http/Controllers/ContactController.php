<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        try {
            Mail::raw(
                "New contact form message!\n\n" .
                "From: {$request->full_name}\n" .
                "Email: {$request->email}\n" .
                "Subject: {$request->subject}\n\n" .
                "Message:\n{$request->message}",
                function($message) use ($request) {
                    $message->to(config('mail.from.address'))
                        ->subject('TechStore - ' . $request->subject)
                        ->replyTo($request->email, $request->full_name);
                }
            );

            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
