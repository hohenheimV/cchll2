@extends('layouts.pengurusan.email')
@section('title', 'ADUAN DAN MAKLUMBALAS TAMAN PERSEKUTUAN BUKIT KIARA')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Terdapat satu (1) aduan dan maklumbalas berkaitan Taman Persekutuan Bukit Kiara melalui laman web dan butiran lanjut seperti berikut:</p>
@php($null = 'Tiada Maklumat')
<table width="100%">
    <tr>
        <th colspan="2">MAKLUMAT ADUAN DAN MAKLUMBALAS</th>
    </tr>
    <tr>
        <th style="width: 220px">Nombor Rujukan</th>
        <td>{!! $MIB->ref_num ?? $null !!}</td>
    </tr>
    <tr>
        <th style="width: 220px">Tarikh</th>
        <td>{!! $MIB->created_at ?? $null !!}</td>
    </tr>
    <tr>
        <th>Nama Penuh</th>
        <td>{!! $MIB->name ?? $null !!}</td>
    </tr>
    <tr>
        <th>Alamat E-mel</th>
        <td>{!! $MIB->email ?? $null !!}</td>
    </tr>
    <tr>
        <th>Mesej</th>
        <td>{!! $MIB->message ?? $null !!}</td>
    </tr>
</table>

@endsection
