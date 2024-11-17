<!-- Sidebar Widgets Column -->
<div class="col-lg-4">

    <!-- Search Widget -->
    <div class="card mb-4 d-none d-lg-block">
        {!! website_sidebar_search() !!}
    </div>

    <!-- Categories Widget -->
    {{-- <div class="card my-4">
        <h5 class="card-header">Kategori</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!! website_sidebar_category() !!}
                </div>
            </div>
        </div>
    </div> --}}
     <!-- Categories Widget -->
     <div class="card my-4 border border-success">
        <h5 class="card-header bg-olive">Hubungi Kami</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {!! website_sidebar_contact() !!}
                </div>
            </div>
        </div>
    </div>
</div>
