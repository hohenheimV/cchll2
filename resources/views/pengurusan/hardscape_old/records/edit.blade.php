@extends('layouts.pengurusan.blank')

@section('title', 'Kemaskini Maklumat Asas')

@section('content')

{!! Form::model($record, ['route' => ['pengurusan.softscapes.record.update', $record], 'method'=>'PUT','id'=>'modalFormRekod']) !!}
<div class="modal-header card-olive card-outline d-flex p-2">
    <div class="flex-grow-1">
        <h5 class="my-1 mx-2 text-uppercase">@yield('title')</h5>
    </div>
</div>
<!-- /.modal-header -->
<div class="modal-body">
    @include('pengurusan.softscape.records._form')
</div>
<!-- /.modal-body -->
<div class="modal-footer">
    {{ Form::button('Batal', ['class'=>'btn btn-secondary','data-dismiss'=>'modal']) }}
    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
</div>
<!-- /.modal-footer -->
{!! Form::close() !!}
@endsection
