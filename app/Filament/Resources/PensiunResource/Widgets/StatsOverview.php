<?php

namespace App\Filament\Resources\PensiunResource\Widgets;

use App\Models\Pensiun;
use DateTime;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $recipient = auth()->user();
        $jmlhAktif = Pensiun::where(function ($query) {
            $query->whereDate('status_pensiun', '>', now()->subYears(54));
        })->count();

        $jmlhPensiun = Pensiun::where(function ($query) {
            $query->whereDate('status_pensiun', '<=', now()->subYears(54));
        })->count();
        $jmlhHPensiun = Pensiun::whereBetween('tanggal_lahir', [
        now()->subYears(54)->subMonth(), // satu bulan sebelum berusia 54 tahun
        now()->subYears(54) // tepat saat berusia 54 tahun
        ])->count();
        Notification::make()
            ->title('**Hampir Pensiun!**')
            ->body('Jumlah Pegawai Hampir Pensiun : ' . $jmlhHPensiun)
            ->warning()
            ->sendToDatabase($recipient);
        Notification::make()
            ->title('**Pensiun!**')
            ->body('Jumlah Pegawai Pensiun : ' . $jmlhPensiun)
            ->danger()
            ->sendToDatabase($recipient);
        return [
            Card::make('Jumlah Pegawai Belum Pensiun', $jmlhAktif)->chart([7, 2, 10, 3, 15, 4, 17]),
            Card::make('Jumlah Pegawai Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7]),
        ];
    }
}