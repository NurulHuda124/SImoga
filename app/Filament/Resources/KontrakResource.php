<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontrakResource\Pages;
use App\Filament\Resources\PegawaiResource\Pages\ViewPegawai;
use App\Filament\Resources\KontrakResource\RelationManagers;
use App\Models\Kontrak;
use App\Models\Pegawai;
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
use Filament\Tables\Columns\IconColumn;

class KontrakResource extends Resource
{
    protected static ?string $model = Kontrak::class;

    protected static ?string $pluralModelLabel = 'Kontrak';
    protected static ?string $navigationLabel = 'Kontrak';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'MANAJEMEN MASA KERJA PEGAWAI';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Card::make()
                // ->schema([
                // TextInput::make('nama_pegawai')->required(),
                // TextInput::make('email')->required(),
                // DatePicker::make('tanggal_kontrak_awal')->format('Y-m-d')->required(),
                // DatePicker::make('tanggal_kontrak_akhir')->format('Y-m-d')->required(),
                // TextInput::make('status_kontrak')->required(),
                // ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pegawai'),
                TextColumn::make('email'),
                TextColumn::make('tanggal_kontrak_awal')->date(),
                TextColumn::make('tanggal_kontrak_akhir')->date(),
                IconColumn::make('status_kontrak')
                ->options([
                'heroicon-o-x-circle',
                'heroicon-o-check-circle' => fn ($state): bool => $state > 0,
                ])
                ->colors([
                'danger',
                'success' => fn ($state): bool => $state > 0,
                ])->size('xl'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListKontraks::route('/'),
            // 'create' => Pages\CreateKontrak::route('/create'),
            'view' => PegawaiResource\Pages\ViewPegawai::route('/{record}'),
            // 'edit' => Pages\EditKontrak::route('/{record}/edit'),
        ];
    }    
}