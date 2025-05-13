<div class="form-group col-md-8">
    {{ Form::label('sumber_type', 'Jenis Sumber') }}
    <div>
        <label>
            {{ Form::radio('sumber_type', 'jln', $epact->sumber != '11', ['id' => 'sumber_jln']) }} Sumber JLN
        </label>
        <label class="ml-4">
            {{ Form::radio('sumber_type', 'selain_jln', $epact->sumber == '11', ['id' => 'sumber_selain_jln']) }} Sumber Selain JLN
        </label>
    </div>
</div>

<div class="form-group col-md-8" id="sumber_jln_group" style="{{ $epact->sumber == '11' ? 'display: none;' : '' }}">
    {{ Form::label('sumber', 'Sumber Terbitan') }}
    {!! Form::select('sumber', [
        '1' => 'Bahagian Pengurusan Landskap',
        '2' => 'Bahagian Taman Awam',
        '3' => 'Bahagian Pembangunan Landskap',
        '4' => 'Bahagian Khidmat Teknikal',
        '5' => 'Bahagian Penyelidikan & Pemulihan',
        '6' => 'Bahagian Penilaian & Penyelenggaraan',
        '7' => 'Bahagian Teknologi Maklumat',
        '8' => 'Bahagian Promosi & Industri Landskap',
        '9' => 'Bahagian Dasar & Pengurusan Korporat',
        '10' => 'Bahagian Kontrak & Ukur Bahan',
    ], $epact->sumber != '11' ? $epact->sumber : null, ['class' => 'form-control', 'id' => 'sumber','placeholder' => 'Pilih Sumber Terbitan']) !!}
    @error('sumber')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group col-md-8" id="subkat_group" style="{{ $epact->sumber != '11' ? 'display: none;' : '' }}">
    {{ Form::label('subkat', 'Sumber Selain JLN') }}
    {{ Form::text('subkat', $epact->sumber == '11' ? $epact->subkat : null, [
        'placeholder' => 'Nyatakan', 
        'class' => 'form-control', 
        'id' => 'subkat',
        'oninput' => "this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"
        ]) }}
    @error('subkat')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group col-md-8">
    {{ Form::label('kate', 'Kategori') }}
    {{ Form::select('kate', $kategories, $epact->kate ?? null, [
        'placeholder' => 'Pilih Kategori',
        'class' => 'form-control',
        'id' => 'kate',
        'required' => true
    ]) }}
    {!! Html::hasError($errors, 'kate') !!}
</div>

<div class="form-group col-md-8">
    {{ Form::label('tahun', 'Tahun Terbitan') }}
    {{ Form::number('tahun', $epact->tahun ?? \Carbon\Carbon::now()->year, ['required' => true, 'autocomplete'=>'off', 'placeholder' => '2025', 'class' => 'form-control ' . Html::isInvalid($errors, 'tahun'), 'id' => 'tahun', 'min' => 1950, 'max' => \Carbon\Carbon::now()->year]) }}
    {!! Html::hasError($errors, 'tahun') !!}
</div>

<div class="form-group col-md-12">
    {{ Form::label('tajuk', 'Tajuk') }}
    {{ Form::text('tajuk', $epact->tajuk, [
        'required' => true, 
        'placeholder' => 'Sila Masukkan Tajuk', 
        'class' => 'form-control ' . Html::isInvalid($errors, 'tajuk'),
        'oninput' => "this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"
    ]) }}
    {!! Html::hasError($errors, 'tajuk') !!}
</div>

<div class="form-group col-md-12">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan', $epact->keterangan, [
        'placeholder' => 'Sila Masukkan Keterangan', 
        'rows' => 3, 
        'class' => 'form-control ' . Html::isInvalid($errors, 'keterangan'),
        'oninput' => "this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();"
    ]) }}
    {!! Html::hasError($errors, 'keterangan') !!}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tahunInput = document.getElementById('tahun');
        const currentYear = new Date().getFullYear();
        const minYear = 1950; // Set the minimum year
        const maxYear = currentYear; // Set the maximum year to the current year
        
        const sumberJlnRadio = document.getElementById('sumber_jln');
        const sumberSelainJlnRadio = document.getElementById('sumber_selain_jln');
        const sumberJlnGroup = document.getElementById('sumber_jln_group');
        const subkatGroup = document.getElementById('subkat_group');
        const subkatInput = document.getElementById('subkat');
        function toggleSumberFields() {
            if (sumberJlnRadio.checked) {
                sumberJlnGroup.style.display = 'block';
                subkatGroup.style.display = 'none';
                subkatInput.value = ''; // Clear subkat input
            } else if (sumberSelainJlnRadio.checked) {
                sumberJlnGroup.style.display = 'none';
                subkatGroup.style.display = 'block';
            }
        }

        // Initialize on page load
        toggleSumberFields();

        // Add event listeners
        sumberJlnRadio.addEventListener('change', toggleSumberFields);
        sumberSelainJlnRadio.addEventListener('change', toggleSumberFields);
    });
</script>