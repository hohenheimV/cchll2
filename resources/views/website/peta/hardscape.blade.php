@extends('layouts.pengurusan.blank')

@section('title', 'Hardscape')

@section('content')

<div class="modal-header bg-gradient-olive d-flex p-2">
    <div class="flex-grow-1">
        <h5 class="my-1 mx-2 text-uppercase">@yield('title')</h5>
    </div>
    <div>
        {{ Form::button('<i class="fas fa-times-circle"></i>', ['class'=>'btn bg-dark m-1','data-dismiss'=>'modal']) }}
    </div>
</div>
<!-- /.modal-header -->
<div class="modal-body">
    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="col-12">
                <img class="product-image" alt="Gambar lengkap" src="{{ $hardscape->gambar_lengkap ? $hardscape->gambar_lengkap : asset('img/default-150x150.png') }}">
            </div>
        </div>
        <div class="col-12 col-sm-8" id="hardscape">
            <div class="bg-gray py-2 px-3 mb-4">
                <h2 class="mb-0 d-flex">
                    <div class="flex-fill">Kod Tag : {{ $hardscape->kod_tag }}</div>
                    <div class="flex-fill text-right"><small>Tahun : {{ $hardscape->tahun_bina }}</small></div>
                </h2>
                <h4 class="mt-0">
                    <small>No Rujukan : {{  $hardscape->no_rujukan }}</small>
                </h4>
            </div>
            <h5><b>Jenis Komponen / Struktur</b> : {{ $hardscape->jenis_komponen }}</h5>
            <h5><b>Nama Struktur</b>: {{ $hardscape->nama_struktur }}</h5>
        </div>
    </div>
</div>
<!-- /.modal-body -->
@endsection
