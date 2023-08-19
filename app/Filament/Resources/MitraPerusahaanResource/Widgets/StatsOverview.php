<?php

namespace App\Filament\Resources\MitraPerusahaanResource\Widgets;

use App\Models\MitraPerusahaan;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.resources.mitra-perusahaan-resource.widgets.stats-overview';

    protected function getCards(): array
    {
        $jmlhMitra = MitraPerusahaan::distinct('nama_perusahaan')->count('nama_perusahaan');
        $jmlhAktif = MitraPerusahaan::where('status_kontrak_perusahaan', '>', date('Y-m-d'))->count();
        $jmlhNonaktif = MitraPerusahaan::where('status_kontrak_perusahaan', '<=', date('Y-m-d'))->count();
        return [

            Card::make('Jumlah Mitra', $jmlhMitra)
                ->description('Mitra Perusahaan')
                ->descriptionIcon('heroicon-o-presentation-chart-line')
                ->color('primary'),
            Card::make('Jumlah Kontrak Berlaku', $jmlhAktif),
            Card::make('Jumlah Kontrak Tidak Berlaku', $jmlhNonaktif)
        ];
    }
}