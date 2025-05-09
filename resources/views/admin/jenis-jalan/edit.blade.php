@extends('admin.layout.app')

@section('title')
    Ubah Jenis Jalan - {{ $jenisJalan->jenis }}
@endsection

@push('addons-css')
@endpush

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Ubah Jenis Jalan - {{ $jenisJalan->jenis }}</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <form action="{{ route('admin.update.jenis.jalan', $jenisJalan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="">Jenis Jalan</label>
                                            <input type="text" name="jenis"
                                                class="form-control @error('jenis') is-invalid @enderror"
                                                value="{{ old('jenis', $jenisJalan->jenis) }}" id="" required>
                                            @error('jenis')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-success">
                                                Simpan
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
@endpush
