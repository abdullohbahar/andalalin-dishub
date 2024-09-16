@extends('admin.layout.app')

@section('title')
    Buat Jadwal Sidang
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
                        Buat Jadwal Sidang</h1>
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
                        <li class="breadcrumb-item text-muted">Buat Jadwal Sidang</li>
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
                        @include('admin.layout.stepper')
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Buat Jadwal Sidang</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store.jadwal.sidang', $pengajuan->id) }}" id="jadwalSidang"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 mt-4">
                                            <label for="" class="form-label">Tanggal</label>
                                            <input type="date"
                                                class="form-control @error('tanggal') is-invalid @enderror"
                                                value="{{ old('tanggal') }}" name="tanggal" id="" required>
                                            @error('tanggal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6 mt-4">
                                            <label for="" class="form-label">Jam</label>
                                            <div class="input-group mb-5" style="width: 30%">
                                                <select name="jam" class="form-control" id="">
                                                    <option value="00">00</option>
                                                    @for ($i = 1; $i < 24; $i++)
                                                        @php
                                                            $formattedValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        @endphp
                                                        <option value="{{ $formattedValue }}">{{ $formattedValue }}</option>
                                                    @endfor
                                                </select>
                                                <select name="menit" class="form-control" id="">
                                                    <option value="00">00</option>
                                                    @for ($i = 1; $i < 60; $i++)
                                                        @php
                                                            $formattedValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        @endphp
                                                        <option value="{{ $formattedValue }}">{{ $formattedValue }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6 mt-4">
                                            <label for="" class="form-label">Tipe Sidang</label>
                                            <select name="tipe" class="form-control @error('tipe') is-invalid @enderror"
                                                id="tipe" required>
                                                <option value="">-- Pilih Tipe Sidang --</option>
                                                <option {{ old('tipe') == 'offline' ? 'selected' : '' }} value="offline">
                                                    Offline</option>
                                                <option {{ old('tipe') == 'offline' ? 'selected' : '' }} value="online">
                                                    Online</option>
                                            </select>
                                            @error('tipe')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6 mt-4" id="alamatComponent" hidden>
                                            <label for="" class="form-label">Alamat Pelaksanaan Sidang</label>
                                            <textarea name="alamat" id="alamat" class="form-control" id="" style="width: 100%" rows="2">{{ old('alamat') }}</textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6 mt-4" id="urlComponent" hidden>
                                            <label for="" class="form-label">URL Sidang Online</label>
                                            <textarea name="url" id="url" class="form-control" id="" style="width: 100%" rows="2">{{ old('url') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-5" style="float: right">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success">Buat Jadwal</button>
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
    <script>
        $("#tipe").on("change", function() {
            var val = $(this).val()

            if (val == 'offline') {
                $("#alamatComponent").attr("hidden", false)
                $("#alamat").attr("required", true)

                $("#urlComponent").attr("hidden", true)
                $("#url").attr("required", false)
            } else {
                $("#urlComponent").attr("hidden", false)
                $("#url").attr("required", true)

                $("#alamatComponent").attr("hidden", true)
                $("#alamat").attr("required", false)
            }
        })
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap formulir saat di-submit
            var form = document.getElementById(
                'jadwalSidang'); // Ganti 'jadwalSidang' dengan ID formulir Anda

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah formulir untuk langsung di-submit

                // Menampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Klik "Ya" untuk konfirmasi.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengklik "Ya", formulir akan di-submit
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
