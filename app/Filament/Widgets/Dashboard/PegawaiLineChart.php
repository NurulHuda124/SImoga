<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\LineChartWidget;

class PegawaiLineChart extends LineChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Pensiun Tiap Tahunnya';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
