@extends('kadis.layout.app')

@section('title')
    Dashboard
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
                        Dashboard</h1>
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
                        <li class="breadcrumb-item text-muted">Dashboard</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mt-5">
                                    <b>Surat Persetujuan Perlu Diapprove</b>
                                </h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="tableNotApprove">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pemohon</th>
                                            <th>Nama Proyek</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($belumApprove as $pengajuan)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    {{ $pengajuan->belongsToPengajuan->belongsToUser->hasOneProfile->nama }}
                                                </td>
                                                <td>
                                                    {{ $pengajuan->belongsToPengajuan->hasOneDataPemohon?->nama_proyek ?? '' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group"
                                                        aria-label="Basic mixed styles example">
                                                        <a href="{{ route('kadis.surat.persetujuan', $pengajuan->belongsToPengajuan->id) }}"
                                                            class="btn btn-info btn-sm">Approve Surat Persetujuan</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mt-5">
                                    <b>Surat Persetujuan Sudah Diapprove</b>
                                </h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="tableApprove">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pemohon</th>
                                            <th>Nama Proyek</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($sudahApprove as $pengajuan)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    {{ $pengajuan->belongsToPengajuan->belongsToUser->hasOneProfile->nama }}
                                                </td>
                                                <td>
                                                    {{ $pengajuan->belongsToPengajuan->hasOneDataPemohon?->nama_proyek ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($pengajuan->belongsToPengajuan->hasOneSuratPersetujuan->is_kadis_approve)
                                                        <div class="btn-group" role="group"
                                                            aria-label="Basic mixed styles example">
                                                            <a href="{{ route('laporan.dokumen.akhir', $pengajuan->belongsToPengajuan->id) }}"
                                                                class="btn btn-success btn-sm">Laporan Dokumen Akhir</a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    <script src="{{ asset('./assets/js/pages/penilai/pengajuan.js') }}"></script>
@endpush
