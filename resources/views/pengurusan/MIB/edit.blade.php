@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Rakan Taman')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {!! Form::model($MIB, ['route' => ['pengurusan.MIB.update', $MIB],
                'method'=>'PUT','id'=>'formFeedbacks','files' => true]) !!}
                <div class="card-body">
                    <style>
                        .inertClass {
                            pointer-events: none;
                        }

                        .inertClass input,
                        .inertClass span,
                        .inertClass textarea,
                        .inertClass select {
                            background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                            color: rgb(65, 60, 60); /* Light grey text color */
                            cursor: not-allowed;
                            pointer-events: none;
                        }
                    </style>
                    @include('pengurusan.MIB._form')

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.MIB.index')."'",
                    'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
