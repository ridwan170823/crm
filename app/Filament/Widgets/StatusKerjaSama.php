<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\KerjaSama;
use Filament\Tables\Table;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\KerjaSamaResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;

class StatusKerjaSama extends BaseWidget
{
    protected static ?int $sort = 3;


    public function table(Table $table): Table
    {
        $today = Carbon::now()->toDateString();
        $warningDate = Carbon::now()->addDays(7)->toDateString();

        $query = KerjaSama::where('is_active', 1)
            ->select('*')
            ->selectRaw('DATEDIFF(tanggal_selesai, ?) AS days_remaining', [$today])
            ->selectRaw('
        CASE
            WHEN DATEDIFF(tanggal_selesai, ?) = 0 THEN "Selesai"
            WHEN DATEDIFF(tanggal_selesai, ?) <= 7 THEN "Akan Berakhir"
            ELSE "Berjalan"
        END AS status_kerja_sama', [$today, $today])
            ->where('tanggal_selesai', '<', $warningDate)
            ->where('tanggal_selesai', '!=', $today)
            ->orderBy('days_remaining', 'asc')
            ->with('client');

        if ($query->count() > 0) {
            foreach ($query->get() as $kerjaSama) {
                $body = "Kerja sama dengan {$kerjaSama->client->nama_institusi} akan berakhir pada " .
                    "{$kerjaSama->tanggal_selesai->format('d F Y')}";

                $checkNotifikasi = DatabaseNotification::where('notifiable_id', auth()->user()->id)
                    ->where('notifiable_type', 'App\\Models\\User')
                    ->where('data->body', $body)
                    ->first();

                if (!$checkNotifikasi) {
                    Notification::make()
                        ->title('Status Kerja Sama')
                        ->body($body)
                        ->icon('ExclamationCircle')
                        ->iconColor('red')
                        ->status('warning')
                        ->actions([
                            Action::make('View')
                                ->url(KerjaSamaResource::getUrl('edit', ['record' => $kerjaSama])),
                        ])
                        ->sendToDatabase(auth()->user());
                }
            }
        }

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('client.nama_institusi')
                    ->label('Client')
                    ->sortable(),
                TextColumn::make('tanggal_selesai')
                    ->label('Remaining ')
                    ->since(),
                TextColumn::make('status_kerja_sama')
                    ->label('Status')
                    ->sortable()
                    ->badge(),
            ])
            ->recordUrl(fn (KerjaSama $kerjaSama): string => KerjaSamaResource::getUrl('edit', ['record' => $kerjaSama]));
    }
}
