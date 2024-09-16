<div class="card mb-5">
    <div class="card-header">
        <div class="stepper-wrapper">
            <div class="stepper-item {{ Route::is('pemohon.create.pengajuan') ? 'active' : 'completed' }}">
                <div class="step-counter">1</div>
                <div class="step-name text-center">Buat Pengajuan Baru</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.pilih.konsultan.pengajuan.andalalin') ? 'active' : 'completed' }}">
                <div class="step-counter">2</div>
                <div class="step-name text-center">Input Data Permohonan Dan Data Konsultan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.upload.dokumen.pemohon') || Route::is('konsultan.upload.dokumen.pemohon') ? 'active' : 'completed' }}">
                <div class="step-counter">3</div>
                <div class="step-name text-center">Upload Dokumen Permohonan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.menunggu.verifikasi.data') || Route::is('konsultan.menunggu.verifikasi.data') ? 'active' : 'completed' }}">
                <div class="step-counter">4</div>
                <div class="step-name text-center">Verifikasi Data</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.jadwal.tinjauan.lapangan') || Route::is('konsultan.jadwal.tinjauan.lapangan') ? 'active' : 'completed' }}">
                <div class="step-counter">5</div>
                <div class="step-name text-center">Tinjauan Lapangan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.jadwal.sidang') || Route::is('konsultan.jadwal.sidang') ? 'active' : 'completed' }}">
                <div class="step-counter">6</div>
                <div class="step-name text-center">Sidang</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.berita.acara') || Route::is('konsultan.berita.acara') || Route::is('pemohon.menunggu.verifikasi.penilai') || Route::is('konsultan.menunggu.verifikasi.penilai') ? 'active' : 'completed' }}">
                <div class="step-counter">7</div>
                <div class="step-name text-center">Berita Acara</div>
            </div>
        </div>
        <div class="stepper-wrapper">
            <div class="stepper-item {{ Route::is('pemohon.unduh.berita.acara') ? 'active' : 'completed' }}">
                <div class="step-counter">8</div>
                <div class="step-name text-center">Unduh & Unggah Berita Acara</div>
            </div>
            <div class="stepper-item {{ Route::is('pemohon.surat.kesanggupan') ? 'active' : 'completed' }}">
                <div class="step-counter">9</div>
                <div class="step-name text-center">Unduh & Unggah Surat Kesanggupan</div>
            </div>
            <div class="stepper-item {{ Route::is('pemohon.menungu.verifikasi') ? 'active' : 'completed' }}">
                <div class="step-counter">10</div>
                <div class="step-name text-center">Surat Kesanggupan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.menunggu.surat.persetujuan') || Route::is('pemohon.surat.persetujuan') || Route::is('konsultan.menunggu.surat.persetujuan') || Route::is('konsultan.surat.persetujuan') ? 'active' : 'completed' }}">
                <div class="step-counter">11</div>
                <div class="step-name text-center">Surat Persetujuan</div>
            </div>
            <div
                class="stepper-item {{ Route::is('pemohon.pengajuan.selesai') || Route::is('konsultan.pengajuan.selesai') ? 'active' : 'completed' }}">
                <div class="step-counter">12</div>
                <div class="step-name text-center">Selesai</div>
            </div>
        </div>
    </div>
</div>
