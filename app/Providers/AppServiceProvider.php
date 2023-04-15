<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Password::defaults(function () {
            return [
                'min'       => 8,
                'max'       => 255,
                'mixedCase' => true,
                'numbers'   => true,
                'letters'   => true,
                'symbols'   => true,
            ];
        });
    }
}
