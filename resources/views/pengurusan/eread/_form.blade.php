<div class="form-group col-md-6">
            {{ Form::label('bahagian_jln', 'Bahagian - Jabatan Landskap Negara') }}
            {!! Form::select('bahagian_jln', [
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
            ], null, [
                'placeholder' => 'Pilih Bahagian',
                'required' => true,
                'class' => 'form-control'
            ]) !!}
            @error('bahagian_jln')
                <div class="text-danger">{{ $message }}</div>
            @enderror
</div>

<div class="form-group col-md-6">
    {{ Form::label('kate', 'Kategori') }}
    {{ Form::select('kate', $kategories, $eread->kate ?? null, [
        'placeholder' => 'Pilih Kategori',
        'class' => 'form-control',
        'id' => 'kate',
        'required' => true
    ]) }}
    {!! Html::hasError($errors, 'kate') !!}
</div>
<div class="form-group col-md-6">
    {{ Form::label('tarikh', 'Tarikh Penerbitan') }}
    {{ Form::text('tarikh', null, ['required' => true, 'autocomplete'=>'off','placeholder' => 'Sila Masukkan Tarikh Penerbitan', 'class' => 'form-control tarikh ' . Html::isInvalid($errors, 'tarikh'), 'id' => 'tarikh']) }}
    {!! Html::hasError($errors, 'tarikh') !!}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tarikhInput = document.getElementById('tarikh');
        const today = new Date().toISOString().split('T')[0];
        tarikhInput.value = today;
    });
</script>

<div class="form-group col-md-12">
    {{ Form::label('tajuk', 'Tajuk') }}
    {{ Form::text('tajuk', null, ['required' => true, 
        'placeholder' => 'Sila Masukkan Tajuk', 
        'class' => 'form-control ' . Html::isInvalid($errors, 'tajuk'),
        'oninput' => "this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"
    ]) }}
    {!! Html::hasError($errors, 'tajuk') !!}
</div>
<div class="form-group col-md-12">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan', null, ['placeholder' => 'Sila Masukkan Keterangan',
        'rows' => 5, 
        'class' => 'form-control ' . Html::isInvalid($errors, 'keterangan'),
    ]) }}
    {!! Html::hasError($errors, 'keterangan') !!}
</div>


