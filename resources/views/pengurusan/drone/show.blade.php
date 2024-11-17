@extends('layouts.pengurusan.app')

@section('title', 'Butiran Drone')

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

                                    {!! Form::button('Kembali', [
                                        'onclick' => "window.location='" . route('pengurusan.drone.index') . "'",
                                        'class' => 'btn bg-secondary',
                                        Html::tooltip('Kembali'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body table-hardscape form-hardscape text-sm">
                        @php
                            $blank = 'Tiada Maklumat';
                        @endphp

                        <div class="row">
                            <div class="col-md-4 offset-md-3">
                                <div class="card">
                                    <video controls
                                        poster="{{ asset($drone->gambar ?  'storage/images/shares/drone/'.$drone->gambar : 'img/no-photos.png') }}">
                                        <source
                                            src="{{ asset($drone->video ?  'storage/images/shares/drone/'.$drone->video : 'img/no-photos.png') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="card-body">
                                        <dl class="row">

                                            <dt class="col-6">Tajuk</dt>
                                            <dd class="col-6">{{ $drone->tajuk }}</dd>

                                            <dt class="col-6">Keterangan</dt>
                                            <dd class="col-6">{{ $drone->keterangan }}</dd>

                                            <dt class="col-6">Tarikh Cerap</dt>
                                            <dd class="col-6">{{ date('d-m-Y', strtotime($drone->tarikh)) }}</dd>

                                            <dt class="col-6">Jenis Dokumen</dt>
                                            <dd class="col-6">{{ $drone->mimes }}</dd>

                                            <dt class="col-6">Saiz Extension</dt>
                                            <dd class="col-6">{{ $drone->extension }}</dd>

                                            <dt class="col-6">Saiz Dokumen</dt>
                                            <dd class="col-6">{{ $drone->sizeName.' MB' }}</dd>

                                            <dt class="col-6">Tarikh Daftar</dt>
                                            <dd class="col-6">{{ $drone->created_at->format('d-m-Y') }}</dd>

                                            <dt class="col-6">Tarikh Kemaskini</dt>
                                            <dd class="col-6">{{ $drone->updated_at->format('d-m-Y') }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
