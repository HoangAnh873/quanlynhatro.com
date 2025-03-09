<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AdminLTEServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $role = Auth::user()->role; // Lấy role của user
                $menu = config("adminlte.menu.$role", []); // Lấy menu theo role
                $view->with('menu', $menu);
            }
        });
    }
}
