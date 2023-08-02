<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Kontrak;
use Filament\Widgets\BarChartWidget;

class PegawaiBarChart extends BarChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Per Masa Kontrak';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $jmlhBerlaku= Kontrak::where('status_kontrak', 'Berlaku')->count('status_kontrak');
        $jmlhTdkBerlaku = Kontrak::where('status_kontrak', 'Tidak Berlaku')->count('status_kontrak');
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => [$jmlhBerlaku, $jmlhTdkBerlaku],
                    'fill' => 'start',
                    'backgroundColor' => [
                    'rgba(255, 205, 86, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    ],
                    'borderColor' => [
                    'rgb(255, 205, 86)',
                    'rgb(54, 162, 235)',
                    ],
                    'borderWidth' => 3,
                    'borderRadius' => 10,
                ],
            ],
            'labels' => ['Pegawai Kontrak Berlaku', 'Pegawai Kontrak Tidak Berlaku'],
        ];
    }
}
