@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini')

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

                    {!! Form::model($user, ['route' => ['pengurusan.eLIND.profile.update', $user], 'method'=>'PATCH']) !!}

                    <div class="card-body">
                        @include('pengurusan.eLIND.profile._form')
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::button('Batal dan Kembali',
                        ['onclick'=>"window.location='".route('pengurusan.eLIND.profile.show',$user)."'",'class'=>'btn btn-secondary']) !!}
                        {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
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
