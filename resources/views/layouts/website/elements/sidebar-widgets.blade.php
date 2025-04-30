<!-- Sidebar Widgets Column -->
<div class="col-lg-3">

    <!-- Search Widget -->
    {{--<div class="card mb-4 d-none d-lg-block">
        {!! website_sidebar_search() !!}
    </div>--}}

    @if(isset($eLIND))
        <div class="card my-4">
            <h5 class="card-header">Kategori</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li><a href="../penggiat-industri/kontraktor" target="_self">Kontraktor</a></li>
                            <li><a href="../penggiat-industri/perunding" target="_self">Perunding</a></li>
                            <li><a href="../penggiat-industri/pembekal" target="_self">Pembekal</a></li>
                            <li><a href="../penggiat-industri/antarabangsa" target="_self">Pertubuhan Antarabangsa</a></li>
                            <li><a href="../penggiat-industri/ngo" target="_self">NGO &amp; Badan Ikhtisas</a></li>
                            <li><a href="../penggiat-industri/pendidikan" target="_self">Institusi Pendidikan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif


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
     <div class="card mobile-gone">
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
