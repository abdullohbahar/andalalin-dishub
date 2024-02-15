@extends('admin.layout.app')

@section('title')
    Jenis Rencana Pembangunan
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
                                <h1>Jenis Rencana Pembangunan</h1>
                                <div class="card-toolbar">
                                    <a href="{{ route('admin.create.jenis.rencana.pembangunan') }}"
                                        class="btn btn-sm btn-primary">
                                        Tambah
                                    </a>
                                </div>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table id="kt_datatable_dom_positioning"
                                    class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                                            <th style="width: 10%">#</th>
                                            <th style="width: 30%">Jenis Rencana Pembangunan</th>
                                            <th style="width: 30%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($jenisRencanaPembangunan as $jenis)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $jenis->nama }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('admin.jenis.sub.rencana.pembangunan', $jenis->id) }}"
                                                            type="button" class="btn btn-sm btn-success">Tambah Sub
                                                            Jenis</a>
                                                        <a href="{{ route('admin.edit.jenis.rencana.pembangunan', $jenis->id) }}"
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
