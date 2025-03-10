@extends('layouts.pengurusan.app')

@section('title', 'Lihat Entiti Landskap Unik')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                {!! Form::model($entitiLandskapUnik, ['route' => ['pengurusan.entiti-landskap-unik.update', $entitiLandskapUnik], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    <div inert>
                        @include('pengurusan.entiti-landskap-unik._form')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.entiti-landskap-unik.index')."'", 'class' => 'btn btn-secondary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
