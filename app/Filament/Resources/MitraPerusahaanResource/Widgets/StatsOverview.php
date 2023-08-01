<?php

namespace App\Filament\Resources\MitraPerusahaanResource\Widgets;

use App\Models\MitraPerusahaan;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class StatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.resources.mitra-perusahaan-resource.widgets.stats-overview';

    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Pegawai TKJP', MitraPerusahaan::all()->count()),
            Card::make('Jumlah Pegawai Kontraktor', '75'),
            Card::make('Jumlah Pegawai Konsultan', '150'),
        ];
    }
}
