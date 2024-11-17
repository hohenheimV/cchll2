<div class="form-row">
    <div class="col-2">
        <div class="form-group">
            {{ Form::label('tarikh', 'Tarikh') }}
            {{ Form::text('tarikh',null,['placeholder'=>'Sila masukkan Nama Kategori','class' => 'form-control '.Html::isInvalid($errors,'tarikh')]) }}
            {!! Html::hasError($errors,'tarikh') !!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-2">
        <div class="form-group">
            {{ Form::label('kelebaran', 'Kelebaran Silara') }}
            {{ Form::text('kelebaran',null,['placeholder'=>'Sila masukkan Kelebaran Silara','class' => 'form-control '.Html::isInvalid($errors,'kelebaran')]) }}
            {!! Html::hasError($errors,'kelebaran') !!}
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            {{ Form::label('bentuk', 'Bentuk Silara Pokok') }}
            {{ Form::text('bentuk',null,['placeholder'=>'Sila masukkan Bentuk Silara Pokok','class' => 'form-control '.Html::isInvalid($errors,'bentuk')]) }}
            {!! Html::hasError($errors,'bentuk') !!}
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

        $('#modalFormSilara').validate({ //sets up the validator
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'tarikh' : 'required',
                'kelebaran' : 'required',
                'bentuk' : 'required',
            },

        });
    });

</script>
@stop
