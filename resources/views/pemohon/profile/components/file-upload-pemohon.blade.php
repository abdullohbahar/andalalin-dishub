<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">
            Foto KTP <span style="color: red">*</span>
        </label>
        <div class="input-group mb-3">
            <input required type="file" name="file_ktp" class="form-control @error('file_ktp') is-invalid @enderror"
                id="">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
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
    </form>
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">
            Sertifikat Andalalin (Penyusun) <span style="color: red">*</span>
        </label>
        <div class="input-group mb-3">
            <input required type="file" name="file_sertifikat_andalalin"
                class="form-control @error('file_sertifikat_andalalin') is-invalid @enderror" id="">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
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
    </form>
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">
            CV (Company Profile) <span style="color: red">*</span>
        </label>
        <div class="input-group mb-3">

            <input required type="file" name="file_cv" class="form-control @error('file_cv') is-invalid @enderror"
                id="">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
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
    </form>

</div>
