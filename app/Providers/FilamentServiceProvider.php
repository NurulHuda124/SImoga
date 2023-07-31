<?php

namespace App\Providers;

use Filament\Facades\Filament;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
        // Using Vite
        Filament::registerViteTheme('resources/css/filament.css');

        // Using Laravel Mix
        Filament::registerTheme(
        mix('css/filament.css'),
        );
        });

    }
}
