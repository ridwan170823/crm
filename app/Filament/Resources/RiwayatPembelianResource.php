<?php

namespace App\Filament\Resources;

use Filament\Tables\Table;
use App\Models\ProdukKerjaSama;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\RiwayatPembelianResource\Pages;

class RiwayatPembelianResource extends Resource
{
    protected static ?string $model = ProdukKerjaSama::class;

    protected static ?string $modelLabel = 'Riwayat Pembelian';

    protected static ?string $navigationIcon =  'Wallet';

    protected static ?string $navigationGroup = 'Riwayat';

    protected static ?string $navigationLabel = 'Riwayat Pembelian';

    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('kerja_samas_id')
            ->columns([
                TextColumn::make('kerjaSama.masa_kerja_sama')
                    ->label('Masa Kerja Sama')
                    ->sortable()
                    ->searchable(isIndividual: true),
                TextColumn::make('kerjaSama.client.nama_institusi')
                    ->label('Client')
                    ->sortable()
                    ->searchable(isIndividual: true),
                TextColumn::make('produk.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kerjaSama.nilai_kerja_sama_bulanan')
                    ->label('Nilai Kerja Sama Bulanan')
                    ->sortable()
                    ->searchable()
                    ->money('IDR'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatPembelians::route('/'),
        ];
    }
}
