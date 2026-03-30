@extends('layouts.pengurusan.email')
@section('title', 'Permohonan Pembangunan Projek')

@section('body')
<p>YBhg. Dato’ Sri / Datuk / Dr. / Tuan / Puan</p>
<p>Permohonan baru telah diterima. Berikut adalah maklumat permohonan yang memerlukan tindakan pengesahan:</p>
@php($style = 'border: 1px solid #ddd; padding: 8px; vertical-align: top;')
<table style="border-collapse: collapse; width:100%;">
    <tr>
        <th colspan="2">Permohonan Pembangunan Projek</th>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Tajuk Permohonan Projek</th>
        <td style="{!! $style !!}">{{ $elaps->projectTitle ?? 'No Information' }}</td>
    </tr>
    <tr>
        <th style="width: 220px; {!! $style !!}">Nama Pemohon</th>
        <td style="{!! $style !!}">{{ $name ?? 'No Information' }}</td>
    </tr>
    <!-- <tr>
        <th style="{!! $style !!}">Emel Pemohon</th>
        <td style="{!! $style !!}">{{ $email ?? 'No Information' }}</td>
    </tr> -->
    @php($status_pembangunan = [
        ['id' => 'Draf Permohonan', 'label' => 'bg-warning'], //1
        ['id' => 'Permohonan diterima', 'label' => 'bg-info'], //2
        ['id' => 'Pengesahan Permohonan', 'label' => 'bg-primary'], //3
        ['id' => 'Permohonan ditolak', 'label' => 'bg-danger'], //4
        ['id' => 'Serahan Permohonan ke Bahagian', 'label' => 'bg-secondary'], //5
        ['id' => 'Permohonan sedang diproses', 'label' => 'bg-success'], //6
        ['id' => 'Draf Ulasan', 'label' => 'bg-warning'], //7
        ['id' => 'Ulasan diterima', 'label' => 'bg-info'], //8
        ['id' => 'Permohonan dalam pertimbangan', 'label' => 'bg-primary'], //9
        ['id' => 'Permohonan Lengkap', 'label' => 'bg-success'], //10
        ['id' => 'Permohonan Tidak Lengkap', 'label' => 'bg-danger'], //11
        ['id' => 'Projek dalam pelaksanaan', 'label' => 'bg-secondary'], //12
        ['id' => 'Projek Batal', 'label' => 'bg-dark'], //13
        ['id' => 'Projek Siap', 'label' => 'bg-success'], //14
        ['id' => 'Lulus J/kuasa Penilaian Tapak', 'label' => 'bg-success'], //15
        ['id' => 'Tidak Lulus J/kuasa Penilaian Tapak', 'label' => 'bg-danger'], //16
        ['id' => 'Projek disenaraikan dalam permohonan JLN', 'label' => 'bg-teal'], //17
    ])
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            {{ $status_pembangunan[$elaps->status_permohonan - 1]['id'] }}
        </td>
    </tr>
    <tr>
        <th style="{!! $style !!}">Pautan Permohonan</th>
        <td style="{!! $style !!}">
            <a href="{{ url('/pengurusan/eLAPS/' . $elaps->id) }}">Klik di sini</a>
        </td>
    </tr>
</table>
@endsection
