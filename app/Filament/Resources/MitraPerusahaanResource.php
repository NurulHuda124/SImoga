<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MitraPerusahaanResource\Pages;
use App\Filament\Resources\MitraPerusahaanResource\RelationManagers;
use App\Filament\Resources\MitraPerusahaanResource\RelationManagers\RiwayatRelationManager;
use App\Models\MitraPerusahaan;
use Closure;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\StatsOverviewWidget;

class MitraPerusahaanResource extends Resource
{
    protected static ?string $model = MitraPerusahaan::class;

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_perusahaan', 'jenis_mitra', 'email', 'website', 'no_telp_1', 'no_telp_2', 'no_telp_3'];
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
                    TextInput::make('nama_perusahaan')->required()->label('Nama Perusahaan'),
                    TextInput::make('jenis_mitra')->required()->label('Jenis Mitra'),
                    TextInput::make('email')->required(),
                    TextInput::make('website')->required()->url()
                        ->prefix('https://')
                        ->suffix('.com'),
                ])->columns(2),
                Section::make('Kontrak')->schema([
                    TextInput::make('no_kontrak_perusahaan')->required()->label('No. Kontrak Perusahaan')
                        ->unique(MitraPerusahaan::class, 'no_kontrak_perusahaan', ignoreRecord: true),
                    DatePicker::make('tanggal_kontrak_awal_perusahaan')->format('Y-m-d')->required()->label('Tanggal Kontrak Awal Perusahaan'),
                    DatePicker::make('tanggal_kontrak_akhir_perusahaan')->format('Y-m-d')->required()->label('Tanggal Kontrak Akhir Perusahaan')->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('status_kontrak_perusahaan', $state);
                        }),
                    DatePicker::make('status_kontrak_perusahaan')->format('Y-m-d')->disabled()->label('Status Kontrak Perusahaan')
                ])->columns(2),
                Section::make('Contact')->schema([
                    TextInput::make('no_telp_1')->required()->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                        ->label('No. Telp 1'),
                    TextInput::make('no_telp_2')->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                        ->label('No. Telp 2'),
                    TextInput::make('no_telp_3')->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                        ->label('No. Telp 3'),
                ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_kontrak_perusahaan')
                    ->searchable()
                    ->label('No. Kontrak Perusahaan'),
                TextColumn::make('nama_perusahaan')
                    ->searchable()
                    ->label('Nama Perusahaan'),
                TextColumn::make('jenis_mitra')->searchable()->label('Jenis Mitra'),
                BadgeColumn::make('email')->searchable()->toggleable()->icon('heroicon-o-mail')->color('warning')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500),
                BadgeColumn::make('website')->searchable()->toggleable()
                    ->color('secondary')
                    ->icon('heroicon-s-external-link')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab(),
                TextColumn::make('no_telp_1')->searchable()->toggleable()->label('No. Telp 1')->copyable()
                    ->copyMessage('No. Telp copied')
                    ->copyMessageDuration(1500),
                TextColumn::make('no_telp_2')->searchable()->toggleable()->label('No. Telp 2')->placeholder('Tidak
                Ada')->copyable()
                    ->copyMessage('No. Telp copied')
                    ->copyMessageDuration(1500),
                TextColumn::make('no_telp_3')->searchable()->toggleable()->label('No. Telp 3')->placeholder('Tidak
                Ada')->copyable()
                    ->copyMessage('No. Telp copied')
                    ->copyMessageDuration(1500),
                TextColumn::make('tanggal_kontrak_awal_perusahaan')->date()->searchable()->toggleable()->label('Tanggal Kontrak Awal Perusahaan'),
                TextColumn::make('tanggal_kontrak_akhir_perusahaan')->date()->searchable()->toggleable()->label('Tanggal Kontrak Akhir Perusahaan'),
                IconColumn::make('status_kontrak_perusahaan')->label('Status Kontrak Perusahaan')
                    ->options([
                        'heroicon-s-check-circle' => fn ($state): bool => $state > date('Y-m-d'),
                        'heroicon-s-x-circle' => fn ($state): bool => $state <= date('Y-m-d'), 'heroicon-s-exclamation-circle' =>
                        fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')),
                    ])->colors([
                        'success' => fn ($state): bool => $state > date('Y-m-d'),
                        'danger' => fn ($state): bool => $state <= date('Y-m-d'), 'warning' => fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')),
                    ])->size('xl')
                    ->tooltip(function (IconColumn $column) {
                        $state = $column->getState();
                        $currentDate = date('Y-m-d');
                        $nextYearDate = date('Y-m-d', strtotime('+1 year'));

                        if ($state > $nextYearDate) {
                            return 'Kontrak Berlaku';
                        } elseif ($state <= $currentDate) {
                            return 'Kontrak Tidak Berlaku';
                        } elseif (
                            $state > $currentDate
                            && $state <= $nextYearDate
                        ) {
                            return 'Kontrak Hampir Tidak Berlaku';
                        }
                        return null;
                    }),
            ])
            ->filters([
                SelectFilter::make('jenis_mitra')
                    ->options([
                        'TKJP' => 'TKJP',
                        'Konsultan' => 'Konsultan',
                        'Auditor' => 'Auditor',
                    ]),
                Filter::make('status_kontrak_perusahaan')
                    ->form([
                        DatePicker::make('tanggal_kontrak_akhir_perusahaan'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_kontrak_akhir_perusahaan'],
                                fn (Builder $query, $date): Builder => $query->whereDate('status_kontrak_perusahaan', '<=', $date),
                            );
                    })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('show')->label('PDF')
                ->icon('heroicon-s-printer')
                ->url(fn (MitraPerusahaan $record) => route('downloadmitra.pdf', $record))
                ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RiwayatRelationManager::class,
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