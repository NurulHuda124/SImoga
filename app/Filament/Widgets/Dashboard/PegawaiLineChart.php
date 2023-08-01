<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\LineChartWidget;

class PegawaiLineChart extends LineChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Pensiun Tiap Tahunnya';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
