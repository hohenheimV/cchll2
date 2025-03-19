@extends('layouts.website.secondary')
@section('title', 'Blogs')

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

<section id="posts" class="bg-white pt-lg-5 pt-3 mib">
    <div class="container pt-lg-5">
        <h1 class="text-center text-capitalize">@yield('title')</h1>
        <div class="row">
            <div class="col-12 d-lg-none">
                <!-- Search Widget -->
                <div class="card mb-4">
                    {!! website_sidebar_search() !!}
                </div>
            </div>
            <!-- Post Content Column -->
            <div class="col-lg-8">
                @forelse ($articles as $article)
                <div class="card">
                    @if ($article->page_image)
                    <div class="embed-responsive embed-responsive-21by9">
                        <img src="{{ str_replace('10.28.203.150/tpbk', 'tpbk.jln.gov.my', $articles->page_image) }}" class="embed-responsive-item" />
                    </div>
                    @endif

                    <div class="card-body">
                        <h3>{!! $article->title !!}</h3>
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item text-muted"><i class="fa fa-calendar-check"></i> {{ $article->created_at->format('F d, Y') }}</li>
                            @if (isset($article->users))
                            <li class="list-inline-item text-muted"><i class="fa fa-user"></i> {{ $article->users->name }}</li>
                            @endif
                            @if (isset($article->category))
                            <li class="list-inline-item text-muted"><i class="fas fa-book"></i> {{ $article->category->name }}</li>
                            @endif
                        </ul>
                        <div class="body-content">
                            {!! $article->meta_description !!}
                        </div>
                        <a class="btn bg-olive font-weight-bold my-2" href="{{ url($article->type . '/' . $article->slug) }}">Baca lagi...</a>
                    </div>

                </div>
                @empty
                <h2 class="page-title">Nothing Found</h2>
                <p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
                @endforelse

                {{ $articles->links() }}
            </div>
            <!-- Sidebar Widgets Column -->
            @include('layouts.website.elements.sidebar-widgets')

        </div>
    </div>
</section>
<!-- /.section#posts -->
@endsection
