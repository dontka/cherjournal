<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Volt::route('onboarding', 'onboarding')
    ->middleware(['auth'])
    ->name('onboarding');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('journal', 'journal')
    ->middleware(['auth', 'verified'])
    ->name('journal');

require __DIR__.'/auth.php';
