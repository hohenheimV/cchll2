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
        <th style="{!! $style !!}">Pihak Berkuasa Tempatan</th>
        <td style="{!! $style !!}">{!! $MIB->pbt ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Taman Perumahan</th>
        <td style="{!! $style !!}">{!! $MIB->taman ?? $null !!}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Status</th>
        <td style="{!! $style !!}">{!! $MIB->status ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Pautan Cepat</th>
        <td style="{!! $style !!}">
            <a href="{{ url('/pengurusan/MIB/' . $MIB->id) }}">Klik di sini</a>
        </td>
    </tr>
</table>

<p>Mohon semakan untuk tindakan kelulusan.</p>

@endsection
