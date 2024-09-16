@extends('admin.layout.app')

@section('title')
    Edit Sub Jenis Rencana Pembangunan
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
                                <h1>Edit Sub Jenis Rencana Pembangunan</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <form
                                    action="{{ route('admin.update.jenis.sub.rencana.pembangunan', $subJenisRencanaPembangunan->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="">Nama</label>
                                            <input type="text" name="nama"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama', $subJenisRencanaPembangunan->nama) }}" id=""
                                                required>
                                            @error('nama')
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
