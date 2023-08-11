<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Kontrak;
use Filament\Widgets\DoughnutChartWidget;

class PegawaiDoughnutChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'Jumlah Karyawan Per Masa Kontrak';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $jmlhBerlaku = Kontrak::where('status_kontrak', '>', date('Y-m-d'))->count();
        $jmlhTdkBerlaku = Kontrak::where('status_kontrak', '<=', date('Y-m-d'))->count();
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Karyawan',
                    'data' => [$jmlhBerlaku, $jmlhTdkBerlaku],
                    'fill' => 'start',
                    'backgroundColor' => [
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    ],
                    'borderColor' => [
                    'rgb(255, 205, 86)',
                    'rgb(54, 162, 235)',
                    ],
                    'borderWidth' => 3,
                    'borderRadius' => 10,
                ],
            ],
            'labels' => ['Karyawan Kontrak Berlaku', 'Karyawan Kontrak Tidak Berlaku'],
        ];
    }
}
