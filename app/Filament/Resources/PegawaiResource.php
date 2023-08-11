<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\MitraPerusahaan;
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
use Filament\Widgets\StatsOverviewWidget;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Closure;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Livewire\TemporaryUploadedFile;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_pegawai', 'jenis_mitra', 'email', 'jabatan', 'alamat'];
    }
    protected static ?string $pluralModelLabel = 'Karyawan';
    protected static ?string $navigationLabel = 'Karyawan';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'MANAJEMEN KARYAWAN';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Diri')->schema([
                    TextInput::make('no_induk_karyawan')->required(),
                    TextInput::make('nama_karyawan')->required(),
                    TextInput::make('nik')
                    ->label('NIK')->required()
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    TextInput::make('email')->required(),
                    TextInput::make('jenis_kelamin')->required(),
                    TextInput::make('tempat_lahir')->required(),
                    DatePicker::make('tanggal_lahir')->format('Y-m-d')->required(),
                    Select::make('jabatan')->required()
                        ->options(Jabatan::all()->pluck('jabatan', 'jabatan')),
                    Select::make('divisi')->label('Fungsi')->required()
                        ->options(Divisi::all()->pluck('divisi', 'divisi')),
                    TextInput::make('no_telp')->required()
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    TextArea::make('alamat')->required(),
                ])->columns(2),
                Section::make('Unggah Berkas')->schema([
                    FileUpload::make('file_ktp')
                        ->image()
                        ->enableDownload()
                        ->enableOpen()
                        ->label('File KTP')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend('ktp-');
                        }),
                    FileUpload::make('file_nda')
                        ->label('File NDA')
                        ->enableDownload()
                        ->enableOpen()
                        ->acceptedFileTypes(['application/pdf'])
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str($file->getClientOriginalName())->prepend('nda-');
                        }),
                ]),
                Section::make('Mitra')->schema([
                    Select::make('no_kontrak_perusahaan')->required()
                        ->options(MitraPerusahaan::all()->pluck('no_kontrak_perusahaan', 'no_kontrak_perusahaan')),
                    Select::make('jenis_mitra')->required()
                        ->searchable()
                        ->options(function (Closure $get) {
                            return MitraPerusahaan::where(
                                'no_kontrak_perusahaan',
                                $get('no_kontrak_perusahaan')
                            )->pluck(
                                'jenis_mitra',
                                'jenis_mitra'
                            );
                        }),
                    Select::make('nama_perusahaan')->required()
                        ->searchable()
                        ->options(function (Closure $get) {
                            return MitraPerusahaan::where(
                                'no_kontrak_perusahaan',
                                $get('no_kontrak_perusahaan')
                            )->pluck(
                                'nama_perusahaan',
                                'nama_perusahaan'
                            );
                        }),
                    Select::make('tanggal_kontrak_awal_perusahaan')->required()
                        ->searchable()
                        ->options(function (Closure $get) {
                            return MitraPerusahaan::where(
                                'no_kontrak_perusahaan',
                                $get('no_kontrak_perusahaan')
                            )->pluck(
                                'tanggal_kontrak_awal_perusahaan',
                                'tanggal_kontrak_awal_perusahaan'
                            );
                        }),
                    Select::make('tanggal_kontrak_akhir_perusahaan')->required()
                        ->searchable()
                        ->options(function (Closure $get) {
                            return MitraPerusahaan::where(
                                'no_kontrak_perusahaan',
                                $get('no_kontrak_perusahaan')
                            )->pluck(
                                'tanggal_kontrak_akhir_perusahaan',
                                'tanggal_kontrak_akhir_perusahaan'
                            );
                        }),
                ])->columns(2),
                Section::make('Masa Kerja')->schema([
                    DatePicker::make('tanggal_kontrak_awal')->format('Y-m-d')->required(),
                    DatePicker::make('tanggal_kontrak_akhir')->format('Y-m-d')->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_induk_karyawan')->searchable(),
                ImageColumn::make('file_ktp')->width(100)->height('auto')
                    ->label('File KTP')
                    ->url(fn ($record) => Storage::url($record->file_ktp))
                    ->openUrlInNewTab(),
                BadgeColumn::make('file_nda')
                    ->label('File NDA')
                    ->limit(20)
                    ->url(fn ($record) => Storage::url($record->file_nda))
                    ->openUrlInNewTab(),
                TextColumn::make('nama_karyawan')->searchable(),
                TextColumn::make('nik')->searchable()->toggleable(),
                TextColumn::make('jenis_kelamin')->searchable()->toggleable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('tempat_lahir')->searchable()->toggleable(),
                TextColumn::make('tanggal_lahir')->date()->searchable()->toggleable(),
                TextColumn::make('alamat')->searchable()->toggleable(),
                TextColumn::make('no_telp')->searchable()->toggleable(),
                TextColumn::make('jabatan')->searchable(),
                TextColumn::make('divisi')->searchable(),
                TextColumn::make('jenis_mitra')->searchable(),
                TextColumn::make('nama_perusahaan')->searchable()->toggleable(),
                TextColumn::make('no_kontrak_perusahaan')->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_awal_perusahaan')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_akhir_perusahaan')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_awal')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_akhir')->date()->searchable()->toggleable(),
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
                Tables\Actions\ViewAction::make()->color('success'),
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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'view' => Pages\ViewPegawai::route('/{record}'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class
        ];
    }
}