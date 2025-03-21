<div class="form-group col-md-6">
    {{ Form::label('kate', 'Kategori') }}
    {{ Form::select('kate', $kategories, old('kate', $elad->kate ?? null), [
        'placeholder' => 'Pilih Kategori',
        'class' => 'form-control',
        'id' => 'kate'
    ]) }}
    {!! Html::hasError($errors, 'kate') !!}
</div>

<div class="form-group col-md-6">
    {{ Form::label('tarikh', 'Tarikh') }}
    {{ Form::text('tarikh', null, ['autocomplete'=>'off','placeholder' => 'Sila Masukkan Tarikh', 'class' => 'form-control tarikh ' . Html::isInvalid($errors, 'tarikh'), 'id' => 'tarikh']) }}
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
    {{ Form::text('tajuk', old('tajuk', $elad->tajuk ?? null), ['placeholder' => 'Sila Masukkan Tajuk', 'class' => 'form-control ' . Html::isInvalid($errors, 'tajuk')]) }}
    {!! Html::hasError($errors, 'tajuk') !!}
</div>
<div class="form-group col-md-12">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan', old('keterangan', $elad->keterangan ?? null), ['placeholder' => 'Sila Masukkan Keterangan', 'rows' => 5, 'class' => 'form-control ' . Html::isInvalid($errors, 'keterangan')]) }}
    {!! Html::hasError($errors, 'keterangan') !!}
</div>
