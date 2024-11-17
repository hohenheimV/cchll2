<div class="form-row">
    <div class="form-group col-md-10">
        <div class="form-group">
            <label for="fail_dokumen">{{ __('Dokumen') }}</label>
            <input type="file" class="form-control @error('fail_dokumen') is-invalid @enderror" id="fail_dokumen" name="fail_dokumen" value="{{ old('fail_dokumen', $pegawai->fail_dokumen ?? null) }}">

            @error('fail_dokumen')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
