@extends('layouts.pengurusan.email')
@section('title', 'ADUAN DAN MAKLUMBALAS JABATAN LANDSKAP NEGARA')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Terdapat satu (1) aduan dan maklumbalas berkaitan Taman Persekutuan Bukit Kiara melalui laman web dan butiran lanjut seperti berikut:</p>
{{-- @php($null = 'Tiada Maklumat') --}}
<table width="100%">
    <tr>
        <th colspan="2">MAKLUMAT ADUAN DAN MAKLUMBALAS</th>
    </tr>
    <tr>
        <th style="width: 220px">Nombor Rujukan</th>
        <td>{!! $feedback->ref_num ?? $null !!}</td>
    </tr>
    <tr>
        <th style="width: 220px">Tarikh</th>
        <td>{!! $feedback->created_at ?? $null !!}</td>
    </tr>
    <tr>
        <th>Nama Penuh</th>
        <td>{!! $feedback->name ?? $null !!}</td>
    </tr>
    <tr>
        <th>Alamat E-mel</th>
        <td>{!! $feedback->email ?? $null !!}</td>
    </tr>
    <tr>
        <th>Mesej</th>
        <td>{!! $feedback->message ?? $null !!}</td>
    </tr>
</table>

@endsection
