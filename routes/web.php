<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\InfografisController;
use App\Http\Controllers\Menu\Import\ImportMadrasahController;
use App\Http\Controllers\Menu\Madrasah\RA\RaController;
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
        : redirect()->route('home')
)->name('welcome');

Route::get('register', fn() => redirect()->route('login'))
    ->middleware('guest');
Route::get('home', [FrontHomeController::class, 'landingPage'])
    ->name('home');
Route::post('captcha/reload', [LoginController::class, 'reload'])
    ->name('captcha.reload');


Route::prefix('services')
    ->name('services.')
    ->group(function () {

        // Dashboard
        Route::get('infografis', [InfografisController::class, 'dataMadrasah'])
            ->name('data.madrasah');
    });

// Semua route /menu/* butuh autentikasi & verified
Route::middleware(['auth', 'verified'])
    ->prefix('menu')
    ->name('menu.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [HomeController::class, 'dashboard'])
            ->name('dashboard');

        Route::prefix('import')->as('import.')->group(function () {
            Route::controller(ImportMadrasahController::class)
                ->prefix('madrasah')
                ->name('madrasah.')
                ->group(function () {
                    Route::get('/',   'indexImportMadrasah')->name('index');
                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
        });
        Route::prefix('madrasah')->as('madrasah.')->group(function () {
            Route::controller(RaController::class)
                ->prefix('ra')
                ->name('ra.')
                ->group(function () {
                    Route::get('/',   'indexRa')->name('index');
                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
        });
    });