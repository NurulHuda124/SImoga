<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PensiunResource\Pages;
use App\Models\Pensiun;
use DateTime;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\StatsOverviewWidget;

class PensiunResource extends Resource
{
    protected static ?string $model = Pensiun::class;

    protected static ?string $recordTitleAttribute = 'nama_pegawai';
    protected static ?string $pluralModelLabel= 'Pensiun';
    protected static ?string $navigationLabel = 'Pensiun';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'MANAJEMEN MASA KERJA PEGAWAI';
    protected static ?int $navigationSort = 2;
    protected static function getNavigationBadge(): ?string
    {
    return static::getModel()::where(function ($query) {
    $query->whereDate('status_pensiun', '<=', now()->subYears(54));
        })->count();
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
                TextColumn::make('nama_pegawai')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('tanggal_lahir')->date()->searchable()->toggleable(),
                IconColumn::make('status_pensiun')
                ->options([
                    'heroicon-s-x-circle' => function ($state) {
                        $tanggalLahir = new DateTime($state);
                        $selisih = $tanggalLahir->diff(new DateTime());
                        return $selisih->y >= 54;
                    },
                    'heroicon-s-check-circle' => function ($state) {
                        $tanggalLahir = new DateTime($state);
                        $selisih = $tanggalLahir->diff(new DateTime());
                        return $selisih->y < 54; 
                    }, 
                    'heroicon-s-exclamation-circle' => function ($state) {
                        $tanggalLahir = new DateTime($state);
                        $tanggalPensiun = $tanggalLahir->modify('+54 years');
                        $sekarang = new DateTime();
                        // Hitung tanggal sebulan ke depan dari sekarang
                        $sebulanKemudian = new DateTime();
                        $sebulanKemudian->modify('+1 month');
                        // Hitung selisih tanggal pensiun dengan tanggal sebulan ke depan
                        $selisih = $sebulanKemudian->diff($tanggalPensiun);
                        return $selisih->m == 0 && $sekarang < $sebulanKemudian; 
                    },
                 ])
                ->colors([
                    'danger' => function ($state) {
                        $tanggalLahir = new DateTime($state);
                        $selisih = $tanggalLahir->diff(new DateTime());
                        return $selisih->y >= 54;
                    },
                    'success' => function ($state) {
                        $tanggalLahir = new DateTime($state);
                        $selisih = $tanggalLahir->diff(new DateTime());
                        return $selisih->y < 54; 
                    } ,
                    'warning' => function ($state) {
                        $tanggalLahir = new DateTime($state);
                        $tanggalPensiun = $tanggalLahir->modify('+54 years');
                        $sekarang = new DateTime();

                        // Hitung tanggal sebulan ke depan dari sekarang
                        $sebulanKemudian = new DateTime();
                        $sebulanKemudian->modify('+1 month');

                        // Hitung selisih tanggal pensiun dengan tanggal sebulan ke depan
                        $selisih = $sebulanKemudian->diff($tanggalPensiun);

                        return $selisih->m == 0 && $sekarang < $sebulanKemudian; 
                    }
                ])
                ->size('xl')
,
            ])
            ->filters([
                Filter::make('status_pensiun')
                ->form([
                DatePicker::make('tanggal_pensiun'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                return $query
                ->when(
                $data['tanggal_pensiun'],
                fn (Builder $query, $date): Builder => $query->whereDate('status_pensiun', '<', now()->subYears(54)), );
                })
                
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
               Tables\Actions\Action::make('print')
               ->icon('heroicon-s-printer')
               ->url(fn(Pensiun $record) => route('downloadpensiun.pdf', ['id' => $record->id]))
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
            'index' => Pages\ListPensiuns::route('/'),
            // 'create' => Pages\CreatePensiun::route('/create'),
            'view' => PegawaiResource\Pages\ViewPegawai::route('/{record}'),
            // 'edit' => Pages\EditPensiun::route('/{record}/edit'),
        ];
    }    

    public static function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class
        ];
    }
}
