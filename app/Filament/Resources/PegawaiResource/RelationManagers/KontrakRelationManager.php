<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KontrakRelationManager extends RelationManager
{
    protected static string $relationship = 'kontrak';

    protected static ?string $recordTitleAttribute = 'nama_pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pegawai')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_pegawai'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('tempat_lahir'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->date(),
                Tables\Columns\TextColumn::make('alamat'),
                Tables\Columns\TextColumn::make('no_telp'),
                Tables\Columns\TextColumn::make('jabatan'),
                Tables\Columns\TextColumn::make('divisi'),
                Tables\Columns\TextColumn::make('jenis_mitra'),
                Tables\Columns\TextColumn::make('tanggal_kontrak_awal')->date(),
                Tables\Columns\TextColumn::make('tanggal_kontrak_akhir')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
