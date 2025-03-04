<div class="form-row">
    <div class="form-group col-md-10">
        <!-- <div class="form-group">
            <label for="fail_imej">{{ __('Imej Hadapan') }}</label>
            <input type="file" class="form-control @error('fail_imej') is-invalid @enderror" id="fail_imej" name="fail_imej" value="{{ old('fail_imej', $pegawai->fail_imej ?? null) }}" accept="image/*">

            @error('fail_imej')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div> 
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>   --> 
    </div>
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
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>    
    </div>
</div>


