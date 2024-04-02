<?php

use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Admin\BeritaAcaraController;
use App\Http\Controllers\Admin\CreateJadwalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guest\LoginController;
use App\Http\Controllers\Role\PilihRoleController;
use App\Http\Controllers\Admin\JenisJalanController;
use App\Http\Controllers\Admin\UkuranMinimalController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JadwalSidangController;
use App\Http\Controllers\Pemohon\Ajax\ShowUkuranMinimal;
use App\Http\Controllers\Pemohon\Ajax\ShowSubJenisRencana;
use App\Http\Controllers\Pemohon\ProfilePemohonController;
use App\Http\Controllers\Admin\SubSubJenisRencanaController;
use App\Http\Controllers\Pemohon\DashboardPemohonController;
use App\Http\Controllers\Pemohon\PengajuanPemohonController;
use App\Http\Controllers\Pemohon\Ajax\ShowSubSubJenisRencana;
use App\Http\Controllers\Pemohon\PengajuanAndalalinController;
use App\Http\Controllers\Admin\JenisRencanaPembangunanController;
use App\Http\Controllers\Admin\KontruksiController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\PengajuanSelesaiController;
use App\Http\Controllers\Admin\SubJenisRencanaPembangunanController;
use App\Http\Controllers\Admin\SuratKesanggupanAdminController;
use App\Http\Controllers\Admin\SuratPersetujuanAdminController;
use App\Http\Controllers\Admin\TemplateBeritaAcaraController;
use App\Http\Controllers\Admin\TinjauanLapanganController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Kabid\DashboardKabidController;
use App\Http\Controllers\Kadis\DashboardKadisController;
use App\Http\Controllers\Kasi\DashboardKasiController;
use App\Http\Controllers\Konsultan\DashboardKonsultan;
use App\Http\Controllers\Konsultan\PengajuanAndalalinKonsultanController;
use App\Http\Controllers\LaporanDokumenAkhir;
use App\Http\Controllers\Pdf\BeritaAcaraController as PdfBeritaAcaraController;
use App\Http\Controllers\Pdf\CoverController;
use App\Http\Controllers\Pdf\LaporanDokumenAkhir as PdfLaporanDokumenAkhir;
use App\Http\Controllers\Pdf\SuratKesanggupanController;
use App\Http\Controllers\Pdf\SuratPersetujuanController;
use App\Http\Controllers\PemberitahuanJadwalTinjauan;
use App\Http\Controllers\Pemohon\BeritaAcaraPemohonController;
use App\Http\Controllers\Pemohon\JadwalSidangController as PemohonJadwalSidangController;
use App\Http\Controllers\Pemohon\JadwalTinjauanLapangan;
use App\Http\Controllers\Pemohon\RiwayatInputDataController;
use App\Http\Controllers\Pemohon\SuratKesanggupanPemohonController;
use App\Http\Controllers\Pemohon\SuratPersetujuanController as PemohonSuratPersetujuanController;
use App\Http\Controllers\Penilai\DashboardPenilaiController;
use App\Models\SuratPersetujuan;
use App\Models\TemplateBeritaAcara;

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

Route::get('/', [LoginController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'redirectToKeycloak'])->name('login.keycloak');
Route::get('/callback', [AuthController::class, 'handleKeycloakCallback'])->name('keycloak.callback');
Route::get('/logout', [AuthController::class, 'logout'])->name('keycloak.logout');

