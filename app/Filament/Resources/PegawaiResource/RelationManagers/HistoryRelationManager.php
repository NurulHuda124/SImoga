<?php

namespace App\Filament\Resources\PegawaiResource\RelationManagers;

use App\Models\History;
use App\Models\MitraPerusahaan;
use DateTime;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class HistoryRelationManager extends RelationManager
{
    protected static ?string $model = History::class;
    protected static string $relationship = 'history';
    protected static ?string $title = "Riwayat";
    protected static ?string $recordTitleAttribute = 'no_induk_karyawan';

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
                TextColumn::make('no_induk_karyawan')->searchable()->label('No. Induk Karyawan'),
                BadgeColumn::make('file_ktp')
                ->label('File KTP')->color('secondary')
                ->limit(20)->icon('heroicon-s-external-link')
                ->url(fn ($record) => Storage::url($record->file_nda))
                ->openUrlInNewTab(),
                BadgeColumn::make('file_nda')
                ->label('File NDA')->color('primary')
                ->limit(20)->icon('heroicon-s-external-link')
                ->url(fn ($record) => Storage::url($record->file_nda))
                ->openUrlInNewTab(),
                TextColumn::make('nama_karyawan')->searchable()->label('Nama Karyawan'),
                TextColumn::make('nik')->searchable()->label('NIK'),
                BadgeColumn::make('email')->searchable()->toggleable()->icon('heroicon-o-mail')->color('warning')
                ->copyable()
                ->copyMessage('Email address copied')
                ->copyMessageDuration(1500),
                TextColumn::make('sex')->searchable()->label('Jenis Kelamin'),
                TextColumn::make('tempat_lahir')->searchable()->toggleable()->label('Tempat Lahir'),
                TextColumn::make('tanggal_lahir')->date()->searchable()->toggleable()->label('Tanggal Lahir'),
                TextColumn::make('alamat')->limit(40)->searchable()->toggleable(),
                TextColumn::make('no_telp')->searchable()->toggleable()->label('No. Telp')->copyable()
                ->copyMessage('No. Telp copied')
                ->copyMessageDuration(1500),
                TextColumn::make('jabatan')->searchable(),
                TextColumn::make('divisi')->limit(40)->searchable(),
                TextColumn::make('jenis_mitra')->searchable()->label('Jenis Mitra'),
                TextColumn::make('nama_perusahaan')->limit(40)->searchable()->toggleable()->label('Nama Perusahaan'),
                TextColumn::make('no_kontrak_perusahaan')->searchable()->toggleable()->label('No. Kontrak Perusahaan'),
                TextColumn::make('tanggal_kontrak_awal_perusahaan')->date()->searchable()->toggleable()->label('Tanggal
                Kontrak Awal Perusahaan'),
                TextColumn::make('tanggal_kontrak_akhir_perusahaan')->date()->searchable()->toggleable()->label('Tanggal
                Kontrak Akhir Perusahaan'),
                TextColumn::make('tanggal_kontrak_awal')->date()->searchable()->toggleable()->label('Tanggal Kontrak
                Awal Karyawan'),
                TextColumn::make('tanggal_kontrak_akhir')->date()->searchable()->toggleable()->label('Tanggal Kontrak
                Akhir Karyawan'),
                IconColumn::make('status_kontrak')->label('Status Masa Kontrak')
                    ->options([
                        'heroicon-s-check-circle' => fn ($state): bool => $state > date('Y-m-d'),
                        'heroicon-s-x-circle' => fn ($state): bool => $state <= date('Y-m-d'), 'heroicon-s-exclamation-circle' => fn ($state): bool =>
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
                            $state >
                            $currentDate
                            && $state <= $nextYearDate
                        ) {
                            return 'Kontrak Hampir Tidak Berlaku';
                        }
                        return null;
                    }), IconColumn::make('status_pensiun')->label('Status Pensiun')
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
                    ->tooltip(function (IconColumn $column) {
                        $state = $column->getState();
                        $tanggalLahir = new DateTime($state);
                        $tanggalPensiun = clone $tanggalLahir;
                        $tanggalPensiun->modify('+56 years');
                        $sekarang = new DateTime();
                        $setahunKemudian = clone $sekarang;
                        $setahunKemudian->modify('+1 years');
                        $selisih1 = $tanggalLahir->diff($sekarang);
                        $selisih2 = $tanggalPensiun->diff($setahunKemudian);

                        if (
                            $selisih2->y == 0 && $selisih2->m == 0 && $sekarang <
                            $setahunKemudian
                        ) {
                            return 'Hampir Pensiun';
                        } elseif ($selisih1->y >= 56) {
                            return 'Pensiun';
                        } elseif ($selisih1->y < 56) {
                            return 'Belum Pensiun';
                        }
                        return
                            null;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('show')->label('PDF')
                ->icon('heroicon-s-printer')->color('success')
                ->url(fn (History $record) => route('downloadhistory.pdf', $record))
                ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
