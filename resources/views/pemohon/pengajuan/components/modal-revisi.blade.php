<div class="modal fade" tabindex="-1" id="modalRevisi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Revisi <span id="namaDokumen1"></span></h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form action="{{ route('pemohon.upload.dokumen.revisi') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="" class="form-label">Pilih File <span id="namaDokumen"></span></label>
                    <input type="hidden" name="dokumen_id" id="revisiDokumenID">
                    <input type="hidden" name="nama_proyek" id="namaProyek">
                    <input type="hidden" name="nama_dokumen" id="fieldNamaDokumen">
                    <input type="file" name="file" class="form-control" id="" accept=".pdf"
                        onchange="validateFile(this)" required>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
