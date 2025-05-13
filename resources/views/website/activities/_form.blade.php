@section('insert_style')
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

<style>
    input.error,
    textarea.error {
        border: 1px solid #e83e8c !important;
    }

    .errorSlotRadio,
    .errorSlotRadioMsg,
    .errorSlotLokasi,
    label.error {
        color: #e83e8c;
        font-weight: 400 !important;
    }

    .custom-control-input.error~.custom-control-label, .was-validated .custom-control-input:invalid~.custom-control-label {
        color: #dc3545;
    }
    .custom-control-input-teal:checked~.custom-control-label::before {
        border-color: #84cd73 !important;
        background-color: #84cd73 !important;
    }

    .cell-success {
        background-color: #c3e6cb;
    }

    .cell-primary {
        background-color: #b8daff;
    }

    .table-primary {
        background-color: #bee5eb;
    }

    .scroll-container {
      overflow-x: auto;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .img-container {
      display: inline-block;
      margin-right: 10px; /* Add some space between images */
    }

    .img-thumbnail {
      max-width: 100%; /* Make sure the image does not exceed its container */
      height: auto; /* Maintain aspect ratio */
    }

</style>
@endsection

@section('insert_js')


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

    $('#spinner').hide();
    $('input[id^="slot_"]').attr('disabled', true);

    function checkBooking(date1, date2,lokasi){
        $('#spinner').show();
        $('input[id^="slot_"]').attr('disabled', false);
        if(typeof lokasi == 'undefined'){
            $('.errorSlotLokasi').show().text('Sila lengkapkan lokasi');            
        }else{
            $('.errorSlotLokasi').hide();
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            dataType: 'json',
            type:'POST',
            url:"{{ route('website.activities.checkbooking') }}",
            data:{tarikhmula:date1, tarikhtamat:date2, lokasi:lokasi},
            success:function(data){
                $('#spinner').hide();
                slotChanges('sehari',data.sehari);
                slotChanges('pagi',data.pagi);
                slotChanges('petang',data.petang);
                if(data.all > 0){
                    $('#submitBtn').prop('disabled', true);
                    var label = $('label[for="'+lokasi+'"]').html();
                    $('.errorSlotRadioMsg').show()
                        .html('Lokasi '+label +' bagi tempoh tarikh tersebut telah ditempah');
                }else{
                    $('#submitBtn').prop('disabled', false);
                    $('input[name="tempoh_id"]').attr("checked", false);
                    $('.errorSlotRadioMsg').hide();
                }
            }
        });
    }

	function date1(){
		$('input[name="start_at"]').daterangepicker({
            timePicker: false,
            timePickerIncrement:15,
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            disabledDays: 'today',
            minDate: moment().add(1, 'day'),
            // minDate: moment(),
            maxDate: moment().add(2, 'year'),
            autoUpdateInput: autoupdate,
            locale: {
                format: 'DD-MM-YYYY'
            }
		}, function(chosen_date) {
		  $('input[name="start_at"]').val(chosen_date.format('DD-MM-YYYY'));
		});
    }

    date1();

    $('input[name="start_at"]').on('apply.daterangepicker', function(ev, picker) {
        if ($('input[name="start_at"]').val().length == 0 ){
            autoupdate = true;
            date1();
        }
        var departpicker = $('input[name="start_at"]').val();
        var passdate1 = moment(departpicker,'DD-MM-YYYY').format('YYYY-MM-DD');
        var lokasi = $('input[name="lokasi"]:checked').val();
        checkBooking(passdate1,passdate1,lokasi);
        $('input[name="end_at"]').daterangepicker({
            timePicker: false,
            timePickerIncrement:15,
            singleDatePicker: true,
            minDate: departpicker,
            showDropdowns: true,
            autoApply: true,
            // startDate: moment(departpicker, 'DD-MM-YYYY'),
            maxDate: moment(departpicker, 'DD-MM-YYYY').add(30, 'day'),
            locale: {
                format: 'DD-MM-YYYY'
            }
        }, function(chosen_date) {
          $('input[name="end_at"]').val(chosen_date.format('DD-MM-YYYY'));
        });

        var drp = $('input[name="end_at"]').data('daterangepicker');
        drp.setStartDate(departpicker);
        drp.setEndDate(departpicker);
    });

    $('input[name="end_at"]').on('apply.daterangepicker', function(ev, picker) {
        var departpicker1 = $('input[name="start_at"]').val();
        var departpicker2 = $('input[name="end_at"]').val();
        var passdate1 = moment(departpicker1,'DD-MM-YYYY').format('YYYY-MM-DD');
        var passdate2 = moment(departpicker2,'DD-MM-YYYY').format('YYYY-MM-DD');
        var lokasi = $('input[name="lokasi"]:checked').val();
        checkBooking(passdate1,passdate1,lokasi);
    });

    $('input[name="lokasi"]').on('change', function(ev, picker) {
        var departpicker1 = $('input[name="start_at"]').val();
        var departpicker2 = $('input[name="end_at"]').val();
        var passdate1 = moment(departpicker1,'DD-MM-YYYY').format('YYYY-MM-DD');
        var passdate2 = moment(departpicker2,'DD-MM-YYYY').format('YYYY-MM-DD');
        var lokasi = $('input[name="lokasi"]:checked').val();
        if(departpicker1  && departpicker2)
        checkBooking(passdate1,passdate1,lokasi);
    });

    $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param * 1000000)
        // return this.optional(element) || (element.files[0].size <= param)
      }, 'Dokumen mesti bersaiz kurang dari {0}MB');

        $('#ajaxactivities').validate({ //sets up the validator

            rules: {
                start_at: 'required',
                end_at: 'required',
                tempoh_id: 'required',
                lokasi: 'required',
                organizer:{
                    required:true,
                    minlength:5
                },
                title: {
                    required:true,
                    minlength:5
                },
                description: {
                    required:true,
                    minlength:5
                },
                // 'borang': 'required',
                borang: {
                    required: true,
                    extension: "jpg,jpeg,png,zip,pdf",
                    filesize: 5,
                },
                surat: {
                    required: true,
                    extension: "jpg,jpeg,png,zip,pdf",
                    filesize: 5,
                },
                jadual: {
                    required: true,
                    extension: "jpg,jpeg,png,zip,pdf",
                    filesize: 5,
                },
                // surat: 'required',
                // jadual: 'required',
                // name: 'required',
                name:{
                    required:true,
                    minlength:5
                },
                email: {
                    required:true,
                    email:true,
                },
                phone: {
                    required:true,
                    pattern:/^(\+?6?0?1)[0-9]{7,8}$/
                },
               bilangan_peserta: {
                   required:true,
                    pattern:/^[0-9]{1,4}$/
               },
            },
            messages :{
                borang :{extension:"Format dokumen tidak di benarkan"},
                surat :{extension:"Format dokumen tidak di benarkan"},
                jadual :{extension:"Format dokumen tidak di benarkan"},
                tempoh_id :{required:"Sila pilih slot masa program."},
                lokasi :{required:"Sila pilih lokasi yang ingin digunakan."},
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "tempoh_id"){
                    error.appendTo($(element).parents('div').find($('.errorSlotRadio')));
                }else if (element.attr("name") == "lokasi"){
                    error.appendTo($(element).parents('div').find($('.errorSlotLokasi')));
                }else{
                    element.after( error );
                }
            },
        });



        function slotChanges(type, exits){
            // console.log('type '+type,exits);
            if (exits) {
                $('#slot_'+type).attr('disabled', true); // If checked disable item
                $('#slot_'+type).next().css("text-decoration", "line-through");
            } else {
                $('#slot_'+type).attr('disabled', false); // If checked enable item
                $('#slot_'+type).next().css("text-decoration", "");
            }
        }

    });
    
    $(document).ready(function() {
      $('.open-image-modal').click(function() {
        var zon = $(this).data('zon');
        $.get('/aktiviti/imej/' + zon, function(data) {
          $('#modal-image-container').html(data);
          $('#imageModal').modal('show');
        });
      });
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
@endsection
@include('layouts.website.notification')

<div class="card my-4">
    <h5 class="card-header bg-olive">Borang Permohonan</h5>
    <div class="card-body p-2">
        {{ Form::open(['route' =>['website.activities.store'],'id'=>'ajaxactivities','files' => true]) }}

      
        @include('website.activities._zon')

        @include('website.activities._slot')

       

        
        <div class="form-group">
            <div class="col-12">
                <table id="example" class="responsive table table-bordered table-sm">
                    <tr class="cell-success">
                        <th colspan="3">BUTIRAN PERMOHONAN</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                {{ Form::label('organizer', 'Nama Penganjur') }}
                                {{ Form::text('organizer',null,['placeholder'=>'Sila masukkan Nama Penganjur','class' => 'form-control '.Html::isInvalid($errors,'organizer')]) }}
                                {!! Html::hasError($errors,'organizer') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('title', ' Nama Program/Aktiviti') }}
                                {{ Form::text('title',null,['placeholder'=>'Sila masukkan Nama Program/Aktiviti','class' => 'form-control '.Html::isInvalid($errors,'title')]) }}
                                {!! Html::hasError($errors,'title') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Ringkasan Aktiviti') }}
                                {{ Form::textarea('description',null,['rows'=>3,'placeholder'=>'Sila masukkan Ringkasan Aktiviti','class' => 'form-control '.Html::isInvalid($errors,'description')]) }}
                                {!! Html::hasError($errors,'description') !!}
                            </div>

                            <div class="form-group rows">
                                <div class="col-md-2 pl-0">
                                    {{ Form::label('bilangan_peserta', 'Bilangan Peserta') }}
                                    {{ Form::number('bilangan_peserta',null,['placeholder'=>'Sila masukkan Bilangan Peserta','class' => 'form-control '.Html::isInvalid($errors,'bilangan_peserta')]) }}
                                    {!! Html::hasError($errors,'bilangan_peserta') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('file', 'Surat Permohonan Rasmi') }}
                                <div class="custom-file">
                                    {{ Form::file('surat',['class'=>'custom-file-input','id'=>'surat']) }}
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('file', 'Jadual Program/Aktiviti') }}
                                <div class="custom-file">
                                    {{ Form::file('jadual',['class'=>'custom-file-input','id'=>'jadual']) }}
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
							<div class="form-group">
                                {{ Form::label('file', 'Senarai Maklumat Peserta') }}
                                <div class="custom-file">
                                    {{ Form::file('borang',['class'=>'custom-file-input','id'=>'borang']) }}
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Nama Pemohon') }}
                                        {{ Form::text('name',null,['placeholder'=>'Sila masukkan Nama Pemohon','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
                                        {!! Html::hasError($errors,'name') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('phone', 'No. Telefon Pemohon') }}
                                        {{ Form::text('phone',null,['placeholder'=>'Sila masukkan No. Telefon Pemohon','class' => 'form-control '.Html::isInvalid($errors,'phone')]) }}
                                        {!! Html::hasError($errors,'phone') !!}
                                    </div>
                                </div>
								<div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('email', 'E-Mel Pemohon') }}
                                        {{ Form::email('email',null,['placeholder'=>'Sila masukkan E-Mel Pemohon','class' => 'form-control '.Html::isInvalid($errors,'email')]) }}
                                        {!! Html::hasError($errors,'email') !!}
                                    </div>
                                </div>
                               <!-- <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('fax', 'No. Faks') }}
                                        {{ Form::text('fax',null,['placeholder'=>'Sila masukkan No. Faks','class' => 'form-control '.Html::isInvalid($errors,'fax')]) }}
                                        {!! Html::hasError($errors,'fax') !!}
                                    </div>
                                </div>-->
                            </div>

                            <div class="form-group">
                                {{ Form::submit('Hantar', ['id'=>'submitBtn','class'=>'btn bg-olive','type'=>'submit']) }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.modal-footer -->
        {{ Form::close() }}
    </div>
</div>
