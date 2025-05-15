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
                                        'onclick' => "window.location='" . route('pengurusan.elad.edit', $elad) . "'",
                                        'class' => 'btn bg-warning',
                                        Html::tooltip('Kemaskini'),
                                    ]) !!}
                                </div>
                                &nbsp;
                                <div class="btn-group" role="group" aria-label="First group">

                                    {!! Form::button('Kembali', [
                                        'onclick' => "window.location='" . route('pengurusan.elad.index') . "'",
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
                                    @if($elad->dokumen)
                                        @if(Str::endsWith($elad->dokumen, '.zip'))
                                            <img src="{{ asset('img/zip-preview.png') }}" alt="ZIP File Preview" width="80%" height="300">
                                            <p class="m-0 ml-2 text-info">
                                                <a href="{{ asset('storage/uploads/elad/dokumen/' . $elad->dokumen) }}" download>
                                                    <small>Klik Sini Untuk Muat Turun</small>
                                                </a>
                                            </p>
                                        @else
                                            <iframe src="{{ asset('storage/uploads/elad/dokumen/' . $elad->dokumen) }}" width="80%" height="400">
                                                This browser does not support PDFs. Please download the PDF to view it: 
                                                <a href="{{ asset('storage/uploads/elad/dokumen/' . $elad->dokumen) }}">Download PDF</a>
                                            </iframe>
                                            <p class="m-0 ml-2 text-info">
                                                <a href="{{ asset('storage/uploads/elad/dokumen/' . $elad->dokumen) }}" data-toggle="lightbox" data-title="{{ $elad->tajuk }}" data-gallery="gallery">
                                                    <small>Klik Sini Untuk Paparan Penuh</small>
                                                </a>
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-center">
                                            <a href="{{ asset('storage/uploads/elad/dokumen/' . $elad->dokumen) }}" download>
                                                Klik Sini Untuk Muat Turun
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>                 
                        <div class="col-md-6 text-sm">                                  
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="col-6">Tajuk</th>
                                            <td class="col-6">{{ $elad->tajuk }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Keterangan</th>
                                            <td class="col-6" style="word-break: break-all;">{{ $elad->keterangan && trim($elad->keterangan) !== '' ? $elad->keterangan : 'Tiada Maklumat' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Saiz Dokumen</th>
                                            <td class="col-6">{{ $elad->sizeName.' MB' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Kategori</th>
                                            <td class="col-6">{{ $elad->kategori->name ?? 'Tiada Maklumat' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Tahun</th>
                                            <td class="col-6">{{ date('Y', strtotime($elad->tarikh)) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Jenis Dokumen</th>
                                            <td class="col-6">{{ $elad->mimes }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Nama Dokumen</th>
                                            <td class="col-6">{{ $elad->dokumen }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Tarikh Daftar</th>
                                            <td class="col-6">{{ $elad->created_at->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-6">Tarikh Kemaskini</th>
                                            <td class="col-6">{{ $elad->updated_at->format('d-m-Y') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
