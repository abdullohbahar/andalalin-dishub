<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Foto KTP
        @if (!$user->file_ktp)
            <span style="color: red">*</span>
        @else
            <small>Biarkan kosong jika tidak ingin mengubah tanda tangan</small>
        @endif
    </label>
    <input {{ $user->file_ktp == null ? 'required' : '' }} type="file" name="file_ktp"
        class="form-control @error('file_ktp') is-invalid @enderror" id="">
    @error('file_ktp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Tanda Tangan
        @if (!$user->hasOneTtd)
            <span style="color: red">*</span>
        @else
            <small>Biarkan kosong jika tidak ingin mengubah tanda tangan</small>
        @endif
    </label>
    <div id="sig"></div>
    <br />
    <button id="clear">Hapus Tanda Tangan</button>
    <textarea id="signature64" name="signed" class="@error('signed') is-invalid @enderror" style="display: none"></textarea>
    @error('signed')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
