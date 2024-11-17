@extends('layouts.pengurusan.app')

@section('title', 'Daftar Page')

@section('content')
{{ Form::open(['route' =>['pengurusan.page.store']]) }}
<div class="row">
    @include('pengurusan.page._form')
</div>
{{ Form::close() }}
@endsection
