@extends('layouts.website.secondary')
@section('title', 'Konsultasi Awam')

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
            <div class="col-12 mt-5 d-lg-none">

                <!-- Search Widget -->
                <div class="card mb-4 d-none d-lg-block">
                    {!! website_sidebar_search() !!}
                </div>
            </div>
            <!-- Post Content Column -->
            <div class="col-lg-8">
                @foreach ($articles as $article)
                <div class="card">
                    @if ($article->page_image)
                    <div class="embed-responsive embed-responsive-21by9">
                        <img src="{{ str_replace('10.28.203.150/tpbk', 'tpbk.jln.gov.my', $article->page_image) }}" class="embed-responsive-item" />
                    </div>
                    @endif

                    <div class="card-body">
                        <h3>{!! $article->title !!}</h3>
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item text-muted"><i class="fa fa-calendar-check"></i> {{ $article->created_at->format('F d, Y') }}</li>
                            <li class="list-inline-item text-muted"><i class="fa fa-user"></i> {{ $article->users->name }}</li>
                            <li class="list-inline-item text-muted"><i class="fas fa-book"></i> {{ $article->category->name }}</li>
                        </ul>
                        <div class="body-content">
                            {!! $article->meta_description !!}
                        </div>
                        <a class="btn bg-olive font-weight-bold my-2" href="{{ url($article->type . '/' . $article->slug) }}">Baca lagi...</a>
                    </div>

                </div>
                @endforeach

                {{ $articles->links() }}
            </div>
            <!-- Sidebar Widgets Column -->
            @include('layouts.website.elements.sidebar-widgets')

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

<!-- /.section#sponsors -->
@endsection
