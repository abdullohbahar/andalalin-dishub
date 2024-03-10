@php
    $role = auth()->user()->role;
@endphp

@extends("$role.layout.app")

@section('title')
    Sidang
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
                        Sidang</h1>
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
                        <li class="breadcrumb-item text-muted">Sidang</li>
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
                        @include('pemohon.layout.stepper')
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Sidang</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Nama Proyek</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->nama_proyek }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Sidang</td>
                                                <td class="text-capitalize">
                                                    : {{ $pengajuan->hasOneJadwalSidang->tipe }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Sidang</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->tanggal }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jam Sidang</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->jam }}
                                                </td>
                                            </tr>
                                            <tr {{ $pengajuan->hasOneJadwalSidang->tipe == 'offline' ? '' : 'hidden' }}>
                                                <td>Alamat Sidang</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->alamat }}
                                                </td>
                                            </tr>
                                            <tr {{ $pengajuan->hasOneJadwalSidang->tipe == 'online' ? '' : 'hidden' }}>
                                                <td>URL Online Meeting</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->url }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
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
@endpush
