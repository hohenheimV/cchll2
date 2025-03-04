@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Maklumbalas')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {!! Form::model($MIB, ['route' => ['pengurusan.MIB.update', $MIB],
                'method'=>'PUT','id'=>'formFeedbacks','files' => true]) !!}
                <div class="card-body">
                    @include('pengurusan.MIB._form')

                    <div class="p-3 bg-gray">
                        <div class="form-row">
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    {{ Form::label('attachment', 'Dokumen Kelulusan') }}
                                    <div class="custom-file">
                                        {{ Form::file('attachment',['class'=>'form-control custom-file-input','id'=>'attachment']) }}
                                        <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
                                    </div>
                                    {!! Html::hasError($errors,'attachment') !!}
                                </div>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    {{ Form::label('response_at', 'Tarikh Tindakan') }}
                                {{ Form::text('response_at',$MIB->response_at?$MIB->response_at->format('d-m-Y g:m A') : null,
                                ['class' => 'form-control '.Html::isInvalid($errors,'response_at')]) }}
                                    {!! Html::hasError($errors,'response_at') !!}
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    {{ Form::label('status', 'Status') }}
                                    {{ Form::select('status', $status, null, ['placeholder' => '','class' => 'form-control notselect2']) }}
                                    {!! Html::hasError($errors,'status') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    {{ Form::label('notes', 'Catatan') }}
                                    {{ Form::textarea('notes',null,['rows'=>6,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'notes')]) }}
                                    {!! Html::hasError($errors,'notes') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.MIB.index')."'",
                    'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                <!-- /.card-footer -->
                {{ Form::close() }}
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
