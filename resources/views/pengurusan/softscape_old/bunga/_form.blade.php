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
            {{ Form::label('warna', 'Warna Bunga') }}
            {{ Form::text('warna',null,['placeholder'=>'Sila masukkan Warna Bunga','class' => 'form-control '.Html::isInvalid($errors,'warna')]) }}
            {!! Html::hasError($errors,'warna') !!}
        </div>
    </div>
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('bentuk', 'Bentuk Bunga') }}
            {{ Form::text('bentuk',null,['placeholder'=>'Sila masukkan Bentuk Bunga','class' => 'form-control '.Html::isInvalid($errors,'bentuk')]) }}
            {!! Html::hasError($errors,'bentuk') !!}
        </div>
    </div>
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('saiz', 'Saiz Bunga') }}
            {{ Form::text('saiz',null,['placeholder'=>'Sila masukkan Saiz Bunga','class' => 'form-control '.Html::isInvalid($errors,'saiz')]) }}
            {!! Html::hasError($errors,'saiz') !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('bilangan', 'Bilangan Kelopak Bunga') }}
            {{ Form::text('bilangan',null,['placeholder'=>'Sila masukkan Bilangan Kelopak Bunga','class' => 'form-control '.Html::isInvalid($errors,'bilangan')]) }}
            {!! Html::hasError($errors,'bilangan') !!}
        </div>
    </div>
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('wangian', 'Wangian Bunga') }}
            {{ Form::text('wangian',null,['placeholder'=>'Sila masukkan Wangian Bunga','class' => 'form-control '.Html::isInvalid($errors,'wangian')]) }}
            {!! Html::hasError($errors,'wangian') !!}
        </div>
    </div>
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('tempoh', 'Tempoh Berbunga') }}
            {{ Form::text('tempoh',null,['placeholder'=>'Sila masukkan Tempoh Berbunga','class' => 'form-control '.Html::isInvalid($errors,'tempoh')]) }}
            {!! Html::hasError($errors,'tempoh') !!}
        </div>

    </div>
</div>
<div class="form-row">
    <div class="col col-12 col-sm-6">
        <div class="form-group">
            {{ Form::label('musim', 'Musim Berbunga') }}
            {{ Form::text('musim',null,['placeholder'=>'Sila masukkan Musim Berbunga','class' => 'form-control '.Html::isInvalid($errors,'musim')]) }}
            {!! Html::hasError($errors,'musim') !!}
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

        $('#modalFormBunga').validate({ //sets up the validator
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'tarikh' : 'required',
                'warna' : 'required',
                'bentuk' : 'required',
                'saiz' : 'required',
                'bilangan' : 'required',
                'wangian' : 'required',
                //'musim' : 'required',
                'tempoh' : 'required',
            },

        });
    });

</script>
@stop
