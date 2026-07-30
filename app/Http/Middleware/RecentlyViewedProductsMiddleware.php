<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecentlyViewedProductsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->route()->getName() !== 'product.show') {
            return $response;
        }

        $user = session('user');


        if (!$user) {
            return $response;
        }

        $productId = (int) $request->route('id');
        $recentlyViewed = $user['recentlyViewed'] ?? [];
        $recentlyViewed = array_values(array_filter($recentlyViewed, fn($pid) => $pid != $productId));
        array_unshift($recentlyViewed, $productId);
        $recentlyViewed = array_slice($recentlyViewed, 0, 5);

        $user['recentlyViewed'] = $recentlyViewed;
        session(['user' => $user]);

        return $response;
    }
}
