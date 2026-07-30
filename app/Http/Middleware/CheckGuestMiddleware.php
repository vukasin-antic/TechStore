<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
