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
            {{ Form::label('saiz_kanopi', 'Saiz Kanopi') }}
            {{ Form::text('saiz_kanopi',null,['placeholder'=>'Sila masukkan Saiz Kanopi','class' => 'form-control '.Html::isInvalid($errors,'saiz_kanopi')]) }}
            {!! Html::hasError($errors,'saiz_kanopi') !!}
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            {{ Form::label('nilai_semasa', 'Nilai Semasa') }}
            {{ Form::text('nilai_semasa',null,['placeholder'=>'Sila masukkan Nilai Semasa','class' => 'form-control '.Html::isInvalid($errors,'nilai_semasa')]) }}
            {!! Html::hasError($errors,'nilai_semasa') !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('keadaan_semasa', 'Keadaan Semasa') }}
            {{ Form::text('keadaan_semasa',null,['placeholder'=>'Sila masukkan Keadaan Semasa','class' => 'form-control '.Html::isInvalid($errors,'keadaan_semasa')]) }}
            {!! Html::hasError($errors,'keadaan_semasa') !!}
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('catatan', 'Catatan') }}
            {{ Form::textarea('catatan',null,['placeholder'=>'Sila masukkan Catatan','class' => 'form-control '.Html::isInvalid($errors,'catatan')]) }}
            {!! Html::hasError($errors,'catatan') !!}
        </div>
    </div>
</div>

@section('page-js-script')

<script>
    $(document).ready(function () {

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

        $('#modalFormRekod').validate({ //sets up the validator
            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'tarikh' : 'required',
                'saiz_kanopi' : 'required',
                'nilai_semasa' : 'required',
                'keadaan_semasa' : 'required',
            }
        });

    });

</script>
@endsection
