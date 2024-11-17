@section('page-css-style')
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

<style>
    input.error,
    textarea.error {
        border: 1px solid #e83e8c !important;
    }

    label.error {
        color: #e83e8c;
        font-weight: 400 !important;
    }
</style>
@endsection

@section('page-js-script')


<!-- jquery-validation -->
<script src="{{ asset('web/plugins/jquery-validation/jquery-validation.min.js') }}"></script>
<script src="{{ asset('web/plugins/jquery-validation/jquery-validation-methods.min.js') }}"></script>
<script src="{{ asset('web/plugins/jquery-validation/jquery-validation-additional.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(document).ready(function () {
    bsCustomFileInput.init();

    var autoupdate = false;

    $('input[name="feedback_at"], input[name="response_at"]').daterangepicker({           
           singleDatePicker: true,
            timePicker: true,
            showDropdowns: true,
            minDate: moment().subtract(1, 'month').subtract(1, 'year').format('DD-MM-YYYY'),
            maxDate: moment().add(1, 'week').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
            drops: "down",
            locale: {
                format: 'DD-MM-YYYY h:mm A'
            }
        });


        $('#formFeedbacks').validate({ //sets up the validator

            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'feedback_at': 'required',
                'name': 'required',
                'email': {
                    required:true,
                    email:true,
                },
                //'phone': 'required',
                'message': 'required',
            }
        });

    });

</script>
@endsection

<div class="form-row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            {{ Form::label('name', 'Nama Pengguna') }}
            {{ Form::text('name',null,['placeholder'=>'Sila masukkan Nama Pemohon','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
            {!! Html::hasError($errors,'name') !!}
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            {{ Form::label('email', 'E-Mel Pengguna') }}
            {{ Form::email('email',null,['placeholder'=>'Sila masukkan E-Mel Pemohon','class' => 'form-control '.Html::isInvalid($errors,'email')]) }}
            {!! Html::hasError($errors,'email') !!}
        </div>
    </div>
    <div class="col-12 col-md-2">
        <div class="form-group">
            {{ Form::label('phone', 'No. Telefon Pengguna') }}
            {{ Form::text('phone',null,['placeholder'=>'Sila masukkanNo. Telefon','class' => 'form-control '.Html::isInvalid($errors,'phone')]) }}
            {!! Html::hasError($errors,'phone') !!}
        </div>
    </div>
</div>

<div class="form-group">
    {{ Form::label('message', 'Ringkasan Aktiviti') }}
    {{ Form::textarea('message',null,['rows'=>6,'placeholder'=>'Sila masukkan Ringkasan Aktiviti','class' => 'form-control '.Html::isInvalid($errors,'message')]) }}
    {!! Html::hasError($errors,'message') !!}
</div>
