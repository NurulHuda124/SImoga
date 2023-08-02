<?php

namespace App\Filament\Resources\PegawaiResource\Widgets;

use App\Models\MitraPerusahaan;
use App\Models\Pegawai;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class StatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.resources.pegawai-resource.widgets.stats-overview';

    protected function getCards(): array
    {
         $jmlhTKJP = Pegawai::where('jenis_mitra', 'TKJP')->count('jenis_mitra');
         $jmlhAudit= Pegawai::where('jenis_mitra', 'Audit')->count('jenis_mitra');
         $jmlhKonsultan = Pegawai::where('jenis_mitra', 'Konsultan')->count('jenis_mitra');
<<<<<<< HEAD
        return [
            Card::make('Jumlah Pegawai TKJP', $jmlhTKJP)->chart([7, 2, 10, 3, 15, 4, 17]),
            Card::make('Jumlah Pegawai Audit', $jmlhAudit)->chart([7, 8, 2, 15, 20, 15, 2, 8, 7]),
            Card::make('Jumlah Pegawai Konsultan', $jmlhKonsultan)->chart([17, 4, 15, 3, 10, 2, 7]),
=======
        
         return [
            Card::make('Jumlah Pegawai TKJP', $jmlhTKJP)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Card::make('Jumlah Pegawai Audit', $jmlhAudit)
            ->chart([7, 8, 2, 15, 20, 15, 2, 8, 7])
            ->color('danger'),
            Card::make('Jumlah Pegawai Konsultan', $jmlhKonsultan)
            ->chart([17, 4, 15, 3, 10, 2, 7])
            ->color('warning'),
>>>>>>> e761f407eb674d602174f9a7f4bf93dcad000818
        ];
    }
}
