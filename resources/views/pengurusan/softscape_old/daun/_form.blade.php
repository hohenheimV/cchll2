<div class="form-row">
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('tarikh', 'Tarikh') }}
            {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan Tarikh','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
            {!! Html::hasError($errors,'tarikh') !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('warna', 'Warna Daun') }}
            {{ Form::text('warna',null,['placeholder'=>'Sila masukkan Warna Daun','class' => 'form-control '.Html::isInvalid($errors,'warna')]) }}
            {!! Html::hasError($errors,'warna') !!}
        </div>
    </div>
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('bentuk',  'Bentuk Daun') }}
            {{ Form::text('bentuk',null,['placeholder'=>'Sila masukkan Bentuk Daun','class' => 'form-control '.Html::isInvalid($errors,'bentuk')]) }}
            {!! Html::hasError($errors,'bentuk') !!}
        </div>
    </div>
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('jenis', 'Jenis Daun') }}
            {{ Form::text('jenis',null,['placeholder'=>'Sila masukkan Jenis Daun','class' => 'form-control '.Html::isInvalid($errors,'jenis')]) }}
            {!! Html::hasError($errors,'jenis') !!}
        </div>
    </div>
</div>
<div class="form-row">

    <div class="col col-12 col-sm-6">
        <div class="form-group">
            {{ Form::label('percambahan', 'Cara Percambahan Daun') }}
            {{ Form::text('percambahan',null,['placeholder'=>'Sila masukkan Cara Percambahan Daun','class' => 'form-control '.Html::isInvalid($errors,'percambahan')]) }}
            {!! Html::hasError($errors,'percambahan') !!}
        </div>
    </div>
</div>


@section('page-js-script')
<script>
    $(document).ready(function () {
        //jquery validation

        //Date picker
        $('input[name="tarikh"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
            maxDate: moment().endOf('month').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
            drops: "up",
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    });

</script>
@stop
