<?php

namespace App\Filament\Resources\KerjaSamaResource\Widgets;

use App\Models\KerjaSama;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class KerjaSamaStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalKerjaSamaCount = KerjaSama::count();
        $activeKerjaSamaCount = KerjaSama::where('is_active', 1)->count();
        $nonActiveKerjaSamaCount = KerjaSama::where('is_active', 0)->count();
        $endingSoonKerjaSamaCount = KerjaSama::where('is_active', 1)
            ->where('tanggal_selesai', '<', now()->addDays(7)->toDateString())
            ->where('tanggal_selesai', '!=', now()->toDateString())
            ->count();
        return [


            Stat::make('Total Kerja Sama', "{$totalKerjaSamaCount} Kerja Sama")
                ->value($totalKerjaSamaCount)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart(KerjaSama::pluck('id')->toArray())
                ->color('primary'),

            Stat::make('Kerja Sama Active', "{$activeKerjaSamaCount} Kerja Sama")
                ->value($activeKerjaSamaCount)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart(KerjaSama::where('is_active', 1)->pluck('id')->toArray())
                ->color('success'),

            Stat::make('Kerja Sama Non Active', $nonActiveKerjaSamaCount)
                ->value($nonActiveKerjaSamaCount)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart(KerjaSama::where('is_active', 0)->pluck('id')->toArray())
                ->color('warning'),

            Stat::make('Kerja Akan Berakhir', $endingSoonKerjaSamaCount)
                ->value($endingSoonKerjaSamaCount)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart(KerjaSama::where('is_active', 1)
                    ->where('tanggal_selesai', '<', now()->addDays(7)->toDateString())
                    ->where('tanggal_selesai', '!=', now()->toDateString())
                    ->pluck('id')->toArray())
                ->color('danger')

        ];
    }
}
