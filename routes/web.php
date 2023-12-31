<?php

use App\Livewire\Form;
use App\Livewire\Clients;
use App\Models\KerjaSama;
use Illuminate\Support\Facades\Route;

\Illuminate\Support\Facades\Route::get('form', Form::class);

Route::get('/laravel/login', fn () => redirect('/'))->name('login');

Route::get('/test', function () {
    $kerjasama = KerjaSama::where('is_active', 1)
        ->where('tanggal_selesai', '<', now()->addDays(7)->toDateString())
        ->where('tanggal_selesai', '!=', now()->toDateString())
        ->pluck('id')->toArray();
    dd($kerjasama);
});
