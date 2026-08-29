<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // 1. IMPORT GATE FACADE

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
        // 2. OTOMATIS BERIKAN SEMUA PERMISSION JIKA ROLE USER ADALAH 'ADMIN'
        Gate::before(function ($user, $ability) {
            return ($user->role === 'admin' || $user->role === 'administrator') ? true : null;
        });
    }
}