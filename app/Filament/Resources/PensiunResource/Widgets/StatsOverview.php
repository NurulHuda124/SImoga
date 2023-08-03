<?php

namespace App\Filament\Resources\PensiunResource\Widgets;

use App\Models\Pensiun;
use DateTime;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $jmlhAktif= Pensiun::where(function ($query) {
        $query->whereDate('status_pensiun', '>', now()->subYears(54));
        })->count();

        $jmlhPensiun = Pensiun::where(function ($query) {
        $query->whereDate('status_pensiun', '<=', now()->subYears(54));
            })->count();
        return [
        Card::make('Jumlah Pegawai Belum Pensiun', $jmlhAktif)->chart([7, 2, 10, 3, 15, 4, 17]),
        Card::make('Jumlah Pegawai Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7]),
        ];
    }
}
