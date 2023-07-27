<?php

namespace App\Filament\Resources\PensiunResource\Pages;

use App\Filament\Resources\PensiunResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPensiun extends ViewRecord
{
    protected static string $resource = PensiunResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
