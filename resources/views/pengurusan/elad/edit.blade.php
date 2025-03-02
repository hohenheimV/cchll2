@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Rekabentuk Landskap')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-olive card-outline ">
                    <div class="card-header p-0 m-0">
                        <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                    </div>

                    {!! Form::model($elad, [
                        'route' => ['pengurusan.elad.update', $elad],
                        'method' => 'PUT',
                        'enctype' => 'multipart/form-data',
                        'id' => 'eladForm',
                    ]) !!}
                    <div class="card-body table-hardscape form-hardscape text-sm">
                        <div class="row">
                            <!-- Left Column: Main Form -->
                            <div class="col-md-6">
                                @include('pengurusan.elad._form', ['elad' => $elad, 'kategories' => $kategories])
                            </div>

                            <!-- Right Column: Upload Form -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5 d-flex justify-content-center align-items-center">
                                        <div class="card text-center">
                                            <div class="row justify-content-center">
                                                <iframe src="{{ asset($elad->dokumen ? 'storage/images/shares/elad/dokumen/' . $elad->dokumen : 'img/no-photos.png') }}" width="80%" height="300">
                                                        This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset($elad->dokumen ? 'storage/images/shares/elad/dokumen/' . $elad->dokumen : 'img/no-photos.png') }}">Download PDF</a>
                                                </iframe>
                                            </div>
                                            <p class="m-0 ml-2 text-info">Dokumen</p>
                                        </div>
                                    </div>  
                                </div>
                                <div class="form-group">
                                    {{ Form::label('fail_dokumen', 'Muat Naik Dokumen') }}
                                    {{ Form::file('fail_dokumen', ['class' => 'form-control ' . Html::isInvalid($errors, 'fail_dokumen')]) }}
                                    {!! Html::hasError($errors, 'fail_dokumen') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! Form::button('Batal dan Kembali', [
                            'onclick' => "window.location='" . route('pengurusan.elad.index') . "'",
                            'class' => 'btn btn-secondary',
                        ]) !!}
                        {!! Form::button('<i class="fas fa-save"></i> Simpan', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
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

            $('#eladForm').ajaxForm({
                beforeSend: function() {
                    var percentage = '0';
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                complete: function(xhr) {
                    // Simulate an HTTP redirect:
                    console.log('File has uploaded');
                    window.location.replace("{{ route('pengurusan.elad.index') }}");
                }
            });


            $('input.tarikh').daterangepicker({
                singleDatePicker: true,
                timePicker: false,
                showDropdowns: true,
                minDate: moment().subtract(1, 'month').subtract(10, 'year').format('DD-MM-YYYY'),
                maxDate: moment().format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
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
