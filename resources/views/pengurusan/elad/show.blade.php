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
                                    <iframe src="{{ asset($elad->dokumen ? 'storage/images/shares/elad/dokumen/' . $elad->dokumen : 'img/no-photos.png') }}" width="80%" height="300">
                                            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset($elad->dokumen ? 'storage/images/shares/elad/dokumen/' . $elad->dokumen : 'img/no-photos.png') }}">Download PDF</a>
                                    </iframe>
                                </div>
                                <p class="m-0 ml-2 text-info"><a href="{{ asset($elad->dokumen ? 'storage/images/shares/elad/dokumen/' . $elad->dokumen : 'img/no-photos.png') }}" data-toggle="lightbox" data-title="{{ $elad->tajuk }}" data-gallery="gallery"><small>Klik Sini Untuk Paparan Penuh</small></a></p>
                            </div>
                        </div>                 
                        <div class="col-md-5 text-sm">                                  
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-6">Tajuk</dt>
                                    <dd class="col-6">{{ $elad->tajuk }}</dd>

                                    <dt class="col-6">Keterangan</dt>
                                    <dd class="col-6">{{ $elad->keterangan }}</dd>

                                    <dt class="col-6">Saiz Dokumen</dt>
                                    <dd class="col-6">{{ $elad->sizeName.' MB' }}</dd>
                                    
                                    <dt class="col-6">Kategori</dt>
                                    <dd class="col-6">
                                        {{ $elad->kategori->name ?? 'Tiada Maklumat' }}
                                    </dd>

                                        <dt class="col-6">Tahun</dt>
                                        <dd class="col-6">{{ date('Y', strtotime($elad->tarikh)) }}</dd>

                                        <dt class="col-6">Jenis Dokumen</dt>
                                        <dd class="col-6">{{ $elad->mimes }}</dd>

                                        <dt class="col-6">Nama Dokumen</dt>
                                        <dd class="col-6">{{ $elad->dokumen }}</dd>
                                            
                                        <dt class="col-6">Tarikh Daftar</dt>
                                        <dd class="col-6">{{ $elad->created_at->format('d-m-Y') }}</dd>

                                        <dt class="col-6">Tarikh Kemaskini</dt>
                                        <dd class="col-6">{{ $elad->updated_at->format('d-m-Y') }}</dd>
                                    </dl>
                                    <!-- <a href="{{ route('pengurusan.elad.download', $elad) }}" class="btn btn-primary">Muat Turun</a> -->
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
