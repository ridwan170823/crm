<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Page;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function mount(): void
    {
        $previousRoute = url()->previous();
        if (strpos($previousRoute, 'login') !== false) {
            $this->js('alert("Welcome back, ' . auth()->user()->name . '! You have successfully logged in.")');

            Notification::make()
                ->title('Welcome back, ' . auth()->user()->name . '!')
                ->success()
                ->body('You have successfully logged in.')
                ->send();
        }
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([]);
    }
}
