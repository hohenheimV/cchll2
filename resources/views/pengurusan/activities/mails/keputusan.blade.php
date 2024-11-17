@extends('layouts.pengurusan.email')
@section('title', 'STATUS PERMOHONAN AKTIVITI TAMAN PERSEKUTUAN BUKIT KIARA')


@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>

<p>Dengan segala hormatnya perkara di atas adalah dirujuk.</p>

@if ($status == 'Lulus')
<p>Sukacita dimaklumkan bahawa permohonan YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan adalah <strong>DILULUSKAN</strong></p>
<p>Sila patuhi arahan dan syarat-syarat seperti yang telah ditetapkan.</p>

@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top; ')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">MAKLUMAT PERMOHONAN</th>
    </tr>
    <tr>
		<th style="{!! $style !!}">Nama Program/Aktiviti</th>
        <td style="{!! $style !!}">{!! $activity->title ?? $null !!}</td>
    </tr>
	<tr>
        <th style="{!! $style !!}">Tarikh Mula - Tamat</th>
        <td style="{!! $style !!}">{!! $activity->start_at->format('d-m-Y')!!} hingga {!! $activity->end_at->format('d-m-Y')!!}</td>
    </tr>

    <tr>
        <th style="{!! $style !!}">Masa </th>
        <td style="{!! $style !!}">{!! $activity->slot !!}</td>
    </tr>
</table>

@else
<p>Dukacita dimaklumkan bahawa permohonan YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan adalah <strong>TIDAK DILULUSKAN</strong></p>

@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top; ')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">MAKLUMAT PERMOHONAN</th>
    </tr>
    <tr>
        <th style="{!! $style !!}">Nama Program/Aktiviti</th>
        <td style="{!! $style !!}">{!! $activity->title ?? $null !!}</td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Tarikh Mula - Tamat</th>
        <td style="{!! $style !!}">{!! $activity->start_at->format('d-m-Y')!!} hingga {!! $activity->end_at->format('d-m-Y')!!}</td>
    </tr>

    <tr>
        <th style="{!! $style !!}">Masa </th>
        <td style="{!! $style !!}">{!! $activity->slot !!}</td>
    </tr>
</table>

@endif

<p>Sekian, dimaklumkan. Terima kasih.</p>
<p><strong>'BERKHIDMAT UNTUK NEGARA'</strong></p>
<p>Saya yang menjalankan amanah,</p>
<p>&nbsp;</p>
<p>t.t<br />
<strong>KETUA PENGARAH,<br />
    JABATAN LANDSKAP NEGARA</strong></p>
@endsection
