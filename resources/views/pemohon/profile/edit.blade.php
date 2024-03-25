@php
    $role = auth()->user()->role;

    if ($role == 'penilai1' || $role == 'penilai2' || $role == 'penilai3') {
        $role = 'penilai';
    }
@endphp

@extends("$role.layout.app")

@section('title')
    Profile
@endsection

@push('addons-css')
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/jquery.signature.css">

    <style>
        .kbw-signature {
            width: 250px;
            height: 250px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
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
                    @includeWhen(
                        $user->hasOneProfile == null,
                        'pemohon.profile.components.alert-lengkapi-profile')
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Lengkapi Profil Anda</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST"
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
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                                            <label for="" class="form-label">
                                                Username <span style="color: red">*</span>
                                            </label>
                                            <input type="text" name="username"
                                                class="form-control @error('username') is-invalid @enderror"
                                                placeholder="Masukkan Username Anda"
                                                value="{{ old('username', $user->username ?? '') }}" id="">
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
                                            <label for="" class="form-label">
                                                Password
                                                @if (!$user->password)
                                                    <span style="color: red">*</span>
                                                @else
                                                    <small>Biarkan kosong jika tidak ingin mengubah password</small>
                                                @endif
                                            </label>
                                            <div class="input-group mb-5">
                                                <input type="password" name="password"
                                                    {{ $user->password == null ? 'required' : '' }}
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Masukkan password Anda" id="password">
                                                <span class="input-group-text view-password" id="basic-addon2">
                                                    <i id="icon" class="fas fa-eye"></i>
                                                </span>
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            @include('admin.user.components.password-requirement')
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4">
                                            <label for="" class="form-label">Konfirmasi Password</label>
                                            <div class="input-group mb-5">
                                                <input type="password" name="password_confirmation"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    id="password_confirmation" autocomplete="new-password">
                                                <span class="input-group-text view-password-confirmation"
                                                    id="basic-addon2">
                                                    <i id="icon-password-confirmation" class="fas fa-eye"></i>
                                                </span>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback text-capitalize">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        @includeWhen(
                                            $user->role == 'pemohon',
                                            'pemohon.profile.components.file-upload-pemohon')
                                        @includeWhen(
                                            $user->role == 'pemrakarsa',
                                            'pemohon.profile.components.file-upload-pemrakarsa')
                                        @includeWhen(
                                            $user->role == 'konsultan',
                                            'pemohon.profile.components.file-upload-konsultan')
                                        @includeWhen(
                                            $user->role == 'penilai1' ||
                                                $user->role == 'penilai2' ||
                                                $user->role == 'penilai3',
                                            'pemohon.profile.components.ttd')
                                        @includeWhen(
                                            $user->role == 'kasi' || $user->role == 'kabid',
                                            'pemohon.profile.components.file-upload-kasi')
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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/jquery.signature.min.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.touch-punch.min.js"></script>

    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>

    <script src="{{ asset('./assets/js/pages/view-password.js') }}"></script>
@endpush
