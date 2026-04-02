<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session()->has('user') ? session()->get('user')['email'] : "unauthorized";
        $date = new \DateTime();
        $route = request()->route()->getName();
        $data = json_encode([$request->except('_token', "password", "password_confirmation")]);
        $query = $request->getQueryString();

        Log::create([
            'user' => $user,
            'date' => $date,
            'route' => $route,
            'data' => $data,
            'query' => $query
        ]);

        return $next($request);
    }
}
