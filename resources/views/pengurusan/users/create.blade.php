@extends('layouts.pengurusan.app')

@section('title', 'Daftar')

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

                    {!! Form::open(['route' => 'pengurusan.users.store']) !!}

                    <div class="card-body">
                        @include('pengurusan.users._form')
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::button('Kembali',
                        ['onclick'=>"window.location='".route('pengurusan.users.index')."'",'class'=>'btn btn-secondary']) !!}
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
