@extends('pemohon.layout.app')

@section('title')
    Pengajuan
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
                        Pengajuan</h1>
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
                        <li class="breadcrumb-item text-muted">Pengajuan</li>
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
                            <div class="card-header pt-5">
                                <h1>Pengajuan</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pemohon</th>
                                            <th>Jenis Rencana Pembangunan</th>
                                            <th>Nama Proyek</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($pengajuans as $pengajuan)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                <td>{{ $pengajuan->belongsToUser->hasOneProfile->nama }}</td>
                                                </td>
                                                <td>
                                                    {{ $pengajuan->belongsToJenisRencana?->nama ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $pengajuan->hasOneDataPemohon?->nama_proyek ?? '' }}
                                                </td>
                                                <td class="text-capitalize">
                                                    {{ $pengajuan->status }}
                                                </td>
                                                <td>
                                                    @if ($pengajuan->status != 'ditolak')
                                                        <div class="btn-group" role="group"
                                                            aria-label="Basic mixed styles example">
                                                            @if ($pengajuan->hasOneRiwayatInputData->step == 'Upload Dokumen Permohonan')
                                                                <a href="{{ route('konsultan.upload.dokumen.pemohon', $pengajuan->id) }}"
                                                                    class="btn btn-success btn-sm">Upload Dokumen
                                                                    Permohonan</a>
                                                            @endif
                                                            @if ($pengajuan->hasOneRiwayatVerifikasi->step == 'Tinjauan Lapangan')
                                                                <a href="{{ route('konsultan.jadwal.tinjauan.lapangan', $pengajuan->id) }}"
                                                                    class="btn btn-success btn-sm">Jadwal Tinjauan
                                                                    Lapangan</a>
                                                            @endif
                                                            @if ($pengajuan->hasOneRiwayatVerifikasi->step == 'Sidang')
                                                                <a href="{{ route('konsultan.jadwal.sidang', $pengajuan->id) }}"
                                                                    class="btn btn-success btn-sm">Jadwal Sidang</a>
                                                            @endif
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
@endpush
