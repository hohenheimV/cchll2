@extends('layouts.pengurusan.app')

@section('title', 'Lihat Entiti Landskap ')

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
                    <style>
                        .showButton{
                            display: none;
                        }
                        .inertShow {
                            pointer-events: none;
                        }

                        .inertShow input,
                        .inertShow span:not(.parks span),
                        .inertShow select {
                            background-color: rgb(241, 241, 241);
                            color: rgb(65, 60, 60);
                            cursor: not-allowed;
                            pointer-events: none;
                        }
                    </style>
                    <div>
                        @include('pengurusan.entiti-landskap-unik._form')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.entiti-landskap-unik.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.entiti-landskap-unik.edit',$entitiLandskapUnik)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini Entiti')]); 
                    !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
