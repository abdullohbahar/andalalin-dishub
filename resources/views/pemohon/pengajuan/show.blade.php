@extends('pemohon.layout.app')

@section('title')
    Detail Pengajuan Permohonan
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
                        Detail Pengajuan Permohonan</h1>
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
                        <li class="breadcrumb-item text-muted">Verifikasi Pengajuan Permohonan</li>
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
                                <h1>Detail Pengajuan Permohonan</h1>
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
                                                    : {{ $pengajuan->belongsToUser?->hasOneProfile?->no_ktp }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Pemohon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser?->hasOneProfile?->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Email Pemohon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser?->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor Telepon Pemohon</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUser?->hasOneProfile?->no_telepon }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Pimpinan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->nama_pimpinan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Jabatan Pimpinan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->jabatan_pimpinan }}
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
                                                    {{ $pengajuan->hasOneDataPemohon?->belongsToConsultan?->hasOneProfile?->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor Telepon Konsultan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon?->belongsToConsultan?->hasOneProfile?->no_telepon }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Email Konsultan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->belongsToConsultan?->email }}
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
                                                    {{ $pengajuan->belongsToJenisJalan?->jenis }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Jenis Rencana Pembangunan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->belongsToJenisRencana?->nama }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Sub Jenis Rencana Pembangunan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToSubJenisRencana?->nama }}
                                                </td>
                                            </tr>
                                            @if ($pengajuan->belongsToSubSubJenisRencana != null)
                                                <tr>
                                                    <td>
                                                        <b>Sub Sub Jenis Rencana Pembangunan</b>
                                                    </td>
                                                    <td>
                                                        : {{ $pengajuan->belongsToSubSubJenisRencana?->nama }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>
                                                    <b>Ukuran Minimal</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUkuranMinimal?->keterangan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Kategori Bangkitan Lalu Lintas</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->belongsToUkuranMinimal?->kategori }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Proyek</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->nama_proyek }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nama Jalan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->nama_jalan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Lusa Bangunan</b>
                                                </td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->luas_bangunan }}
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
                                                    {{ $pengajuan->hasOneDataPemohon?->luas_tanah }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Alamat</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon?->alamat }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Nomor Surat Permohonan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon?->nomor_surat_permohonan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Tanggal Surat Permohonan</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon?->tanggal_surat_permohonan }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Longitude</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon?->longitude }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Latitude</b>
                                                </td>
                                                <td>
                                                    :
                                                    {{ $pengajuan->hasOneDataPemohon?->latitude }}
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
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Dokumen</th>
                                                    <th>Status</th>
                                                    <th>Lihat Dokumen</th>
                                                    @if ($pengajuan->status == 'disetujui' || $pengajuan->status == 'menunggu konfirmasi admin')
                                                    @else
                                                        <th>Alasan</th>
                                                        <th>Aksi</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengajuan->hasOneDataPemohon?->hasManyDokumenDataPemohon as $dokumen)
                                                    @php
                                                        if ($dokumen->is_revised = 1) {
                                                            $isRevised = 1;
                                                        }
                                                    @endphp
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
                                                                <span class="badge bg-danger text-light">Ditolak</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a target="_blank" href="{{ $dokumen->dokumen }}">Lihat
                                                                Dokumen</a>
                                                        </td>
                                                        @if ($pengajuan->status == 'disetujui' || $pengajuan->status == 'menunggu konfirmasi admin')
                                                        @else
                                                            <td>
                                                                {{ $dokumen->alasan }}
                                                            </td>
                                                            <td>
                                                                @if ($dokumen->status == 'revisi' || $dokumen->status == 'ditolak')
                                                                    <button id="revisiBtn" class="btn btn-info btn-sm"
                                                                        data-dokumenid="{{ $dokumen->id }}"
                                                                        data-namadokumen="{{ $dokumen->nama_dokumen }}"
                                                                        data-namaproyek="{{ $pengajuan->hasOneDataPemohon?->nama_proyek }}">Upload
                                                                        Ulang</button>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    @if ($pengajuan->hasOneSuratPersetujuan?->is_kadis_approve)
                                                        <td>Surat Persetujuan</td>
                                                        <td>-</td>
                                                        <td><a target="_blank"
                                                                href="{{ route('download.surat.persetujuan', $pengajuan->id) }}">Lihat
                                                                Dokumen</a></td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- @if ($dokumen->status == 'revisi' || $dokumen->status == 'ditolak' || $isRevised == 1)
                                <div class="card-footer">
                                    <div style="float: right">
                                        <form action="{{ route('pemohon.selesai.revisi', $pengajuan->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Selesai
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    @include('pemohon.pengajuan.components.modal-revisi')
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
            var dokumenID = $(this).data("dokumenid");
            var namaDokumen = $(this).data("namadokumen");
            var namaProyek = $(this).data("namaproyek");

            $("#revisiDokumenID").val(dokumenID)
            $("#namaDokumen").text(namaDokumen)
            $("#namaDokumen1").text(namaDokumen)
            $("#namaProyek").val(namaProyek)
            $("#fieldNamaDokumen").val(namaDokumen)

            var myModal = new bootstrap.Modal(document.getElementById('modalRevisi'), {
                keyboard: false
            })

            myModal.show()
        })
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
