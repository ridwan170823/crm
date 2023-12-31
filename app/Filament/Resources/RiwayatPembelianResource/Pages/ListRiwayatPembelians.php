<?php

namespace App\Filament\Resources\RiwayatPembelianResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\RiwayatPembelianResource;
use App\Filament\Resources\RiwayatPembelianResource\Widgets\RiwayatPembelianStats;

class ListRiwayatPembelians extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = RiwayatPembelianResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RiwayatPembelianStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
        ];
    }
}
