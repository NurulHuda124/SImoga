<?php

namespace App\Filament\Resources\MitraPerusahaanResource\Pages;

use App\Filament\Resources\MitraPerusahaanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMitraPerusahaans extends ListRecords
{
    protected static string $resource = MitraPerusahaanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {   
        return [
            MitraPerusahaanResource\Widgets\StatsOverview::class,
        ];
    }
}
