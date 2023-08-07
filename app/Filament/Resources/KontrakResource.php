<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontrakResource\Pages;
use App\Models\Kontrak;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\StatsOverviewWidget;

class KontrakResource extends Resource
{
    protected static ?string $model = Kontrak::class;

    protected static ?string $recordTitleAttribute = 'nama_pegawai';
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
                TextColumn::make('nama_pegawai')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_awal')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_akhir')->date()->searchable()->toggleable(),
                IconColumn::make('status_kontrak')
                ->options([
                    'heroicon-s-check-circle' => fn ($state): bool => $state > date('Y-m-d'),
                    'heroicon-s-x-circle' => fn ($state): bool => $state <= date('Y-m-d'), 
                    'heroicon-s-exclamation-circle'=> fn ($state): bool => 
                    $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 month')), ])
                ->colors([
                    'success' => fn ($state): bool => $state > date('Y-m-d'),
                    'danger' => fn ($state): bool => $state <= date('Y-m-d'),
                    'primary' => fn ($state): bool =>
                    $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 month')),
                    ])
                ->size('xl'),
            ])
            ->filters([
                Filter::make('status_kontrak')
                ->form([
                DatePicker::make('tanggal_kontrak_akhir'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                return $query
                ->when(
                $data['tanggal_kontrak_akhir'],
                fn (Builder $query, $date): Builder => $query->whereDate('status_kontrak', '<=', $date),
                ); }) ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                ->icon('heroicon-s-printer')->color('success')
                ->url(fn(Kontrak $record)=>route('downloadkontrak.pdf', $record))
                ->openUrlInNewTab(),
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
    
    public static function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class
        ];
    }
}
