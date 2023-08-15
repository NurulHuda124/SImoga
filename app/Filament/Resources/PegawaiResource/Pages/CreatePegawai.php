<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePegawai extends CreateRecord
{
    protected static string $resource = PegawaiResource::class;
    protected static ?string $title = "Tambah Karyawan";
    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
