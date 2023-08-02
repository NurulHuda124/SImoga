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
        Card::make('Jumlah Pegawai Aktif', $jmlhAktif)->chart([7, 2, 10, 3, 15, 4, 17]),
        Card::make('Jumlah Pegawai Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7]),
        ];
    }
}
