@extends('layouts.website.secondary')
@section('title', 'Direktori Entiti Landskap ')

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
        .mib {
            background-color:rgb(25, 98, 92) !important;
            background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}");
            /* background-image: url("https://www.transparenttextures.com/patterns/flowers.png"); */
        }

    </style>

    <section id="posts" class="bg-white pt-5 mib2">
        <div class="container pt-5">

            <div class="row">
                <div class="col-12 mt-5 d-lg-none">

                    <!-- Search Widget -->
                    <div class="card mb-4 d-none d-lg-block">
                        {!! website_sidebar_search() !!}
                    </div>
                </div>
                <!-- Post Content Column -->
                <div class="col-12 col-lg-9">
                    <div class="card card-olive card-outline">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold my-1">Direktori Entiti Landskap </h3>
                        </div>

                        <div class="card-body">
                            <div class="body-content">
                                <div class="table-responsive">
                                    <style>
                                        table th {
                                            text-align: center;
                                            padding: 2px 5px !important;
                                        }
                                        table td {
                                            padding: 2px 5px !important;
                                            height: 15px;
                                        }
                                        
                                    </style>
                                    <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0">
                                        <thead style="background-color:rgb(0, 0, 0) !important;color: white;">
                                            <tr>
                                                <th class="w-1">Bil.</th>
                                                <th class="w-15">Nama Entiti Landskap </th>
                                                <th class="w-3">Lokasi</th>
                                                <th class="text-center w-5">Pihak Berkuasa Tempatan</th>
                                                <th class="text-center w-1">Tindakan</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = $unik->firstItem();
                                            @endphp
                                            @if($unik->isNotEmpty())
                                                @foreach($unik as $entiti)
                                                    @php
                                                        if(isset($entiti->pbt)){
                                                            $dataPbt = json_decode($entiti->pbt, true);
                                                            if ($dataPbt === null) {
                                                                $dataPbt = [];
                                                            } elseif (!is_array($dataPbt)) {
                                                                $dataPbt = (string) $dataPbt;
                                                            }else{
                                                                $negeri = $dataPbt['negeri'];
                                                                $pbt = $dataPbt['pbt'];
                                                            }
                                                        } else {
                                                            $dataPbt = [];
                                                        }
                                                        //dd($dataPbt);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ (ucwords(strtolower($entiti->nama_entiti) ?? 'Tiada Maklumat')) }}</td>
                                                        <td>{{ (ucwords(strtolower($entiti->lokasi) ?? 'Tiada Maklumat')) }}</td>
                                                        <td>{{ isset($pbt) ? (ucwords(strtolower($pbt))) : 'Tiada Maklumat' }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a target="_self" class="btn bg-success btn-sm mr-1" href="/entiti-landskap/{{ $entiti->slug }}"><i class="fas fa-search"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr><td colspan="5" class="text-center">No data available</td></tr>
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                                @if(count($unik) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($unik) !!}
                                    </div>
                                    <!-- /.card-footer -->
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                @include('layouts.website.elements.sidebar-widgets')
            </div>
        </div>
    </section>
    <!-- /.section#posts -->

@endsection



