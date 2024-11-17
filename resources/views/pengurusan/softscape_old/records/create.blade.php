@extends('layouts.pengurusan.app')

@section('title', 'Daftar Maklumat Asas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    @include('pengurusan.softscape._pill_nav')
                </div>
                {{ Form::open(['route' =>['pengurusan.softscapes.record.store'],'id'=>'modalFormRekod']) }}
                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('title') </h5>
                        <div class="py-1">
                            {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.softscapes.record.index',$softscape)."'",'class'=>'btn btn-secondary']) !!}
                            {!! Form::button('<i class="fas fa-save"></i> Simpan', ['class'=>'btn btn-success','type'=>'submit']) !!}
                        </div>
                    </div>
                    @include('pengurusan.softscape.records._form')
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.softscapes.record.index',$softscape)."'",'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Simpan', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
