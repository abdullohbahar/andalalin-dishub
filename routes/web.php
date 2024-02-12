<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JenisRencanaPembangunanController;
use App\Http\Controllers\Guest\LoginController;
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
    });
});
