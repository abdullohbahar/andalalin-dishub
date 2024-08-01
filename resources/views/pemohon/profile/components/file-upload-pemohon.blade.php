<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
    <label for="" class="form-label">
        Foto KTP <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_ktp" class="form-control @error('file_ktp') is-invalid @enderror"
        id="">
    @if ($user->hasOneProfile->getRawOriginal('file_ktp'))
        <a target="_blank" href="{{ $user->hasOneProfile->file_ktp }}">
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
<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
    <label for="" class="form-label">
        Sertifikat Andalalin (Penyusun) <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_sertifikat_andalalin"
        class="form-control @error('file_sertifikat_andalalin') is-invalid @enderror" id="">
    @if ($user->hasOneProfile->getRawOriginal('file_sertifikat_andalalin'))
        <a target="_blank" href="{{ $user->hasOneProfile->file_sertifikat_andalalin }}">
            Lihat Sertifikat Andalalin Yang Telah Diupload
        </a>
        <br>
    @endif
    @error('file_sertifikat_andalalin')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
    <label for="" class="form-label">
        CV (Company Profile) <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_cv" class="form-control @error('file_cv') is-invalid @enderror"
        id="">
    @if ($user->hasOneProfile->getRawOriginal('file_cv'))
        <a target="_blank" href="{{ $user->hasOneProfile->file_cv }}">
            Lihat CV Yang Telah Diupload
        </a>
        <br>
    @endif
    @error('file_cv')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
