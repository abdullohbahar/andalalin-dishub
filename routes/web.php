<?php

use App\Http\Controllers\Admin\CreateJadwalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\LoginController;
use App\Http\Controllers\Role\PilihRoleController;
use App\Http\Controllers\Admin\JenisJalanController;
use App\Http\Controllers\Admin\UkuranMinimalController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Pemohon\Ajax\ShowUkuranMinimal;
use App\Http\Controllers\Pemohon\Ajax\ShowSubJenisRencana;
use App\Http\Controllers\Pemohon\ProfilePemohonController;
use App\Http\Controllers\Admin\SubSubJenisRencanaController;
use App\Http\Controllers\Pemohon\DashboardPemohonController;
use App\Http\Controllers\Pemohon\PengajuanPemohonController;
use App\Http\Controllers\Pemohon\Ajax\ShowSubSubJenisRencana;
use App\Http\Controllers\Pemohon\PengajuanAndalalinController;
use App\Http\Controllers\Admin\JenisRencanaPembangunanController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\SubJenisRencanaPembangunanController;
use App\Http\Controllers\Admin\TinjauanLapanganController;

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

Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [AuthController::class, 'redirectToKeycloak'])->name('login.keycloak');
Route::get('/callback', [AuthController::class, 'handleKeycloakCallback'])->name('keycloak.callback');
Route::get('/logout', [AuthController::class, 'logout'])->name('keycloak.logout');

Route::post('auth', [LoginController::class, 'authenticate'])->name('authenticate');

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('pengajuan')->group(function () {
        Route::get('/', [PengajuanController::class, 'index'])->name('admin.pengajuan.index');
        Route::get('/detail/{pengajuanID}', [PengajuanController::class, 'show'])->name('admin.pengajuan.show');
        Route::put('revisi', [PengajuanController::class, 'revisi'])->name('admin.revisi.dokumen');
        Route::put('tolak', [PengajuanController::class, 'tolak'])->name('admin.tolak.dokumen');
        Route::put('selesai-verifikasi/{pengajuanID}', [PengajuanController::class, 'selesaiVerifikasi'])->name('admin.selesai.verifikasi');

        Route::prefix('buat-jadwal')->group(function () {
            Route::get('{pengajuanID}', [CreateJadwalController::class, 'index'])->name('admin.buat.jadwal');
            Route::post('store-jadwal', [CreateJadwalController::class, 'store'])->name('admin.store.jadwal');
            Route::delete('/destroy/{jadwalID}', [CreateJadwalController::class, 'hapusJadwal'])->name('admin.destroy.jadwal');
        });

        Route::prefix('tinjauan-lapangan')->group(function () {
            Route::get('/{pengajuanID}', [TinjauanLapanganController::class, 'index'])->name('admin.tinjauan.lapangan');
            Route::post('/telah-melakukan-tinjauan/{jadwalID}', [TinjauanLapanganController::class, 'telahMelakukanTinjauan'])->name('admin.telah.melakukan.tinjauan');
        });

        Route::prefix('ajax')->group(function () {
            Route::get('/setujui/{dokumenID}', [PengajuanController::class, 'setujui'])->name('admin.setujui.dokumen');
            Route::get('/get-detai-jadwal/{jadwalID}', [CreateJadwalController::class, 'getDetailJadwal'])->name('admin.get.detail.jadwal');
        });
    });

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
                Route::delete('/destroy/{idMinimal}', [UkuranMinimalController::class, 'destroy'])->name('admin.destroy.ukuran.minimal');
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

    Route::prefix('jenis-jalan')->group(function () {
        Route::get('/', [JenisJalanController::class, 'index'])->name('admin.jenis.jalan');
        Route::get('/create', [JenisJalanController::class, 'create'])->name('admin.create.jenis.jalan');
        Route::post('/store', [JenisJalanController::class, 'store'])->name('admin.store.jenis.jalan');
        Route::get('/edit/{id}', [JenisJalanController::class, 'edit'])->name('admin.edit.jenis.jalan');
        Route::put('/update/{id}', [JenisJalanController::class, 'update'])->name('admin.update.jenis.jalan');
        Route::delete('/destroy/{id}', [JenisJalanController::class, 'destroy'])->name('admin.destroy.jenis.jalan');
    });
});

Route::get('pilih-role', [PilihRoleController::class, 'index'])->name('pilih-role');
Route::get('pilih-role/{role}', [PilihRoleController::class, 'store'])->name('store.pilih.role');

Route::prefix('pemohon')->middleware('choose.role')->group(function () {
    Route::get('dashboard', [DashboardPemohonController::class, 'index'])->middleware('check.profile')->name('pemohon.dashboard');

    Route::prefix('pengajuan')->middleware('check.profile')->group(function () {
        Route::get('/', [PengajuanPemohonController::class, 'index'])->name('pemohon.pengajuan');
        Route::get('/pilih-tipe', [PengajuanPemohonController::class, 'pilihTipe'])->name('pemohon.pilih.tipe.pengajuan');
        Route::get('/create-tipe-andalalin', [PengajuanPemohonController::class, 'createTipeAndalalin'])->name('pemohon.create.tipe.andalalin');

        Route::prefix('andalalin')->group(function () {
            Route::get('/create/{id}', [PengajuanAndalalinController::class, 'createAndalalin'])->name('pemohon.create.pengajuan.andalalin');
            Route::put('/store/{pengajuanID}', [PengajuanAndalalinController::class, 'updateAndalalin'])->name('pemohon.store.pengajuan.andalalin');

            Route::get('/pilih-konsultan/{idPengajuan}', [PengajuanAndalalinController::class, 'pilihKonsultan'])->name('pemohon.pilih.konsultan.pengajuan.andalalin');
            Route::post('/store-pemohon', [PengajuanAndalalinController::class, 'storeDataPemohon'])->name('pemohon.store.data.pemohon.andalalin');

            Route::get('upload-dokumen-pemohon/{idDataPemohon}', [PengajuanAndalalinController::class, 'uploadDokumenPemohon'])->name('pemohon.upload.dokumen.pemohon');
            Route::post('store-dokumen-pemohon', [PengajuanAndalalinController::class, 'storeDokumenPemohon'])->name('pemohon.store.dokumen.pemohon');

            Route::get('/detail/{pengajuanID}', [PengajuanAndalalinController::class, 'show'])->name('pemohon.show.pengajuan.andalalin');
            Route::put('upload-dokumen-revisi', [PengajuanAndalalinController::class, 'uploadRevisiDokumen'])->name('pemohon.upload.dokumen.revisi');
            Route::put('selesai-revisi/{pengajuanID}', [PengajuanAndalalinController::class, 'selesaiRevisi'])->name('pemohon.selesai.revisi');
        });
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfilePemohonController::class, 'index'])->name('pemohon.profile');
        Route::get('/edit/{id}', [ProfilePemohonController::class, 'edit'])->name('pemohon.edit.profile');
        Route::put('/update/{id}', [ProfilePemohonController::class, 'update'])->name('pemohon.update.profile');
    });

    Route::prefix('ajax')->group(function () {
        Route::get('/show-sub-jenis-rencana/{idJenis}', ShowSubJenisRencana::class)->name('show.sub.jenis.rencana');
        Route::get('/show-sub-sub-jenis-rencana/{idSubJenisRencana}', ShowSubSubJenisRencana::class)->name('show.sub.sub.jenis.rencana');
        Route::get('/show-ukuran-minimal/{jenis}/{idSubJenisRencana}', ShowUkuranMinimal::class)->name('show.ukuran.minimal');
    });
});
