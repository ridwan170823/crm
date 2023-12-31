<?php

namespace App\Filament\Resources\KerjaSamaResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\KerjaSamaResource;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\KerjaSamaResource\Widgets\KerjaSamaStats;
use App\Filament\Widgets\StatusKerjaSama;
use App\Models\KerjaSama;

class ListKerjaSamas extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = KerjaSamaResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KerjaSamaStats::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            StatusKerjaSama::make(),
        ];
    }
}
