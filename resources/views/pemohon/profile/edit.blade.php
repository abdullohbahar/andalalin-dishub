@extends('pemohon.layout.app')

@section('title')
    Profile
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
                        Profile</h1>
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
                        <li class="breadcrumb-item text-muted">Profile</li>
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
                        <!--begin::Alert-->
                        <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-notification-bing fs-2hx text-dark me-4 mb-5 mb-sm-0"><span
                                    class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column text-dark pe-0 pe-sm-10">
                                <!--begin::Title-->
                                <h4 class="mb-2 light">Harap Melengkapi Profil !</h4>
                                <!--end::Title-->

                                <!--begin::Content-->
                                <span>
                                    Harap lengkapi profile anda agar dapat membuat pengajuan.
                                </span>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Alert-->
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Lengkapi Profil Anda</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <form action="{{ route('pemohon.update.profile', auth()->user()->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                                            <label for="" class="form-label">
                                                Nama <span style="color: red">*</span>
                                            </label>
                                            <input type="text" name="nama"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                placeholder="Masukkan Nama Anda"
                                                value="{{ old('nama', $user->hasOneProfile?->nama ?? '') }}" id="">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                                            <label for="" class="form-label">
                                                No KTP <span style="color: red">*</span>
                                            </label>
                                            <input type="text" name="no_ktp"
                                                class="form-control @error('no_ktp') is-invalid @enderror"
                                                placeholder="Masukkan Nomor KTP Anda"
                                                value="{{ old('no_ktp', $user->hasOneProfile?->no_ktp ?? '') }}"
                                                id="">
                                            @error('no_ktp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                                            <label for="" class="form-label">
                                                No Telepon <span style="color: red">*</span>
                                            </label>
                                            <input type="text" name="no_telepon"
                                                class="form-control @error('no_telepon') is-invalid @enderror"
                                                placeholder="Masukkan Nomor Telepon Anda"
                                                value="{{ old('no_telepon', $user->hasOneProfile?->no_telepon ?? '') }}"
                                                id="">
                                            @error('no_telepon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                                            <label for="" class="form-label">
                                                Alamat <span style="color: red">*</span>
                                            </label>
                                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="" rows="2">{{ old('alamat', $user->hasOneProfile?->alamat ?? '') }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                                            <label for="" class="form-label">
                                                Foto KTP <span style="color: red">*</span>
                                            </label>
                                            <input type="file" name="file_ktp"
                                                class="form-control @error('file_ktp') is-invalid @enderror" id="">
                                            @error('file_ktp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                                            <label for="" class="form-label">
                                                Sertifikat Andalalin (Penyusun) <span style="color: red">*</span>
                                            </label>
                                            <input type="file" name="file_sertifikat_andalalin"
                                                class="form-control @error('file_sertifikat_andalalin') is-invalid @enderror"
                                                id="">
                                            @error('file_sertifikat_andalalin')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                                            <label for="" class="form-label">
                                                CV (Company Profile) <span style="color: red">*</span>
                                            </label>
                                            <input type="file" name="file_cv"
                                                class="form-control @error('file_cv') is-invalid @enderror"
                                                id="">
                                            @error('file_cv')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-5">
                                            <button type="submit" class="btn btn-success mt-5"
                                                style="width: 100%">Simpan</button>
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
@endpush
