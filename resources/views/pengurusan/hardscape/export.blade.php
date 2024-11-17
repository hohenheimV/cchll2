@extends('layouts.pengurusan.app')

@section('title', 'Eksport Landskap Kejur')

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
                {{ Form::open(['route' =>['pengurusan.exports.hardscape.all']]) }}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('zon', 'Zon') }}
                                {{ Form::select('zon', $zones,null,['placeholder'=>'--Pilihan--','class'=>'notselect2 form-control'.Html::isInvalid($errors,'zon')]) }}
                                {!! Html::hasError($errors,'zon') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('jenis', 'Jenis') }}
                                {{ Form::text('jenis',null,['class' => 'form-control '.Html::isInvalid($errors,'jenis')]) }}
                                {!! Html::hasError($errors,'jenis') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('struktur', 'Nama Struktur') }}
                                {{ Form::text('struktur',null,['class' => 'form-control '.Html::isInvalid($errors,'struktur')]) }}
                                {!! Html::hasError($errors,'struktur') !!}
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

@section('page-js-script')
<script>
    $(document).ready(function () {
        $('input.tarikh').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
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

@endsection
