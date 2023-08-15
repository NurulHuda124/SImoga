<?php

namespace App\Filament\Resources\KontrakResource\Widgets;

use App\Models\Kontrak;
use App\Models\MitraPerusahaan;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{


    protected function getCards(): array
    {
        $recipient = auth()->user();
        $jmlhP = Kontrak::where(function ($query) {
        $query->whereDate('status_pensiun', '>', now()->subYears(56));
        })->count();

        $jmlhPensiun = Kontrak::where(function ($query) {
        $query->whereDate('status_pensiun', '<=', now()->subYears(56));
            })->count();
            $jmlhHPensiun = Kontrak::whereBetween('tanggal_lahir', [
            now()->subYears(54)->subMonth(), // satu bulan sebelum berusia 54 tahun
            now()->subYears(54) // tepat saat berusia 54 tahun
            ])->count();
        $jmlhAktif = Kontrak::where('status_kontrak', '>', date('Y-m-d'))->count();
        $jmlhNonaktif = Kontrak::where('status_kontrak', '<=', date('Y-m-d'))->count();
        $nextYear = Carbon::now()->addYears();
        $jmlhHabisKontrak = Kontrak::whereIn('id', function ($query) use ($nextYear) {
            $query->select('id')
                ->from('kontraks')
                ->whereBetween('tanggal_kontrak_akhir', [Carbon::now(), $nextYear]);
        })->count();
         $jmlhNAM = MitraPerusahaan::where('status_kontrak_perusahaan', '<=', date('Y-m-d'))->count();
             $jmlhHabisMitraPerusahaan = MitraPerusahaan::whereIn('id', function ($query) use ($nextYear) {
             $query->select('id')
             ->from('mitra_perusahaans')
             ->whereBetween('tanggal_kontrak_akhir_perusahaan', [Carbon::now(), $nextYear]);
             })->count();
        if (!session('notification_shown')) {
            if ($jmlhHabisKontrak > 0) {
            Notification::make()
                ->title('**Kontrak Hampir Tidak Berlaku!**')
                ->body('Jumlah Karyawan Kontrak Hampir Tidak Berlaku : ' . $jmlhHabisKontrak)
                ->warning()
                ->persistent()
                ->sendToDatabase($recipient);
            }
            if ($jmlhNonaktif > 0) {
                Notification::make()
                ->title('**Kontrak Tidak Berlaku!**')
                ->body('Jumlah Karyawan Kontrak Tidak Berlaku : ' . $jmlhNonaktif)
                ->danger()
                ->persistent()
                ->sendToDatabase($recipient);
            }
            if ($jmlhHPensiun > 0) {
                Notification::make()
                ->title('**Hampir Pensiun!**')
                ->body('Jumlah Karyawan Hampir Pensiun : ' . $jmlhHPensiun)
                ->warning()
                ->persistent()
                ->sendToDatabase($recipient);
            }
            if ($jmlhPensiun > 0) {
                Notification::make()
                ->title('**Pensiun!**')
                ->body('Jumlah Karyawan Pensiun : ' . $jmlhPensiun)
                ->danger()
                ->persistent()
                ->sendToDatabase($recipient);
            }

            if ($jmlhHabisMitraPerusahaan > 0) {
            Notification::make()
            ->title('**Kontrak Mitra Hampir Tidak Berlaku!**')
            ->body('Jumlah Mitra Kontrak Hampir Tidak Berlaku : ' . $jmlhHabisMitraPerusahaan)
            ->warning()
            ->persistent()
            ->sendToDatabase($recipient);
            }

            if ($jmlhNAM > 0) {
            Notification::make()
            ->title('**Kontrak Mitra Tidak Berlaku!**')
            ->body('Jumlah Mitra Kontrak Tidak Berlaku : ' . $jmlhNAM)
            ->danger()
            ->persistent()
            ->sendToDatabase($recipient);
            }

            // Tandai bahwa notifikasi telah ditampilkan dalam session
            session(['notification_shown' => true]);
        }
        return [
            Card::make('Jumlah Karyawan Kontrak Berlaku', $jmlhAktif)->chart([7, 2, 10, 3, 15, 4, 17]),
            Card::make('Jumlah Karyawan Kontrak Tidak Berlaku', $jmlhNonaktif)->chart([
                17, 4, 15, 3, 10, 2,
                7
            ]),
            Card::make('Jumlah Karyawan Belum Pensiun', $jmlhP)->chart([7, 2, 10, 3, 15, 4, 17]),
            Card::make('Jumlah Karyawan Pensiun', $jmlhPensiun)->chart([17, 4, 15, 3, 10, 2, 7]),
        ];
    }
}
