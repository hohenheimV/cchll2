@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Aktiviti')

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {!! Form::model($activity, ['route' => ['pengurusan.activities.update', $activity],
                'method'=>'PUT','id'=>'modalFormAktiviti','files' => true]) !!}
                <div class="card-body">
                    @include('pengurusan.activities._form')

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
                        @if (Auth::user()->hasAnyRole(['Pentadbir Sistem','KP/ TKP JLN']))
                            <div class="col-6 col-md-2">
                                <div class="form-group">
                                    {{ Form::label('approved_at', 'Tarikh Kelulusan') }}
                                    {{ Form::text('approved_at',null,['class' => 'form-control '.Html::isInvalid($errors,'approved_at')]) }}
                                    {!! Html::hasError($errors,'approved_at') !!}
                                </div>
                            </div>
                            @endif
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    {{ Form::label('status', 'Status') }}
                                    {{ Form::select('status', $status, null, ['placeholder' => '','class' => 'form-control notselect2']) }}
                                    {!! Html::hasError($errors,'status') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-6 col-md-6">
                                <div class="form-group">

                                    @if (Auth::user()->hasRole('Pengurus Taman'))

                                        {{ Form::label('note_officer_lvl_1', 'Catatan Pengurus Taman') }}
                                        {{ Form::textarea('note_officer_lvl_1',null,['rows'=>5,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'note_officer_lvl_1')]) }}
                                        {!! Html::hasError($errors,'note_officer_lvl_1') !!}
                                    @elseif(Auth::user()->hasRole('Pengarah Taman'))

                                        {{ Form::label('note_officer_lvl_2', 'Catatan Pengarah Taman') }}
                                        {{ Form::textarea('note_officer_lvl_2',null,['rows'=>5,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'note_officer_lvl_2')]) }}
                                        {!! Html::hasError($errors,'note_officer_lvl_2') !!}
                                    @elseif(Auth::user()->hasRole('KP/ TKP JLN'))

                                        {{ Form::label('note_officer_lvl_3', 'Catatan KP/ TKP JLN') }}
                                        {{ Form::textarea('note_officer_lvl_3',null,['rows'=>5,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'note_officer_lvl_3')]) }}
                                        {!! Html::hasError($errors,'note_officer_lvl_3') !!}
                                    @else
                                        {{ Form::label('notes', 'Catatan') }}
                                        {{ Form::textarea('notes',null,['rows'=>5,'placeholder'=>'Sila masukkan Catatan Permohonan','class' => 'form-control '.Html::isInvalid($errors,'notes')]) }}
                                        {!! Html::hasError($errors,'notes') !!}
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {!! Form::button('Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.activities.index')."'",
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
