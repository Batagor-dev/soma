<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layout.backend.sidebar', function ($view) {
            $menus = Menu::whereNull('menu_id')
                ->where('status', 1)
                ->with('children')
                ->orderBy('sort')
                ->get();

            $view->with('menus', $menus);
        });
    }

    public function register()
    {
        //
    }
}