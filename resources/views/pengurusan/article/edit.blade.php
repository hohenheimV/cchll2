@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Artikel')

@section('content')
{!! Form::model($article, ['route' => ['pengurusan.article.update', $article], 'method'=>'PUT']) !!}
<div class="row">
    @include('pengurusan.article._form')
</div>
{{ Form::close() }}
@endsection
