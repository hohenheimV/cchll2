@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Interaktif')

@section('page-css-style')
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">

    <style>
        .image {
            display: inline-block;
            margin: 4px;
            border: 1px solid #CCCCCC;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .image.size-fixed {
            width: 100%;
            height: 200px;
        }

        .image.size-fluid {
            padding-top: 15%;
            width: 20%;
        }

        .image.scale-fit {
            background-size: contain;
        }

        .image.scale-fill {
            background-size: cover;
        }

        .image img {
            display: none;
        }

        .image a {
            width: 100%;
            height: calc(100% - 40px);
            display: block;
        }
    </style>
@endsection

@section('page-js-script')
    <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    </script>
@endsection

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
                                        'onclick' => "window.location='" . route('pengurusan.analisa.index') . "'",
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

                                    <div class="image size-fixed scale-fill"
                                        style="background-image: url({{ asset($analisa->dokumen ? 'storage/images/shares/analisa/' . $analisa->dokumen : 'img/no-photos.png') }});">

                                        <a href="{{ asset($analisa->dokumen ? 'storage/images/shares/analisa/' . $analisa->dokumen : 'img/no-photos.png') }}"
                                            data-toggle="lightbox" data-title="{{ $analisa->tajuk }}"
                                            data-gallery="gallery">
                                            <img width="100%"
                                                src="{{ asset($analisa->dokumen ? 'storage/images/shares/analisa/' . $analisa->dokumen : 'img/no-photos.png') }}"
                                                alt="Maklumat Interaktif">
                                        </a>
                                    </div>
                                    <p class="m-0 ml-2 text-info"><small>Klik Imej untuk paparan penuh</small></p>

                                    <div class="card-body">
                                        <dl class="row">

                                            <dt class="col-6">Maklumat Interaktif</dt>
                                            <dd class="col-6">{{ $analisa->tajuk }}</dd>
                                            {{-- <dt class="col-6">Keterangan</dt>
                                            <dd class="col-6">{{ $analisa->keterangan }}</dd> --}}

                                            <dt class="col-6">Tarikh Analisa</dt>
                                            <dd class="col-6">{{ date('d-m-Y', strtotime($analisa->tarikh)) }}</dd>

                                            <dt class="col-6">Jenis Dokumen</dt>
                                            <dd class="col-6">{{ $analisa->mimes }}</dd>

                                            <dt class="col-6">Saiz Extension</dt>
                                            <dd class="col-6">{{ $analisa->extension }}</dd>

                                            <dt class="col-6">Saiz Dokumen</dt>
                                            <dd class="col-6">{{ $analisa->sizeName . ' MB' }}</dd>

                                            <dt class="col-6">Tarikh Daftar</dt>
                                            <dd class="col-6">{{ $analisa->created_at->format('d-m-Y') }}</dd>

                                            <dt class="col-6">Tarikh Kemaskini</dt>
                                            <dd class="col-6">{{ $analisa->updated_at->format('d-m-Y') }}</dd>
                                        </dl>
                                        {{-- <a href="{{ route('pengurusan.analisa.download', $analisa) }}"
                                            class="btn btn-primary">Muat Turun</a> --}}
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
