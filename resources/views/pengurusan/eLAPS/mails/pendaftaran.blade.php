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
        ['id' => 'Lawatan Kawasan Tapak', 'label' => 'bg-success'], //6
        ['id' => 'Draf Ulasan Lawatan Kawasan Tapak', 'label' => 'bg-warning'], //7
        ['id' => 'Ulasan Lawatan Kawasan Tapak diterima', 'label' => 'bg-info'], //8
        ['id' => 'Permohonan dibawa ke JPT', 'label' => 'bg-primary'], //9
        ['id' => 'Permohonan Lulus', 'label' => 'bg-success'], //10
        ['id' => 'Permohonan Gagal', 'label' => 'bg-danger'], //11
        ['id' => 'Projek dalam pembinaan', 'label' => 'bg-secondary'], //12
        ['id' => 'Projek Batal', 'label' => 'bg-dark'], //13
        ['id' => 'Projek Siap', 'label' => 'bg-success'] //14
    ])
    <tr>
        <th style="{!! $style !!}">Status</th>
        <td style="{!! $style !!}">
            {{ $status_pembangunan[$elaps->status_permohonan - 1]['id'] }}
        </td>
    </tr>
</table>
@endsection
