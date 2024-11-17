@extends('layouts.pengurusan.app')

@section('title', 'Eksport Statistik Pengunjung')

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
                {{ Form::open(['route' =>['pengurusan.exports.visitor.all']]) }}
                <div class="card-body table-softscape form-softscape text-sm">


                    <table id="example" class="responsive table table-bordered table-sm mb-3 w-25">
                        <thead>
                            <tr>
                                <th colspan="2">Statistik Pengunjung Mengikut Tahun</th>
                            </tr>
                            <tr>
                                <th style="width: 150px">Tahun</th>
                                <th class="text-center">Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{'2020'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_2020}}</td>
                            </tr>
                            <tr>
                                <td>{{'2021'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_2021}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table id="example" class="responsive table table-bordered table-sm mb-3 w-25">
                        <thead>
                            <tr>
                                <th colspan="2">Statistik Pengunjung Mengikut Bulan bagi Tahun {{ date('Y') }}</th>
                            </tr>
                            <tr>
                                <th style="width: 150px">Bulan</th>
                                <th class="text-center">Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{'Januari'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_1}}</td>
                            </tr>
                            <tr>
                                <td>{{'Februari'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_2}}</td>
                            </tr>
                            <tr>
                                <td>{{'Mac'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_3}}</td>
                            </tr>
                            <tr>
                                <td>{{'April'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_4}}</td>
                            </tr>
                            <tr>
                                <td>{{'Mei'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_5}}</td>
                            </tr>
                            <tr>
                                <td>{{'Jun'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_6}}</td>
                            </tr>
                            <tr>
                                <td>{{'Julai'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_7}}</td>
                            </tr>
                            <tr>
                                <td>{{'Ogos'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_8}}</td>
                            </tr>
                            <tr>
                                <td>{{'September'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_9}}</td>
                            </tr>
                            <tr>
                                <td>{{'Oktober'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_10}}</td>
                            </tr>
                            <tr>
                                <td>{{'November'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_11}}</td>
                            </tr>
                            <tr>
                                <td>{{'Disember'}}</td>
                                <td class="text-center">{{$visitor->visitor_count_month_12}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table id="example" class="responsive table table-bordered table-sm mb-3 w-25">
                        <thead>
                            <tr>
                                <th colspan="2">Statistik Pengunjung Mengikut 7 Hari Lalu</th>
                            </tr>
                            <tr>
                                <th style="width: 150px">Tarikh</th>
                                <th class="text-center">Bilangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{date('d-m-Y')}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day}}</td>
                            </tr>
                            <tr>
                                <td>{{date('d-m-Y',strtotime("-1 day"))}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day_1}}</td>
                            </tr>
                            <tr>
                                <td>{{date('d-m-Y',strtotime("-2 day"))}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day_2}}</td>
                            </tr>
                            <tr>
                                <td>{{date('d-m-Y',strtotime("-3 day"))}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day_3}}</td>
                            </tr>
                            <tr>
                                <td>{{date('d-m-Y',strtotime("-4 day"))}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day_4}}</td>
                            </tr>
                            <tr>
                                <td>{{date('d-m-Y',strtotime("-5 day"))}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day_5}}</td>
                            </tr>
                            <tr>
                                <td>{{date('d-m-Y',strtotime("-6 day"))}}</td>
                                <td class="text-center">{{$visitor->visitor_count_day_6}}</td>
                            </tr>

                        </tbody>
                    </table>
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
