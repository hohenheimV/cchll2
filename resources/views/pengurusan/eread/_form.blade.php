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
    {{ Form::label('tarikh', 'Tarikh') }}
    {{ Form::text('tarikh', null, ['required' => true, 'autocomplete'=>'off','placeholder' => 'Sila Masukkan Tarikh', 'class' => 'form-control tarikh ' . Html::isInvalid($errors, 'tarikh'), 'id' => 'tarikh']) }}
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
    {{ Form::text('tajuk', null, ['required' => true, 'placeholder' => 'Sila Masukkan Tajuk', 'class' => 'form-control ' . Html::isInvalid($errors, 'tajuk')]) }}
    {!! Html::hasError($errors, 'tajuk') !!}
</div>
<div class="form-group col-md-12">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan', null, ['placeholder' => 'Sila Masukkan Keterangan', 'rows' => 5, 'class' => 'form-control ' . Html::isInvalid($errors, 'keterangan')]) }}
    {!! Html::hasError($errors, 'keterangan') !!}
</div>


