@extends('layouts.website.secondary')
@section('title', 'Aktiviti')

@section('content')
<section id="posts" class="bg-white pt-5">
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 mt-5 d-lg-none">
                <!-- Search Widget -->
                <div class="card mb-4 d-none d-lg-block">
                    {!! website_sidebar_search() !!}
                </div>
            </div>
            <!-- Post Content Column -->
            <div class="col-12">
                <h1 class="text-center text-capitalize">@yield('title')</h1>
                <div class="card my-4">
                    <h5 class="card-header">Butiran Permohonan</h5>
                    <div class="card-body">
                        <!--Muat Turun Borang Permohonan Disini<a class="btn bg-olive" href="{{ route('website.activities.borang') }}">Muat Turun</a>-->
                        <p><li>Pemohon perlu melengkapkan borang dan mematuhi senarai semak seperti berikut :</li></p>
                        <ol type="i">
                            <li>Borang Permohonan Yang Telah Lengkap Diisi</li>
                            <li>Surat Permohonan Rasmi</li>
                            <li>Jadual Program/Aktiviti</li>
							<li>Senarai Maklumat Peserta</li>
                            
                        </ol>
						<li>Mematuhi Syarat-syarat Khas Dan Am Taman Persekutuan Bukit Kiara (Lampiran A)<a class="btn bg-olive" href="{{ route('website.activities.borang') }}" target="_blank">Lihat</a></li>
                    </div>
                </div>

                @include('website.activities._form')
            </div>
            <!-- Sidebar Widgets Column -->
            {{-- @include('layouts.website.elements.sidebar-widgets') --}}

        </div>
    </div>
</section>
<!-- /.section#posts -->

<!-- /.section#sponsors -->
@endsection
