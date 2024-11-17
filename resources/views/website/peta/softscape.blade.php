@extends('layouts.pengurusan.blank')

@section('title', 'Softscape')

@section('content')

<div class="modal-header bg-gradient-olive d-flex p-2">
    <div class="flex-grow-1">
        <h5 class="my-1 mx-2 text-uppercase">@yield('title')</h5>
    </div>
    <div>
        {{ Form::button('<i class="fas fa-times-circle"></i>', ['class'=>'btn bg-dark my-1 ','data-dismiss'=>'modal']) }}
    </div>
</div>

<!-- /.modal-header -->
<div class="modal-body">
    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="col-12">
                <img src="{{ isset($softscape->gambar->keseluruhan )? $softscape->gambar->keseluruhan : asset('img/default-150x150.png') }}" class="product-image" alt="Gambar Softscape">
            </div>
            <div class="col-12 product-image-thumbs">
                <div class="product-image-thumb p-1 mr-1">
                    <img alt="Gambar softscape" class="thumb" src="{{ isset($softscape->gambar->keseluruhan ) ? $softscape->gambar->keseluruhan : asset('img/default-150x150.png') }}">
                </div>
                <div class="product-image-thumb p-1 mr-1">
                    <img alt="Gambar softscape" class="thumb" src="{{ isset($softscape->gambar->daun) ? $softscape->gambar->daun : asset('img/default-150x150.png') }}">
                </div>
                <div class="product-image-thumb p-1 mr-1">
                    <img alt="Gambar softscape" class="thumb" src="{{ isset($softscape->gambar->bunga) ? $softscape->gambar->bunga : asset('img/default-150x150.png') }}">
                </div>
                <div class="product-image-thumb p-1 mr-1">
                    <img alt="Gambar softscape" class="thumb" src="{{ isset($softscape->gambar->buah) ? $softscape->gambar->buah : asset('img/default-150x150.png') }}">
                </div>
            </div>
            <div class="col-12 text-center p-4">
                <img class="img-thumbnail border border-dark text-center"
                    src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .3, true)->margin(1)->size(280)->errorCorrection('Q')->generate($softscape->softscape_qrcode)) !!} ">
            </div>
        </div>
        <div class="col-12 col-sm-8" id="softscape">
            <div class="bg-gray py-2 px-3 mb-4">
                <div class="mb-0 d-flex">
                    <div class="flex-grow-1">
                        <h4 class="mt-0">Tahun : {{ $softscape->tahun_tanam }}</h4>
                        <h5 class="mt-0">Kod Tag : {{  $softscape->kod_tag }}</h5>
                    </div>
                </div>
            </div>
            <h5><b>Jenis / Kategori</b> : {{ $softscape->jenis }}</h5>
            <h5><b>Nama Botani </b>: {{ $softscape->nama_botani }}</h5>
            <h5><b>Nama Tempatan</b> : {{ $softscape->nama_tempatan }}</h5>
            <h5><b>Nama Keluarga / Asal</b> : {{ $softscape->nama_keluarga }}</h5>
            <h5><b>Kos Perolehan</b> : {{ "RM ".$softscape->kos_perolehan }}</h5>

            <div class="more">
                <p>{!! $softscape->keterangan !!}</p>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.modal-body -->
@endsection
