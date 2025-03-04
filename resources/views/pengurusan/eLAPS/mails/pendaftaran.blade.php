@extends('layouts.pengurusan.email')
@section('title', 'New elaps Registration Notification')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>We have a new elaps registration with the following details:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">elaps ApplicaTION DETAILS</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Tajuk Permohonan Projek</th>
        <td style="{!! $style !!}">{{ $elaps->projectTitle ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nama Pemohon</th>
        <td style="{!! $style !!}">{{ $name ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Emel Pemohon</th>
        <td style="{!! $style !!}">{{ $email ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            {{ $elaps->id }}
        </td>
    </tr>
</table>
@endsection