Route::post('auth', [LoginController::class, 'authenticate'])->name('authenticate');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::get('aktivitas/{pengajuanID}', AktivitasController::class)->name('admin.aktivitas.verifikasi');

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

        Route::prefix('jadwal-sidang')->group(function () {
            Route::get('/{pengajuanID}', [JadwalSidangController::class, 'index'])->name('admin.jadwal.sidang');
            Route::post('buat-jadwal-sidang/{pengajuanID}', [JadwalSidangController::class, 'store'])->name('admin.store.jadwal.sidang');
            Route::get('detail/{pengajuanID}', [JadwalSidangController::class, 'jadwalSidang'])->name('admin.detail.jadwal.sidang');
            Route::post('telah-melakukan-sidang/{pengajuanID}', [JadwalSidangController::class, 'telahMelakukanSidang'])->name('admin.telah.melakukan.sidang');
        });

        Route::prefix('berita-acara')->group(function () {
            Route::get('/{pengajuanID}', [BeritaAcaraController::class, 'index'])->name('admin.berita.acara');
            Route::post('/update/{pengajuanID}', [BeritaAcaraController::class, 'update'])->name('admin.update.berita.acara');
            Route::post('telahMengisi/{pengajuanID}', [BeritaAcaraController::class, 'telahMengisi'])->name('admin.telah.mengisi.berita.acara');
            Route::get('menunggu-verifikasi-penilai/{pengajuanID}', [BeritaAcaraController::class, 'menungguVerifikasiPenilai'])->name('admin.menunggu.verifikasi.penilai');
        });

        Route::prefix('surat-kesanggupan')->group(function () {
            Route::get('/{pengajuanID}', [SuratKesanggupanAdminController::class, 'index'])->name('admin.surat.kesanggupan');
            Route::get('menunggu-surat-kesanggupan/{pengajuanID}', [SuratKesanggupanAdminController::class, 'menungguSuratKesanggupan'])->name('admin.menunggu.surat.kesanggupan');
            Route::post('approve/{pengajuanID}', [SuratKesanggupanAdminController::class, 'approve'])->name('admin.approve.surat.kesanggupan');
        });

        Route::prefix('surat-persetujuan')->group(function () {
            Route::get('/{pengajuanID}', [SuratPersetujuanAdminController::class, 'index'])->name('admin.surat.persetujuan');
            Route::post('next/{pengajuanID}', [SuratPersetujuanAdminController::class, 'next'])->name('admin.next.surat.persetujuan');
            Route::get('menunggu-persetujuan/{pengajuanID}', [SuratPersetujuanAdminController::class, 'show'])->name('admin.menunggu.persetujuan.surat.persetujuan');
        });

        Route::prefix('selesai')->group(function () {
            Route::get('/{pengajuanID}', [PengajuanSelesaiController::class, 'index'])->name('admin.pengajuan.selesai');
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

        Route::prefix('template')->group(function () {
            Route::get('/{jenisRencanaPembangunanID}', [TemplateBeritaAcaraController::class, 'index'])->name('admin.template.berita.acara');
            Route::post('store/{jenisRencanaPembangunanID}', [TemplateBeritaAcaraController::class, 'update'])->name('admin.update.template.berita.acara');
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

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });
});

Route::get('pilih-role', [PilihRoleController::class, 'index'])->name('pilih-role');
Route::get('pilih-role/{role}', [PilihRoleController::class, 'store'])->name('store.pilih.role');

