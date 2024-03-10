@extends('konsultan.layout.app')

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
                            <div class="card-header pt-5">
                                <h1>Pengajuan Baru</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Pemohon</th>
                                            <th>Nama Proyek</th>
                                            <th>Jenis Rencana Pembangunan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuanBaru as $baru)
                                            <tr>
                                                <td>{{ $baru->belongsToUser->hasOneProfile->nama }}</td>
                                                <td>{{ $baru->belongsToJenisRencana->nama }}</td>
                                                <td>{{ $baru->hasOneDataPemohon->nama_proyek }}</td>
                                                <td>
                                                    @if ($baru->hasOneRiwayatInputData->step == 'Upload Dokumen Permohonan')
                                                        <a href="{{ route('konsultan.upload.dokumen.pemohon', $baru->id) }}"
                                                            class="btn btn-success btn-sm">Upload Dokumen Permohonan</a>
                                                    @endif
                                                    @if ($baru->hasOneRiwayatVerifikasi->step == 'Tinjauan Lapangan')
                                                        <a href="{{ route('konsultan.jadwal.tinjauan.lapangan', $baru->id) }}"
                                                            class="btn btn-success btn-sm">Jadwal Tinjauan Lapangan</a>
                                                    @endif
                                                    @if ($baru->hasOneRiwayatVerifikasi->step == 'Sidang')
                                                        <a href="{{ route('konsultan.jadwal.sidang', $baru->id) }}"
                                                            class="btn btn-success btn-sm">Jadwal Sidang</a>
                                                    @endif
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
                            <div class="card-header pt-5">
                                <h1>Pengajuan Ditolak</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Proyek</th>
                                            <th>Jenis Rencana Pembangunan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuanDitolak as $ditolak)
                                            <tr>
                                                <td>{{ $ditolak->belongsToJenisRencana->nama }}</td>
                                                <td>{{ $ditolak->hasOneDataPemohon->nama_proyek }}</td>
                                                <td>
                                                    <a href="{{ route('pemohon.show.pengajuan.andalalin', $ditolak->id) }}"
                                                        class="btn btn-success btn-sm">Perbaiki Data</a>
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
                            <div class="card-header pt-5">
                                <h1>Pengajuan Direvisi</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Proyek</th>
                                            <th>Jenis Rencana Pembangunan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuanPerluRevisi as $revisi)
                                            <tr>
                                                <td>{{ $revisi->belongsToJenisRencana->nama }}</td>
                                                <td>{{ $revisi->hasOneDataPemohon->nama_proyek }}</td>
                                                <td>
                                                    <a href="{{ route('pemohon.show.pengajuan.andalalin', $revisi->id) }}"
                                                        class="btn btn-success btn-sm">Revisi Data</a>
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
                            <div class="card-header pt-5">
                                <h1>Pengajuan Disetujui</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Proyek</th>
                                            <th>Jenis Rencana Pembangunan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuanDisetujui as $disetujui)
                                            <tr>
                                                <td>{{ $disetujui->belongsToJenisRencana->nama }}</td>
                                                <td>{{ $disetujui->hasOneDataPemohon->nama_proyek }}</td>
                                                <td></td>
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
