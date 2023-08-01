<?php

namespace App\Filament\Resources\KontrakResource\Pages;

use App\Filament\Resources\KontrakResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKontrak extends ViewRecord
{
    protected static string $resource = KontrakResource::class;

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