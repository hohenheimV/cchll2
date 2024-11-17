<div class="p-3">
    <div class="form-group row">
        {{ Form::label('tarikh', 'Tarikh Pemangkasan',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-2">
            {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan Tarikh Pemangkasan','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
            {!! Html::hasError($errors,'tarikh') !!}
        </div>
    </div>
    <div class="form-group row">
        {{ Form::label('jenis', 'Jenis Pemangkasan',['class'=>'col-sm-2 col-form-label']) }}
        <div class="col-sm-6">
            {{ Form::textarea('jenis',null,['placeholder'=>'Sila masukkan Jenis Pemangkasan','class' => 'form-control '.Html::isInvalid($errors,'jenis')]) }}
            {!! Html::hasError($errors,'jenis') !!}
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
