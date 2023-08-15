<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPegawai extends ViewRecord
{
    protected static string $resource = PegawaiResource::class;
    protected static ?string $title = "Detail Karyawan";
    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
