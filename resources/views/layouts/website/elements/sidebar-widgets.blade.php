<style>
    .left-aligned-list {
        padding-left: 1.25rem;
        list-style-type: disc;
        list-style-position: outside;
    }
</style>

<!-- Sidebar Widgets Column -->
<div class="col-lg-3">

    <!-- Search Widget -->
    {{--<div class="card mb-4 d-none d-lg-block">
        {!! website_sidebar_search() !!}
    </div>--}}


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

    @if(isset($eLIND))
        <div class="card my-4">
            <h5 class="card-header">Penggiat Industri Landskap</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <ul class="left-aligned-list"> <!-- This keeps bullets and indents list nicely -->
                        <li><a href="https://www.eperolehan.gov.my/" target="_blank">ePerolehan</a></li>
                        <li><a href="https://www.ssm.com.my/Pages/e-Search.aspx" target="_blank">Carian No. SSM</a></li>
                        <li><a href="https://mcp.cidb.gov.my/MCP/ContractorSearch" target="_blank">Carian Kontraktor CIDB</a></li>
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
</div>
