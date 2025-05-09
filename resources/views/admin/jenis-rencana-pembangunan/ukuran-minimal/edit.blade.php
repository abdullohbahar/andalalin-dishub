@extends('admin.layout.app')

@section('title')
    Edit Ukuran Minimal
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
                                <h1>Edit Ukuran Minimal</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <form action="{{ route('admin.update.ukuran.minimal', $ukuranMinimal->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                                            <input type="hidden" name="id_sub" value="{{ $idSub }}">
                                            <label for="" class="form-label">Ukuran Minimal</label>
                                            <input type="text" name="keterangan"
                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                value="{{ old('keterangan', $ukuranMinimal->keterangan) }}" id="">
                                            @error('keterangan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <label for="" class="form-label">Kategori</label>
                                            <input type="text" name="kategori"
                                                class="form-control @error('kategori') is-invalid @enderror"
                                                value="{{ old('kategori', $ukuranMinimal->kategori) }}" id="">
                                            @error('kategori')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <label for="" class="form-label">Tipe</label>
                                            <input type="text" name="tipe"
                                                class="form-control @error('tipe') is-invalid @enderror"
                                                value="{{ old('tipe', $ukuranMinimal->tipe) }}" id=""
                                                placeholder="Contoh: Dokumen Andalalin">
                                            @error('tipe')
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
