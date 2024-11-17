<div class="p-3">
    <div class="form-group row">
        {{ Form::label('tarikh', 'Tarikh',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-2">
            {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan Tarikh','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
            {!! Html::hasError($errors,'tarikh') !!}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('warna', 'Warna Buah',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('warna',null,['placeholder'=>'Sila masukkan Warna Buah','class' => 'form-control '.Html::isInvalid($errors,'warna')]) }}
            {!! Html::hasError($errors,'warna') !!}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('bentuk', 'Bentuk Buah',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('bentuk',null,['placeholder'=>'Sila masukkan Bentuk Buah','class' => 'form-control '.Html::isInvalid($errors,'bentuk')]) }}
            {!! Html::hasError($errors,'bentuk') !!}
        </div>
    </div>


    <div class="form-group row">
        {{ Form::label('saiz', 'Saiz Buah',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('saiz',null,['placeholder'=>'Sila masukkan Saiz Buah','class' => 'form-control '.Html::isInvalid($errors,'saiz')]) }}
            {!! Html::hasError($errors,'saiz') !!}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('musim', 'Musim Buah',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('musim',null,['placeholder'=>'Sila masukkan Musim Buah','class' => 'form-control '.Html::isInvalid($errors,'musim')]) }}
            {!! Html::hasError($errors,'musim') !!}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('tempoh', 'Tempoh Berbuah',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('tempoh',null,['placeholder'=>'Sila masukkan Tempoh Berbuah','class' => 'form-control '.Html::isInvalid($errors,'tempoh')]) }}
            {!! Html::hasError($errors,'tempoh') !!}
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
