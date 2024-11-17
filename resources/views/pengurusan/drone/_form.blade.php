<div class="form-group">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
            style="width: 0%"></div>
    </div>
</div>
<div class="form-group">
    {{ Form::label('tajuk', 'Tajuk') }}
    {{ Form::text('tajuk',null,['placeholder'=>'Sila masukkan Tajuk','class' => 'form-control '.Html::isInvalid($errors,'tajuk')]) }}
    {!! Html::hasError($errors,'tajuk') !!}
</div>
<div class="form-group">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan',null,['placeholder'=>'Sila masukkan keterangan','rows'=>3,'class' => 'form-control '.Html::isInvalid($errors,'keterangan')]) }}
    {!! Html::hasError($errors,'keterangan') !!}
</div>
<div class="form-group">
    {{ Form::label('tarikh', 'Tarikh') }}
    {{ Form::text('tarikh', null, ['placeholder' => 'Sila masukkan tarikh', 'class' => 'form-control tarikh ' . Html::isInvalid($errors, 'tarikh')]) }}
    {!! Html::hasError($errors, 'tarikh') !!}
</div>
