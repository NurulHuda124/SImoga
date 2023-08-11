<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontrakResource\Pages;
use App\Models\Kontrak;
use DateTime;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\StatsOverviewWidget;

class KontrakResource extends Resource
{
    protected static ?string $model = Kontrak::class;

    protected static ?string $pluralModelLabel = 'Kontrak';
    protected static ?string $navigationLabel = 'Status Karyawan';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'MANAJEMEN MASA KERJA KARYAWAN';
    protected static ?int $navigationSort = 2;
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_kontrak', '>', date('Y-m-d'))->count();
    }

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
                TextColumn::make('no_induk_karyawan')->label('No Induk Karyawan')->searchable(),
                TextColumn::make('nama_karyawan')->label('Nama Karyawan')->searchable(),
                BadgeColumn::make('email')->icon('heroicon-o-mail')->color('warning')->copyable()
                ->copyMessage('Email address copied')
                ->copyMessageDuration(1500)->searchable()->toggleable(),
                TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date()->searchable()->toggleable(),
                TextColumn::make('no_kontrak_perusahaan')
                ->label('No Kontrak Perusahaan')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_awal')
                ->label('Tanggal Kontrak Dimulai')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_akhir')
                ->label('Tanggal Kontrak Berakhir')->date()->searchable()->toggleable(),
                IconColumn::make('status_kontrak')->label('Status Masa Kontrak')
                    ->options([
                        'heroicon-s-check-circle' => fn ($state): bool => $state > date('Y-m-d'),
                        'heroicon-s-x-circle' => fn ($state): bool => $state <= date('Y-m-d'),
                        'heroicon-s-exclamation-circle' => fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')),
                    ])
                    ->colors([
                        'success' => fn ($state): bool => $state > date('Y-m-d'),
                        'danger' => fn ($state): bool => $state <= date('Y-m-d'),
                        'warning' => fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')),
                    ])
                    ->size('xl'),
                IconColumn::make('status_pensiun')
                    ->options([
                        'heroicon-s-x-circle' => function ($state) {
                            $tanggalLahir = new DateTime($state);
                            $selisih = $tanggalLahir->diff(new DateTime());
                            return $selisih->y >= 56;
                        },
                        'heroicon-s-check-circle' => function ($state) {
                            $tanggalLahir = new DateTime($state);
                            $selisih = $tanggalLahir->diff(new DateTime());
                            return $selisih->y < 56;
                        }, 'heroicon-s-exclamation-circle' => function ($state) {
                            $tanggalLahir = new DateTime($state);
                            $tanggalPensiun = $tanggalLahir->modify('+56 years');
                            $sekarang = new DateTime();
                            // Hitung tanggal setahun ke depan dari sekarang
                            $setahunKemudian = new DateTime();
                            $setahunKemudian->modify('+1 years');
                            // Hitung selisih tanggal pensiun dengan tanggal setahun ke depan
                            $selisih = $setahunKemudian->diff($tanggalPensiun);
                            return $selisih->m == 0 && $sekarang < $setahunKemudian;
                        },
                    ])->colors([
                        'danger' => function ($state) {
                            $tanggalLahir = new DateTime($state);
                            $selisih = $tanggalLahir->diff(new DateTime());
                            return $selisih->y >= 56;
                        },
                        'success' => function ($state) {
                            $tanggalLahir = new DateTime($state);
                            $selisih = $tanggalLahir->diff(new DateTime());
                            return $selisih->y < 56;
                        }, 'warning' => function ($state) {
                            $tanggalLahir = new DateTime($state);
                            $tanggalPensiun = $tanggalLahir->modify('+56 years');
                            $sekarang = new DateTime();
                            $setahunKemudian = new DateTime();
                            $setahunKemudian->modify('+1 years');
                            $selisih = $setahunKemudian->diff($tanggalPensiun);

                            return $selisih->m == 0 && $sekarang < $setahunKemudian;
                        }
                    ])->size('xl')
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
                            );
                    })
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('show')->label('PDF')
                    ->icon('heroicon-s-printer')
                    ->url(fn (Kontrak $record) => route('downloadkontrak.pdf', $record))
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
