@extends('layouts.pengurusan.app')

@section('title', 'Pengurusan Kawalan')

@section('content')
<section class="content">

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col">

                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                    </div>
                    <!-- /.card-header -->

                    {!! Form::open(['route' => 'pengurusan.permissions.store']) !!}

                    <div class="card-body">
                        @include('pengurusan.permissions._form')
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    @foreach (['list','create','edit','delete'] as $key => $role)
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        {{ Form::checkbox('crud[]', $role, false, ['class'=>'custom-control-input','id' => "checkbox-".$key]) }}
                                        <label class="custom-control-label text-capitalize" for="checkbox-{{$key}}">{{$role}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::button('Kembali',
                        ['onclick'=>"window.location='".route('pengurusan.permissions.index')."'",'class'=>'btn btn-secondary']) !!}
                        {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                    </div>
                    <!-- /.card-footer -->

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>
    <!--/. container-fluid -->

</section>

@endsection
