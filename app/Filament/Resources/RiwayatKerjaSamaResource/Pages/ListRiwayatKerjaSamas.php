<?php

namespace App\Filament\Resources\RiwayatKerjaSamaResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\RiwayatKerjaSamaResource;
use App\Filament\Resources\RiwayatKerjaSamaResource\Widgets\RiwayatKerjaSama;

class ListRiwayatKerjaSamas extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = RiwayatKerjaSamaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RiwayatKerjaSama::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'success' => Tab::make()->query(fn ($query) => $query->where('is_active', true)),
            'failed' => Tab::make()->query(fn ($query) => $query->where('is_active', false)),
        ];
    }
}
