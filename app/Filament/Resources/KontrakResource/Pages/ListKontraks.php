<?php

namespace App\Filament\Resources\KontrakResource\Pages;

use App\Filament\Resources\KontrakResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKontraks extends ListRecords
{
    protected static string $resource = KontrakResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
