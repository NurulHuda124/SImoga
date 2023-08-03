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
    $jmlhMitra = MitraPerusahaan::distinct('nama_perusahaan')->count('nama_perusahaan');
    return [

    Card::make('Jumlah Mitra', $jmlhMitra)
    ->description('Mitra Perusahaan')
    ->descriptionIcon('heroicon-o-presentation-chart-line')
    ->color('primary'),
    ];
    }
}
