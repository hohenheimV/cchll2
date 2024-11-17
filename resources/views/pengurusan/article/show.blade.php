@extends('layouts.pengurusan.blank')

@section('title', 'Butiran Artikel')
@section('close', 'Tutup')

@section('content')

<div class="modal-header card-olive card-outline p-2">
    <h5 class="modal-title">@yield('title')</h5>
    <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times-circle"></i>
    </button>

</div>
<div class="modal-body">
    <div class="card">
        @if ($article->page_image)
        <div class="embed-responsive embed-responsive-21by9">
            <img src="{{ $article->page_image ?? '' }}" class="embed-responsive-item" />
        </div>
        @endif
        <div class="card-body">
            <ul class="list-unstyled list-inline">
                <li class="list-inline-item text-muted"><i class="fa fa-calendar-check"></i> {{ $article->created_at->format('F d, Y') }}</li>
                <li class="list-inline-item text-muted"><i class="fa fa-user"></i> {{ $article->users->name }}</li>
                <li class="list-inline-item text-muted"><i class="fas fa-book"></i> {{ $article->category->name }}</li>
            </ul>
            <div class="body-content">
                {!! $article->content !!}
            </div>
        </div>
    </div>

</div>

@endsection
