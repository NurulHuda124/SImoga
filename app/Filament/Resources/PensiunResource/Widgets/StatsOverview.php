<?php

namespace App\Filament\Resources\PensiunResource\Widgets;

use App\Models\Pensiun;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $jmlhAktif= Pensiun::where('status_pensiun', 'Aktif')->count('status_pensiun');
        $jmlhPensiun = Pensiun::where('status_pensiun', 'Pensiun')->count('status_pensiun');
        return [
        Card::make('Jumlah Pegawai Aktif', $jmlhAktif)->chart([7, 8, 2, 15, 20, 15, 2, 8, 7])
        ->color('success'),
        Card::make('Jumlah Pegawai Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7])
        ->color('danger'),
        ];
    }
}
