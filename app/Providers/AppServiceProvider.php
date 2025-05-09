<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $defaultUser = User::where('email', 'john3@example.com')->first();
        $defaultUser = User::where('email', 'john@example.com')->first();
        if ($defaultUser) {
            Auth::login($defaultUser);
        }
    }
}
