@extends('layouts.pengurusan.email')
@section('title', 'Permohonan Pendaftaran Rakan Taman')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Terdapat satu (1) Permohonan Pendaftaran Rakan Taman melalui laman web dan butiran lanjut seperti berikut:</p>
@php($null = 'Tiada Maklumat')
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table width="100%">
    <tr>
        <th colspan="2">Permohonan Pendaftaran Rakan Taman</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nombor Rujukan</th>
        <td style="{!! $style !!}">{!! $MIB->ref_num ?? $null !!}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Tarikh</th>
        <td style="{!! $style !!}">{!! $MIB->created_at ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Nama Wakil</th>
        <td style="{!! $style !!}">{!! $MIB->name ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Alamat E-mel</th>
        <td style="{!! $style !!}">{!! $MIB->email ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Taman Perumahan</th>
        <td style="{!! $style !!}">{!! $MIB->taman ?? $null !!}</td>
    </tr>
</table>

@endsection
