<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\InfografisController;
use App\Http\Controllers\Menu\Import\ImportMadrasahController;
use App\Http\Controllers\Menu\Kelembagaan\AdiwiyataController;
use App\Http\Controllers\Menu\Madrasah\Ma\MaController;
use App\Http\Controllers\Menu\Madrasah\Mak\MakController;
use App\Http\Controllers\Menu\Madrasah\Master\MasterMadrasahController;
use App\Http\Controllers\Menu\Madrasah\MI\MiController;
use App\Http\Controllers\Menu\Madrasah\MTs\MtsController;
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
Route::middleware([
    'auth',
    'verified',
    'role:superadmin|kankemenag'
])
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
                    Route::post('list',   'dataRa')->name('list');


                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
            Route::controller(MiController::class)
                ->prefix('mi')
                ->name('mi.')
                ->group(function () {
                    Route::get('/',   'indexMi')->name('index');
                    Route::post('list',   'dataMi')->name('list');


                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
            Route::controller(MtsController::class)
                ->prefix('mts')
                ->name('mts.')
                ->group(function () {
                    Route::get('/',   'indexMts')->name('index');
                    Route::post('list',   'dataMts')->name('list');


                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
            Route::controller(MaController::class)
                ->prefix('ma')
                ->name('ma.')
                ->group(function () {
                    Route::get('/',   'indexMa')->name('index');
                    Route::post('list',   'dataMa')->name('list');


                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
            Route::controller(MakController::class)
                ->prefix('mak')
                ->name('mak.')
                ->group(function () {
                    Route::get('/',   'indexMak')->name('index');
                    Route::post('list',   'dataMak')->name('list');


                    Route::post('/',  'storeImportMadrasah')->name('store');
                    Route::post('fetch', 'editMasterPegawai')->name('fetch');
                    Route::put('/',   'updateMasterPegawai')->name('update');
                    Route::delete('/', 'destroyMasterPegawai')->name('delete');
                    Route::get('data',  'dataMasterPegawai')->name('data');
                });
        });


        Route::prefix('kelembagaan')
            ->name('kelembagaan.')
            ->group(function () {
                // --- Adiwiyata ---
                Route::controller(AdiwiyataController::class)
                    ->prefix('adiwiyata')
                    ->name('adiwiyata.')
                    ->group(function () {
                        Route::get('/',   'indexAdiwiyata')->name('index');
                        Route::post('/',  'storeMadrasahAdiwiyata')->name('store');
                        Route::post('fetch', 'editMasterPegawai')->name('fetch');
                        Route::put('/',   'updateMasterPegawai')->name('update');
                        Route::delete('/', 'destroyMasterPegawai')->name('delete');
                        Route::get('data',  'dataMadrasahAdiwiyata')->name('data');
                    });
            });
    });
Route::middleware(['auth', 'verified'])
    ->prefix('services')
    ->name('services.')
    ->group(function () {

        Route::middleware('role:superadmin|kankemenag')
            ->prefix('master')
            ->name('master.')
            ->group(function () {
                Route::post('madrasah', [MasterMadrasahController::class, 'cekDataMadrasah'])->name('madrasah');
                // Route::post('provinsi', [WilayahController::class, 'provinsi'])->name('provinsi');
                // Route::post('kotakab', [WilayahController::class, 'kotakab'])->name('kotakab');
                // Route::post('kecamatan', [WilayahController::class, 'kecamatan'])->name('kecamatan');
                // Route::post('kelurahan', [WilayahController::class, 'kelurahan'])->name('kelurahan');


            });
    });
