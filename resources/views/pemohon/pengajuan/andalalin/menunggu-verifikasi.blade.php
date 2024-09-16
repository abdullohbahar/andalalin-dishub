@php
    $role = auth()->user()->role;

    if ($role == 'pemrakarsa') {
        $role = 'pemohon';
    }
@endphp

@extends("$role.layout.app")

@section('title')
    Verifikasi Data
@endsection

@push('addons-css')
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
                        Verifikasi Data</h1>
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
                        <li class="breadcrumb-item text-muted">Verifikasi Data</li>
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
                    <div class="col-12 mt-3">
                        @include('pemohon.layout.stepper')
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mt-5">Verifikasi Data</h2>
                            </div>
                            <div class="card-body">
                                <h2 class="text-center">
                                    <b>Harap Menunggu Admin Untuk Memverifikasi Data Yang Telah Anda Ajukan!</b>
                                </h2>
                            </div>
                            <div class="card-footer"
                                {{ $pengajuan->status == 'revisi' || $pengajuan->status == 'disetujui' || $pengajuan->status == 'terverifikasi' ? '' : 'hidden' }}>
                                {{-- <form action="{{ route('pemohon.jadwal.tinjauan.lapangan') }}" method="POST"
                                    style="float: right;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Selanjutnya</button>
                                </form> --}}
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
@endpush
