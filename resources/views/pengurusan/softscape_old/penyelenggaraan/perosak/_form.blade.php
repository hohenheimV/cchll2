<div class="p-3">
    <div class="form-group row">
        {{ Form::label('tarikh', 'Tarikh Rawatan Kawalan Perosak',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-2">
            {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan Tarikh Rawatan Kawalan Perosak','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
            {!! Html::hasError($errors,'tarikh') !!}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('kaedah', 'Kaedah Rawatan Kawalan Perosak',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-6">
            {{ Form::textarea('kaedah',null,['placeholder'=>'Sila masukkan Kaedah Rawatan Kawalan Perosak','class' => 'form-control '.Html::isInvalid($errors,'kaedah')]) }}
            {!! Html::hasError($errors,'kaedah') !!}
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
