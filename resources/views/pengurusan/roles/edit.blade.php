@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Peranan')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                {!! Form::model($role, ['route' => ['pengurusan.roles.update', $role->id], 'method'=>'PUT','id'=>'formModalPeranan']) !!}
                <div class="card-header d-flex p-2">
                    <div class="flex-grow-1">
                        <h6 class="my-1 mx-2 text-uppercase">@yield('title')</h6>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('pengurusan.roles._form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",'class'=>'btn bg-secondary']) }}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                <!-- /.card-footer -->
                {{ Form::close() }}
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
