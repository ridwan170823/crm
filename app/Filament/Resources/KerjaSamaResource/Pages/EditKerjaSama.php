<?php

namespace App\Filament\Resources\KerjaSamaResource\Pages;

use App\Filament\Resources\KerjaSamaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKerjaSama extends EditRecord
{
    protected static string $resource = KerjaSamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
