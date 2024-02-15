@extends('admin.layout.app')

@section('title')
    Tambah Sub Jenis Rencana Pembangunan {{ $jenisRencanaPembangunan->nama }}
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
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="mt-5"> Tambah Sub Jenis Rencana Pembangunan -
                                    {{ $jenisRencanaPembangunan->nama }}
                                </h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store.jenis.sub.rencana.pembangunan') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="" class="form-label">Nama</label>
                                            <input type="hidden" name="id_jenis_rencana_pembangunan"
                                                value="{{ $jenisRencanaPembangunan->id }}">
                                            <input type="text" name="nama"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama') }}" id="">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-success">Tambah</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="mt-5">Sub Jenis Rencana Pembangunan -
                                    {{ $jenisRencanaPembangunan->nama }}</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table id="kt_datatable_dom_positioning"
                                    class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                                            <th style="width: 10%">#</th>
                                            <th style="width: 30%">Sub Jenis Rencana Pembangunan</th>
                                            <th style="width: 30%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($subJenisRencanaPembangunan as $subJenis)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $subJenis->nama }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-sm btn-success">Tambah Sub
                                                            Sub Jenis</button>
                                                        <button type="button" class="btn btn-sm btn-info">Ukuran
                                                            Minimal</button>
                                                        <a href="{{ route('admin.edit.jenis.sub.rencana.pembangunan', $subJenis->id) }}"
                                                            type="button" class="btn btn-sm btn-warning">Ubah</a>
                                                        <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
