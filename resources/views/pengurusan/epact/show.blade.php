@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">
                                {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                                'onclick' => "window.location='" . route('pengurusan.epact.edit', $epact) . "'",
                                'class' => 'btn bg-warning',
                                Html::tooltip('Kemaskini'),
                                ]) !!}
                            </div>
                            &nbsp;
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('Kembali', [
                                'onclick' => "window.location='" . route('pengurusan.epact.index') . "'",
                                'class' => 'btn bg-secondary',
                                Html::tooltip('Kembali'),
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $blank = 'Tiada Maklumat';
                @endphp
                <div class="row">
                    <div class="col-md-5 d-flex justify-content-center align-items-center">
                        <div class="card text-center">
                            <div class="row justify-content-center">
                                @if($epact->dokumen)
                                    <iframe src="{{ asset('storage/uploads/epact/dokumen/' . $epact->dokumen) }}" width="90%" height="400">
                                        This browser does not support PDFs. Please download the PDF to view it: 
                                        <a href="{{ asset('storage/uploads/epact/dokumen/' . $epact->dokumen) }}">Download PDF</a>
                                    </iframe>
                                    <p class="m-0 ml-2 text-info">
                                        <a href="{{ asset('storage/uploads/epact/dokumen/' . $epact->dokumen) }}" data-toggle="lightbox" data-title="{{ $epact->tajuk }}" data-gallery="gallery">
                                            <small>Klik Sini Untuk Paparan Penuh</small>
                                        </a>
                                    </p>
                                @else
                                    <img src="{{ asset('img/no-photos.png') }}" alt="No Document Available" style="width: 100%; height: 300px; object-fit: contain;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-sm">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="col-6">Tajuk Dokumen</th>
                                        <td class="col-6">{{ $epact->tajuk }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Keterangan</th>
                                        <td class="col-6" style="word-break: break-all;">{{ $epact->keterangan && trim($epact->keterangan) !== '' ? $epact->keterangan : 'Tiada Maklumat' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Pautan URL</th>
                                        <td class="col-6" style="word-break: break-all;">
                                            @if($epact->url)
                                                <a href="{{ strpos($epact->url, 'http://') === 0 || strpos($epact->url, 'https://') === 0 ? $epact->url : 'http://' . $epact->url }}" target="_blank" style="word-break: break-all;">
                                                    {{ $epact->url }}
                                                </a>
                                            @else
                                                Tiada Maklumat
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Saiz/Jenis Dokumen</th>
                                        <td class="col-6">{{ $epact->sizeName.' MB' }} / {{ $epact->mimes ?? 'Tiada Maklumat' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Kategori</th>
                                        <td class="col-6">{{ $epact->kategori->name ?? 'Tiada Maklumat' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Sumber Terbitan</th>
                                        <td class="col-6">
                                            {{ $epact->sumber == 0 ? 'Tiada Maklumat' : '' }}
                                            {{ $epact->sumber == 1 ? 'Bahagian Pengurusan Landskap' : '' }}
                                            {{ $epact->sumber == 2 ? 'Bahagian Taman Awam' : '' }}
                                            {{ $epact->sumber == 3 ? 'Bahagian Pembangunan Landskap' : '' }}
                                            {{ $epact->sumber == 4 ? 'Bahagian Khidmat Teknikal' : '' }}
                                            {{ $epact->sumber == 5 ? 'Bahagian Penyelidikan & Pemuliharaan' : '' }}
                                            {{ $epact->sumber == 6 ? 'Bahagian Penilaian & Penyelenggaraan' : '' }}
                                            {{ $epact->sumber == 7 ? 'Bahagian Teknologi Maklumat' : '' }}
                                            {{ $epact->sumber == 8 ? 'Bahagian Promosi & Industri Landskap' : '' }}
                                            {{ $epact->sumber == 9 ? 'Bahagian Dasar & Pengurusan Korporat' : '' }}
                                            {{ $epact->sumber == 10 ? 'Bahagian Kontrak & Ukur Bahan' : '' }}
                                            {{ $epact->sumber == 11 ? $epact->subkat : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Tahun Terbitan</th>
                                        <td class="col-6">{{ $epact->tahun }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="col-6">Nama Dokumen</th>
                                        <td class="col-6">{{ $epact->dokumen ?? 'Tiada Maklumat' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Tarikh Muatnaik</th>
                                        <td class="col-6">{{ $epact->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-6">Tarikh Kemaskini</th>
                                        <td class="col-6">{{ $epact->updated_at->format('d-m-Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                            <!-- <a href="{{ route('pengurusan.epact.download', $epact) }}" class="btn btn-primary">Muat Turun</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection