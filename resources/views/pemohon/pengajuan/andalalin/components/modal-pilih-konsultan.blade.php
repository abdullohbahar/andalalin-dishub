<div class="modal fade" tabindex="-1" id="modalPilihKonsultan">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Pilih Konsultan</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <table id="kt_datatable_dom_positioning"
                    class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($konsultans as $konsultan)
                            <tr>
                                <td>{{ $konsultan->hasOneProfile?->nama }}</td>
                                <td>{{ $konsultan->hasOneProfile?->no_telepon }}</td>
                                <td>{{ $konsultan->email }}</td>
                                <td>
                                    <button class="btn btn-info" id="pilih" data-id="{{ $konsultan->id }}"
                                        data-nama="{{ $konsultan->hasOneProfile?->nama }}"
                                        data-notelepon="{{ $konsultan->hasOneProfile?->no_telepon }}"
                                        data-email="{{ $konsultan->email }}">Pilih</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
