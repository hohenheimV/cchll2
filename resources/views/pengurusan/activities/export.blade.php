@extends('layouts.pengurusan.app')

@section('title', 'Eksport Aktiviti Taman')

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
                {{ Form::open(['route' =>['pengurusan.exports.activities.all']]) }}
                <div class="card-body table-softscape form-softscape text-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('apply_at', 'Tarikh Daftar Aktiviti') }}
                                    {{ Form::text('apply_at',null,['class' => 'form-control '.Html::isInvalid($errors,'apply_at')]) }}
                                    {!! Html::hasError($errors,'apply_at') !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('start_at', 'Tarikh Mula Aktiviti') }}
                                    {{ Form::text('start_at',null,['class' => 'tarikh form-control '.Html::isInvalid($errors,'start_at')]) }}
                                    {!! Html::hasError($errors,'start_at') !!}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('end_at', 'Tarikh Akhir Aktiviti') }}
                                    {{ Form::text('end_at',null,['class' => 'tarikh form-control '.Html::isInvalid($errors,'end_at')]) }}
                                    {!! Html::hasError($errors,'end_at') !!}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('status', 'Status Permohonan Aktiviti') }}
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
        $('input[name="apply_at"], input[name="start_at"],input[name="end_at"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
            maxDate: moment().format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
            drops: "down",
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        $('input[name="apply_at"], input[name="start_at"],input[name="end_at"]').val('');
    });
</script>

@endsection
