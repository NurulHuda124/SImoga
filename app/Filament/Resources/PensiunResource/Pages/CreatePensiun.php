<?php

namespace App\Filament\Resources\PensiunResource\Pages;

use App\Filament\Resources\PensiunResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePensiun extends CreateRecord
{
    protected static string $resource = PensiunResource::class;

    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
