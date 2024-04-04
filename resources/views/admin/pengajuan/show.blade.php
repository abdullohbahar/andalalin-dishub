@extends('admin.layout.app')

@section('title')
    Data Pengajuan Permohonan
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
                        Data Pengajuan Permohonan</h1>
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
                        <li class="breadcrumb-item text-muted">Data Pengajuan Permohonan</li>
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
                        @if ($pengajuan->status == 'disetujui')
                        @else
                            @include('admin.layout.stepper')
                        @endif
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Data Pengajuan Permohonan</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <h3>
                                            <b>Data Pemohon</b>
                                        </h3>
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td>
                                                    <b>NIK</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser->hasOneProfile->no_ktp }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Pemohon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser->hasOneProfile->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Email Pemohon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor Telepon Pemohon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser->hasOneProfile->no_telepon }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Pimpinan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->nama_pimpinan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Jabatan Pimpinan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->jabatan_pimpinan }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <h3>
                                            <b>Data Konsultan</b>
                                        </h3>
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td>
                                                    <b>Nama Konsultan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->belongsToConsultan->hasOneProfile->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor Telepon Konsultan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->belongsToConsultan->hasOneProfile->no_telepon }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Email Konsultan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->belongsToConsultan->email }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mt-5">
                                    <b>Data Pengajuan Andalalin</b>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td>
                                                    <b>Jenis Jalan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->belongsToJenisJalan->jenis }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Jenis Rencana Pembangunan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->belongsToJenisRencana->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Sub Jenis Rencana Pembangunan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToSubJenisRencana->nama }}
                                                </td>
                                            </tr>
                                            @if ($pengajuan->belongsToSubSubJenisRencana != null)
                                                <tr>
                                                    <td>
                                                        <b>Sub Sub Jenis Rencana Pembangunan</b>
                                                    </td>
                                                    <td>
                                                        : {{ $pengajuan->belongsToSubSubJenisRencana->nama }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>
                                                    <b>Ukuran Minimal</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUkuranMinimal->keterangan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Kategori Bangkitan Lalu Lintas</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUkuranMinimal->kategori }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Proyek</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->nama_proyek }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Jalan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->nama_jalan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Luas Bangunan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon->luas_bangunan }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td>
                                                    <b>Luas Tanah</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->luas_tanah }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Alamat</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->alamat }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor Surat Permohonan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->nomor_surat_permohonan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Tanggal Surat Permohonan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->tanggal_surat_permohonan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Longitude</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->longitude }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Latitude</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon->latitude }}
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td>
                                                    <b>Lokasi</b>
                                                </td>
                                                <td>
                                                    <a target="_blank"
                                                        href="https://www.google.com/maps/{{ '@' . $pengajuan->hasOneDataPemohon->latitude }},{{ $pengajuan->hasOneDataPemohon->longitude }}"
                                                        class="btn btn-primary btn-sm">Lihat
                                                        Lokasi Di Google
                                                        Maps</a>
                                                </td>
                                            </tr> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mt-5">
                                    <b>Data Pemrakarsa</b>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td>
                                                    <b>Pemrakarsa</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOnePemrakarsa?->pemrakarsa }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Penanggung Jawab</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOnePemrakarsa?->nama_penanggung_jawab }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Jabatan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOnePemrakarsa?->jabatan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Alamat</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOnePemrakarsa?->alamat }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor telepon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOnePemrakarsa?->no_telepon }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mt-5">
                                    <b>Dokumen Pengajuan Andalalin</b>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div style="float: right">
                                            @if ($pengajuan->status == 'disetujui')
                                            @else
                                                <button class="btn btn-danger mb-3" id="rejectBtn">Tolak Pengajuan
                                                    Permohonan</button>
                                            @endif
                                        </div>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Dokumen</th>
                                                    <th>Status</th>
                                                    <th>Lihat Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengajuan->hasOneDataPemohon->hasManyDokumenDataPemohon as $dokumen)
                                                    <tr>
                                                        <td>{{ $dokumen->nama_dokumen }}</td>
                                                        <td>
                                                            @if (!$dokumen->status)
                                                                Perlu Persetujuan
                                                            @elseif($dokumen->status == 'disetujui')
                                                                <span class="badge bg-success">Disetujui</span>
                                                            @elseif($dokumen->status == 'revisi')
                                                                <span class="badge bg-warning">Revisi</span>
                                                            @elseif($dokumen->status == 'ditolak')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a target="_blank" href="{{ $dokumen->dokumen }}">Lihat
                                                                Dokumen</a>
                                                        </td>
                                                        <td>
                                                            @if (!$dokumen->status)
                                                                <div class="btn-group" role="group"
                                                                    aria-label="Basic mixed styles example">
                                                                    <button type="button" id="approveBtn"
                                                                        class="btn btn-sm btn-success"
                                                                        data-id="{{ $dokumen->id }}">Setujui</button>
                                                                    <button type="button" class="btn btn-sm btn-warning"
                                                                        class="" id="revisiBtn"
                                                                        data-id="{{ $dokumen->id }}">Revisi</button>
                                                                </div>
                                                            @elseif($dokumen->status == 'disetujui')
                                                                Anda Telah Menyetujui Dokumen Ini
                                                            @elseif($dokumen->status == 'revisi')
                                                                Harap Menunggu Pemohon
                                                                Melakukan Upload Ulang
                                                            @elseif($dokumen->status == 'ditolak')
                                                                Anda Telah Menolak Dokumen Ini Harap Menunggu Pemohon
                                                                Melakukan Upload Ulang
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    @if ($pengajuan->hasOneSuratPersetujuan?->is_kadis_approve)
                                                        <td>Surat Persetujuan</td>
                                                        <td>-</td>
                                                        <td><a target="_blank"
                                                                href="{{ route('download.surat.persetujuan', $pengajuan->id) }}">Lihat
                                                                Dokumen</a></td>
                                                        <td>
                                                            Anda Telah Menyetujui Dokumen Ini
                                                        </td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if ($pengajuan->status == 'disetujui')
                                @else
                                    <form action="{{ route('admin.selesai.verifikasi', $pengajuan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div style="float: right">
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
    @include('admin.pengajuan.components.modal-revisi')
    @include('admin.pengajuan.components.modal-tolak')
@endsection

@push('addons-js')
    <script>
        var token = $('meta[name="csrf-token"]').attr('content');

        // destroy anak asuh
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $("body").on("click", "#approveBtn", function() {
            var id = $(this).data("id");

            Swal.fire({
                title: 'Apakah anda yakin menyetujui dokumen ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/pengajuan/ajax/setujui/' +
                            id,
                        type: 'GET',
                        success: function(response) {
                            if (response.code == 200) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location
                                        .reload(); // Refresh halaman setelah mengklik OK
                                });
                            } else if (response.code == 500) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                })
                            }
                        }
                    })
                }
            })
        })

        $("body").on("click", "#revisiBtn", function() {
            var id = $(this).data("id");

            $("#revisiDokumenID").val(id)
            var myModal = new bootstrap.Modal(document.getElementById('modalRevisi'), {
                keyboard: false
            })

            myModal.show()
        })

        $("body").on("click", "#rejectBtn", function() {

            var myModal = new bootstrap.Modal(document.getElementById('modalTolak'), {
                keyboard: false
            })

            myModal.show()
        })
    </script>
@endpush
