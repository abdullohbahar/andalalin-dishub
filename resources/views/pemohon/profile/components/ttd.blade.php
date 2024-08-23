<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Foto KTP
        @if (!$user->hasOneProfile->file_ktp)
            <span style="color: red">*</span>
        @else
            <small>Biarkan kosong jika tidak ingin mengubah KTP</small>
        @endif
    </label>
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="input-group mb-3">

            <input {{ $user->hasOneProfile->file_ktp == null ? 'required' : '' }} type="file" name="file_ktp"
                class="form-control @error('file_ktp') is-invalid @enderror" id="">

            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
        @error('file_ktp')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </form>

</div>
<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3">
    <label for="" class="form-label">
        Tanda Tangan
    </label><br>
    {{-- <div id="sig"></div>
    <br />
    <button id="clear">Hapus Tanda Tangan</button>
    <textarea id="signature64" name="signed" class="@error('signed') is-invalid @enderror" style="display: none"></textarea>
    @error('signed')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror --}}
    <form action="{{ route('update.profile', auth()->user()->id) }}" method="POST" enctype="multipart/form-data"
        id="uploadForm">
        @csrf
        @method('PUT')
        <div class="input-group mb-3">
            <input type="file" name="signed" class="form-control @error('signed') is-invalid @enderror"
                id="ttd">
            <button class="input-group-text btn btn-success" type="submit">Upload</button>
        </div>
        <i style="color: red">Ukuran Max 2MB dengan format file jpeg,png,jpg</i>
        @error('signed')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </form>
</div>
