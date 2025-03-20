@extends('layouts.website.secondary')
@section('title', $articles->title)

@section('content')

<style>
    :root {
        --ck-image-style-spacing: 1.5em;
    }

    #posts .body-content img {
        width: 100%;
    }

    #posts .body-content .image-style-side,
    #posts .body-content .image-style-align-left,
    #posts .body-content .image-style-align-center,
    #posts .body-content .image-style-align-right {
        max-width: 50%;
    }

    #posts .body-content .image-style-side {
        float: right;
        margin-left: var(--ck-image-style-spacing);
    }

    #posts .body-content .image-style-align-left {
        float: left;
        margin-right: var(--ck-image-style-spacing);
    }

    #posts .body-content .image-style-align-center {
        margin-left: auto;
        margin-right: auto;
    }

    #posts .body-content .image-style-align-right {
        float: right;
        margin-left: var(--ck-image-style-spacing);
    }

</style>

<section id="posts" class="bg-white pt-5 mib">
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 mt-5 d-lg-none mobile-gone">

                <!-- Search Widget -->
                <div class="card mb-4 d-none d-lg-block">
                    {!! website_sidebar_search() !!}
                </div>
            </div>
            @if ($articles->layout == 'left')
            @include('layouts.website.elements.sidebar-widgets')
            @endif
            <!-- Post Content Column -->
            <div class="col-12 {{ $articles->layout == 'full' ? 'col-lg-12':'col-lg-9' }}">
                <div class="card">
                    @if ($articles->page_image)
                    <div class="embed-responsive embed-responsive-21by9">
                        <img src="{{ str_replace('10.28.203.150/tpbk', 'tpbk.jln.gov.my', $articles->page_image) }}" class="embed-responsive-item" />
                    </div>
                    @endif

                    <div class="card-body">
                        <h1>{!! $articles->title !!}</h1>
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item text-muted"><i class="fa fa-calendar-check"></i> {{ $articles->created_at->format('F d, Y') }}</li>
                            @if($articles->users->name != 'Pentadbir Sistem Utama')
                            <li class="list-inline-item text-muted"><i class="fa fa-user"></i> {{ $articles->users->name }}</li>
                            @endif
                            <li class="list-inline-item text-muted"><i class="fas fa-book"></i> {{ $articles->category->name }}</li>
                            <li class="list-inline-item text-muted"><i class="fas fa-eye"></i> {{ $articles->visited() }}</li>
                        </ul>
                        <div class="body-content">
                            {!! str_replace('10.28.203.150/tpbk', 'tpbk.jln.gov.my', $articles->content) !!}
                        </div>
                    </div>

                </div>
            </div>
            @if ($articles->layout == 'right')
            @include('layouts.website.elements.sidebar-widgets')
            @endif
        </div>
    </div>
</section>
<!-- /.section#posts -->
<style>
    #related .card-body a {
        color: #1f2d3d !important
    }

    #related .card-body a:hover {
        color: #e83e8c !important;
    }

</style>
@if($relateds->count() > 0)
<section id="related" class="bg-olive">
    <div class="container py-5">
        <h2 class="mb-3 ">Artikel Berkaitan</h2>

        <div class="card-deck text-dark">
            @foreach ($relateds as $related)
            <div class="card">
                <img style="max-height: 180px;" src="{{ isset($related->page_image) ? url(str_replace('10.28.203.150/tpbk', 'tpbk.jln.gov.my', $related->page_image)) : asset('storage/img/bg-pattern-leaves.png') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <a href="{{ url($related->type . '/' . $related->slug)  }}">
                        <h5>{{ $related->title }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags(htmlspecialchars_decode($related->content)), 50) }}</p>
                    </a>
                </div>
            </div>
            @if ($loop->iteration == 2)
            <div class="w-100 d-lg-none"></div>
            @endif
            <?php $iterate = $loop->iteration; ?>

            @endforeach

            @for ($i = $iterate; $i < 4; $i++)
            <div class="card">
                <img style="max-height: 180px;" src="{{ asset('storage/img/bg-pattern-leaves.png') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <a href="#">
                        <h5>Artikel masih dalam proses kemaskini</h5>
                        <p class="card-text"></p>
                    </a>
                </div>
            </div>
            @endfor
        </div>

    </div>
</section>
@endif
<!-- /.section#sponsors -->
@endsection
