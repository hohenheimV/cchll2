@extends('layouts.pengurusan.app')

@section('title', 'Daftar Artikel')

@section('content')
{{ Form::open(['route' =>['pengurusan.article.store']]) }}
<div class="row">
    @include('pengurusan.article._form')
</div>
{{ Form::close() }}
@endsection
