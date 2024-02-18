<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JenisRencanaPembangunanController;
use App\Http\Controllers\Admin\SubJenisRencanaPembangunanController;
use App\Http\Controllers\Admin\SubSubJenisRencanaController;
use App\Http\Controllers\Admin\UkuranMinimalController;
use App\Http\Controllers\Guest\LoginController;
use App\Models\SubJenisRencanaPembangunan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('jenis-rencana-pembangunan')->group(function () {
        Route::get('/', [JenisRencanaPembangunanController::class, 'index'])->name('admin.jenis.rencana.pembangunan');
        Route::get('/create', [JenisRencanaPembangunanController::class, 'create'])->name('admin.create.jenis.rencana.pembangunan');
        Route::post('/store', [JenisRencanaPembangunanController::class, 'store'])->name('admin.store.jenis.rencana.pembangunan');
        Route::get('/edit/{id}', [JenisRencanaPembangunanController::class, 'edit'])->name('admin.edit.jenis.rencana.pembangunan');
        Route::put('/update/{id}', [JenisRencanaPembangunanController::class, 'update'])->name('admin.update.jenis.rencana.pembangunan');
        Route::delete('/destroy/{idSubJenisRencanaPembangunan}', [JenisRencanaPembangunanController::class, 'destroy'])->name('admin.destroy.jenis.rencana.pembangunan');

        Route::prefix('sub-jenis-rencana-pembangunan')->group(function () {
            Route::get('/{idJenisRencanaPembangunan}', [SubJenisRencanaPembangunanController::class, 'index'])->name('admin.jenis.sub.rencana.pembangunan');
            Route::post('/store', [SubJenisRencanaPembangunanController::class, 'store'])->name('admin.store.jenis.sub.rencana.pembangunan');
            Route::get('/edit/{id}', [SubJenisRencanaPembangunanController::class, 'edit'])->name('admin.edit.jenis.sub.rencana.pembangunan');
            Route::put('/update/{id}', [SubJenisRencanaPembangunanController::class, 'update'])->name('admin.update.jenis.sub.rencana.pembangunan');
            Route::delete('/destroy/{idSubJenisRencanaPembangunan}', [SubJenisRencanaPembangunanController::class, 'destroy'])->name('admin.destroy.jenis.sub.rencana.pembangunan');

            Route::prefix('ukuran-minimal')->group(function () {
                Route::post('/store', [UkuranMinimalController::class, 'store'])->name('admin.store.ukuran.minimal');
                Route::get('/edit/{idMinimal}/{jenis}/{idSub}', [UkuranMinimalController::class, 'edit'])->name('admin.edit.ukuran.minimal');
                Route::get('/{idSub}/{jenis}', [UkuranMinimalController::class, 'index'])->name('admin.sub.ukuran.minimal');
                Route::put('/update/{idMinimal}', [UkuranMinimalController::class, 'update'])->name('admin.update.ukuran.minimal');
            });

            Route::prefix('sub-sub-jenis-rencana-pembangunan')->group(function () {
                Route::get('/{idSubJenisRencanaPembangunan}', [SubSubJenisRencanaController::class, 'index'])->name('admin.jenis.sub.sub.rencana.pembangunan');
                Route::post('/store', [SubSubJenisRencanaController::class, 'store'])->name('admin.store.jenis.sub.sub.rencana.pembangunan');
                Route::get('/edit/{id}', [SubSubJenisRencanaController::class, 'edit'])->name('admin.edit.jenis.sub.sub.rencana.pembangunan');
                Route::put('/update/{id}', [SubSubJenisRencanaController::class, 'update'])->name('admin.update.jenis.sub.sub.rencana.pembangunan');
                Route::delete('/destroy/{idSubSubJenisRencanaPembangunan}', [SubSubJenisRencanaController::class, 'destroy'])->name('admin.destroy.jenis.sub.sub.rencana.pembangunan');

                Route::prefix('ukuran-minimal')->group(function () {
                    Route::get('/{idSub}/{jenis}', [UkuranMinimalController::class, 'index'])->name('admin.sub.sub.ukuran.minimal');
                });
            });
        });
    });
});
