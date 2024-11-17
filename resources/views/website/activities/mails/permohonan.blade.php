@extends('layouts.pengurusan.email')
@section('title', 'PERMOHONAN AKTIVITI TAMAN PERSEKUTUAN BUKIT KIARA')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Terdapat satu (1) permohonan aktiviti peggunaan Taman Persekutuan Bukit Kiara melalui laman web dan butiran permohonan anda seperti berikut:</p>
@php($null = 'Tiada Maklumat')
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top; ')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">MAKLUMAT PERMOHONAN</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Rujukan Permohonan</th>
        <td style="{!! $style !!}"> 
        <a target="_blank" href="{{ route('pengurusan.activities.show',$activity) }}">{!! $activity->ref_num ?? $null !!}</a>
        </td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Nama Pemohon</th>
        <td style="{!! $style !!}">{!! $activity->name ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">E-mel Pemohon</th>
        <td style="{!! $style !!}">{!! $activity->email ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">No Telefon Pemohon</th>
        <td style="{!! $style !!}">{!! $activity->phone ?? $null !!}</td>
    </tr>
    <!--<tr>
        <th style="{!! $style !!}">No Fax Pemohon</th>
        <td style="{!! $style !!}">{!! $activity->fax ?? $null !!}</td>
    </tr>-->
    <tr>
        <th style="{!! $style !!}">Nama Penganjur</th>
        <td style="{!! $style !!}">{!! $activity->organizer ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Tarikh Mohon</th>
        <td style="{!! $style !!}">{!! $activity->apply_at->format('d-m-Y')!!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Tarikh Mula - Tamat</th>
        <td style="{!! $style !!}">{!! $activity->start_at->format('d-m-Y')!!} hingga {!! $activity->end_at->format('d-m-Y')!!}</td>
    </tr>

    <tr>
        <th style="{!! $style !!}">Masa </th>
        <td style="{!! $style !!}">{!! $activity->slot !!}</td>
    </tr>

    <tr>
        <th style="{!! $style !!}">Lokasi</th>
        <td style="{!! $style !!}">
             <strong>{!! $activity->lokasi ? $activity->zon : 'Tiada Maklumat' !!}</strong><br/>
            {!! $activity->zones['label'] !!}<br/>
            {!! $activity->zones['text'] !!}
        </td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Nama Program/Aktiviti</th>
        <td style="{!! $style !!}">{!! $activity->title ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Ringkasan Aktiviti</th>
        <td style="{!! $style !!}">{!! $activity->description ?? $null !!}</td>
    </tr>
</table>

@endsection
