@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Tambahan')
@section('card-title', 'Butiran Maklumat Gambar')

@section('page-css-style')
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">

<style>
    .product-image-thumb {
        min-height: 115px !important;
    }

    .product-image-thumb img {
        min-height: 112px !important;
        width: 100% !important;
        height: 112px !important;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                    @include('pengurusan.softscape._pill_nav')
                </div>
                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('card-title') </h5>
                        <div class="py-1">
                            {!! Form::button('Kembali',
                            ['onclick'=>"window.location='".route('pengurusan.softscapes.gambar.index',$softscape)."'",'class'=>'btn
                            btn-secondary']) !!}
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini',
                            ['onclick'=>"window.location='".route('pengurusan.softscapes.gambar.edit',$gambar)."'",'class'=>'btn
                            btn-warning']) !!}
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <div class="border pb-1">
                            <div class="col-12">
                                @isset($gambar->keseluruhan)
                                <div class="p-1 text-capitalize">
                                    <a href="{{$gambar->keseluruhan}}" data-toggle="lightbox" data-gallery="gallery"
                                        data-title="Gambar Keseluruhan" data-max-width="600">
                                        <img src="{{$gambar->keseluruhan}}" class="product-image"
                                            onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                                            alt="Keseluruhan Image" />
                                    </a>
                                    <small>Keseluruhan</small>
                                </div>
                                @endisset
                            </div>
                            <div
                                class="col-12 product-image-thumbs justify-content-center mt-1 d-flex justify-content-center">
                                @foreach (['batang','daun','bunga','buah'] as $item)
                                @isset($gambar->{$item})
                                <div class="text-capitalize text-center">
                                    <a href="{{ $gambar->{$item} }}" data-toggle="lightbox" data-gallery="gallery"
                                        data-title="Gambar {{$item}}" data-max-width="600">
                                        <div class="product-image-thumb p-1 w-100">
                                            <img src="{{$gambar->{$item} }}"
                                                onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                                                class="img-fluid" alt="Gambar {{$item}}" />
                                        </div>
                                    </a>
                                    <small>{{$item}}</small>
                                </div>
                                @endisset
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <dl class="row p-3">
                            @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                            <dt class='col-sm-3'>Tarikh</dt>
                            <dd class='col-sm-9'>{!! $gambar->tarikh ? $gambar->tarikh->format('d/m/Y') : '-' !!}</dd>

                            <dt class='col-sm-3'>Tarikh Daftarkan</dt>
                            <dd class='col-sm-9'>{!! $gambar->created_at ? $gambar->created_at->format('d/m/Y') : '-'
                                !!}</dd>

                            <dt class='col-sm-3'>Tarikh Dikemaskini</dt>
                            <dd class='col-sm-9'>{!! $gambar->updated_at ? $gambar->updated_at->format('d/m/Y') : '-'
                                !!}</dd>

                        </dl>
                    </div>


                </div>

            </div>
        </div>

    </div>
</div>
@endsection


@section('page-js-script')

<!-- Ekko Lightbox -->
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
