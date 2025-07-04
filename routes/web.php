<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Menu\Setting\{
    SettingController,
    MasterRuanganController,
    MasterPegawaiController,
    SettingBpjsController,
    SettingServicesUrlController,
    SettingSatuSehatController
};
use App\Http\Controllers\Services\SatuSehat\SatuSehatController;
use Illuminate\Support\Facades\Auth;

// Auth routes
Auth::routes([
    'register' => false,
    'reset'    => true,
    'verify'   => true,
]);

// Landing & login redirect
Route::get(
    '/',
    fn() => Auth::check()
        ? redirect()->route('menu.dashboard')
        : redirect()->route('login')
)->name('welcome');

Route::get('register', fn() => redirect()->route('login'))
    ->middleware('guest');

Route::post('captcha/reload', [LoginController::class, 'reload'])
    ->name('captcha.reload');

// Semua route /menu/* butuh autentikasi & verified
Route::middleware(['auth', 'verified'])
    ->prefix('menu')
    ->name('menu.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [HomeController::class, 'dashboard'])
            ->name('dashboard');
    });
