<div class="form-group">
    {{ Form::label('label', 'Nama Tag') }}
    {{ Form::text('label',null,['placeholder'=>'Sila masukkan Nama Tag','class' => 'form-control '.Html::isInvalid($errors,'label')]) }}
    {!! Html::hasError($errors,'label') !!}
</div>
<div class="form-group">
    {{ Form::label('title', 'Tajuk Tag') }}
    {{ Form::text('title',null,['placeholder'=>'Sila masukkan Tajuk Tag','class' => 'form-control '.Html::isInvalid($errors,'title')]) }}
    {!! Html::hasError($errors,'title') !!}
</div>
<div class="form-group">
    {{ Form::label('meta_description', 'Keterangan') }}
    {{ Form::textarea('meta_description',null,['rows'=>3,'placeholder'=>'Sila masukkan Keterangan','class' => 'form-control '.Html::isInvalid($errors,'meta_description')]) }}
    {!! Html::hasError($errors,'meta_description') !!}
</div>
