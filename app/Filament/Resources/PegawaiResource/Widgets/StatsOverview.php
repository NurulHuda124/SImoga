<?php

namespace App\Filament\Resources\PegawaiResource\Widgets;
use App\Models\MitraPerusahaan;
use App\Models\Pegawai;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    //protected static string $view = 'filament.resources.pegawai-resource.widgets.stats-overview';

    protected function getCards(): array
    {
         $jmlhTKJP = Pegawai::where('jenis_mitra', 'TKJP')->count('jenis_mitra');
         $jmlhAudit= Pegawai::where('jenis_mitra', 'Audit')->count('jenis_mitra');
         $jmlhKonsultan = Pegawai::where('jenis_mitra', 'Konsultan')->count('jenis_mitra');
        return [
            Card::make('Jumlah Pegawai TKJP', '100'),
            Card::make('Jumlah Pegawai Kontraktor', '75'),
            Card::make('Jumlah Pegawai Konsultan', '150'),
        ];
    }
}
