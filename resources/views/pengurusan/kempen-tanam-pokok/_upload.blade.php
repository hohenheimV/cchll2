<div class="form-row">
    <div class="form-group col-md-10">
        <div class="form-group">
            <label for="gambar">{{ __('Gambar') }}</label>
            <input type="file" accept=".png, .jpg, .jpeg" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" value="{{ old('gambar', $pegawai->gambar ?? null) }}">

            @error('gambar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
