<?php

namespace App\Filament\Resources\PensiunResource\Pages;

use App\Filament\Resources\PensiunResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPensiuns extends ListRecords
{
    protected static string $resource = PensiunResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            PensiunResource\Widgets\StatsOverview::class,
        ];
    }
}
