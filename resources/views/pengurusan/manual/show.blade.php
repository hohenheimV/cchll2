@extends('layouts.pengurusan.app')

@section('title', 'Butiran Manual')

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
                                        'onclick' => "window.location='" . route('pengurusan.manual.index') . "'",
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
                            <div class="col-md-4 offset-md-2">
                                <div class="card">
                                    {{-- <img src="{{ asset($manual->video ?  'storage/images/shares/manual/'.$manual->video : 'img/no-photos.png') }}"
                                        alt="" srcset=""> --}}

                                    <div class="card-body">
                                        <dl class="row">

                                            <dt class="col-6">Tajuk</dt>
                                            <dd class="col-6">{{ $manual->tajuk }}</dd>

                                            {{-- <dt class="col-6">Keterangan</dt>
                                            <dd class="col-6">{{ $manual->keterangan }}</dd> --}}

                                            <dt class="col-6">Tarikh Manual</dt>
                                            <dd class="col-6">{{ date('d-m-Y', strtotime($manual->tarikh)) }}</dd>

                                            <dt class="col-6">Jenis Dokumen</dt>
                                            <dd class="col-6">{{ $manual->mimes }}</dd>

                                            <dt class="col-6">Saiz Extension</dt>
                                            <dd class="col-6">{{ $manual->extension }}</dd>

                                            <dt class="col-6">Saiz Dokumen</dt>
                                            <dd class="col-6">{{ $manual->sizeName.' MB' }}</dd>

                                            <dt class="col-6">Tarikh Daftar</dt>
                                            <dd class="col-6">{{ $manual->created_at->format('d-m-Y') }}</dd>

                                            <dt class="col-6">Tarikh Kemaskini</dt>
                                            <dd class="col-6">{{ $manual->updated_at->format('d-m-Y') }}</dd>
                                        </dl>
                                        <a href="{{ route('pengurusan.manual.download', $manual) }}" class="btn btn-primary">Muat Turun</a>
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
