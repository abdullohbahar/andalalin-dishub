@php
    $role = auth()->user()->role;

    if ($role == 'konsultan') {
        $stepper = 'pemohon';
    } else {
        $stepper = $role;
    }

    if ($role == 'pemrakarsa') {
        $role = 'pemohon';
        $stepper = 'pemohon';
    }
@endphp

@extends("$role.layout.app")

@section('title')
    Berita Acara
@endsection

@push('addons-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        label {
            width: 100%;
        }

        .card-input-element {
            display: none;
        }

        .card-input {
            margin: 10px;
            padding: 00px;
        }

        .card-input:hover {
            cursor: pointer;
        }

        .card-input {
            box-shadow: 0 0 1px 1px #2ecc71;
            height: 30px;
        }

        .card-input-element:checked+.card-input {
            background-color: #2ecc71;
            color: black;
        }

        /* Style untuk elemen kalender */
        #kt_docs_fullcalendar_selectable {
            position: relative;
            /* Membuat posisi relatif untuk child elements */
        }

        /* Style untuk event title */
        .fc-event-title {
            white-space: normal;
            /* Memastikan text wrap pada title yang panjang */
        }

        /* Style untuk elemen tanggal */
        .fc-daygrid-event {
            display: flex;
            /* Menggunakan Flexbox untuk mengatur tata letak */
            align-items: flex-start;
            /* Mengatur alignment title ke atas */
        }
    </style>
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
                                <h4 class="mb-2 light">Alur Pengisian</h4>
                                <!--end::Title-->

                                <!--begin::Content-->
                                <ol style="font-size: 12pt">
                                    <li>Harap melakukan unduh pada berita acara dibawah yang telah disetujui oleh penilai.
                                    </li>
                                    <li>Tanda Tangan pada berita acara yang telah diunduh tadi</li>
                                    <li>Unggah berita acara yang telah diberi tanda tangan</li>
                                    <li>Jika semua sudah dilakukan maka selanjutnya klik tombol selanjutnya</li>
                                </ol>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Alert-->
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Unduh Berita Acara</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <iframe src="{{ route('download.berita.acara', $pengajuanID) }}" width="100%"
                                        height="600px">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('pemohon.unggah.berita.acara', $pengajuanID) }}" id="unggah"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h1 class="mt-5">Unggah Berita Acara</h1>
                                </div>
                                <div class="card-body">
                                    <div class="col-sm-12 col-md-6">
                                        <input class="form-control @error('file_uploads') is-invalid @enderror"
                                            type="file" name="file_uploads" accept=".pdf" onchange="validateFile(this)"
                                            id="" required>
                                        @error('file_uploads')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div style="float: right">
                                        <button type="submit" class="btn btn-success">Selanjutnya</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap formulir saat di-submit
            var form = document.getElementById(
                'formSidang'); // Ganti 'formSidang' dengan ID formulir Anda

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

    <script>
        function validateFile(input) {
            const allowedExtensions = /(\.pdf)$/i;

            if (!allowedExtensions.exec(input.value)) {
                alert('Hanya file PDF yang diperbolehkan.');
                input.value = '';
                return false;
            }
        }
    </script>
@endpush
