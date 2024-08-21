@php
    $role = auth()->user()->role;

    if ($role == 'pemrakarsa') {
        $role = 'pemohon';
    }
@endphp

@extends("$role.layout.app")

@section('title')
    Input Data Permohonan dan Data Konsultan
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
    <form id="form" action="{{ route('pemohon.store.data.pemohon.andalalin') }}" method="POST">
        @csrf
        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Input Data Permohonan dan Data Konsultan</h1>
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
                            <li class="breadcrumb-item text-muted">Input Data Permohonan dan Data Konsultan</li>
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
                            @include('pemohon.layout.stepper')
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
                                                name="nama_pimpinan"
                                                value="{{ old('nama_pimpinan', $dataPemohon->nama_pimpinan ?? '') }}"
                                                id="" required>
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
                                                name="jabatan_pimpinan"
                                                value="{{ old('jabatan_pimpinan', $dataPemohon->jabatan_pimpinan ?? '') }}"
                                                id="" required>
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
                                                <input type="text" class="form-control" readonly name="nama_konsultan"
                                                    id="nama_konsultan"
                                                    value="{{ old('nama_konsultan', $dataPemohon->belongsToConsultan?->hasOneProfile?->nama ?? '') }}"
                                                    required>
                                                <input type="hidden" name="konsultan_id"
                                                    value="{{ old('konsultan_id', $dataPemohon->konsultan_id ?? '') }}"
                                                    class="form-control" id="konsultan_id">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Nomor Telepon</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('no_telepon_konsultan', $dataPemohon->belongsToConsultan?->hasOneProfile?->no_telepon ?? '') }}"
                                                    name="no_telepon_konsultan" readonly id="no_telepon_konsultan">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-5">
                                                <label for="" class="form-label">Email</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('email_konsultan', $dataPemohon->belongsToConsultan?->email ?? '') }}"
                                                    readonly id="email_konsultan" name="email_konsultan">
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
                                        <b>Data Pemrakarsa / Instansi</b>
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <label for="" class="form-label mt-3">Pemrakarsa /
                                                    Instansi</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('pemrakarsa', $dataPemrakarsa?->pemrakarsa) }}"
                                                    name="pemrakarsa" id="" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label for="" class="form-label mt-3">Nama Penanggung
                                                    Jawab</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('nama_penanggung_jawab', $dataPemrakarsa?->nama_penanggung_jawab) }}"
                                                    name="nama_penanggung_jawab" id="" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label for="" class="form-label mt-3">Jabatan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('jabatan_pemrakarsa', $dataPemrakarsa?->jabatan) }}"
                                                    name="jabatan_pemrakarsa" id="" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label for="" class="form-label mt-3">Nomor Telepon</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('no_telepon', $dataPemrakarsa?->no_telepon) }}"
                                                    name="no_telepon" id="" required>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label for="" class="form-label mt-3">Alamat</label>
                                                <textarea class="form-control" required name="alamat_pemrakarsa" id="" cols="30" rows="2">{{ old('alamat_pemrakarsa', $dataPemrakarsa?->alamat) }}</textarea>
                                            </div>
                                        </div>
                                    </form>
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
                                                        value="{{ old('nama_proyek', $dataPemohon->nama_proyek ?? '') }}"
                                                        name="nama_proyek" required id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Nama Jalan</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('nama_jalan', $dataPemohon->nama_jalan ?? '') }}"
                                                        name="nama_jalan" required id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Luas Bangunan</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            value="{{ old('luas_bangunan', $dataPemohon->luas_bangunan ?? '') }}"
                                                            name="luas_bangunan" required id="">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">m<sup>2</sup></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class="form-label">Luas Tanah</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            value="{{ old('luas_tanah', $dataPemohon->luas_tanah ?? '') }}"
                                                            name="luas_tanah" required id="">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">m<sup>2</sup></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Alamat</label>
                                                    <textarea name="alamat" id="" name="alamat" style="width:100%" class="form-control" rows="1">{{ old('alamat', $dataPemohon->alamat ?? '') }}</textarea>
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Nomor Surat
                                                        Permohonan</label>
                                                    <input type="text" class="form-control"
                                                        name="nomor_surat_permohonan"
                                                        value="{{ old('nomor_surat_permohonan', $dataPemohon->nomor_surat_permohonan ?? '') }}"
                                                        required id="">
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <label for="" class="form-label">Tanggal Surat
                                                        Permohonan</label>
                                                    @php
                                                        $tanggal = $dataPemohon->tanggal_surat_permohonan ?? null;

                                                        if ($tanggal) {
                                                            $tanggal = $dataPemohon->getRawOriginal(
                                                                'tanggal_surat_permohonan',
                                                            );
                                                        } else {
                                                            $tanggal = '';
                                                        }
                                                    @endphp
                                                    <input type="date" class="form-control"
                                                        name="tanggal_surat_permohonan"
                                                        value="{{ old('tanggal_surat_permohonan', $tanggal) }}" required
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
                                                        <input type="text" class="form-control" name="longitude"
                                                            value="{{ old('longitude', $dataPemohon->longitude ?? '') }}"
                                                            required id="longitude">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="" class="form-label">latitude</label>
                                                        <input type="text" class="form-control" name="latitude"
                                                            value="{{ old('latitude', $dataPemohon->latitude ?? '') }}"
                                                            required id="latitude">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 mt-3">
                                                        <button type="button" id="getLocation"
                                                            class="btn btn-sm btn-info" style="width:100%">Ambil
                                                            Lokasi</button>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 mt-3">
                                                        <button id="seeLocation" type="button" style="width:100%"
                                                            class="btn btn-sm btn-primary">Lihat
                                                            Lokasi</button>
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

        $("#seeLocation").on("click", function() {
            var latitude = $("#latitude").val()
            var longitude = $("#longitude").val()

            var url = `https://www.google.com/maps?q=${latitude},${longitude}`
            window.open(url, '_blank').focus()
        })
    </script>

    <script>
        $(document).ready(function() {
            var klasifikasi = $("#klasifikasi").val()

            $("#form").on("submit", function(e) {
                if (klasifikasi == 'sedang' || klasifikasi == 'tinggi') {

                    var idKonsultan = $("#konsultan_id").val()

                    if (!idKonsultan) {
                        e.preventDefault();
                        Swal.fire({
                            position: "center",
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Anda harus memilih konsultan terlebih dahulu, karena pengajuan anda masuk kategori bangkitan {{ $klasifikasi }}'
                        })
                    }
                }
            })
        })
    </script>

    <script src="{{ asset('./assets/js/pages/pilih-konsultan.js') }}"></script>
@endpush
