@extends('layouts.pengurusan.email')
@section('title', 'Akaun Telah Diaktifkan')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>

<p>Akaun anda telah berjaya diaktifkan. Anda kini boleh log masuk ke dalam sistem menggunakan emel berikut:</p>

@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">Pengaktifan Pengguna Baru</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nama</th>
        <td style="{!! $style !!}">{{ $user->name ?? 'Tiada Maklumat' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Emel</th>
        <td style="{!! $style !!}">{{ $user->email ?? 'Tiada Maklumat' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Status Akaun</th>
        <td style="{!! $style !!}">Aktif</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Peranan</th>
        <td style="{!! $style !!}">
            {{ $accountType }}
        </td>
    </tr>
</table>

<p>Jika anda mempunyai sebarang pertanyaan atau memerlukan bantuan, sila hubungi pentadbir sistem.</p>
<p>Terima kasih.</p>
@endsection
