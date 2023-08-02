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

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $pluralModelLabel = 'Data Pegawai';
    protected static ?string $navigationLabel = 'Data Pegawai';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'MANAJEMEN PEGAWAI';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                TextInput::make('nama_pegawai')->required(),
                TextInput::make('email')->required(),
                TextInput::make('tempat_lahir')->required(),
                DatePicker::make('tanggal_lahir')->format('Y-m-d')->required(),
                TextArea::make('alamat')->required(),
                TextInput::make('no_telp')->required(),
                Select::make('jabatan')->required()
                ->options(Jabatan::all()->pluck('jabatan', 'jabatan')),
                Select::make('divisi')->required()
                ->options(Divisi::all()->pluck('divisi', 'divisi')),
                Select::make('jenis_mitra')->required()
                ->options(MitraPerusahaan::all()->pluck('jenis_mitra', 'jenis_mitra')),
                Select::make('nama_perusahaan')->required()
                ->searchable()
                ->options(function (Closure $get) {
                return MitraPerusahaan::where('jenis_mitra', $get('jenis_mitra'))->pluck('nama_perusahaan',
                'nama_perusahaan');}),
                DatePicker::make('tanggal_kontrak_awal')->format('Y-m-d')->required(),
                DatePicker::make('tanggal_kontrak_akhir')->format('Y-m-d')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pegawai')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('tempat_lahir')->searchable()->toggleable(),
                TextColumn::make('tanggal_lahir')->date()->searchable()->toggleable(),
                TextColumn::make('alamat')->searchable()->toggleable(),
                TextColumn::make('no_telp')->searchable()->toggleable(),
                TextColumn::make('jabatan')->searchable(),
                TextColumn::make('divisi')->searchable(),
                TextColumn::make('jenis_mitra')->searchable(),
                TextColumn::make('nama_perusahaan')->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_awal')->date()->searchable()->toggleable(),
                TextColumn::make('tanggal_kontrak_akhir')->date()->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('jenis_mitra')
                ->options([
                'TKJP'=>'TKJP',
                'Konsultan'=>'Konsultan',
                'Audit'=>'Audit',
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
