<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Pegawai;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;
class PegawaiLineChart extends LineChartWidget
{
    protected static ?string $heading = 'Jumlah Pegawai Pensiun Tiap Tahunnya';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        $data = Trend::model(Pegawai::class)
            ->between(
                start: now()->subYears(3)->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perYear()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(function (TrendValue $value) {
                $date = Carbon::createFromFormat('Y', $value->date);
                $formattedDate = $date->format('Y');

                return $formattedDate;
            }),
        ];
    }
}
