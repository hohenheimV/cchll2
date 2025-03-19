@extends('layouts.pengurusan.email')
@section('title', 'ADUAN DAN MAKLUMBALAS JABATAN LANDSKAP NEGARA')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Emel ini untuk memaklumkan bahawa aduan dan maklumbalas anda telah berjaya dihantar kepada Bahagian Taman Persekutuan, Jabatan Landskap Negara</p>
<p>Butiran aduan dan maklumbalas adalah seperti berikut:</p>
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

<p>Sekian, dimaklumkan. Terima kasih.</p>
            <p class="text-bold">'BERKHIDMAT UNTUK NEGARA'</p>
            <p>Saya yang menjalankan amanah,</p>
            <p>t.t</p>
            <p>KETUA PENGARAH,<br />
                JABATAN LANDSKAP NEGARA</p>
@endsection
