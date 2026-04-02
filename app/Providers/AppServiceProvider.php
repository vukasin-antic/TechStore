<?php

namespace App\Providers;

use App\Models\Nav;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try{
            $nav = Nav::all();
            View::share('nav', $nav);
        }
        catch (\Exception $exception){
            View::share('nav', collect());
        }
    }
}
