<?php

namespace App\Filament\Resources\PensiunResource\Pages;

use App\Filament\Resources\PensiunResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPensiun extends EditRecord
{
    protected static string $resource = PensiunResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
