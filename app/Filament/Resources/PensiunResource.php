<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PensiunResource\Pages;
use App\Filament\Resources\PensiunResource\RelationManagers;
use App\Models\Pensiun;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class PensiunResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $pluralModelLabel= 'Pensiun';
    protected static ?string $navigationLabel = 'Pensiun';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'MANAJEMEN MASA KERJA PEGAWAI';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPensiuns::route('/'),
            'create' => Pages\CreatePensiun::route('/create'),
            'view' => Pages\ViewPensiun::route('/{record}'),
            'edit' => Pages\EditPensiun::route('/{record}/edit'),
        ];
    }    
}
