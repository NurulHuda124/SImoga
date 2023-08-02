<?php

namespace App\Filament\Resources\DivisiResource\Pages;

use App\Filament\Resources\DivisiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDivisis extends ListRecords
{
    protected static string $resource = DivisiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Divisi'),
        ];
    }

    
}
