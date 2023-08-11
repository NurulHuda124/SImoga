<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MitraPerusahaanResource\Pages;
use App\Filament\Resources\MitraPerusahaanResource\RelationManagers;
use App\Models\MitraPerusahaan;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\StatsOverviewWidget;

class MitraPerusahaanResource extends Resource
{
    protected static ?string $model = MitraPerusahaan::class;

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_perusahaan', 'jenis_mitra', 'email', 'website', 'no_telp'];
    }
    protected static ?string $pluralModelLabel = 'Mitra Perusahaan';
    protected static ?string $navigationLabel = 'Mitra Perusahaan';
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = 'MANAJEMEN KARYAWAN';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Perusahaan')->schema([
                    TextInput::make('nama_perusahaan')->required(),
                    TextInput::make('jenis_mitra')->required(),
                    TextInput::make('email')->required(),
                    TextInput::make('website')->required()->url()
                        ->prefix('https://')
                        ->suffix('.com'),
                ])->columns(2),
                Section::make('Kontrak')->schema([
                    TextInput::make('no_kontrak_perusahaan')->required(),
                    DatePicker::make('tanggal_kontrak_awal_perusahaan')->format('Y-m-d')->required(),
                    DatePicker::make('tanggal_kontrak_akhir_perusahaan')->format('Y-m-d')->required()->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('status_kontrak_perusahaan', $state);
                        }),
                    DatePicker::make('status_kontrak_perusahaan')->format('Y-m-d')->disabled()
                ])->columns(2),
                Section::make('Contact')->schema([
                    TextInput::make('no_telp_1')->required()->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    TextInput::make('no_telp_2')->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    TextInput::make('no_telp_3')->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_kontrak_perusahaan')->searchable(),
                TextColumn::make('nama_perusahaan')->searchable(),
                TextColumn::make('jenis_mitra')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('website')->searchable()->toggleable(),
                TextColumn::make('no_telp_1')->searchable()->toggleable(),
                TextColumn::make('no_telp_2')->placeholder('Tidak Ada')->searchable()->toggleable(),
                TextColumn::make('no_telp_3')->placeholder('Tidak Ada')->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_awal_perusahaan')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_akhir_perusahaan')->date()->searchable()->toggleable(),
                IconColumn::make('status_kontrak_perusahaan')
                    ->options([
                        'heroicon-s-check-circle' => fn ($state): bool => $state > date('Y-m-d'),
                        'heroicon-s-x-circle' => fn ($state): bool => $state <= date('Y-m-d'), 
                        'heroicon-s-exclamation-circle' =>
                        fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')),
                    ])->colors([
                        'success' => fn ($state): bool => $state > date('Y-m-d'),
                        'danger' => fn ($state): bool => $state <= date('Y-m-d'), 'warning' => fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')),
                    ])->size('xl'),
            ])
            ->filters([
                SelectFilter::make('jenis_mitra')
                    ->options([
                        'TKJP' => 'TKJP',
                        'Konsultan' => 'Konsultan',
                        'Audit' => 'Audit',
                    ])
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
