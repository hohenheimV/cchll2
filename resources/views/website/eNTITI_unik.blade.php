@extends('layouts.website.secondary')
@section('title', $unik->nama_entiti)

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
    @php
        $arrChanges = [];
    @endphp
    <section id="posts" class="bg-white pt-5 mib2">
        <div class="container pt-5">

            <div class="row">
                <!-- Post Content Column -->
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-olive card-outline">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold my-1">Direktori Entiti Landskap</h3>
                                    <div class="card-tools">
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="{{ route('website.eNTITI') }}" class="btn btn-secondary py-1 px-3" style="font-size: 0.9rem;">Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::model($unik) !!}
                                <div class="card-body table-hardscape form-hardscape text-sm">
                                    <div class="row">
                                        <div class="form-group required col-md-12">
                                            <h2 class="row justify-content-center">
                                                {{ ucwords(strtolower($unik->nama_entiti)) ?? 'Sedang dikemaskini' }}
                                            </h2>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group required col-md-12">

                                            @php
                                                $imageFields = [];
                                                if(isset($unik->gambar)){
                                                    $folderName = str_replace(' ', '_', $unik->id.' '.$unik->nama_entiti);
                                                    $gambarData = json_decode($unik->gambar, true);
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        $key1 = "gambar_input_modal_$i";
                                                        $img = $gambarData[$key1] ?? null;
                                                        if ($img) {
                                                            $imageFields[] = $folderName . '/' . $img;
                                                        }
                                                    }
                                                } else {
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        $imageFields[$i] = null;
                                                    }
                                                }
                                                // dd($imageFields);
                                            @endphp

                                            <style>
                                                .thumbnail-nav {
                                                    display: flex;
                                                    justify-content: center;
                                                    flex-wrap: wrap;
                                                    margin-top: 15px;
                                                    gap: 10px;
                                                }

                                                .thumbnail-nav img {
                                                    width: 50px;
                                                    height: 50px;
                                                    object-fit: cover;
                                                    border: 0.25px solid black;
                                                    cursor: pointer;
                                                    border-radius: 4px;
                                                    transition: border 0.2s ease;
                                                }

                                                .thumbnail-nav img.active-thumb {
                                                    /* border-color: rgb(49, 213, 200); */
                                                    border: 2px solid rgb(49, 213, 200) !important;
                                                }

                                                .carousel-item img {
                                                    height: 450px;
                                                    object-fit: cover;
                                                    cursor: zoom-in;
                                                    border: 1px solid rgb(49, 213, 200) !important;
                                                }
                                            </style>

                                            @if (collect($imageFields)->filter()->isEmpty())
                                                <p class="text-center">Tiada gambar taman dimuat naik.</p>
                                            @else
                                            <div id="parkCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                                                <div class="carousel-inner">
                                                    @foreach ($imageFields as $i => $img)
                                                            @php
                                                                // $imagePath = asset('storage/uploads/entiti_landskap/' . $img);
                                                                $imagePath = $img ? asset('storage/uploads/entiti_landskap/' . $img) : null;
                                                            @endphp
                                                        @if ($imagePath)
                                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" {{ $imagePath ? '' : 'style=display:none;' }}>
                                                                <img src="{{ $imagePath }}" class="d-block w-100 park-img-slide" alt="Image {{ $i }}" data-full="{{ $imagePath }}">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#parkCarousel" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                </a>
                                                <a class="carousel-control-next" href="#parkCarousel" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                </a>
                                            </div>

                                            <div class="thumbnail-nav">
                                                @foreach ($imageFields as $i => $img)
                                                        @php
                                                            // $imagePath = asset('storage/uploads/entiti_landskap/' . $img);
                                                            $imagePath = $img ? asset('storage/uploads/entiti_landskap/' . $img) : null;
                                                        @endphp
                                                    @if ($imagePath)
                                                        <img src="{{ $imagePath }}" {{ $imagePath ? '' : 'style=display:none;' }} alt="Thumbnail {{ $i }}" class="thumb-img" data-target="#parkCarousel" data-slide-to="{{ $loop->index }}">
                                                    @endif
                                                @endforeach
                                            </div>

                                            <!-- Modal for full image view -->
                                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-0">
                                                            <img id="modalImage" src="" class="img-fluid w-100" alt="Full Size Image">
                                                        </div>
                                                        <div class="modal-footer py-2">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                document.addEventListener("DOMContentLoaded", function () {
                                                    // Full image modal
                                                    document.querySelectorAll(".park-img-slide").forEach(img => {
                                                        img.addEventListener("click", function () {
                                                            const fullImg = this.getAttribute("data-full");
                                                            document.getElementById("modalImage").src = fullImg;

                                                            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                                                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                                                                modal.show();
                                                            } else {
                                                                $('#imageModal').modal('show');
                                                            }
                                                        });
                                                    });

                                                    // Thumbnail click active styling
                                                    const thumbs = document.querySelectorAll(".thumb-img");
                                                    thumbs.forEach((thumb, idx) => {
                                                        thumb.addEventListener("click", () => {
                                                            thumbs.forEach(t => t.classList.remove("active-thumb"));
                                                            thumb.classList.add("active-thumb");
                                                        });
                                                    });

                                                    // Optional: Mark the first thumb as active on load
                                                    if (thumbs.length > 0) {
                                                        thumbs[0].classList.add("active-thumb");
                                                    }

                                                    // Optional: Sync active thumb on slide change
                                                    $('#parkCarousel').on('slide.bs.carousel', function (e) {
                                                        thumbs.forEach(t => t.classList.remove("active-thumb"));
                                                        thumbs[e.to].classList.add("active-thumb");
                                                    });
                                                });
                                            </script>
                                            @endif
                                        </div>
                                    </div>
                                    <h5>Nama Entiti :</h5>
                                    <p id="">{{ $unik->nama_entiti ?? 'Sedang dikemaskini' }}</p>
                                    <br>
                                    <h5>Keterangan :</h5>
                                    <p id="modalKeterangan">{{ $unik->keterangan ?? 'Sedang dikemaskini' }}</p>
                                    <br>
                                    @php
                                        if(isset($unik->pbt)){
                                            $dataPbt = json_decode($unik->pbt, true);
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
                                    {{-- <h5>Pihak Berkuasa Tempatan :</h5>
                                    <p id="modalKeterangan">{{ isset($pbt) ? $pbt : $unik->pbt ?? 'Sedang dikemaskini' }}</p>
                                    <br> --}}
                                    <div class="row">
                                        <div class="col-12 col-md-3"><h5>Negeri :</h5></div>
                                        <div class="col-12 col-md-3"><p id="">{{ isset($negeri) ? $negeri : 'Sedang dikemaskini' }}</p></div>

                                        <div class="col-12 col-md-3"><h5>Pihak Berkuasa Tempatan :</h5></div>
                                        <div class="col-12 col-md-3"><p id="modalKeterangan">{{ isset($pbt) ? ucwords(strtolower($pbt)) : ucwords(strtolower($unik->pbt)) ?? 'Sedang dikemaskini' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3"><h5>Lokasi :</h5></div>
                                        <div class="col-12 col-md-3"><p id="">{{ ucwords(strtolower($unik->lokasi)) ?? 'Sedang dikemaskini' }}</p></div>

                                        <div class="col-12 col-md-3"><h5>Koordinat :</h5></div>
                                        <div class="col-12 col-md-3">
                                            {{--
                                            <p id="modalCoordinate">
                                                {{ is_numeric($unik->lng) && is_numeric($unik->lat) ? '( '.$unik->lng.', '.$unik->lat.' )' : 'Sedang dikemaskini' }}
                                                @if(is_numeric($unik->lng) && is_numeric($unik->lat))
                                                &nbsp;<br>
                                                <a href="{{ 'https://maps.google.com/?q='.$unik->lat.','.$unik->lng }}" target="_blank">
                                                    Pautan Google Map <i class="fas fa-globe"></i>
                                                </a>
                                                @endif
                                            </p>
                                            --}}
                                            <p id="modalCoordinate">
                                            @if(is_numeric($unik->lng) && is_numeric($unik->lat))
                                                <a href="https://maps.google.com/?q={{ $unik->lat }},{{ $unik->lng }}" target="_blank">
                                                    <i class="fas fa-globe"></i>
                                                    ( {{ round($unik->lng, 6) }}, {{ round($unik->lat, 6) }} )
                                                </a>
                                            @else
                                                Sedang dikemaskini
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-12 col-md-3"><h5>Lokasi :</h5></div>
                                        <div class="col-12 col-md-3"><p id="">{{ $unik->lokasi ?? 'Sedang dikemaskini' }}</p></div>

                                        <div class="col-12 col-md-3"><h5>Koordinat Taman :</h5></div>
                                        <div class="col-12 col-md-3">
                                            <p id="modalCoordinate">
                                                {{ is_numeric($unik->lng) && is_numeric($unik->lat) ? '( '.$unik->lat.', '.$unik->lng.' )' : 'Sedang dikemaskini' }}
                                                @if(is_numeric($unik->lng) && is_numeric($unik->lat))
                                                &nbsp;<br>
                                                <a href="{{ 'https://maps.google.com/?q='.$unik->lat.','.$unik->lng }}" target="_blank">
                                                    Pautan Google Map <i class="fas fa-globe"></i>
                                                </a>
                                                @endif
                                            </p>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="card-footer">
                                <a href="{{ route('website.eNTITI') }}" class="btn btn-secondary py-1 px-3" style="font-size: 0.9rem;">Kembali</a>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @include('layouts.website.elements.sidebar-widgets') --}}
            </div>
        </div>

    </section>
    <!-- /.section#posts -->

@endsection



