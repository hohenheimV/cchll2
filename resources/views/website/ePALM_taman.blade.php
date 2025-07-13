@extends('layouts.website.secondary')
@section('title', $ePALM->nama_taman)

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
                                <!-- <div class="card-header">
                                    <h5 class="card-title font-weight-bold">@yield('title')</h5>
                                    <div class="card-tools">
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                {!! Form::button('Kembali', ['onclick' => "window.location='" . route('website.epalm') . "'", 'class' => 'btn btn-secondary']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold my-1">Direktori Taman & Landskap</h3>
                                    <div class="card-tools">
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="{{ route('website.epalm') }}" class="btn btn-secondary py-1 px-3" style="font-size: 0.9rem;">Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::model($ePALM) !!}
                                <div class="card-body table-hardscape form-hardscape text-sm">
                                    <div>
                                        <div class="row">
                                            <div class="form-group required col-md-12">
                                                <h2 class="row justify-content-center">
                                                    {{ $ePALM->nama_taman }}
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="bg-white">
                                            {{-- @php
                                                $imageFields = [];
                                                if(isset($ePALM->gambar_taman)){
                                                    $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
                                                    $rootFolder = str_replace(' ', '_', $ePALM->nama_pbt);
                                                    $gambar_tamanData = json_decode($ePALM->gambar_taman, true);

                                                    for ($i = 1; $i <= 6; $i++) {
                                                        $fieldKeyX = "XGIM_$i";
                                                        $fieldKeyX2 = "Xgambar_input_modal_$i";
                                                        //dump($fieldKeyX);
                                                        //dump($fieldKeyX2);
                                                        //dump(isset($gambar_tamanData["XGIM_$i"]) ? $folderName . '/' . $gambar_tamanData["XGIM_$i"] : 'des');
                                                        //dump((isset($gambar_tamanData[$fieldKeyX2]) ? $folderName . '/' . $gambar_tamanData[$fieldKeyX2] : 'qdes'));
                                                        $imageFields[$fieldKeyX] = isset($gambar_tamanData["XGIM_$i"]) ? $folderName . '/' . $gambar_tamanData["XGIM_$i"] : (isset($gambar_tamanData[$fieldKeyX2]) ? $folderName . '/' . $gambar_tamanData[$fieldKeyX2] : null);
                                                    }
                                                    //dd($gambar_tamanData);
                                                }else{
                                                    for ($i = 1; $i <= 6; $i++) {
                                                        $fieldKey = "XGIM_$i";
                                                        $imageFields[$fieldKey] = null;
                                                    }
                                                }
                                            @endphp
                                            <style>
                                                .grid-container {
                                                    display: grid;
                                                    grid-template-columns: repeat(3, 1fr);
                                                    gap: 10px;
                                                    width: 500px;         /* Fixed width */
                                                    height: 450px;        /* Fixed height */
                                                    margin: 0 auto;
                                                    box-sizing: border-box;
                                                    /* overflow: hidden; */
                                                }


                                                /* Grid item styling */
                                                .grid-item {
                                                    display: flex;
                                                    flex-direction: column;
                                                    align-items: center;
                                                    justify-content: space-between;
                                                    text-align: center;
                                                    border: 1px solid #ddd;
                                                    background-color: lightgray;
                                                    padding: 10px;
                                                    box-sizing: border-box;
                                                    overflow: hidden; /* Prevent overflowing content */
                                                }

                                                /* Image preview container */
                                                .image-preview-container {
                                                display: grid;
                                                place-items: center; /* Center both horizontally and vertically */
                                                width: 100%;
                                                height: 100%;
                                                overflow-y: auto;
                                                }

                                                .image-preview-container img {
                                                width: 250px;
                                                max-height: 150px;
                                                height: auto;
                                                object-fit: cover;
                                                border-radius: 5px;
                                                border: 0px solid #ddd;
                                                padding: 2px;
                                                }

                                                /* File input button styling */
                                                .form-control-file {
                                                    padding: 5px;
                                                    font-size: 12px;
                                                    width: 100%;
                                                    height: 30px;
                                                    border-radius: 4px;
                                                    background-color: #f7f7f7;
                                                    border: 1px solid #ccc;
                                                    cursor: pointer;
                                                }
                                                @media only screen and (max-width: 768px) {
                                                    .grid-container {
                                                        display: grid;
                                                        grid-template-columns: 1fr 1fr ; /* 2 equal-width columns */
                                                        gap: 10px; /* Space between grid items */
                                                        width: 300px;
                                                        max-width: 600px;  /* Limit max width for the grid */
                                                        margin: 0 auto; /* Centers the grid container horizontally */
                                                        height: auto; /* Allow the height to adjust based on content */
                                                    }
                                                    .image-preview-container img {
                                                        width: 200px; /* Adjust the width as needed */
                                                        height: 100px; /* Adjust the height as needed */
                                                        object-fit: cover;
                                                        border-radius: 10px;
                                                        border: 0px solid #ddd;
                                                        padding: 2px;
                                                    }
                                                }
                                                @keyframes blink2 {
                                                    0% {
                                                        border-color: #008000;
                                                    }
                                                    50% {
                                                        border-color: transparent;
                                                    }
                                                    100% {
                                                        border-color: #008000;
                                                    }
                                                }
                                                .park-images {
                                                    display: flex;
                                                    justify-content: center;
                                                    gap: 10px;
                                                    margin-top: 10px;
                                                }

                                                .park-images2 {
                                                    display: flex;
                                                    justify-content: center;
                                                    gap: 10px;
                                                    margin-top: 10px;
                                                }

                                                .park-img {
                                                    width: 250px;
                                                    height: 250px;
                                                    border-radius: 8px;
                                                    border: 0.5px solid black;
                                                }

                                                /* For mobile view (screens smaller than 768px) */
                                                @media (max-width: 767px) {
                                                    .park-img {
                                                        width: 100px; /* Reduce image size */
                                                        height: 100px; /* Maintain aspect ratio */
                                                    }

                                                    .park-images {
                                                        justify-content: space-between;
                                                        flex-wrap: wrap; /* Ensure the images wrap to the next line */
                                                    }
                                                }

                                                /* For tablet and larger view (screens 768px and above) */
                                                @media (min-width: 768px) and (max-width: 1024px) {
                                                    .park-img {
                                                        width: 195px; /* Keep the original size */
                                                        height: 195px;
                                                    }
                                                    .park-images {
                                                        flex-wrap: wrap;
                                                    }
                                                }
                                            </style>

                                            <div class="park-images2">
                                                @for ($i = 1; $i <= 3; $i++)
                                                @if(1 || isset($imageFields['XGIM_'.$i]))
                                                    <img id="{{ isset($imageFields['XGIM_'.$i]) ? 'preview_'.$i : 'nopreview_'.$i }}" 
                                                        src="{{ isset($imageFields['XGIM_'.$i]) ? asset('storage/uploads/ePALM/' . $imageFields['XGIM_'.$i]) : asset('storage/uploads/no-photos.png') }}" 
                                                        alt="Park Image {{ $i }}" 
                                                        class="park-img clickable-preview" 
                                                        style="border: 0.5px solid black;">
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="park-images2">
                                                @for ($i = 4; $i <= 6; $i++)
                                                @if(1 || isset($imageFields['XGIM_'.$i]))
                                                    <img id="{{ isset($imageFields['XGIM_'.$i]) ? 'preview_'.$i : 'nopreview_'.$i }}" 
                                                        src="{{ isset($imageFields['XGIM_'.$i]) ? asset('storage/uploads/ePALM/' . $imageFields['XGIM_'.$i]) : asset('storage/uploads/no-photos.png') }}" 
                                                        alt="Park Image {{ $i }}" 
                                                        class="park-img clickable-preview" 
                                                        style="border: 0.5px solid black;">
                                                    @endif
                                                @endfor
                                            </div>

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
                                                    const totalImages = 6;

                                                    for (let i = 1; i <= totalImages; i++) {
                                                        const preview = document.getElementById(`preview_${i}`);
                                                        if (!preview) continue;

                                                        preview.style.cursor = 'zoom-in';
                                                        preview.title = 'Lihat Gambar';

                                                        preview.addEventListener('click', function () {
                                                            const modalImage = document.getElementById('modalImage');
                                                            modalImage.src = this.src;

                                                            // Check for Bootstrap 5 or 4
                                                            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                                                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                                                                modal.show();
                                                            } else {
                                                                $('#imageModal').modal('show'); // For Bootstrap 4 with jQuery
                                                            }
                                                        });
                                                    }
                                                });


                                            </script> --}}

                                            @php
                                                $imageFields = [];
                                                if(isset($ePALM->gambar_taman)){
                                                    $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
                                                    $gambar_tamanData = json_decode($ePALM->gambar_taman, true);
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        $key1 = "XGIM_$i";
                                                        $key2 = "Xgambar_input_modal_$i";
                                                        // $imageFields[$i] = isset($gambar_tamanData[$key1])
                                                        //     ? $folderName . '/' . $gambar_tamanData[$key1]
                                                        //     : (isset($gambar_tamanData[$key2]) ? $folderName . '/' . $gambar_tamanData[$key2] : null);
                                                        $img = $gambar_tamanData[$key1] ?? $gambar_tamanData[$key2] ?? null;
                                                        if ($img) {
                                                            $imageFields[] = $folderName . '/' . $img;//asset('storage/uploads/ePALM/' . $folderName . '/' . $img);
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
                                                                // $imagePath = asset('storage/uploads/ePALM/' . $img);
                                                                $imagePath = $img ? asset('storage/uploads/ePALM/' . $img) : null;
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
                                                            // $imagePath = asset('storage/uploads/ePALM/' . $img);
                                                            $imagePath = $img ? asset('storage/uploads/ePALM/' . $img) : null;
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
                                            

                                            

                                            <br><br>
                                            <h5>Pihak Berkuasa Tempatan :</h5>
                                            <p id="modalpbt">{{ $ePALM->nama_pbt ?? 'Tiada Maklumat' }}</p>
                                            <br>
                                            <h5>Keterangan Taman :</h5>
                                            <p id="modalKeterangan">{{ $ePALM->keterangan_taman ?? 'Tiada Maklumat' }}</p>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-12 col-md-3"><h5>Kategori Taman :</h5></div>
                                                <div class="col-12 col-md-3"><p id="modalKategoriTaman">{{ $ePALM->kategori_taman ?? 'Tiada Maklumat' }}</p></div>

                                                <div class="col-12 col-md-3"><h5>Waktu Operasi :</h5></div>
                                                <div class="col-12 col-md-3"><p id="modalWaktu">{{ ($ePALM->waktuMula_taman && $ePALM->waktuTamat_taman) ? $ePALM->waktuMula_taman . ' - ' . $ePALM->waktuTamat_taman : 'Tiada Maklumat' }}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-3"><h5>Keluasan Taman :</h5></div>
                                                <div class="col-12 col-md-3"><p id="modalKeluasan">{{ is_numeric($ePALM->keluasan_taman) ? number_format($ePALM->keluasan_taman, 2).' '.$ePALM->keluasan_unit : 'Tiada Maklumat' }}</p></div>

                                                <div class="col-12 col-md-3"><h5>Koordinat Taman :</h5></div>
                                                <div class="col-12 col-md-3">
                                                    <p id="modalCoordinate">
                                                        {{ is_numeric($ePALM->lng) && is_numeric($ePALM->lat) ? '( '.$ePALM->lng.', '.$ePALM->lat.' )' : 'Tiada Maklumat' }}
                                                        @if(is_numeric($ePALM->lng) && is_numeric($ePALM->lat))
                                                        &nbsp;<br>
                                                        <a href="{{ 'https://maps.google.com/?q='.$ePALM->lat.','.$ePALM->lng }}" target="_blank">
                                                            Pautan Google Map <i class="fas fa-globe"></i>
                                                        </a>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <br><br>
                                            @php
                                                $fasilitiData = isset($ePALM->fasiliti) && $ePALM->fasiliti != null
                                                    ? (array) json_decode($ePALM->fasiliti, true)
                                                    : [];

                                                $facilityOptions = [
                                                    'cctv'    => ['label' => 'CCTV', 'icon' => 'fas fa-video'],
                                                    'wifi'    => ['label' => 'WiFi', 'icon' => 'fas fa-wifi'],
                                                    'cycling' => ['label' => 'Kemudahan Berbasikal', 'icon' => 'fas fa-bicycle'],
                                                    'food'    => ['label' => 'Gerai Makan', 'icon' => 'fas fa-utensils'],
                                                    'oku'     => ['label' => 'Kemudahan OKU', 'icon' => 'fas fa-wheelchair'],
                                                    'toilet'  => ['label' => 'Tandas Awam', 'icon' => 'fas fa-toilet'],
                                                ];

                                                $facilityKeys = array_keys($facilityOptions);
                                                //dump($fasilitiData);
                                            @endphp

                                            @if($fasilitiData)
                                            <h5 class="row justify-content-center">Kemudahan Taman</h5>
                                            <br>
                                            <div class="col-md-12">
                                                {{-- <div class="row justify-content-center"> --}}
                                                    <style>
                                                        /* .facility-wrapper {
                                                            margin-bottom: 15px;
                                                            text-align: center;
                                                        }

                                                        .facility {
                                                            display: flex;
                                                            flex-direction: column;
                                                            align-items: center;
                                                            cursor: pointer;
                                                            text-align: center;
                                                            transition: transform 0.3s ease;
                                                        } */

                                                        .facility:hover {
                                                            transform: scale(1.05);
                                                        }

                                                        /* .facility .bg {
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                            padding: 15px;
                                                            background-color: #ccc;
                                                            border-radius: 8px;
                                                            margin-bottom: 8px;
                                                            transition: background-color 0.3s ease;
                                                        } */

                                                        .facility input[type="checkbox"]:checked + .bg {
                                                            background-color: #28a745;
                                                        }

                                                        .facility input[type="checkbox"]:checked + .bg i {
                                                            color: #fff;
                                                        }

                                                        .facility input[type="checkbox"] {
                                                            display: none;
                                                        }

                                                        .facility-label {
                                                            font-weight: 600;
                                                            font-size: 14px;
                                                            color: #333;
                                                        }

                                                        /* .icon-container i {
                                                            font-size: 28px;
                                                            color: #000;
                                                        } */

                                                        .facility input[type="checkbox"]:hover + .bg i {
                                                            transform: scale(1.1);
                                                        }

                                                        .facility-wrapper {
                                                            /* margin-bottom: 15px; */
                                                            text-align: center;
                                                            display: flex;
                                                            justify-content: center;
                                                        }

                                                        .facility {
                                                            display: flex;
                                                            flex-direction: column;
                                                            align-items: center;
                                                            cursor: pointer;
                                                            text-align: center;
                                                            transition: transform 0.3s ease;
                                                            width: 100%; /* Fill column width */
                                                            max-width: 140px;
                                                            /* min-height: 160px; */
                                                            padding: 10px;
                                                            box-sizing: border-box;
                                                            /* background-color: #f9f9f9; */
                                                            border-radius: 8px;
                                                        }

                                                        .facility .bg {
                                                            width: 60px;
                                                            height: 60px;
                                                            background-color: #ccc;
                                                            border-radius: 8px;
                                                            margin-bottom: 8px;
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                            transition: background-color 0.3s ease;
                                                        }

                                                        .icon-container i {
                                                            font-size: 28px;
                                                            color: #000;
                                                        }
                                                    </style>

                                                    <div class="row justify-content-center">
                                                        {{-- Predefined Facilities - Show only checked --}}
                                                        @foreach($facilityOptions as $key => $option)
                                                            @php $isChecked = isset($fasilitiData[$key]) && $fasilitiData[$key] == '1'; @endphp
                                                            @if($isChecked)
                                                                <div class="col-4 col-md-2 facility-wrapper">
                                                                    <label class="facility" aria-label="{{ $option['label'] }}">
                                                                        <input disabled type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                                                        <input disabled type="checkbox" name="fasiliti[{{ $key }}]" value="1" checked>
                                                                        <span class="bg">
                                                                            <div class="icon-container">
                                                                                <i class="{{ $option['icon'] }}" title="{{ $option['label'] }}"></i>
                                                                            </div>
                                                                        </span>
                                                                        <span class="facility-label">{{ $option['label'] }}</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                        {{-- Dynamic Facilities - Show if checked --}}
                                                        @foreach($fasilitiData as $key => $val)
                                                            @if (!in_array($key, $facilityKeys) && $val == '1')
                                                                <div class="col-4 col-md-2 facility-wrapper">
                                                                    <label class="facility" aria-label="{{ ucfirst($key) }}">
                                                                        <input disabled type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                                                        <input disabled type="checkbox" name="fasiliti[{{ $key }}]" value="1" checked>
                                                                        <span class="bg">
                                                                            <div class="icon-container">
                                                                                <i class="fas fa-chart-pie" title="{{ ucfirst($key) }}"></i>
                                                                            </div>
                                                                        </span>
                                                                        <span class="facility-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    {{-- <div class="row justify-content-center">
                                                        @foreach($facilityOptions as $key => $option)
                                                            @php $isChecked = isset($fasilitiData[$key]) && $fasilitiData[$key] == '1'; @endphp
                                                            <div class="col-6 col-md-2 facility-wrapper">
                                                                <label class="facility" aria-label="{{ $option['label'] }}">
                                                                    <input disabled type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                                                    <input disabled type="checkbox" name="fasiliti[{{ $key }}]" value="1" {{ $isChecked ? 'checked' : '' }}>
                                                                    <span class="bg">
                                                                        <div class="icon-container">
                                                                            <i class="{{ $option['icon'] }}" title="{{ $option['label'] }}"></i>
                                                                        </div>
                                                                    </span>
                                                                    <span class="facility-label">{{ $option['label'] }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                        @foreach($fasilitiData as $key => $val)
                                                            @if (!in_array($key, $facilityKeys))
                                                                @php $isChecked = $val == '1'; @endphp
                                                                <div class="col-6 col-md-2 facility-wrapper">
                                                                    <label class="facility" aria-label="{{ ucfirst($key) }}">
                                                                        <input disabled type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                                                        <input disabled type="checkbox" name="fasiliti[{{ $key }}]" value="1" {{ $isChecked ? 'checked' : '' }}>
                                                                        <span class="bg">
                                                                            <div class="icon-container">
                                                                                <i class="fas fa-chart-pie" title="{{ ucfirst($key) }}"></i>
                                                                            </div>
                                                                        </span>
                                                                        <span class="facility-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                            @endif

                                            <br>
                                            <h5 class="row justify-content-center">Media Sosial</h5>
                                            <br>
                                            @php
                                                $mediaData = isset($ePALM->mediaSosial_taman) ? json_decode($ePALM->mediaSosial_taman, true) : [];
                                                $fixedFields = ['Web', 'Telefon', 'Emel', 'Facebook'];
                                                $displayFields = [];

                                                // Build list of label-value pairs (including dynamic ones)
                                                foreach ($fixedFields as $field) {
                                                    $label = $field === 'Web' ? 'Laman Web' : $field;
                                                    $value = $mediaData[$field] ?? 'Tiada Maklumat';
                                                    $displayFields[] = ['label' => $label, 'value' => $value];
                                                }

                                                foreach ($mediaData as $key => $value) {
                                                    if (!in_array($key, $fixedFields)) {
                                                        $displayFields[] = ['label' => $key, 'value' => $value ?? 'Tiada Maklumat'];
                                                    }
                                                }
                                            @endphp

                                            @for ($i = 0; $i < count($displayFields); $i += 2)
                                                <div class="row">
                                                    {{-- First column --}}
                                                    <div class="col-12 col-md-3"><h5>{{ $displayFields[$i]['label'] }} :</h5></div>
                                                    <div class="col-12 col-md-3"><p>{{ $displayFields[$i]['value'] }}</p></div>

                                                    {{-- Second column (if exists) --}}
                                                    @if (isset($displayFields[$i + 1]))
                                                        <div class="col-12 col-md-3"><h5>{{ $displayFields[$i + 1]['label'] }} :</h5></div>
                                                        <div class="col-12 col-md-3"><p>{{ $displayFields[$i + 1]['value'] }}</p></div>
                                                    @endif
                                                </div>
                                            @endfor
                                            <br>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                <a href="{{ route('website.epalm') }}" class="btn btn-secondary py-1 px-3" style="font-size: 0.9rem;">Kembali</a>
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



