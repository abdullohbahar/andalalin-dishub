@extends('pemohon.layout.app')

@section('title')
    Buat Pengajuan Baru
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
                        Buat Pengajuan Baru</h1>
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
                        <li class="breadcrumb-item text-muted">Buat Pengajuan Baru</li>
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
                                <h2 class="mt-5">Buat Pengajuan Andalalin Baru</h2>
                            </div>
                            <div class="card-body">
                                <form action="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class="form-label">Pilih Jenis Jalan</label>
                                            <select name="jenis_jalan_id" id="" class="form-control" required>
                                                <option value="">-- Pilih Jenis Jalan --</option>
                                                @foreach ($jenisJalans as $jalan)
                                                    <option value="{{ $jalan->id }}">{{ $jalan->jenis }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <label for="" class="form-label">Pilih Jenis Rencana Pembangunan</label>
                                            <select required name="jenis_rencana_id" id="jenisRencana" class="form-control"
                                                required>
                                                <option value="">-- Pilih Jenis Rencana Pembangunan --</option>
                                                @foreach ($jenisRencanas as $jenis)
                                                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-5" id="sectionSubJenisRencana" hidden>
                                        <div class="col-12">
                                            <label for="" class="form-label">Pilih Sub Jenis Rencana
                                                Pembangunan</label>
                                            <select name="sub_jenis_rencana_id" id="subJenisRencana" class="form-control"
                                                required>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-5" id="sectionSubSubJenisRencana" hidden>
                                        <div class="col-12">
                                            <label for="" class="form-label">Pilih Sub Sub Jenis Rencana
                                                Pembangunan</label>
                                            <select name="sub_sub_jenis_rencana_id" id="subSubJenisRencana"
                                                class="form-control" required>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-5" id="sectionUkuranMinimal" hidden>
                                        <div class="col-12">
                                            <label for="" class="form-label">Pilih Ukuran Minimal</label>
                                            <select name="ukuran_minimal_id" id="ukuranMinimal" class="form-control"
                                                required>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="next" class="btn btn-primary mt-5" style="float: right">
                                                Lanjut
                                            </button>
                                        </div>
                                    </div>
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
    <script src="{{ asset('./assets/js/pages/show-sub-jenis-rencana.js') }}"></script>
@endpush
