@extends('layouts.website.secondary')
@section('title', 'eMAP JLN')

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
<section id="posts" class="bg-white pt-5 mib2">
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 mt-5 d-lg-none mobile-gone">

                <!-- Search Widget -->
                <div class="card mb-4 d-none d-lg-block">
                    {!! website_sidebar_search() !!}
                </div>
            </div>
            <!-- Post Content Column -->
            <div class="col-12 col-lg-12">
                <div class="card card-olive card-outline">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold my-1">Taburan Pembangunan Projek Landskap di Malaysia</h3>
                        <div class="d-flex justify-content-end" role="group" aria-label="First group">
                            <a href="https://emap.jln.gov.my/arcgis/apps/storymaps/stories/a64ff694f21446a6a60414d0b71fb778" 
                            target="_blank" 
                            class="btn btn-info btn-sm">
                                Paparan Penuh
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <iframe src="https://emap.jln.gov.my/arcgis/apps/storymaps/stories/a64ff694f21446a6a60414d0b71fb778" width="100%" height="500px" frameborder="0" allowfullscreen allow="geolocation"></iframe>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
