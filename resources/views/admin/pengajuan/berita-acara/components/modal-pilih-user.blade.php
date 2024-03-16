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
                            <th>Role</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->hasOneProfile?->nama }}</td>
                                <td>{{ $user->hasOneProfile?->no_telepon }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">{{ $user->role }}</td>
                                <td>
                                    <button class="btn btn-info" id="pilih" data-id="{{ $user->id }}"
                                        data-nama="{{ $user->hasOneProfile?->nama }}"
                                        data-notelepon="{{ $user->hasOneProfile?->no_telepon }}"
                                        data-email="{{ $user->email }}">Pilih</button>
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
