@extends('layouts.pengurusan.app')

@section('title', 'Sejarah Landskap Lembut')

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
                    {!! Form::open(['route' => 'pengurusan.softscape.history.proses']) !!}
                    <div class="card-body table-softscape form-softscape text-sm row">

                        <ul class="list-group col-md-4">

                            @forelse ($histories as $history)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $history->tahun_history }}
                                </li>
                                <li class="list-group-item d-flex list-group-item-info">
                                    Butang jana sejarah akan dipaparkan pada tahun berikutnya.
                                </li>
                            @empty
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ date('Y', strtotime('-1 year')) }}

                                    {!! Form::button('<i class="fas fa-save"></i> Jana Sejarah', ['class' => 'btn btn-success', 'type' => 'submit']) !!}

                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer">
                        {!! Form::button('Batal dan Kembali', [
                            'onclick' => "window.location='" . route('pengurusan.sections') . "'",
                            'class' => 'btn btn-secondary',
                        ]) !!}

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js-script')
    <script>
        $(document).ready(function() {


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
