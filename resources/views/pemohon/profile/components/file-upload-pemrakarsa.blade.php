<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Foto KTP <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_ktp" class="form-control @error('file_ktp') is-invalid @enderror"
        id="">
    @error('file_ktp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        SK Kepala Dinas <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_sk_kepala_dinas"
        class="form-control @error('file_sk_kepala_dinas') is-invalid @enderror" id="">
    @error('file_sk_kepala_dinas')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
