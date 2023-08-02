<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\BarChartWidget;

class PegawaiBarChart extends BarChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Per Masa Kontrak';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
