@extends('layouts.pengurusan.app')

@section('title', 'Landskap Lembut')

@section('page-css-style')
<style>
    .table-softscape .table tr th.table-secondary,
    .table-softscape .table tr th.font-weigt-bold {
        width: 200px;
    }

    .table-softscape .table tr th,
    .table-softscape .table tr td {
        padding: .1rem .3rem;
    }

    .table-softscape .form-control-table {
        width: 20% !important;
    }

    .form-softscape .form-control-sm {
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
                {!! Form::model($softscape, ['route' => ['pengurusan.softscape.update', $softscape], 'method'=>'PUT','id'=>'modalFormSoftscape']) !!}
                <div class="card-body table-softscape form-softscape text-sm">
                    @include('pengurusan.softscape.form._tumbuhan')

                    {{-- @include('pengurusan.softscape.form._gambar') --}}

                    @include('pengurusan.softscape.form._penyelenggaraan')
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.softscape.show',$softscape)."'",'class'=>'btn btn-secondary']) !!}
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
