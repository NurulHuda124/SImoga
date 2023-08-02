<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PensiunResource\Pages;
use App\Filament\Resources\PegawaiResource\Pages\ViewPegawai;
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
use Filament\Tables\Columns\IconColumn;

class PensiunResource extends Resource
{
    protected static ?string $model = Pensiun::class;

    protected static ?string $pluralModelLabel= 'Pensiun';
    protected static ?string $navigationLabel = 'Pensiun';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'MANAJEMEN MASA KERJA PEGAWAI';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Card::make()
                ->schema([
                TextInput::make('nama_pegawai')->required(),
                TextInput::make('email')->required(),
                DatePicker::make('tanggal_lahir')->format('Y-m-d')->required(),
                TextInput::make('status_pensiun')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pegawai'),
                TextColumn::make('email'),
                TextColumn::make('tanggal_lahir')->date(),
                IconColumn::make('status_pensiun')
                ->options([
                'heroicon-o-x-circle' => fn ($state): bool => $state === 54,
                'heroicon-o-check-circle',
                ])
                ->colors([
                'danger' => fn ($state): bool => $state === 54,
                'success',
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
            'index' => Pages\ListPensiuns::route('/'),
            // 'create' => Pages\CreatePensiun::route('/create'),
            'view' => PegawaiResource\Pages\ViewPegawai::route('/{record}'),
            // 'edit' => Pages\EditPensiun::route('/{record}/edit'),
        ];
    }    
}
