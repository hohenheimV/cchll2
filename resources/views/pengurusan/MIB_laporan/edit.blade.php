@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Aktiviti Rakan Taman')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {!! Form::model($MIB_laporan, ['route' => ['pengurusan.MIB_laporan.update', $MIB_laporan],
                'method'=>'PUT','id'=>'formFeedbacks','files' => true]) !!}
                <div class="card-body">
                    @include('pengurusan.MIB_laporan._form')

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.MIB.show',$MIB_laporan->id_rakan)."'",
                    'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
