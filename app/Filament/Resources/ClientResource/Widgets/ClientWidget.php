<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ClientWidget extends BaseWidget
{
    protected static ?string $heading = 'Chart';

    protected function getStats(): array
    {
        $clientData = Client::all();

        $totalClientsData = [];
        $lengkapData = [];

        foreach ($clientData as $client) {
            $totalClientsData[] = [
                'id' => $client->id,
                'created_at' => $client->created_at,
            ];
        }
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $newClientsData = Client::query()
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->get();

        $lengkapDataD = Client::query()
            ->whereHas('media')
            ->get();

        $newClientsChartData = [];

        foreach ($newClientsData as $client) {
            $newClientsChartData[] = [
                'id' => $client->id,
                'created_at' => $client->created_at,
            ];
        }

        foreach ($lengkapDataD as $client) {
            $lengkapData[] = [
                'id' => $client->id,
                'created_at' => $client->created_at,
            ];
        }

        return [

            Stat::make('Total Clients', count($totalClientsData), 'heroicon-s-users')
                ->value(count($totalClientsData))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart(array_column($totalClientsData, 'id'))
                ->color('success'),

            Stat::make('New Clients 30 Hari', count($newClientsChartData), 'heroicon-s-user-add')
                ->value(count($newClientsChartData))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart(array_column($newClientsChartData, 'id'))
                ->color('success'),

            Stat::make('Lengkap', count($lengkapData), 'heroicon-s-user-add')
                ->value(count($lengkapData))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart(array_column($lengkapData, 'id'))
                ->color('danger'),
        ];
    }
}
