@extends('layouts.pengurusan.app')

@php
    $lastSegment = Request::segment(3);
    $capitalizedSegment = ucfirst($lastSegment);
    if ($capitalizedSegment == 'Pendidikan') {
        $capitalizedSegment = 'Institusi Pendidikan';
    }else if ($capitalizedSegment == 'Ngo') {
        $capitalizedSegment = 'NGO / Badan Ikhtisas';
    }else if ($capitalizedSegment == 'Antarabangsa') {
        $capitalizedSegment = 'Pertubuhan Antarabangsa';
    }
@endphp

@section('title', 'Kemaskini Maklumat ' . $capitalizedSegment)
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

                    {!! Form::model($eLIND, ['route' => ['pengurusan.eLIND.update', 'type' => $lastSegment, 'id' => $eLIND], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    <div class="card-body">
                        @include('pengurusan.eLIND._form')
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        {!! Form::button('Batal dan Kembali',
                        ['onclick'=>"window.location='".route('pengurusan.eLIND.index', ['type' => $lastSegment])."'",'class'=>'btn btn-secondary']) !!}
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
