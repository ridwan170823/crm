<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ClientChart extends ChartWidget
{
    protected static ?string $heading = 'Total Client';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {

        $clients = \App\Models\Client::all();

        $monthlyCounts = array_fill(1, 12, 0);

        foreach ($clients as $client) {
            $month = Carbon::parse($client->created_at)->month;

            $monthlyCounts[$month]++;
        }
        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' =>  array_values($monthlyCounts),
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
