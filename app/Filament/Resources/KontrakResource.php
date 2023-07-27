<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontrakResource\Pages;
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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pegawais.nama_pegawai'),
                TextColumn::make('pegawais.email'),
                TextColumn::make('pegawais.tempat_lahir'),
                TextColumn::make('pegawais.tanggal_lahir')->date(),
                TextColumn::make('pegawais.alamat'),
                TextColumn::make('pegawais.no_telp'),
                TextColumn::make('pegawais.jabatan'),
                TextColumn::make('pegawais.divisi'),
                TextColumn::make('pegawais.jenis_mitra'),
                TextColumn::make('pegawais.tanggal_kontrak_awal')->date(),
                TextColumn::make('pegawais.tanggal_kontrak_akhir')->date(),
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
            'index' => Pages\ListKontraks::route('/'),
            // 'create' => Pages\CreateKontrak::route('/create'),
            'view' => Pages\ViewKontrak::route('/{record}'),
            'edit' => Pages\EditKontrak::route('/{record}/edit'),
        ];
    }    
}