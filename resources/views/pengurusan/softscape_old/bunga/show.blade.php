@extends('layouts.pengurusan.app')

@section('title', 'Butiran Maklumat Bunga')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    @include('pengurusan.softscape._pill_nav')
                </div>

                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('title') </h5>
                        <div class="py-1">
                            {!! Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.softscapes.bunga.index',$softscape)."'",'class'=>'btn btn-secondary']) !!}
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.softscapes.bunga.edit',$bunga)."'",'class'=>'btn btn-warning']) !!}
                        </div>
                    </div>

                    <dl class="row p-3">
                        @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')

                        <dt class='col-sm-6'>Warna Bunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->warna ?? $null !!}</dd>

                        <dt class='col-sm-6'>Bentuk Bunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->bentuk ?? $null !!}</dd>

                        <dt class='col-sm-6'>Saiz Bunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->saiz ?? $null !!}</dd>

                        <dt class='col-sm-6'>Bilangan Kelopak Bunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->bilangan ?? $null !!}</dd>

                        <dt class='col-sm-6'>Wangian Bunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->wangian ?? $null !!}</dd>

                        <dt class='col-sm-6'>Musim Berbunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->musim ?? $null !!}</dd>

                        <dt class='col-sm-6'>Tempoh Berbunga</dt>
                        <dd class='col-sm-6'>{!! $bunga->tempoh ?? $null !!}</dd>

                        <dt class='col-sm-6'>Tarikh</dt>
                        <dd class='col-sm-6'>{!! $bunga->tarikh ?? $null !!}</dd>

                        <dt class='col-sm-6'>Tarikh Daftarkan</dt>
                        <dd class='col-sm-6'>{{ $bunga->created_at ? $bunga->created_at->format('d/m/Y') : '-' }}</dd>

                        <dt class='col-sm-6'>Tarikh Dikemaskini</dt>
                        <dd class='col-sm-6'>{{ $bunga->updated_at ? $bunga->updated_at->format('d/m/Y') : '-' }}</dd>

                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

