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
            {{ Form::label('ketinggian', 'Ketinggian Batang Pokok') }}
            {{ Form::text('ketinggian',null,['placeholder'=>'Sila masukkan Ketinggian Batang Pokok','class' => 'form-control '.Html::isInvalid($errors,'ketinggian')]) }}
            {!! Html::hasError($errors,'ketinggian') !!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col col-12 col-sm-2">
        <div class="form-group">
            {{ Form::label('diameter', 'Diameter Batang Pokok') }}
            {{ Form::text('diameter',null,['placeholder'=>'Sila masukkan Diameter Batang Pokok','class' => 'form-control '.Html::isInvalid($errors,'diameter')]) }}
            {!! Html::hasError($errors,'diameter') !!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col col-12 col-sm-4">
        <div class="form-group">
            {{ Form::label('bentuk', 'Bentuk Batang Pokok') }}
            {{ Form::text('bentuk',null,['placeholder'=>'Sila masukkan Bentuk Batang Pokok','class' => 'form-control '.Html::isInvalid($errors,'bentuk')]) }}
            {!! Html::hasError($errors,'bentuk') !!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col col-12 col-sm-4">
        <div class="form-group">
            {{ Form::label('tekstur', 'Tekstur Batang Pokok') }}
            {{ Form::text('tekstur',null,['placeholder'=>'Sila masukkan Tekstur Batang Pokok','class' => 'form-control '.Html::isInvalid($errors,'tekstur')]) }}
            {!! Html::hasError($errors,'tekstur') !!}
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

