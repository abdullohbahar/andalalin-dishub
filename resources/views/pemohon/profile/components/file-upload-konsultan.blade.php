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
    </form>
</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">
            Sertifikat <span style="color: red">*</span>
        </label>
        <div class="input-group mb-3">
            <input required type="file" name="file_sertifikat"
                class="form-control @error('file_sertifikat') is-invalid @enderror" id="">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
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
    </form>

</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">
            Ijazah Terakhir <span style="color: red">*</span>
        </label>
        <div class="input-group mb-3">
            <input required type="file" name="file_ijazah_terakhir"
                class="form-control @error('file_ijazah_terakhir') is-invalid @enderror" id="">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>

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
    </form>
</div>
