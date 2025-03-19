@extends('layouts.pengurusan.email')
@section('title', 'Pendaftaran Pengguna Baru')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Terdapat satu (1) Pendaftaran Pengguna Baru melalui laman web dan butiran lanjut seperti berikut:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">Pendaftaran Pengguna Baru</th>
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
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
        </td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Peranan</th>
        <td style="{!! $style !!}">
            {{ $accountType }}
        </td>
    </tr>
    <tr>
        <th style="{!! $style !!}" colspan="2">{{ $name }}</th>
    </tr>
</table>

<p>Mohon semakan untuk tindakan pengaktifan pengguna.</p>
@endsection
