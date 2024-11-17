<div class="form-row">
    <div class="form-group col-md-10">
        <div class="form-group">
            <label for="filevideo">{{ __('Video') }}</label>
            <input type="file" accept=".`mp4, .mov, .avi, .flv" class="form-control @error('filevideo') is-invalid @enderror" id="filevideo" name="filevideo" value="{{ old('filevideo', $dron->video ?? null) }}">

            @error('filevideo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-10">
        <div class="form-group">
            <label for="filegambar">{{ __('Gambar') }}</label>
            <input type="file" accept=".png, .jpg, .jpeg" class="form-control @error('filegambar') is-invalid @enderror" id="filegambar" name="filegambar" value="{{ old('filegambar', $dron->gambar ?? null) }}">

            @error('filegambar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

