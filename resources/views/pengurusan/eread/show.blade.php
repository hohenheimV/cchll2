@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumat R&D Landskap')

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
                                        'onclick' => "window.location='" . route('pengurusan.eread.edit', $eread) . "'",
                                        'class' => 'btn bg-warning',
                                        Html::tooltip('Kemaskini'),
                                    ]) !!}
                                </div>
                                &nbsp;
                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('Kembali', [
                                        'onclick' => "window.location='" . route('pengurusan.eread.index') . "'",
                                        'class' => 'btn bg-secondary',
                                        Html::tooltip('Kembali'),
                                    ]) !!}
                                </div>
                                &nbsp;
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
                                    <iframe src="{{ asset($eread->dokumen ? 'storage/images/shares/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}" width="80%" height="300">
                                            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset($eread->dokumen ? 'storage/images/shares/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}">Download PDF</a>
                                    </iframe>
                                </div>
                                <p class="m-0 ml-2 text-info"><a href="{{ asset($eread->dokumen ? 'storage/images/shares/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}" data-toggle="lightbox" data-title="{{ $eread->tajuk }}" data-gallery="gallery"><small>Klik Sini Untuk Paparan Penuh</small></a></p>
                            </div>
                        </div>                 
                        <div class="col-md-5 text-sm">                                  
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-6">Tajuk</dt>
                                    <dd class="col-6">{{ $eread->tajuk }}</dd>

                                    <dt class="col-6">Keterangan</dt>
                                    <dd class="col-6">{{ $eread->keterangan }}</dd>

                                    <dt class="col-6">Saiz Dokumen</dt>
                                    <dd class="col-6">{{ $eread->sizeName.' MB' }}</dd>
                                    
                                    <dt class="col-6">Kategori</dt>
                                    <dd class="col-6">
                                        {{ $eread->kategori->name ?? 'Tiada Maklumat' }}
                                    </dd>

                                        <dt class="col-6">Tahun</dt>
                                        <dd class="col-6">{{ date('Y', strtotime($eread->tarikh)) }}</dd>

                                        <dt class="col-6">Jenis Dokumen</dt>
                                        <dd class="col-6">{{ $eread->mimes }}</dd>

                                        <dt class="col-6">Nama Dokumen</dt>
                                        <dd class="col-6">{{ $eread->dokumen }}</dd>
                                            
                                        <dt class="col-6">Tarikh Daftar</dt>
                                        <dd class="col-6">{{ $eread->created_at->format('d-m-Y') }}</dd>

                                        <dt class="col-6">Tarikh Kemaskini</dt>
                                        <dd class="col-6">{{ $eread->updated_at->format('d-m-Y') }}</dd>
                                    </dl>
                                    <!-- <a href="{{ route('pengurusan.eread.download', $eread) }}" class="btn btn-primary">Muat Turun</a> -->
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
