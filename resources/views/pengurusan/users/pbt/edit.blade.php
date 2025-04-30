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
                        <!-- <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    
                                    {!! Form::button('Kemaskini PBT<i class="fas fa-pencil-alt"></i>', [
                                    'class'=>'btn btn-warning btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.users.pbt.edit')."'"
                                    ]) !!}
                                   
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- /.card-header -->

                    {!! Form::model($user, ['route' => ['pengurusan.users.pbt.update', $user], 'method'=>'PATCH']) !!}

                    <div class="card-body">
                        @include('pengurusan.users.pbt._form')
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::button('Kembali',
                        ['onclick'=>"window.location='".route('pengurusan.users.profile.edit',$user)."'",'class'=>'btn btn-secondary']) !!}
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
