<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

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
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role === 'admin') {
                    $menu = [
                        ['header' => 'QUẢN LÝ'],
                        [
                            'text' => 'Dashboard',
                            'url'  => 'admin/dashboard',
                            'icon' => 'fas fa-tachometer-alt',
                        ],
                        [
                            'text' => 'Chủ Trọ',
                            'url'  => 'admin/hosts',
                            'icon' => 'fas fa-user',
                        ],
                        [
                            'text' => 'Trường Học',
                            'url'  => 'admin/schools',
                            'icon' => 'fas fa-school',
                        ],
                        [
                            'text' => 'Bản Đồ',
                            'url'  => 'admin/map',
                            'icon' => 'fas fa-map-marked-alt',
                        ],
                        ['header' => 'HỆ THỐNG'],
                        [
                            'text' => 'Quản lý Tài Khoản',
                            'url'  => 'admin/users',
                            'icon' => 'fas fa-users-cog',
                        ],
                        [
                            'text' => 'Cài Đặt',
                            'url'  => 'admin/settings',
                            'icon' => 'fas fa-cogs',
                        ],
                    ];
                } elseif ($user->role === 'host') {
                    $menu = [
                        ['header' => 'QUẢN LÝ KHU TRỌ'],
                        [
                            'text' => 'Dashboard',
                            'url'  => 'host/dashboard',
                            'icon' => 'fas fa-tachometer-alt',
                        ],
                        [
                            'text' => 'Quản lý Khu Trọ',
                            'url'  => 'host/areas',
                            'icon' => 'fas fa-home',
                        ],
                        [
                            'text' => 'Quản lý Phòng',
                            'url'  => 'host/rooms',
                            'icon' => 'fas fa-door-open',
                        ],
                        [
                            'text' => 'Quản lý Hợp Đồng',
                            'url'  => 'host/contracts',
                            'icon' => 'fas fa-file-signature',
                        ],
                        ['header' => 'HỆ THỐNG'],
                        [
                            'text' => 'Cài Đặt',
                            'url'  => 'host/settings',
                            'icon' => 'fas fa-cogs',
                        ],
                    ];
                } else {
                    $menu = [];
                }

                Config::set('adminlte.menu', $menu);
            }
        });
    }
}
