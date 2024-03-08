@extends('pemohon.layout.app')

@section('title')
    Upload Dokumen
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
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Upload Dokumen</h1>
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
                        <li class="breadcrumb-item text-muted">Upload Dokumen</li>
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
                                <h2 class="mt-5">Upload Dokumen</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Peringatan!!!</h2>
                                <ul>
                                    <li>Harap melakukan koordinasi dengan konsultan untuk file yang akan diupload</li>
                                    <li>Harap klik tombol <b>UPLOAD</b> setelah memilih file</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mt-5">
                                        <form action="{{ route('pemohon.store.dokumen.pemohon') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="data_pemohon_id" value="{{ $dataPemohon->id }}">
                                            <label for="" class="form-label">Surat Permohonan</label>
                                            <div class="input-group mb-3">
                                                <input type="file" name="surat_permohonan" class="form-control" required
                                                    accept=".pdf" onchange="validateFile(this)" id="">
                                                <button class="input-group-text btn btn-success"
                                                    type="submit">Upload</button>
                                            </div>
                                            @if ($suratPermohonan)
                                                <a target="_blank" href="{{ $suratPermohonan }}">
                                                    Lihat Surat Permohonan Yang Telah Diupload
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-5">
                                        <form action="{{ route('pemohon.store.dokumen.pemohon') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="data_pemohon_id" value="{{ $dataPemohon->id }}">
                                            <label for="" class="form-label">Dokumen Site Plan</label>
                                            <div class="input-group mb-3">
                                                <input type="file" name="dokumen_site_plan" class="form-control" required
                                                    accept=".pdf" onchange="validateFile(this)" id="">
                                                <button class="input-group-text btn btn-success"
                                                    type="submit">Upload</button>
                                            </div>
                                            @if ($dokumenSitePlan)
                                                <a target="_blank" href="{{ $dokumenSitePlan }}">
                                                    Lihat Dokumen Site Plan Yang Telah Diupload
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-5">
                                        <form action="{{ route('pemohon.store.dokumen.pemohon') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="data_pemohon_id" value="{{ $dataPemohon->id }}">
                                            <label for="" class="form-label">Surat Aspek Tata Ruang</label>
                                            <div class="input-group mb-3">
                                                <input type="file" name="surat_aspek_tata_ruang" class="form-control"
                                                    required accept=".pdf" onchange="validateFile(this)" id="">
                                                <button class="input-group-text btn btn-success"
                                                    type="submit">Upload</button>
                                            </div>
                                            @if ($suratAspekTataRuang)
                                                <a target="_blank" href="{{ $suratAspekTataRuang }}">
                                                    Lihat Surat Aspek Tata Ruang Yang Telah Diupload
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-5">
                                        <form action="{{ route('pemohon.store.dokumen.pemohon') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="data_pemohon_id" value="{{ $dataPemohon->id }}">
                                            <label for="" class="form-label">Sertifikat Tanah</label>
                                            <div class="input-group mb-3">
                                                <input type="file" name="sertifikat_tanah" class="form-control"
                                                    required accept=".pdf" onchange="validateFile(this)" id="">
                                                <button class="input-group-text btn btn-success"
                                                    type="submit">Upload</button>
                                            </div>
                                            @if ($sertifikatTanah)
                                                <a target="_blank" href="{{ $sertifikatTanah }}">
                                                    Lihat Sertifikat Tanah Yang Telah Diupload
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mt-5">
                                        <form action="{{ route('pemohon.store.dokumen.pemohon') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="data_pemohon_id" value="{{ $dataPemohon->id }}">
                                            <label for="" class="form-label">KKOP</label>
                                            <div class="input-group mb-3">
                                                <input type="file" name="kkop" class="form-control" required
                                                    accept=".pdf" onchange="validateFile(this)" id="">
                                                <button class="input-group-text btn btn-success"
                                                    type="submit">Upload</button>
                                            </div>
                                            @if ($kkop)
                                                <a target="_blank" href="{{ $kkop }}">
                                                    Lihat KKOP Yang Telah Diupload
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('after.upload.dokumen') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="data_pemohon_id" value="{{ $dataPemohon->id }}">
                                    <button type="submit" class="btn btn-success"
                                        style="float: right;">Selanjutnya</button>
                                </form>
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
