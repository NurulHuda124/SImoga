<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPegawai extends EditRecord
{
    protected static string $resource = PegawaiResource::class;
    protected static ?string $title = "Edit Karyawan";
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
