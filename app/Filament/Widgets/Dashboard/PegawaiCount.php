<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\MitraPerusahaan;
use App\Models\Pensiun;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class PegawaiCount extends BaseWidget
{
    //protected static string $view = 'filament.resources.pegawai-resource.widgets.stats-overview';

    protected function getCards(): array
    {
         $jmlhMitra = MitraPerusahaan::distinct('nama_perusahaan')->count('nama_perusahaan');
          $jmlhAktif= Pensiun::where(function ($query) {
          $query->whereDate('status_pensiun', '>', now()->subYears(54));
          })->count();

          $jmlhPensiun = Pensiun::where(function ($query) {
          $query->whereDate('status_pensiun', '<=', now()->subYears(54));
              })->count();
        return [

            Card::make('Jumlah Mitra', $jmlhMitra)
            ->description('Mitra Perusahaan')
            ->descriptionIcon('heroicon-o-presentation-chart-line')
            ->color('primary'),
            Card::make('Jumlah Pegawai Belum Pensiun', $jmlhAktif)->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Card::make('Jumlah Pegawai Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7])
            ->color('danger'),
        ];
    }
}
