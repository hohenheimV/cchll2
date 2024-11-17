<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::label('lat', 'Koordinat X') }}
            {{ Form::text('lat',null,['placeholder'=>'Koordinat X : x.xxxxxx','class' => 'form-control '.Html::isInvalid($errors,'lat')]) }}
            {!! Html::hasError($errors,'lat') !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {{ Form::label('lng', 'Koordinat Y') }}
            {{ Form::text('lng',null,['placeholder'=>'Koordinat Y  : xxx.xxxxxx','class' => 'form-control '.Html::isInvalid($errors,'lng')]) }}
            {!! Html::hasError($errors,'lng') !!}
        </div>
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


