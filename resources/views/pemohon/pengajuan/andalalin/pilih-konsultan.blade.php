@extends('pemohon.layout.app')

@section('title')
    Pengajuan Baru
@endsection

@push('addons-css')
    <style>
        input[readonly] {
            background-color: #F1F1F2;
            /* Ganti dengan warna yang diinginkan */
        }
    </style>
@endpush

@section('content')
    <form action="">
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Pengajuan Baru</h1>
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
                            <li class="breadcrumb-item text-muted">Pengajuan Baru</li>
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
                        <div class="col-sm-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="mt-5">Data Pengajuan</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="mt-5">
                                        Data Pemohon
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class="form-label">NIK</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->hasOneProfile->no_ktp }}" disabled id="">
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="" class="form-label">Nama</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->hasOneProfile->nama }}" disabled id="">
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="" class="form-label">Email</label>
                                            <input type="text" class="form-control" value="{{ $user->email }}" disabled
                                                id="">
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->hasOneProfile->no_telepon }}" disabled id="">
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="" class="form-label">Nama Pimpinan</label>
                                            <input type="text"
                                                class="form-control @error('nama_pimpinan') is-invalid @enderror"
                                                name="nama_pimpinan" value="{{ old('nama_pimpinan') }}" id=""
                                                required>
                                            @error('nama_pimpinan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-5">
                                            <label for="" class="form-label">Jabatan Pimpinan</label>
                                            <input type="text"
                                                class="form-control @error('jabatan_pimpinan') is-invalid @enderror"
                                                name="jabatan_pimpinan" value="{{ old('jabatan_pimpinan') }}" id=""
                                                required>
                                            @error('jabatan_pimpinan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            @include('pemohon.pengajuan.andalalin.components.alert')
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="mt-5">
                                        Data Konsultan<br>
                                    </h2>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalPilihKonsultan">
                                            Pilih Konsultan
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Nama</label>
                                                <input type="text" class="form-control" readonly id="nama_konsultan"
                                                    required>
                                                <input type="hidden" name="konsultan_id" class="form-control"
                                                    id="konsultan_id">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control" readonly
                                                    id="no_telepon_konsultan">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Email</label>
                                                <input type="text" class="form-control" readonly id="email_konsultan">
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">No Sertifikat</label>
                                                <input type="text" class="form-control" disabled
                                                    id="no_sertifikat_konsultan">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Masa Berlaku Sertifikat</label>
                                                <input type="text" class="form-control" disabled
                                                    id="masa_berlaku_sertifikat_konsultan">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Tingkatan</label>
                                                <input type="text" class="form-control" disabled
                                                    id="tingkatan_konsultan">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="mt-5">
                                        <b>Data Pengajuan Andalalin</b>
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class="form-label">Jenis Jalan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $pengajuan->belongsToJenisJalan->jenis }}" disabled
                                                        id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Jenis Rencana
                                                        Pembangunan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $pengajuan->belongsToJenisRencana->nama }}" disabled
                                                        id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Sub Jenis Rencana
                                                        Pembangunan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $pengajuan->belongsToSubJenisRencana->nama }}" disabled
                                                        id="">
                                                </div>
                                                @if ($pengajuan->belongsToSubSubJenisRencana != null)
                                                    <div class="col-12 mt-5">
                                                        <label for="" class="form-label">Sub Sub Jenis Rencana
                                                            Pembangunan</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $pengajuan->belongsToSubSubJenisRencana->nama }}"
                                                            disabled id="">
                                                    </div>
                                                @endif
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Ukuran Minimal</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $pengajuan->belongsToUkuranMinimal->kategori }}"
                                                        disabled id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Nama Proyek</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('nama_proyek') }}" required id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Nama Jalan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('nama_jalan') }}" required id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Luas Bangunan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('luas_bangunan') }}" required id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class="form-label">Luas Tanah</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('luas_tanah') }}" required id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Alamat</label>
                                                    <textarea name="alamat" id="" style="width:100%" class="form-control" rows="1">{{ old('alamat') }}</textarea>
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Nomor Surat
                                                        Permohonan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('nomor_surat_permohonan') }}" required
                                                        id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Tanggal Surat
                                                        Permohonan</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ old('tanggal_surat_permohonan') }}" required
                                                        id="">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mt-5">
                                                        <label for="" class="form-label">Tentukan Lokasi. <i
                                                                style="color: red">Anda Harus Berada Dilokasi Untuk
                                                                Menentukan
                                                                Lokasi</i></label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="" class="form-label">longitude</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ old('longitude') }}" required id="longitude">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="" class="form-label">latitude</label>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ old('latitude') }}" required id="latitude">
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <button type="button" id="getLocation"
                                                            class="btn btn-sm btn-info">Klik
                                                            untuk mengambil
                                                            longitude dan latitude lokasi</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success"
                                        style="float: right;">Selanjutnya</button>
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
    </form>
    @include('pemohon.pengajuan.andalalin.components.modal-pilih-konsultan')
@endsection

@push('addons-js')
    <script>
        $("#getLocation").on("click", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    $("#longitude").val(longitude)
                    $("#latitude").val(latitude)
                });
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        })
    </script>

    <script src="{{ asset('./assets/js/pages/pilih-konsultan.js') }}"></script>
@endpush
