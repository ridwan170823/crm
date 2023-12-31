<?php

namespace App\Filament\Pages\Auth;

use Illuminate\Http\RedirectResponse;
use Filament\Pages\Auth\Login as BasePage;
use Livewire\Features\SupportRedirects\Redirector;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();
    }
}
