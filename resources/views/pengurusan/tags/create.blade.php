@extends('layouts.pengurusan.app')

@section('title', 'Daftar Tag')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                {{ Form::open(['route' =>['pengurusan.tags.store'],'id'=>'modalFormTag']) }}
                <div class="card-header d-flex p-2">
                    <div class="flex-grow-1">
                        <h6 class="my-1 mx-2 text-uppercase">@yield('title')</h6>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('pengurusan.tags._form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.tags.index')."'",'class'=>'btn bg-secondary']) }}
                    {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                <!-- /.card-footer -->
                {{ Form::close() }}
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
