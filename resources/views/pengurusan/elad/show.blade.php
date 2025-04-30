@extends('layouts.pengurusan.app')

@section('title', 'Butiran Pengurusan Rekabentuk Landskap(eLAD)')

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
                        <div class="col-md-5 text-sm">                                  
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Tajuk</th>
                                        <td>{{ $elad->tajuk }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $elad->keterangan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Saiz Dokumen</th>
                                        <td>{{ $elad->sizeName.' MB' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>{{ $elad->kategori->name ?? 'Tiada Maklumat' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun</th>
                                        <td>{{ date('Y', strtotime($elad->tarikh)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Dokumen</th>
                                        <td>{{ $elad->mimes }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Dokumen</th>
                                        <td>{{ $elad->dokumen }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tarikh Daftar</th>
                                        <td>{{ $elad->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tarikh Kemaskini</th>
                                        <td>{{ $elad->updated_at->format('d-m-Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
