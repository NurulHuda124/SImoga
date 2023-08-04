<?php

namespace App\Filament\Resources\KontrakResource\Pages;
use App\Filament\Resources\KontrakResource\RelationManagers;
use App\Filament\Resources\KontrakResource;
use App\Models\Kontrak;
use App\Models\User;
use Filament\Forms\Components\Actions\Modal\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKontraks extends ListRecords
{
    protected static string $resource = KontrakResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            // Actions\ButtonAction::make('Laporan pdf')->url(fn()=>route('download.tes'))
            // ->openUrlInNewTab(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        $jmlhNonaktif = Kontrak::where('status_kontrak', '<=', date('Y-m-d'))->count();
        Notification::make()
        ->danger()
        ->title('Ada Pegawai dengan Kontrak Tidak Berlaku')
        ->body('Jumlah pegawai dengan kontrak yang tidak berlaku : ' .$jmlhNonaktif)
        ->actions([Action::make('view')
        ->url(fn()=>'kontrak/view'.$this->record->id, shouldOpenInNewTab:true)
        ->button()]);
        return [
            KontrakResource\Widgets\StatsOverview::class,
        ];
    }
}