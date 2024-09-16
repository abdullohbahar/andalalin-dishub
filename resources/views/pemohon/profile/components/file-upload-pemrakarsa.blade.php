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
            SK Kepala Dinas <span style="color: red">*</span>
        </label>
        <div class="input-group mb-3">

            <input required type="file" name="file_sk_kepala_dinas"
                class="form-control @error('file_sk_kepala_dinas') is-invalid @enderror" id="">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
        @if ($user->hasOneProfile?->getRawOriginal('file_sk_kepala_dinas'))
            <a target="_blank" href="{{ $user->hasOneProfile?->file_sk_kepala_dinas }}">
                Lihat Sk Kepala Dinas Yang Telah Diupload
            </a>
            <br>
        @endif
        @error('file_sk_kepala_dinas')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </form>
</div>
