@extends('layouts.pengurusan.pdf')

@section('title', 'Senarai Landskap Lembut')

@section('page-css-style')
<style>
    body,html {
        margin: 2px 15px;
    }

    .table-softscape .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: transparent;
        border-collapse: collapse;
    }

    .table-softscape .table-secondary {
        background-color: #E0E0E0;
    }

    .table-softscape .table-sm {
        font-size: 7pt !important;
    }

    .table-softscape .table-bordered {
        border: 1px solid #212529;
    }

    .table-softscape .table tr th.table-secondary,
    .table-softscape .table tr th.font-weigt-bold {
        /* width: 200px; */
    }

    .table-softscape .table tr th,
    .table-softscape .table tr td {
        padding: .08rem .2rem;
        border: 1px solid #212529;
    }

    .table-softscape .table tr td img {
        width: 92px;
    }

</style>
@endsection

@section('content')

@php($blank = '<span class="font-italic">Tiada Maklumat</span>')

<div class="table-softscape text-sm">
    <h1 class="text-center">MAKLUMAT ASET LANDSKAP LEMBUT</h1>
    <p class="m-0">Kementerian/ Jabatan: Jabatan Landskap Negara</p>
    <p class="mt-0">Bahagian/ Cawangan/ Pusat/ Stesen: Bahagian Taman Persekutuan</p>
    @include('pengurusan.softscape.show._tumbuhan')
    @include('pengurusan.softscape.show._gambar')
    <div style="clear: both; page-break-after: always;"></div>
    <div class="mt-3"></div>
    @include('pengurusan.softscape.show._penyelenggaraan')
</div>

@endsection