Route::prefix('pemohon')->middleware('choose.role', 'pemohon')->group(function () {
    Route::get('dashboard', [DashboardPemohonController::class, 'index'])->middleware('check.profile')->name('pemohon.dashboard');

    Route::prefix('pengajuan')->middleware('check.profile')->group(function () {
        Route::get('/', [PengajuanPemohonController::class, 'index'])->name('pemohon.pengajuan');
        Route::get('/pilih-tipe', [PengajuanPemohonController::class, 'pilihTipe'])->name('pemohon.pilih.tipe.pengajuan');
        Route::get('/create-tipe-andalalin', [PengajuanPemohonController::class, 'createTipeAndalalin'])->name('pemohon.create.tipe.andalalin');

        Route::prefix('andalalin')->group(function () {
            Route::get('riwayat-input-data/{pengajuanID}', RiwayatInputDataController::class)->name('pemohon.riwayat.input.data');

            Route::get('/create/{id}', [PengajuanAndalalinController::class, 'createAndalalin'])->name('pemohon.create.pengajuan.andalalin');
            Route::put('/store/{pengajuanID}', [PengajuanAndalalinController::class, 'updateAndalalin'])->name('pemohon.store.pengajuan.andalalin');

            Route::get('/pilih-konsultan/{idPengajuan}', [PengajuanAndalalinController::class, 'pilihKonsultan'])->name('pemohon.pilih.konsultan.pengajuan.andalalin');
            Route::post('/store-pemohon', [PengajuanAndalalinController::class, 'storeDataPemohon'])->name('pemohon.store.data.pemohon.andalalin');

            Route::get('upload-dokumen-pemohon/{pengajuanID}', [PengajuanAndalalinController::class, 'uploadDokumenPemohon'])->name('pemohon.upload.dokumen.pemohon');
            Route::post('store-dokumen-pemohon', [PengajuanAndalalinController::class, 'storeDokumenPemohon'])->name('pemohon.store.dokumen.pemohon');

            Route::post('after-upload-dokumen', [PengajuanAndalalinController::class, 'afterUploadDokumen'])->name('pemohon.after.upload.dokumen');

            Route::get('menunggu-verifikasi-data/{pengajuanID}', [PengajuanAndalalinController::class, 'menungguVerifikasiData'])->name('pemohon.menunggu.verifikasi.data');

            Route::get('/detail/{pengajuanID}', [PengajuanAndalalinController::class, 'show'])->name('pemohon.show.pengajuan.andalalin');
            Route::put('upload-dokumen-revisi', [PengajuanAndalalinController::class, 'uploadRevisiDokumen'])->name('pemohon.upload.dokumen.revisi');
            Route::put('selesai-revisi/{pengajuanID}', [PengajuanAndalalinController::class, 'selesaiRevisi'])->name('pemohon.selesai.revisi');

            Route::get('jadwal-tinjauan-lapangan/{pengajuanID}', [JadwalTinjauanLapangan::class, 'index'])->name('pemohon.jadwal.tinjauan.lapangan');
            Route::get('jadwal-sidang/{pengajuanID}', [PemohonJadwalSidangController::class, 'index'])->name('pemohon.jadwal.sidang');

            Route::prefix('berita-acara')->group(function () {
                Route::get('/{pengajuanID}', [BeritaAcaraController::class, 'index'])->name('pemohon.berita.acara');
                Route::post('/update/{pengajuanID}', [BeritaAcaraController::class, 'update'])->name('pemohon.update.berita.acara');
                Route::post('telahMengisi/{pengajuanID}', [BeritaAcaraController::class, 'telahMengisi'])->name('pemohon.telah.mengisi.berita.acara');
                Route::get('menunggu-verifikasi-penilai/{pengajuanID}', [BeritaAcaraController::class, 'menungguVerifikasiPenilai'])->name('pemohon.menunggu.verifikasi.penilai');

                Route::get('unduh/{pengajuanID}', [BeritaAcaraPemohonController::class, 'index'])->name('pemohon.unduh.berita.acara');
                Route::post('unggah/{pengajuanID}', [BeritaAcaraPemohonController::class, 'unggahBeritaAcara'])->name('pemohon.unggah.berita.acara');
            });

            Route::prefix('surat-kesanggupan')->group(function () {
                Route::get('/{pengajuanID}', [SuratKesanggupanPemohonController::class, 'index'])->name('pemohon.surat.kesanggupan');
                Route::post('nomor-surat/{pengajuanID}', [SuratKesanggupanPemohonController::class, 'storeNomorSurat'])->name('pemohon.store.nomor.surat.kesanggupan');
                Route::post('unggah/{pengajuanID}', [SuratKesanggupanPemohonController::class, 'storeFileSurat'])->name('pemohon.store.file.surat.kesanggupan');
                Route::get('menunggu-verifikasi/{pengajuanID}', [SuratKesanggupanPemohonController::class, 'menungguVerifikasi'])->name('pemohon.menungu.verifikasi');
            });

            Route::prefix('surat-persetujuan')->group(function () {
                Route::get('/{pengajuanID}', [PemohonSuratPersetujuanController::class, 'index'])->name('pemohon.surat.persetujuan');
                Route::get('menunggu/{pengajuanID}', [PemohonSuratPersetujuanController::class, 'menunggu'])->name('pemohon.menunggu.surat.persetujuan');
                Route::post('selesai/{pengajuanID}', [PemohonSuratPersetujuanController::class, 'selesai'])->name('pemohon.selesai.surat.persetujuan');
            });

            Route::prefix('selesai')->group(function () {
                Route::get('/{pengajuanID}', [PengajuanSelesaiController::class, 'index'])->name('pemohon.pengajuan.selesai');
            });
        });
    });

    Route::prefix('ajax')->group(function () {
        Route::get('/show-sub-jenis-rencana/{idJenis}', ShowSubJenisRencana::class)->name('show.sub.jenis.rencana');
        Route::get('/show-sub-sub-jenis-rencana/{idSubJenisRencana}', ShowSubSubJenisRencana::class)->name('show.sub.sub.jenis.rencana');
        Route::get('/show-ukuran-minimal/{jenis}/{idSubJenisRencana}', ShowUkuranMinimal::class)->name('show.ukuran.minimal');
    });
});

