<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Foto KTP <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_ktp" class="form-control @error('file_ktp') is-invalid @enderror"
        id="">
    @if ($user->hasOneProfile?->getRawOriginal('file_ktp'))
        <a target="_blank" href="{{ $user->hasOneProfile?->file_ktp }}">
            Lihat KTP Yang Telah Diupload
        </a>
        <br>
    @endif
    @error('file_ktp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
