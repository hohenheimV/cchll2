@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Penyelenggaraan')
@section('card-title', 'Butiran Maklumat Penyelenggaraan Pemangkasan')

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
                            ['onclick'=>"window.location='".route('pengurusan.softscapes.pemangkasan.index',$softscape)."'",'class'=>'btn
                            btn-secondary']) !!}
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini',
                            ['onclick'=>"window.location='".route('pengurusan.softscapes.pemangkasan.edit',$pemangkasan)."'",'class'=>'btn
                            btn-warning']) !!}
                        </div>
                    </div>

                    <dl class="row p-3">

                        @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                        <dt class='col-sm-4'>Tarikh Pemangkasan</dt>
                        <dd class='col-sm-8'>{!! $pemangkasan->tarikh ?? $null !!}</dd>

                        <dt class='col-sm-4'>Jenis Pemangkasan</dt>
                        <dd class='col-sm-8'>{!! $pemangkasan->jenis ?? $null !!}</dd>

                        <dt class='col-sm-4'>Tarikh Daftarkan</dt>
                        <dd class='col-sm-8'>
                            {{ $pemangkasan->created_at ? $pemangkasan->created_at->format('d/m/Y') : '-' }}</dd>

                        <dt class='col-sm-4'>Tarikh Dikemaskini</dt>
                        <dd class='col-sm-8'>
                            {{ $pemangkasan->updated_at ? $pemangkasan->updated_at->format('d/m/Y') : '-' }}</dd>



                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
