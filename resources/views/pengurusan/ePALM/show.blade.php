@extends('layouts.pengurusan.app')

@section('title', 'Lihat ePALM')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {!! Form::model($ePALM, ['route' => ['pengurusan.ePALM.update', $ePALM], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    <style>
                        div[inert] {
                            pointer-events: none;
                        }

                        div[inert] input,
                        div[inert] span,
                        div[inert] textarea,
                        div[inert] select {
                            /* background-color:rgb(215, 215, 215); */
                            /* color:rgb(65, 60, 60); */
                            cursor: not-allowed;
                            pointer-events: none;
                        }
                        .showButton{
                            display: none;
                        }

                    </style>
                    <div inert>
                        @include('pengurusan.ePALM._form')
                    </div>
                    <!-- @include('pengurusan.ePALM._upload') -->
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.ePALM.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.ePALM.edit',$ePALM)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini Taman')]); 
                    !!}
                    {!! Form::button('<i class="fas fa-save"></i> Approve', [
                        'class' => 'btn btn-primary', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'approve'
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
