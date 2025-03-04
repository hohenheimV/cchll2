@extends('layouts.pengurusan.app')

@section('title', 'Lihat ePIL')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {{-- dd($ePIL)--}}
                {!! Form::model($ePIL, ['route' => ['pengurusan.ePIL.update', $ePIL], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
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
                        @include('pengurusan.ePIL._form')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.ePIL.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.ePIL.edit',$ePIL->id_pelan)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini PIL')]); 
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
