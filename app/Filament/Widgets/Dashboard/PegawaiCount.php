<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\MitraPerusahaan;
use App\Models\Pegawai;
use App\Models\Pensiun;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class PegawaiCount extends BaseWidget
{
    //protected static string $view = 'filament.resources.pegawai-resource.widgets.stats-overview';

    protected function getCards(): array
    {
         $jmlhMitra = MitraPerusahaan::select('jenis_mitra', 'jenis_mitra')->count('jenis_mitra');
         $jmlhAktif= Pensiun::where('status_pensiun', 'Aktif')->count('status_pensiun');
         $jmlhPensiun = Pensiun::where('status_pensiun', 'Pensiun')->count('status_pensiun');
        return [

            Card::make('Jumlah Mitra', $jmlhMitra)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->description('Mitra Perusahaan')
            ->descriptionIcon('heroicon-o-presentation-chart-line')
            ->color('primary'),
            Card::make('Jumlah Pegawai Aktif', $jmlhAktif)->chart([7, 8, 2, 15, 20, 15, 2, 8, 7])
            ->color('success'),
            Card::make('Jumlah Pegawai Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7])
            ->color('danger'),
        ];
    }
}
