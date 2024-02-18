@extends('admin.layout.app')

@section('title')
    Ukuran Minimal - {{ $queries->nama }}
@endsection

@push('addons-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <h1 class="mt-5"> Ukuran Minimal -
                                    {{ $queries->nama }}
                                </h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store.ukuran.minimal') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" name="id_sub" value="{{ $queries->id }}">
                                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                                            <label for="" class="form-label">Ukuran Minimal</label>
                                            <input type="text" name="keterangan"
                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                value="{{ old('keterangan') }}" id="">
                                            @error('keterangan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <input type="hidden" name="id_sub" value="{{ $queries->id }}">
                                            <label for="" class="form-label">Kategori</label>
                                            <input type="text" name="kategori"
                                                class="form-control @error('kategori') is-invalid @enderror"
                                                value="{{ old('kategori') }}" id="">
                                            @error('kategori')
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
                                <h1 class="mt-5">Ukuran Minimal -
                                    {{ $queries->nama }}</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <table id="kt_datatable_dom_positioning"
                                    class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                                            <th style="width: 10%">#</th>
                                            <th style="width: 30%">Ukuran Minimal</th>
                                            <th style="width: 30%">Keterangan</th>
                                            <th style="width: 30%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($ukuranMinimal as $ukuran)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $ukuran->keterangan }}</td>
                                                <td>{{ $ukuran->kategori }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('admin.edit.ukuran.minimal', [
                                                            'idMinimal' => $ukuran->id,
                                                            'jenis' => $jenis,
                                                            'idSub' => $queries->id,
                                                        ]) }}"
                                                            type="button" class="btn btn-sm btn-warning">Ubah</a>
                                                        <a data-id="{{ $ukuran->id }}" id="removeBtn"
                                                            style="cursor: pointer !important;"
                                                            class="btn btn-sm btn-danger"><b>Hapus</b></a>
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
    <script>
        var token = $('meta[name="csrf-token"]').attr('content');


        // destroy anak asuh
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $("body").on("click", "#removeBtn", function() {
            var id = $(this).data("id");

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang berhubungan akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/jenis-rencana-pembangunan/sub-jenis-rencana-pembangunan/ukuran-minimal/destroy/' +
                            id,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.code == 200) {
                                Swal.fire(
                                    'Berhasil!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location
                                        .reload(); // Refresh halaman setelah mengklik OK
                                });
                            } else if (response.code == 500) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                })
                            }
                        }
                    })
                }
            })
        })
    </script>
@endpush
