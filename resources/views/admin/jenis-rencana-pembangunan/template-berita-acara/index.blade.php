@extends('admin.layout.app')

@section('title')
    Template Berita Acara {{ $jenisRencana->nama }}
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pt-5">
                                <h1>Template Berita Acara {{ $jenisRencana->nama }}</h1>
                            </div>
                            <div class="card-body" style="overflow-y: visible">
                                <form action="{{ route('admin.update.template.berita.acara', $jenisRencana->id) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="jenis" value="{{ $jenis }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="">
                                                <h4>Tahapan Operasional</h4>
                                            </label>
                                            <textarea name="body" class="editor" style="width: 100%;">{{ old('body', $jenisRencana->hasOneTemplateBeritaAcara?->body) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-5">
                                            <button type="submit" class="btn btn-success">Simpan</button>
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
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>

    <script>
        ClassicEditor.create(document.querySelector(".editor"), {
            height: 1200, // Ganti nilai ini sesuai dengan tinggi yang Anda inginkan
        }).catch((error) => {
            console.error(error);
        });
    </script>
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
                        url: '/admin/jenis-rencana-pembangunan/destroy/' +
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
