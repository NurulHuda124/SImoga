<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Kontrak;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PegawaiMasaKerja extends BaseWidget
{
    protected function getCards(): array
    {
    $jmlhBerlaku= Kontrak::where('status_kontrak', 'Berlaku')->count('status_kontrak');
    $jmlhTdkBerlaku = Kontrak::where('status_kontrak', 'Tidak Berlaku')->count('status_kontrak');
    return [
    Card::make('Jumlah Pegawai Kontrak Berlaku', $jmlhBerlaku)->chart([7, 2, 10, 3, 15, 4, 17]),
    Card::make('Jumlah Pegawai Kontrak Tidak Berlaku', $jmlhTdkBerlaku)->chart([17, 4, 15, 3, 10, 2, 7]),
    ];
    }
}
