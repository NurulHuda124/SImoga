<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MitraPerusahaanResource\Pages;
use App\Filament\Resources\MitraPerusahaanResource\RelationManagers;
use App\Models\MitraPerusahaan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\StatsOverviewWidget;

class MitraPerusahaanResource extends Resource
{
    protected static ?string $model = MitraPerusahaan::class;

    protected static ?string $pluralModelLabel = 'Mitra Perusahaan';
    protected static ?string $navigationLabel = 'Mitra Perusahaan';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = 'MANAJEMEN PEGAWAI';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                TextInput::make('nama_perusahaan')->required(),
                TextInput::make('jenis_mitra')->required(),
                TextInput::make('email')->required(),
                TextInput::make('website')->required(),
                TextInput::make('no_telp')->required()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_perusahaan')->searchable(),
                TextColumn::make('jenis_mitra'),
                TextColumn::make('email'),
                TextColumn::make('website'),
                TextColumn::make('no_telp')
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListMitraPerusahaans::route('/'),
            'create' => Pages\CreateMitraPerusahaan::route('/create'),
            'edit' => Pages\EditMitraPerusahaan::route('/{record}/edit'),
        ];
    }    
    public static function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class
        ];
    }
}
