@extends('layouts.pengurusan.app')

@section('title', 'Landskap Kejur')

@section('page-css-style')
<style>
    .table-hardscape .table tr th.table-secondary,
    .table-hardscape .table tr th.font-weigt-bold {
        width: 200px;
    }

    .table-hardscape .table tr th,
    .table-hardscape .table tr td {
        padding: .1rem .3rem;
    }

    .table-hardscape .form-control-table{
        width: 20% !important;
    }

    .form-hardscape .form-control-sm {
        height: calc(1.6125rem) !important;
    }
</style>
@endsection

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
                {!! Form::model($hardscape, ['route' => ['pengurusan.hardscape.update', $hardscape], 'method'=>'PUT','id'=>'modalFormSoftscape']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.hardscape.form._maklumat')

                    @include('pengurusan.hardscape.form._gambar')

                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.hardscape.show',$hardscape)."'",'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
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
