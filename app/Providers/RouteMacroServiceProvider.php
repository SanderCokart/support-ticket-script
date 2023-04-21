<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteMacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /**
         * resources commonly use put and patch together.
         * Rather than use match(['put', 'patch'], ...), we can use putPatch.
         */
        Route::macro('putPatch', function (string $uri, $action) {
            return $this->match(['put', 'patch'], $uri, $action);
        });
    }
}
