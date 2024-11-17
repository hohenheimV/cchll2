@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Page')

@section('content')
{!! Form::model($page, ['route' => ['pengurusan.page.update', $page], 'method'=>'PUT']) !!}
<div class="row">
    @include('pengurusan.page._form')
</div>
{{ Form::close() }}
@endsection
