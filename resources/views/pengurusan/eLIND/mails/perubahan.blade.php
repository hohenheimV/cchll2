@extends('layouts.pengurusan.email')
@section('title', 'Modul Pengurusan Maklumat Industri Landskap (eLIND)')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Perubahan telah dibuat. Berikut adalah maklumat Penggiat Industri Landskap yang memerlukan tindakan pengesahan perubahan:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">Modul Pengurusan Maklumat Industri Landskap (eLIND)</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nama Penggiat Industri</th>
        <td style="{!! $style !!}">{{ $elind->nama_pelan ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Jenis Penggiat Industri</th>
        <td style="{!! $style !!}">{{ $jenis ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            Proses Pengesahan Perubahan
        </td>
    </tr>
</table>
@endsection
