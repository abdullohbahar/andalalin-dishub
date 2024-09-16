@php
    $role = auth()->user()->role;

    if ($role == 'konsultan') {
        $stepper = 'pemohon';
    } else {
        $stepper = $role;
    }

    if ($role == 'pemrakarsa') {
        $role = 'pemohon';
    }
@endphp

@extends("$role.layout.app")

@section('title')
    Berita Acara
@endsection

@push('addons-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Berita Acara</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Berita Acara</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row">
                    <div class="col-12">
                        @include($stepper . '.layout.stepper')
                        <!--begin::Alert-->
                        <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row p-5 mb-10">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-notification-bing fs-2hx text-light me-4 mb-5 mb-sm-0"><span
                                    class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                <!--begin::Title-->
                                <h4 class="mb-2 light">Peringatan !!!</h4>
                                <!--end::Title-->

                                <!--begin::Content-->
                                <span>
                                    <ol>
                                        <li>Harap klik tombol simpan jika anda telah mengisi berita acara</li>
                                        <li>Setelah itu klik tombol selanjutnya untuk melanjutkan ke langkah berikutnya</li>
                                    </ol>
                                </span>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Close-->
                            <button type="button"
                                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                data-bs-dismiss="alert">
                                <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </button>
                            <!--end::Close-->
                        </div>
                        <!--end::Alert-->
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Berita Acara</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route($role . '.update.berita.acara', $pengajuan->id) }}" id="jadwalSidang"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <label for="" class="form-label">Pilih Pemohon / Konsultan /
                                                Pemrakarsa
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modalPilihKonsultan">Klik
                                                    Untuk Memilih</button>
                                            </label>
                                            <input type="text" name="user"
                                                class="form-control @error('user') is-invalid @enderror" id="nama_user"
                                                readonly required
                                                value="{{ old('user', $pengajuan->hasOneBeritaAcara?->belongsToUser->hasOneProfile->nama) }}">
                                            <input type="hidden" name="user_id"
                                                value="{{ old('user_id', $pengajuan->hasOneBeritaAcara?->belongsToUser->id) }}"
                                                id="user_id">
                                            @error('user')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="" class="form-label">Tanggal</label>
                                            <input type="date" name="tanggal"
                                                class="form-control @error('tanggal') is-invalid @enderror"
                                                value="{{ old('tanggal', $pengajuan->hasOneBeritaAcara?->tanggal ?? date('Y-m-d')) }}"
                                                id="">
                                            @error('tanggal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="" class="form-label">Tahapan Prakonstruksi</label>
                                            <textarea name="body_prakonstruksi" class="editor_prakonstruksi" style="width: 100%;">{{ old('body_prakonstruksi', $pengajuan->hasOneBeritaAcara?->body_prakonstruksi ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="" class="form-label">Tahapan Konstruksi</label>
                                            <textarea name="body_konstruksi" class="editor_konstruksi" style="width: 100%;">{{ old('body_konstruksi', $pengajuan->hasOneBeritaAcara?->body_konstruksi ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="" class="form-label">Tahapan Operasional</label>
                                            <textarea name="body" class="editor" style="width: 100%;">{{ old('body', $pengajuan->hasOneBeritaAcara?->body ?? $template) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <button class="btn btn-info">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                @if ($pengajuan->hasOneBeritaAcara != null)
                                    <form action="{{ route($role . '.telah.mengisi.berita.acara', $pengajuan->id) }}"
                                        method="POST" id="telahMengisi">
                                        @csrf
                                        <div class="row" style="float: right">
                                            <button class="btn btn-success">Selanjutnya</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    @include('admin.pengajuan.berita-acara.components.modal-pilih-user')
@endsection

@push('addons-js')
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/pages/pilih-user.js') }}"></script>

    <script>
        ClassicEditor.create(document.querySelector(".editor"), {
            height: 1200, // Ganti nilai ini sesuai dengan tinggi yang Anda inginkan
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector(".editor_konstruksi"), {
            height: 1200, // Ganti nilai ini sesuai dengan tinggi yang Anda inginkan
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector(".editor_prakonstruksi"), {
            height: 1200, // Ganti nilai ini sesuai dengan tinggi yang Anda inginkan
        }).catch((error) => {
            console.error(error);
        });
    </script>

    <script>
        $("#tipe").on("change", function() {
            var val = $(this).val()

            if (val == 'offline') {
                $("#alamatComponent").attr("hidden", false)
                $("#alamat").attr("required", true)

                $("#urlComponent").attr("hidden", true)
                $("#url").attr("required", false)
            } else {
                $("#urlComponent").attr("hidden", false)
                $("#url").attr("required", true)

                $("#alamatComponent").attr("hidden", true)
                $("#alamat").attr("required", false)
            }
        })
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap formulir saat di-submit
            var form = document.getElementById(
                'jadwalSidang'); // Ganti 'jadwalSidang' dengan ID formulir Anda

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah formulir untuk langsung di-submit

                // Menampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Klik "Ya" untuk konfirmasi.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengklik "Ya", formulir akan di-submit
                        form.submit();
                    }
                });
            });

            // Menangkap formulir saat di-submit
            var telahMengisi = document.getElementById(
                'telahMengisi'); // Ganti 'jadwalSidang' dengan ID telahMengisiulir Anda

            telahMengisi.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah telahMengisiulir untuk langsung di-submit

                // Menampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Klik "Ya" untuk konfirmasi.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengklik "Ya", formulir akan di-submit
                        telahMengisi.submit();
                    }
                });
            });
        });
    </script>
@endpush
