<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Pegawai;
use App\Models\Pensiun;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;
use Filament\Widgets\PolarAreaChartWidget;

class PegawaiPolarAreaChart extends PolarAreaChartWidget
{
    protected static ?string $heading = 'Jumlah Karyawan Berdasarkan Jenis Mitra';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
     $jmlhTKJP = Pegawai::where('jenis_mitra', 'TKJP')->count('jenis_mitra');
     $jmlhAuditor= Pegawai::where('jenis_mitra', 'Auditor')->count('jenis_mitra');
     $jmlhKonsultan = Pegawai::where('jenis_mitra', 'Konsultan')->count('jenis_mitra');
        return [
        'datasets' => [
        [
        'label' => 'Jumlah Karyawan',
        'data' => [$jmlhTKJP, $jmlhAuditor, $jmlhKonsultan],
        'fill' => 'start',
        'backgroundColor' => [
        'rgba(255, 99, 132, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        ],
        'borderColor' => [
        'rgb(255, 99, 132)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)'],
        'borderWidth' => 3,
        'borderRadius' => 10,
        ],
        ],
        'labels' => ['Karyawan TKJP', 'Karyawan Auditor','Karyawan Konsultan'],
        ];
        }
}
