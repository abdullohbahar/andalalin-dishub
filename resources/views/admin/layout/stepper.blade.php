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
            <div class="stepper-item">
                <div class="step-counter">3</div>
                <div class="step-name text-center">Third</div>
            </div>
            <div class="stepper-item">
                <div class="step-counter">4</div>
                <div class="step-name text-center">Forth</div>
            </div>
        </div>
    </div>
</div>
