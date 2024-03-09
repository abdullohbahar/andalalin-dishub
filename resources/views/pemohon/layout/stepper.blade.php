<div class="card mb-5">
    <div class="card-header">
        <div class="stepper-wrapper">
            <div class="stepper-item {{ Route::is('pemohon.pilih.tipe.pengajuan') ? 'active' : 'completed' }}">
                <div class="step-counter">1</div>
                <div class="step-name text-center">Pilih Tipe</div>
            </div>
            <div class="stepper-item {{ Route::is('pemohon.create.pengajuan.andalalin') ? 'active' : 'completed' }}">
                <div class="step-counter">2</div>
                <div class="step-name text-center">Buat Pengajuan Baru</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.pilih.konsultan.pengajuan.andalalin') ? 'active' : 'completed' }}">
                <div class="step-counter">3</div>
                <div class="step-name text-center">Input Data Permohonan Dan Data Konsultan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.upload.dokumen.pemohon') || Route::is('konsultan.upload.dokumen.pemohon') ? 'active' : 'completed' }}">
                <div class="step-counter">4</div>
                <div class="step-name text-center">Upload Dokumen Permohonan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.menunggu.verifikasi.data') || Route::is('konsultan.menunggu.verifikasi.data') ? 'active' : 'completed' }}">
                <div class="step-counter">5</div>
                <div class="step-name text-center">Verifikasi Data</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.jadwal.tinjauan.lapangan') || Route::is('konsultan.jadwal.tinjauan.lapangan') ? 'active' : 'completed' }}">
                <div class="step-counter">6</div>
                <div class="step-name text-center">Tinjauan Lapangan</div>
            </div>
        </div>
    </div>
</div>
