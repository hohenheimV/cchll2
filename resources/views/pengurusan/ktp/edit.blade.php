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

                {!! Form::model($ktp, ['route' => ['pengurusan.ktp.update', $ktp], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.ktp._form', ['spesisPokokJumlahPairs' => $spesisPokokJumlahPairs ?? []])

                    <!-- @include('pengurusan.ktp._upload') -->
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick' => "window.location='".route('pengurusan.ktp.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! Form::button('Set Semula', ['type' => 'reset', 'class' => 'btn btn-warning']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
