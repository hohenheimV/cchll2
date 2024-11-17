<div class="form-group">
    {{ Form::label('name', 'Nama Kategori') }}
    {{ Form::text('name',null,['placeholder'=>'Sila masukkan Nama Kategori','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
    {!! Html::hasError($errors,'name') !!}
</div>
<div class="form-group">
    {{ Form::label('description', 'Keterangan') }}
    {{ Form::textarea('description',null,['rows'=>3,'placeholder'=>'Sila masukkan Keterangan','class' => 'form-control '.Html::isInvalid($errors,'description')]) }}
    {!! Html::hasError($errors,'description') !!}
</div>
