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
    Surat Persetujuan
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
                        Surat Persetujuan</h1>
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
                        <li class="breadcrumb-item text-muted">Surat Persetujuan</li>
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
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Surat Persetujuan</h1>
                            </div>
                            <div class="card-body">
                                <iframe src="{{ route('download.surat.persetujuan', $pengajuan->id) }}" width="100%"
                                    height="700px">
                                </iframe>
                            </div>
                            <div class="card-footer">
                                <div style="float: right">
                                    <form action="{{ route('admin.next.surat.persetujuan', $pengajuan->id) }}"
                                        id="approve" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selanjutnya</button>
                                    </form>
                                </div>
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
                'approve'); // Ganti 'approve' dengan ID formulir Anda

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
        });
    </script>
@endpush
