<?php

namespace App\Filament\Resources\RiwayatPembelianResource\Widgets;

use Flowframe\Trend\Trend;
use App\Models\ProdukKerjaSama;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\RiwayatKerjaSamaResource\Pages\ListRiwayatKerjaSamas;
use App\Filament\Resources\RiwayatPembelianResource\Pages\ListRiwayatPembelians;

class RiwayatPembelianStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListRiwayatPembelians::class;
    }

    protected function getStats(): array
    {
        $kerjaSamaData = Trend::model(ProdukKerjaSama::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Kerja Sama', $this->getPageTableQuery()->count())
                ->chart(
                    $kerjaSamaData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),


        ];
    }
}
