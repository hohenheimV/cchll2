@extends('layouts.pengurusan.app')

@section('title', 'Daftar Maklumbalas')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {{ Form::open(['route' =>['pengurusan.feedbacks.store'],'id'=>'formFeedbacks','files' => true]) }}
                <div class="card-body">
                    @include('pengurusan.feedbacks._form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {!! Form::button('Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.feedbacks.index')."'",
                    'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                <!-- /.card-footer -->
                {{ Form::close() }}
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
