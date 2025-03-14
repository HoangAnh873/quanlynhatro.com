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
                            'url'  => route('admin.dashboard'),
                            'icon' => 'fas fa-tachometer-alt',
                        ],
                        [
                            'text' => 'Quản lý chủ trọ',
                            'url'  => route('hosts.index'),
                            'icon' => 'fas fa-user',
                        ],
                        [
                            'text' => 'Quản lý trường học',
                            'url'  => route('schools.index'),
                            'icon' => 'fas fa-school',
                        ],
                        [
                            'text' => 'Quản lý bản Đồ',
                            'url'  => url('admin/map'),
                            'icon' => 'fas fa-map-marked-alt',
                        ],
                        ['header' => 'HỆ THỐNG'],
                        [
                            'text' => 'Quản lý Tài Khoản',
                            'url'  => route('users.index'),
                            'icon' => 'fas fa-users-cog',
                        ],
                        [
                            'text' => 'Cài Đặt',
                            'url'  => url('admin/settings'),
                            'icon' => 'fas fa-cogs',
                        ],
                    ];
                } elseif ($user->role === 'host') {
                    $menu = [
                        ['header' => 'QUẢN LÝ KHU TRỌ'],
                        [
                            'text' => 'Dashboard',
                            'url'  => route('host.dashboard'),
                            'icon' => 'fas fa-tachometer-alt',
                        ],
                        [
                            'text' => 'Quản lý Khu Trọ',
                            'url'  => route('host.apartments.index'),
                            'icon' => 'fas fa-home',
                        ],
                        [
                            'text' => 'Quản lý loại phòng',
                            'url'  => url('host/types'), // Chưa có route, cần thêm vào web.php
                            'icon' => 'fas fa-door-open',
                        ],
                        [
                            'text' => 'Danh sách Phòng',
                            'url'  => url('host/rooms'), // Chưa có route, cần thêm vào web.php
                            'icon' => 'fas fa-bed',
                        ],
                        [
                            'text' => 'Duyệt Phiếu Thuê Phòng',
                            'url'  => url('host/rentals'), // Chưa có route, cần thêm vào web.php
                            'icon' => 'fas fa-clipboard-check',
                        ],
                        [
                            'text' => 'Quản lý Hợp Đồng',
                            'url'  => url('host/contracts'), // Chưa có route, cần thêm vào web.php
                            'icon' => 'fas fa-file-signature',
                        ],
                        ['header' => 'HỆ THỐNG'],
                        [
                            'text' => 'Cài Đặt',
                            'url'  => url('host/settings'),
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
