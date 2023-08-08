<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
        // Using Vite
        Filament::registerViteTheme('resources/css/filament.css');

        // Using Laravel Mix
        Filament::registerTheme(
        app(Vite::class)('resources/css/filament.css'),
        );
        });

    }
}