Route::prefix('konsultan')->middleware('choose.role', 'konsultan')->group(function () {
    Route::get('dashboard', [DashboardKonsultan::class, 'index'])->middleware('check.profile')->name('konsultan.dashboard');

    Route::prefix('pengajuan')->group(function () {
        Route::prefix('andalalin')->group(function () {
            Route::get('/', [PengajuanAndalalinKonsultanController::class, 'index'])->name('konsultan.pengajuan');

            Route::get('upload-dokumen-pemohon/{pengajuanID}', [PengajuanAndalalinController::class, 'uploadDokumenPemohon'])->name('konsultan.upload.dokumen.pemohon');
            Route::post('store-dokumen-pemohon', [PengajuanAndalalinController::class, 'storeDokumenPemohon'])->name('konsultan.store.dokumen.pemohon');

            Route::post('after-upload-dokumen', [PengajuanAndalalinController::class, 'afterUploadDokumen'])->name('konsultan.after.upload.dokumen');
            Route::get('menunggu-verifikasi-data/{pengajuanID}', [PengajuanAndalalinController::class, 'menungguVerifikasiData'])->name('konsultan.menunggu.verifikasi.data');

            Route::get('jadwal-tinjauan-lapangan/{pengajuanID}', [JadwalTinjauanLapangan::class, 'index'])->name('konsultan.jadwal.tinjauan.lapangan');

            Route::get('jadwal-sidang/{pengajuanID}', [PemohonJadwalSidangController::class, 'index'])->name('konsultan.jadwal.sidang');

            Route::prefix('berita-acara')->group(function () {
                Route::get('/{pengajuanID}', [BeritaAcaraController::class, 'index'])->name('konsultan.berita.acara');
                Route::post('/update/{pengajuanID}', [BeritaAcaraController::class, 'update'])->name('konsultan.update.berita.acara');
                Route::post('telahMengisi/{pengajuanID}', [BeritaAcaraController::class, 'telahMengisi'])->name('konsultan.telah.mengisi.berita.acara');
                Route::get('menunggu-verifikasi-penilai/{pengajuanID}', [BeritaAcaraController::class, 'menungguVerifikasiPenilai'])->name('konsultan.menunggu.verifikasi.penilai');
            });


            Route::prefix('surat-persetujuan')->group(function () {
                Route::get('/{pengajuanID}', [PemohonSuratPersetujuanController::class, 'index'])->name('konsultan.surat.persetujuan');
                Route::get('menunggu/{pengajuanID}', [PemohonSuratPersetujuanController::class, 'menunggu'])->name('konsultan.menunggu.surat.persetujuan');
            });

            Route::prefix('selesai')->group(function () {
                Route::get('/{pengajuanID}', [PengajuanSelesaiController::class, 'index'])->name('konsultan.pengajuan.selesai');
            });
        });
    });
});

Route::prefix('penilai')->group(function () {
    Route::get('dashboard', [DashboardPenilaiController::class, 'index'])->name('penilai.dashboard');

    Route::get('berita-acara/{pengajuanID}', [DashboardPenilaiController::class, 'showBeritaAcara'])->name('penilai.berita.acara');
    Route::post('berita-acara/approve/{pengajuanID}', [DashboardPenilaiController::class, 'approve'])->name('penilai.approve.berita.acara');
});

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [ProfilePemohonController::class, 'index'])->name('profile');
    Route::get('/edit/{id}', [ProfilePemohonController::class, 'edit'])->name('edit.profile');
    Route::put('/update/{id}', [ProfilePemohonController::class, 'update'])->name('update.profile');
});

Route::prefix('kasi')->group(function () {
    Route::get('dashboard', [DashboardKasiController::class, 'index'])->name('kasi.dashboard');

    Route::get('surat-persetujuan/{pengajuanID}', [DashboardKasiController::class, 'showSuratPersetujuan'])->name('kasi.surat.persetujuan');
    Route::post('surat-persetujuan/approve/{pengajuanID}', [DashboardKasiController::class, 'approve'])->name('kasi.approve.surat.persetujuan');
});

Route::prefix('kabid')->group(function () {
    Route::get('dashboard', [DashboardKabidController::class, 'index'])->name('kabid.dashboard');

    Route::get('surat-persetujuan/{pengajuanID}', [DashboardKabidController::class, 'showSuratPersetujuan'])->name('kabid.surat.persetujuan');
    Route::post('surat-persetujuan/approve/{pengajuanID}', [DashboardKabidController::class, 'approve'])->name('kabid.approve.surat.persetujuan');
});

Route::prefix('kadis')->group(function () {
    Route::get('dashboard', [DashboardKadisController::class, 'index'])->name('kadis.dashboard');

    Route::get('surat-persetujuan/{pengajuanID}', [DashboardKadisController::class, 'showSuratPersetujuan'])->name('kadis.surat.persetujuan');
    Route::post('surat-persetujuan/approve/{pengajuanID}', [DashboardKadisController::class, 'approve'])->name('kadis.approve.surat.persetujuan');
});

Route::prefix('laporan-dokumen-akhir')->group(function () {
    Route::get('/{pengajuanID}', [LaporanDokumenAkhir::class, 'index'])->name('laporan.dokumen.akhir');
});

Route::prefix('download')->middleware('auth')->group(function () {
    Route::get('pemberitahuan-jadwal-tinjauan/{pengajuanID}', PemberitahuanJadwalTinjauan::class)->name('download.pemberitahuan.jadwal.tinjauan');

    Route::get('berita-acara/{pengajuanID}', PdfBeritaAcaraController::class)->name('download.berita.acara');
    Route::get('surat-kesanggupan/{pengajuanID}', SuratKesanggupanController::class)->name('download.surat.kesanggupan');
    Route::get('surat-persetujuan/{pengajuanID}', SuratPersetujuanController::class)->name('download.surat.persetujuan');

    Route::get('cover/{pengajuanID}', CoverController::class)->name('cover');
    Route::get('laporan-dokumen-akhir/{pengajuanID}', PdfLaporanDokumenAkhir::class)->name('download.laporan.dokumen.akhir');
});
