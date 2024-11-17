@extends('layouts.pengurusan.email')
@section('title', 'STATUS PERMOHONAN PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA')


@section('body')
<p>YBhg Tuan/Puan</p>
<p>Emel ini untuk memaklumkan bahawa permohonan anda telah diluluskan oleh Bahagian Taman Persekutuan, Jabatan Landskap Negara</p>
<p>Butiran permohonan adalah seperti berikut:</p>
{{-- @php($null = 'Tiada Maklumat') --}}
<table width="100%">
    <tr>
        <th colspan="2">MAKLUMAT PERMOHONAN</th>
    </tr>
    <tr>
        <th style="width: 220px">Rujukan Permohonan</th>
        <td>{!! $activity->ref_num ?? $null !!}</td>
    </tr>
    <tr>
        <th>Nama Pemohon</th>
        <td>{!! $activity->name ?? $null !!}</td>
    </tr>
    <tr>
        <th>E-mel Pemohon</th>
        <td>{!! $activity->email ?? $null !!}</td>
    </tr>
    <tr>
        <th>No Telefon Pemohon</th>
        <td>{!! $activity->phone ?? $null !!}</td>
    </tr>
   <!-- <tr>
        <th>No Fax Pemohon</th>
        <td>{!! $activity->fax ?? $null !!}</td>
    </tr>-->
    <tr>
        <th>Nama Penganjur</th>
        <td>{!! $activity->organizer ?? $null !!}</td>
    </tr>
    <tr>
        <th>Tarikh Mohon</th>
        <td>{!! $activity->apply_at->format('d-m-Y')!!}</td>
    </tr>
    <tr>
        <th>Tarikh Mula - Tamat</th>
        <td>{!! $activity->start_at->format('d-m-Y')!!} hingga {!! $activity->end_at->format('d-m-Y')!!}</td>
    </tr>

    <tr>
        <th>Masa </th>
        <td>{!! $activity->slot !!}</td>
    </tr>

    <tr>
        <th>Lokasi</th>
        <td>
             <strong>{!! $activity->lokasi ? $activity->zon : 'Tiada Maklumat' !!}</strong><br/>
            {!! $activity->zones['label'] !!}<br/>
            {!! $activity->zones['text'] !!}
        </td>
    </tr>
    <tr>
        <th>Nama Program/Aktiviti</th>
        <td>{!! $activity->title ?? $null !!}</td>
    </tr>
    <tr>
        <th>Ringkasan Aktiviti</th>
        <td>{!! $activity->description ?? $null !!}</td>
    </tr>
</table>
<p>Sila patuhi arahan dan syarat-syarat seperti yang telah ditetapkan.</p>
<p>Sekian, dimaklumkan. Terima kasih.</p>
            <p class="text-bold">'BERKHIDMAT UNTUK NEGARA'</p>
            <p>Saya yang menjalankan amanah,</p>
            <p>t.t</p>
            <p>KETUA PENGARAH,<br />
                JABATAN LANDSKAP NEGARA</p>
@endsection
