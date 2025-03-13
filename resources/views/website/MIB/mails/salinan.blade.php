@extends('layouts.pengurusan.email')
@section('title', 'ADUAN DAN MAKLUMBALAS TAMAN PERSEKUTUAN BUKIT KIARA')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Emel ini untuk memaklumkan bahawa aduan dan maklumbalas anda telah berjaya dihantar kepada Bahagian Taman Persekutuan, Jabatan Landskap Negara</p>
<p>Butiran aduan dan maklumbalas adalah seperti berikut:</p>
@php($null = 'Tiada Maklumat')
<table width="100%">
    <tr>
        <th colspan="2">MAKLUMAT ADUAN DAN MAKLUMBALAS</th>
    </tr>
    <tr>
        <th style="width: 220px">Nombor Rujukan</th>
        <td>{!! $MIB->ref_num ?? '' !!}</td>
    </tr>
    <tr>
        <th style="width: 220px">Tarikh</th>
        <td>{!! $MIB->created_at ?? '' !!}</td>
    </tr>
    <tr>
        <th>Nama Penuh</th>
        <td>{!! $MIB->name ?? '' !!}</td>
    </tr>
    <tr>
        <th>Alamat E-mel</th>
        <td>{!! $MIB->email ?? '' !!}</td>
    </tr>
    <tr>
        <th>Mesej</th>
        <td>{!! $MIB->message ?? '' !!}</td>
    </tr>
</table>

<p>Sekian, dimaklumkan. Terima kasih.</p>
            <p class="text-bold">'BERKHIDMAT UNTUK NEGARA'</p>
            <p>Saya yang menjalankan amanah,</p>
            <p>t.t</p>
            <p>KETUA PENGARAH,<br />
                JABATAN LANDSKAP NEGARA</p>
@endsection
