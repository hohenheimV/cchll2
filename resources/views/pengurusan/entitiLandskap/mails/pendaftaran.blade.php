@extends('layouts.pengurusan.email')
@section('title', 'New User Registration Notification')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>We have a new user registration with the following details:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">USER REGISTRATION DETAILS</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Name</th>
        <td style="{!! $style !!}">{{ $user->name ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Email</th>
        <td style="{!! $style !!}">{{ $user->email ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
        </td>
    </tr>
</table>
@endsection
