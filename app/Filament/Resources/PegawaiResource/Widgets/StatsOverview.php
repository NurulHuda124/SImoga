<?php

namespace App\Filament\Resources\PegawaiResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class StatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.resources.pegawai-resource.widgets.stats-overview';

    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Pegawai TKJP', '100'),
            Card::make('Jumlah Pegawai Kontraktor', '75'),
            Card::make('Jumlah Pegawai Konsultan', '150'),
        ];
    }
}
