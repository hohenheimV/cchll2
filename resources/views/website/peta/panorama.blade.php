@extends('layouts.pengurusan.blank')

@section('title', 'Panorama')

@section('content')
<!-- /.modal-header -->
<div class="modal-header bg-gradient-olive d-flex p-2">
    <div class="flex-grow-1">
        <h5 class="my-1 mx-2 text-uppercase">@yield('title')</h5>
    </div>
    <div>{{ Form::button('<i class="fas fa-times-circle"></i>', ['class'=>'btn bg-dark m-1','data-dismiss'=>'modal']) }}</div>
</div>
<div class="modal-body p-0">
    <div id="photosphere"></div>
</div>
<!-- /.modal-body -->
@endsection
