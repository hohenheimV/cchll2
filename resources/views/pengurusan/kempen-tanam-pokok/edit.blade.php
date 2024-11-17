@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Kempen Tanam Pokok')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                {!! Form::model($kempenTanamPokok, ['route' => ['pengurusan.kempen-tanam-pokok.update', $kempenTanamPokok], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.kempen-tanam-pokok._form')

                    @include('pengurusan.kempen-tanam-pokok._upload')
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick' => "window.location='".route('pengurusan.kempen-tanam-pokok.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
