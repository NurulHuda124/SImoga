<?php

namespace App\Filament\Resources\PegawaiResource\Widgets;

use App\Models\Pegawai;
use App\Models\MitraPerusahaan;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class StatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.resources.pegawai-resource.widgets.stats-overview';

    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Pegawai TKJP', MitraPerusahaan::all()->count()),
            Card::make('Jumlah Pegawai Konsultan', '75'),
            Card::make('Jumlah Pegawai Audit', '150'),
        ];
    }
}
