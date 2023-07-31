<?php

namespace App\Filament\Resources\KontrakResource\Pages;

use App\Filament\Resources\KontrakResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKontrak extends CreateRecord
{
    protected static string $resource = KontrakResource::class;

    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
