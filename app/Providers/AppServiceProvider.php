<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <--- Tambahkan Baris Ini

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
        // --- TAMBAHKAN BARIS INI ---
        // Agar pagination sesuai dengan style Bootstrap 5
        Paginator::useBootstrapFive();
    }
}