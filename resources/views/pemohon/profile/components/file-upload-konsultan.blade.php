<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Nomor Sertifikat <span style="color: red">*</span>
    </label>
    <input required type="text" name="no_sertifikat"
        value="{{ old('no_sertifikat', $user->hasOneProfile?->no_sertifikat ?? '') }}"
        class="form-control @error('no_sertifikat') is-invalid @enderror" id="">
    @error('no_sertifikat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Masa Berlaku Sertifikat Sertifikat <span style="color: red">*</span>
    </label>
    <input required type="text" name="masa_berlaku_sertifikat"
        value="{{ old('masa_berlaku_sertifikat', $user->hasOneProfile?->masa_berlaku_sertifikat ?? '') }}"
        class="form-control @error('masa_berlaku_sertifikat') is-invalid @enderror" id="">
    @error('masa_berlaku_sertifikat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Tingkatan (madya dll)<span style="color: red">*</span>
    </label>
    <input required type="text" name="tingkatan"
        value="{{ old('tingkatan', $user->hasOneProfile?->tingkatan ?? '') }}"
        class="form-control @error('tingkatan') is-invalid @enderror" id="">
    @error('tingkatan')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Sekolah Terakhir<span style="color: red">*</span>
    </label>
    <input required type="text" name="sekolah_terakhir"
        value="{{ old('sekolah_terakhir', $user->hasOneProfile?->sekolah_terakhir ?? '') }}"
        class="form-control @error('sekolah_terakhir') is-invalid @enderror" id="">
    @error('sekolah_terakhir')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
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
<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
    <label for="" class="form-label">
        Sertifikat <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_sertifikat"
        class="form-control @error('file_sertifikat') is-invalid @enderror" id="">
    @if ($user->hasOneProfile?->getRawOriginal('file_sertifikat'))
        <a target="_blank" href="{{ $user->hasOneProfile?->file_sertifikat }}">
            Lihat Sertifikat Yang Telah Diupload
        </a>
        <br>
    @endif
    @error('file_sertifikat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
    <label for="" class="form-label">
        Ijazah Terakhir <span style="color: red">*</span>
    </label>
    <input required type="file" name="file_ijazah_terakhir"
        class="form-control @error('file_ijazah_terakhir') is-invalid @enderror" id="">
    @if ($user->hasOneProfile?->getRawOriginal('file_ijazah_terakhir'))
        <a target="_blank" href="{{ $user->hasOneProfile?->file_ijazah_terakhir }}">
            Lihat Ijazah Terakhir Yang Telah Diupload
        </a>
        <br>
    @endif
    @error('file_ijazah_terakhir')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
