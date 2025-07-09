@extends('layouts.pengurusan.email')
@section('title', 'Modul Pelan Induk Landskap (ePIL)')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Perubahan telah dibuat. Berikut adalah maklumat Pelan Induk Landskap (PIL) yang memerlukan tindakan pengesahan perubahan:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">Modul Pelan Induk Landskap (ePIL)</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nama PIL</th>
        <td style="{!! $style !!}">{{ $epil->nama_pelan ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Pemilik PIL</th>
        <td style="{!! $style !!}">{{ $epil->nama_pbt ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            Proses Pengesahan Perubahan
        </td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Pautan Cepat</th>
        <td style="{!! $style !!}">
            <a href="{{ url('/pengurusan/ePIL/' . $epil->id_pelan) }}">Klik di sini</a>
        </td>
    </tr>
</table>
@endsection
