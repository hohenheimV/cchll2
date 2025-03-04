@extends('layouts.pengurusan.app')

@section('title', 'Eksport Maklumbalas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                </div>
                @php
                $blank = '<span class="font-italic">Tiada Maklumat</span>';
                @endphp
                {{ Form::open(['route' =>['pengurusan.exports.MIB.all']]) }}
                <div class="card-body table-softscape form-softscape text-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('feedback_at', 'Tarikh Daftar Maklumbalas') }}
                                    {{ Form::text('feedback_at',null,['class' => 'form-control '.Html::isInvalid($errors,'feedback_at')]) }}
                                    {!! Html::hasError($errors,'feedback_at') !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('response_at', 'Tarikh Tindakan Maklumbalas') }}
                                    {{ Form::text('response_at',null,['class' => 'tarikh form-control '.Html::isInvalid($errors,'response_at')]) }}
                                    {!! Html::hasError($errors,'response_at') !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('status', 'Status Maklumbalas') }}
                                    {{ Form::select('status', $status,null,['placeholder'=>'--Pilihan--','class'=>'notselect2 form-control '.Html::isInvalid($errors,'status')]) }}
                                    {!! Html::hasError($errors,'status') !!}
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
                <div class="card-footer">
                    {!! Form::button('<i class="fas fa-file-excel"></i> Jana Laporan', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

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


<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>



<script>
    $(document).ready(function () {

        $('input[name="feedback_at"], input[name="response_at"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
            maxDate: moment().format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
            drops: "down",
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        $('input[name="feedback_at"], input[name="response_at"]').val('');
    });
</script>

@endsection
