<?php

namespace App\Filament\Resources\KontrakResource\Widgets;

use App\Models\Kontrak;
use Filament\Forms\Components\Actions\Modal\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;
class StatsOverview extends BaseWidget
{


    protected function getCards(): array
    {
        $recipient = auth()->user();
        $jmlhAktif = Kontrak::where('status_kontrak', '>', date('Y-m-d'))->count();
        $jmlhNonaktif = Kontrak::where('status_kontrak', '<=', date('Y-m-d'))->count();
        $nextMonth = Carbon::now()->addMonth();
        $jmlhHabisKontrak = Kontrak::whereIn('id', function ($query) use ($nextMonth) {
        $query->select('id')
        ->from('kontraks')
        ->whereBetween('tanggal_kontrak_akhir', [Carbon::now(), $nextMonth]);
        })->count();
        Notification::make()
        ->title('**Kontrak Hampir Tidak Berlaku!**')
        ->body('Jumlah Pegawai Kontrak Hampir Tidak Berlaku : ' . $jmlhHabisKontrak)
        ->warning()
        ->sendToDatabase($recipient);
        Notification::make()
            ->title('**Kontrak Tidak Berlaku!**')
            ->body('Jumlah Pegawai Kontrak Tidak Berlaku : ' . $jmlhNonaktif)
            ->danger()
            ->sendToDatabase($recipient);
        return [
            Card::make('Jumlah Pegawai Kontrak Berlaku', $jmlhAktif)->chart([7, 2, 10, 3, 15, 4, 17]),
            Card::make('Jumlah Pegawai Kontrak Tidak Berlaku', $jmlhNonaktif)->chart([
                17, 4, 15, 3, 10, 2,
                7
            ]),
        ];
    }
}
