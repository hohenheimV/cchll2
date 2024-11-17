@extends('layouts.website.secondary')
@section('title', 'VTour Bukit Kiara')

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
    #posts .card-body .vr-tm{
        height: calc(100vh - 200px);
    }



</style>

<section id="posts" class="bg-white pt-5">
    <div class="container-fluit">

        <div class="row pt-5">

            <!-- Post Content Column -->
            <div class="col-12 col-lg-12">
                <div class="card">


                    <div class="card-body p-0">
                        <embed type="text/html" src="https://tpbk.jln.gov.my/vtour/index.html"  width="100%" class="vr-tm">
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
