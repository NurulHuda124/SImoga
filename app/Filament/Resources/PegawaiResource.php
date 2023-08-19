<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers\HistoryRelationManager;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\MitraPerusahaan;
use App\Models\Pegawai;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use PhpParser\Node\Stmt\Label;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_karyawan', 'jenis_mitra', 'email', 'jabatan', 'alamat'];
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
                    TextInput::make('no_induk_karyawan')
                        ->required()->label('No. Induk Karyawan')
                        ->unique(Pegawai::class, 'no_induk_karyawan', ignoreRecord: true),
                    TextInput::make('nama_karyawan')->required()->label('Nama Karyawan'),
                    TextInput::make('nik')->required()
                        ->label('NIK')
                        ->numeric()
                        ->unique(Pegawai::class, 'nik', ignoreRecord: true),
                    TextInput::make('email')->required(),
                    TextInput::make('tempat_lahir')->required()->label('Tempat Lahir'),
                    DatePicker::make('tanggal_lahir')->format('Y-m-d')->required()->label('Tanggal Lahir'),
                    Select::make('sex')->label('Jenis_kelamin')->required()
                        ->options([
                            'laki-laki' => 'Laki-laki',
                            'perempuan' => 'Perempuan'
                        ]),
                    Select::make('jabatan')->required()
                        ->options(Jabatan::all()->pluck('jabatan', 'jabatan')),
                    Select::make('divisi')->label('Fungsi')->required()
                        ->options(Divisi::all()->pluck('divisi', 'divisi')),
                    TextInput::make('no_telp')->required()
                        ->label('No. Telp')
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    TextArea::make('alamat')->required(),
                ])->columns(2),
                Section::make('Unggah Berkas')->schema([
                    FileUpload::make('file_ktp')
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
                    Select::make('no_kontrak_perusahaan')->required()->label('No. Kontrak Perusahaan')
                        ->options(MitraPerusahaan::all()->pluck('no_kontrak_perusahaan', 'no_kontrak_perusahaan')),
                    Select::make('jenis_mitra')->required()
                        ->label('Jenis Mitra')
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
                        ->label('Nama Perusahaan')
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
                        ->label('Tanggal Kontrak Awal Perusahaan')
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
                        ->label('Tanggal Kontrak Akhir Perusahaan')
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
                    DatePicker::make('tanggal_kontrak_awal')->format('Y-m-d')->required()->label('Tanggal Kontrak Awal Karyawan'),
                    DatePicker::make('tanggal_kontrak_akhir')->format('Y-m-d')->required()->label('Tanggal Kontrak Akhir Karyawan'),
                ])->columns(2),
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
                TextColumn::make('tanggal_kontrak_awal_perusahaan')->date()->searchable()->toggleable()->label('Tanggal Kontrak Awal Perusahaan'),
                TextColumn::make('tanggal_kontrak_akhir_perusahaan')->date()->searchable()->toggleable()->label('Tanggal Kontrak Akhir Perusahaan'),
                TextColumn::make('tanggal_kontrak_awal')->date()->searchable()->toggleable()->label('Tanggal Kontrak Awal Karyawan'),
                TextColumn::make('tanggal_kontrak_akhir')->date()->searchable()->toggleable()->label('Tanggal Kontrak Akhir Karyawan'),
            ])
            ->filters([
                SelectFilter::make('jenis_mitra')
                    ->options([
                        'TKJP' => 'TKJP',
                        'Konsultan' => 'Konsultan',
                        'Auditor' => 'Auditor',
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
            HistoryRelationManager::class,
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
