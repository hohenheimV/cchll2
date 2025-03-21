@extends('layouts.pengurusan.app')

@section('title', 'Daftar Maklumat Polisi Landskap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                </div>

                {{ Form::open(['route' => ['pengurusan.epact.store'], 'enctype' => 'multipart/form-data', 'id' => 'epactForm']) }} 
                    <div class="card-body table-hardscape form-hardscape text-sm">
                        <div class="row">
                            <!-- Left Column: Main Form -->
                            <div class="col-md-6">
                                @include('pengurusan.epact._form')
                            </div>

                            <!-- Right Column: Upload Form -->
                            <div class="col-md-6">
                                @include('pengurusan.epact._upload')
                            </div>
                        </div>
                    </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.epact.index')."'",'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#epactForm').ajaxForm({
            complete: function(xhr) {
                Swal.fire({
                    title: 'Success',
                    text: 'Maklumat Berjaya Disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace("{{ route('pengurusan.epact.index') }}");
                    }
                });
            }
        });

            $('input.tarikh').daterangepicker({
           singleDatePicker: true,
            timePicker: false,
            showDropdowns: true,
            startDate: moment(), // Set start date to current date
            maxDate: moment().format('DD-MM-YYYY'), // Tarikh mula 01/01/TahunDepan
            drops: "down",
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('input.tarikh').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });

        $('input.tarikh').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>

@endsection
