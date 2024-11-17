@extends('layouts.pengurusan.blank')

@section('title', 'Daftar Maklumat Asas')

@section('content')

{{ Form::open(['route' =>['pengurusan.softscapes.record.store'],'id'=>'modalFormRekod']) }}
<div class="modal-header card-olive card-outline d-flex p-2">
    <div class="flex-grow-1">
        <h5 class="my-1 mx-2 text-uppercase">@yield('title')</h5>
    </div>
</div>
<!-- /.modal-header -->
<div class="modal-body">
    {{ Form::hidden('softscape_id',$softscape->id) }}
    @include('pengurusan.softscape.records._form')
</div>
<!-- /.modal-body -->
<div class="modal-footer">
    {{ Form::button('Batal', ['class'=>'btn btn-secondary','data-dismiss'=>'modal']) }}
    {!! Form::button('<i class="fas fa-save"></i> Daftar', ['class'=>'btn btn-success','type'=>'submit']) !!}
</div>
<!-- /.modal-footer -->
{{ Form::close() }}
@endsection
