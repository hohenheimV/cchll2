@extends('layouts.pengurusan.app')

@section('title', 'Daftar eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                    <div class="d-flex justify-content-end" role="group" aria-label="First group">
                        {!! Form::button('Informasi&nbsp;&nbsp;&nbsp;<i class="fas fa-info"></i>', [
                            'class'=>'btn btn-success btn-sm',
                            'data-toggle'=>'modal','data-target'=>'#pelanModal',
                        ]) !!}
                        &nbsp;
                    </div>
                </div>

                {{ Form::open(['route' =>['pengurusan.eLAPS.store'], 'enctype'=>'multipart/form-data']) }}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.eLAPS._form')

                    <!-- @include('pengurusan.eLAPS._upload') -->
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.eLAPS.index')."'",'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
