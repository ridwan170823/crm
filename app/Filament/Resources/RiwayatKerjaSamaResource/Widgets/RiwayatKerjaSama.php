<?php

namespace App\Filament\Resources\RiwayatKerjaSamaResource\Widgets;

use App\Models\KerjaSama;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\RiwayatKerjaSamaResource\Pages\ListRiwayatKerjaSamas;

class RiwayatKerjaSama extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListRiwayatKerjaSamas::class;
    }

    protected function getStats(): array
    {
        $kerjaSamaData = Trend::model(KerjaSama::class)
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
            Stat::make('Open Kerja Sama', $this->getPageTableQuery()->whereIn('is_active', [true, false])->count())
                ->chart(
                    $kerjaSamaData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make('Rata Rata Nilai Kerja Sama Bulanan', number_format($this->getPageTableQuery()->avg('nilai_kerja_sama_bulanan'), 2)),
        ];
    }
}
