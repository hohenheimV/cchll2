@extends('layouts.pengurusan.app')

@section('title', 'Daftar Entiti Landskap Unik')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                {{ Form::open(['route' =>['pengurusan.entiti-landskap-unik.store'], 'enctype'=>'multipart/form-data']) }}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.entiti-landskap-unik._form')

                    @include('pengurusan.entiti-landskap-unik._upload')
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.entiti-landskap-unik.index')."'",'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
