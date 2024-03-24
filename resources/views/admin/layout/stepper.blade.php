<div class="card mb-5">
    <div class="card-header">
        <div class="stepper-wrapper">
            <div class="stepper-item {{ Route::is('admin.pengajuan.show') ? 'active' : 'completed' }}">
                <div class="step-counter">1</div>
                <div class="step-name text-center">Verifikasi Pengajuan Permohonan</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.buat.jadwal') ? 'active' : 'completed' }}">
                <div class="step-counter">2</div>
                <div class="step-name text-center">Buat Jadwal Tinjauan Lapangan</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.tinjauan.lapangan') ? 'active' : 'completed' }}">
                <div class="step-counter">3</div>
                <div class="step-name text-center">Tinjauan Lapangan</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.jadwal.sidang') ? 'active' : 'completed' }}">
                <div class="step-counter">4</div>
                <div class="step-name text-center">Buat Jadwal Sidang</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.detail.jadwal.sidang') ? 'active' : 'completed' }}">
                <div class="step-counter">5</div>
                <div class="step-name text-center">Sidang</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.berita.acara') ? 'active' : 'completed' }}">
                <div class="step-counter">6</div>
                <div class="step-name text-center">Berita Acara</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.menunggu.surat.kesanggupan') ? 'active' : 'completed' }}">
                <div class="step-counter">6</div>
                <div class="step-name text-center">Surat Kesanggupan</div>
            </div>
            <div class="stepper-item {{ Route::is('admin.surat.persetujuan') ? 'active' : 'completed' }}">
                <div class="step-counter">7</div>
                <div class="step-name text-center">Surat Persetujuan</div>
            </div>
        </div>
    </div>
</div>
