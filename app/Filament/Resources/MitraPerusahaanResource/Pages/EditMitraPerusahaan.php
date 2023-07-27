<?php

namespace App\Filament\Resources\MitraPerusahaanResource\Pages;

use App\Filament\Resources\MitraPerusahaanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMitraPerusahaan extends EditRecord
{
    protected static string $resource = MitraPerusahaanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
