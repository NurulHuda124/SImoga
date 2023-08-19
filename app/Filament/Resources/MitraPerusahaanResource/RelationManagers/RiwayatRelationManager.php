<?php

namespace App\Filament\Resources\MitraPerusahaanResource\RelationManagers;

use App\Models\Riwayat;
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

class RiwayatRelationManager extends RelationManager
{
    protected static string $relationship = 'riwayat';

    protected static ?string $recordTitleAttribute = 'mitra_perusahaan_id';

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
            TextColumn::make('tanggal_kontrak_awal_perusahaan')->date()->searchable()->toggleable()->label('Tanggal
            Kontrak Awal Perusahaan'),
            TextColumn::make('tanggal_kontrak_akhir_perusahaan')->date()->searchable()->toggleable()->label('Tanggal
            Kontrak Akhir Perusahaan'),
            IconColumn::make('status_kontrak_perusahaan')->label('Status Kontrak Perusahaan')
            ->options([
            'heroicon-s-check-circle' => fn ($state): bool => $state > date('Y-m-d'),
            'heroicon-s-x-circle' => fn ($state): bool => $state <= date('Y-m-d'), 'heroicon-s-exclamation-circle'=>
                fn ($state): bool =>
                $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')), ])->colors([
                    'success' => fn ($state): bool => $state > date('Y-m-d'),
                    'danger' => fn ($state): bool => $state <= date('Y-m-d'), 'warning'=> fn ($state): bool =>
                        $state > date('Y-m-d') && $state <= date('Y-m-d', strtotime('+1 years')), ])->size('xl')
                            ->tooltip(function (IconColumn $column) {
                            $state = $column->getState();
                            $currentDate = date('Y-m-d');
                            $nextYearDate = date('Y-m-d', strtotime('+1 year'));

                            if ($state > $nextYearDate) {
                            return 'Kontrak Berlaku';
                            } elseif ($state <= $currentDate) { return 'Kontrak Tidak Berlaku' ; } elseif ( $state>
                                $currentDate
                                && $state <= $nextYearDate ) { return 'Kontrak Hampir Tidak Berlaku' ; } return null;
                                    }), ])
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
                ->url(fn (Riwayat $record) => route('downloadriwayat.pdf', $record))
                ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}