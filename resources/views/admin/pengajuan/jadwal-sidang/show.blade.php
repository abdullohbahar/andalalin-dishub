@extends('admin.layout.app')

@section('title')
    Sidang
@endsection

@push('addons-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        label {
            width: 100%;
        }

        .card-input-element {
            display: none;
        }

        .card-input {
            margin: 10px;
            padding: 00px;
        }

        .card-input:hover {
            cursor: pointer;
        }

        .card-input {
            box-shadow: 0 0 1px 1px #2ecc71;
            height: 30px;
        }

        .card-input-element:checked+.card-input {
            background-color: #2ecc71;
            color: black;
        }

        /* Style untuk elemen kalender */
        #kt_docs_fullcalendar_selectable {
            position: relative;
            /* Membuat posisi relatif untuk child elements */
        }

        /* Style untuk event title */
        .fc-event-title {
            white-space: normal;
            /* Memastikan text wrap pada title yang panjang */
        }

        /* Style untuk elemen tanggal */
        .fc-daygrid-event {
            display: flex;
            /* Menggunakan Flexbox untuk mengatur tata letak */
            align-items: flex-start;
            /* Mengatur alignment title ke atas */
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
                        Sidang</h1>
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
                        <li class="breadcrumb-item text-muted">Sidang</li>
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
                                <h1>Sidang</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Nama Proyek</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneDataPemohon?->nama_proyek }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Sidang</td>
                                                <td class="text-capitalize">
                                                    : {{ $pengajuan->hasOneJadwalSidang->tipe }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Sidang</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->tanggal }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jam Sidang</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->jam }}
                                                </td>
                                            </tr>
                                            <tr {{ $pengajuan->hasOneJadwalSidang->tipe == 'offline' ? '' : 'hidden' }}>
                                                <td>Alamat Sidang</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->alamat }}
                                                </td>
                                            </tr>
                                            <tr {{ $pengajuan->hasOneJadwalSidang->tipe == 'online' ? '' : 'hidden' }}>
                                                <td>URL Online Meeting</td>
                                                <td>
                                                    : {{ $pengajuan->hasOneJadwalSidang->url }}
                                                </td>
                                            </tr>
                                            @php
                                                $tanggalSidang = $pengajuan->hasOneJadwalSidang->getRawOriginal(
                                                    'tanggal',
                                                );
                                                $tanggalSekarang = date('Y-m-d');
                                            @endphp

                                            @if ($tanggalSidang > $tanggalSekarang)
                                                <tr>
                                                    <td colspan="2">
                                                        <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            class="btn btn-warning btn-sm">Ubah Jadwal Sidang</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                    <div class="col-12 mt-5">
                                        @if (!$pengajuan->hasOneJadwalSidang->is_meeting)
                                            <form id="formSidang"
                                                action="{{ route('admin.telah.melakukan.sidang', $pengajuan->id) }}"
                                                method="POST">
                                                @csrf
                                                <p>Klik tombol ini jika anda telah melakukan Sidang</p>
                                                <button class="btn btn-info btn-sm">Sudah melakukan sidang</button>
                                            </form>
                                        @else
                                            <div style="float: right">
                                                <a href="{{ route('admin.berita.acara', $pengajuan->id) }}"
                                                    class="btn btn-sm btn-success">Selanjutnya</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Jadwal Sidang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.store.jadwal.sidang', $pengajuan->id) }}" id="jadwalSidang" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 mt-4">
                                <label for="" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ $pengajuan->hasOneJadwalSidang->tanggal }}" name="tanggal" id=""
                                    required>
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 mt-4">
                                <label for="" class="form-label">Jam</label>
                                <div class="input-group mb-5" style="width: 100%">
                                    @php
                                        $parts = explode(':', $pengajuan->hasOneJadwalSidang->jam);
                                    @endphp
                                    <select name="jam" class="form-control" id="">
                                        <option value="00">00</option>
                                        @for ($i = 1; $i < 24; $i++)
                                            @php
                                                $formattedValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                            @endphp
                                            <option {{ $parts[0] == $formattedValue ? 'selected' : '' }}
                                                value="{{ $formattedValue }}">{{ $formattedValue }}</option>
                                        @endfor
                                    </select>
                                    <select name="menit" class="form-control" id="">
                                        <option value="00">00</option>
                                        @for ($i = 1; $i < 60; $i++)
                                            @php
                                                $formattedValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                            @endphp
                                            <option {{ $parts[1] == $formattedValue ? 'selected' : '' }}
                                                value="{{ $formattedValue }}">{{ $formattedValue }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                <label for="" class="form-label">Tipe Sidang</label>
                                <select name="tipe" class="form-control @error('tipe') is-invalid @enderror"
                                    id="tipe" required>
                                    <option value="">-- Pilih Tipe Sidang --</option>
                                    <option
                                        {{ old('tipe', $pengajuan->hasOneJadwalSidang->tipe) == 'offline' ? 'selected' : '' }}
                                        value="offline">
                                        Offline</option>
                                    <option
                                        {{ old('tipe', $pengajuan->hasOneJadwalSidang->tipe) == 'online' ? 'selected' : '' }}
                                        value="online">
                                        Online</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4" id="alamatComponent" hidden>
                                <label for="" class="form-label">Alamat Pelaksanaan Sidang</label>
                                <textarea name="alamat" id="alamat" class="form-control" id="" style="width: 100%" rows="2">{{ old('alamat', $pengajuan->hasOneJadwalSidang->alamat) }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4" id="urlComponent" hidden>
                                <label for="" class="form-label">URL Sidang Online</label>
                                <textarea name="url" id="url" class="form-control" id="" style="width: 100%" rows="2">{{ old('url', $pengajuan->hasOneJadwalSidang->url) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('addons-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap formulir saat di-submit
            var form = document.getElementById(
                'formSidang'); // Ganti 'formSidang' dengan ID formulir Anda

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

    <script>
        $("#tipe").on("change", function() {
            var val = $(this).val()

            console.log(val)

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
        }).trigger("change")
    </script>
@endpush
