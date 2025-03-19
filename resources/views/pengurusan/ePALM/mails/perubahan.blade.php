@extends('layouts.pengurusan.email')
@section('title', 'Modul Pengurusan Taman & Landskap (ePALM)')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Perubahan telah dibuat. Berikut adalah maklumat taman yang memerlukan tindakan pengesahan perubahan:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">Modul Pengurusan Taman & Landskap (ePALM)</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nama Taman</th>
        <td style="{!! $style !!}">{{ $epalm->nama_taman ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Pemilik Taman</th>
        <td style="{!! $style !!}">{{ $epalm->nama_pbt ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Kategori Taman</th>
        <td style="{!! $style !!}">{{ $epalm->kategori_taman ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            Proses Pengesahan Perubahan
        </td>
    </tr>
</table>
@endsection
