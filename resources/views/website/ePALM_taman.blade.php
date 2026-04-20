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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
                                    <h3 class="card-title font-weight-bold my-1">Direktori Taman dan Landskap</h3>
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
                                                <p class="text-center">Gambar taman sedang dikemaskini.</p>
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
                                            <p id="modalpbt">{{ $ePALM->nama_pbt ?? 'Sedang dikemaskini' }}</p>
                                            <br>
                                            <h5>Keterangan Taman :</h5>
                                            <p id="modalKeterangan" style="white-space: pre-line;">{{ $ePALM->keterangan_taman ?? 'Sedang dikemaskini' }}</p>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-12 col-md-3"><h5>Kategori Taman :</h5></div>
                                                <div class="col-12 col-md-3"><p id="modalKategoriTaman">{{ $ePALM->kategori_taman ?? 'Sedang dikemaskini' }}</p></div>

                                                <div class="col-12 col-md-3"><h5>Waktu Operasi :</h5></div>
                                                <div class="col-12 col-md-3"><p id="modalWaktu">{{ ($ePALM->waktuMula_taman && $ePALM->waktuTamat_taman) ? $ePALM->waktuMula_taman . ' - ' . $ePALM->waktuTamat_taman : 'Sedang dikemaskini' }}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-3"><h5>Keluasan Taman :</h5></div>
                                                <div class="col-12 col-md-3"><p id="modalKeluasan">{{ is_numeric($ePALM->keluasan_taman) ? number_format($ePALM->keluasan_taman, 2).' '.$ePALM->keluasan_unit : 'Sedang dikemaskini' }}</p></div>

                                                <div class="col-12 col-md-3"><h5>Koordinat Taman :</h5></div>
                                                <div class="col-12 col-md-3">
                                                    <p id="modalCoordinate">
                                                    @if(is_numeric($ePALM->lng) && is_numeric($ePALM->lat))
                                                        <a href="https://maps.google.com/?q={{ $ePALM->lat }},{{ $ePALM->lng }}" target="_blank">
                                                            <i class="fas fa-globe"></i>
                                                            ( {{ round($ePALM->lng, 6) }}, {{ round($ePALM->lat, 6) }} )
                                                        </a>
                                                    @else
                                                        Sedang dikemaskini
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
                                                    'cctv'          => ['label' => 'CCTV', 'icon' => 'fas fa-video'],
                                                    'wifi'          => ['label' => 'WiFi', 'icon' => 'fas fa-wifi'],
                                                    'cycling'       => ['label' => 'Kemudahan Berbasikal', 'icon' => 'fas fa-bicycle'],
                                                    'food'          => ['label' => 'Gerai Makan', 'icon' => 'fas fa-utensils'],
                                                    'oku'           => ['label' => 'Kemudahan OKU', 'icon' => 'fas fa-wheelchair'],
                                                    'toilet'        => ['label' => 'Tandas Awam', 'icon' => 'fas fa-restroom'],

                                                    'surau'         => ['label' => 'Surau', 'icon' => 'fas fa-mosque'],
                                                    'basikal'       => ['label' => 'Laluan Basikal', 'icon' => 'fas fa-biking'],
                                                    'plaza'         => ['label' => 'Dataran /Plaza', 'icon' => 'fas fa-landmark'],
                                                    'sukan'         => ['label' => 'Gelanggang Sukan', 'icon' => 'fas fa-basketball-ball'],
                                                    'senam'         => ['label' => 'Alat Senam Riang', 'icon' => 'fas fa-dumbbell'],
                                                    'laluan'        => ['label' => 'Laluan Pejalan Kaki', 'icon' => 'fas fa-walking'],
                                                    'park'          => ['label' => 'Tempat Letak Kenderaan', 'icon' => 'fas fa-parking'],
                                                    'air'           => ['label' => 'Badan Air (Kolam /Tasik)', 'icon' => 'fas fa-water'],
                                                    'mainan'        => ['label' => 'Alat Permainan Kanak-kanak', 'icon' => 'fas fa-child'],
                                                    'wakaf'         => ['label' => 'Wakaf dan Struktur Berbumbung', 'icon' => 'fas fa-umbrella-beach'],
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
                                                        @php
                                                            // For performance, get the keys of $facilityOptions once
                                                            $facilityOptionKeys = array_keys($facilityOptions);
                                                        @endphp

                                                        @foreach($fasilitiData as $key => $val)
                                                            @if (!in_array($key, $facilityKeys) && $val == '1')
                                                                @php
                                                                    $iconClass = 'fab fa-pagelines';  // default icon
                                                                    $label = ucwords(str_replace('_', ' ', $key)); // default label

                                                                    // Loop through facilityOptions keys to find partial match
                                                                    foreach ($facilityOptionKeys as $fKey) {
                                                                        if (strpos($key, $fKey) !== false) {
                                                                            $iconClass = $facilityOptions[$fKey]['icon'];
                                                                            //$label = $facilityOptions[$fKey]['label'];
                                                                            break; // stop after first match
                                                                        }
                                                                    }
                                                                @endphp
                                                                <div class="col-4 col-md-2 facility-wrapper">
                                                                    <label class="facility" aria-label="{{ $label }}">
                                                                        <input disabled type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                                                        <input disabled type="checkbox" name="fasiliti[{{ $key }}]" value="1" checked>
                                                                        <span class="bg">
                                                                            <div class="icon-container">
                                                                                <i class="{{ $iconClass }}" title="{{ $label }}"></i>
                                                                            </div>
                                                                        </span>
                                                                        <span class="facility-label">{{ $label }}</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    </div>

                                            </div>
                                            @endif

                                            <br>
                                            <h5 class="row justify-content-center">Media Sosial</h5>
                                            <br>
                                            @php
                                                $mediaData = isset($ePALM->mediaSosial_taman) ? json_decode($ePALM->mediaSosial_taman, true) : [];
                                                $fixedFields = ['Web', 'Telefon', 'Emel', 'Facebook'];
                                                $displayFields = [];

                                                // Mapping of labels to Font Awesome icons
                                                $iconMap = [
                                                    'Web' => 'fas fa-globe',
                                                    'Laman Web' => 'fas fa-globe',
                                                    'Telefon' => 'fas fa-phone',
                                                    'Emel' => 'fas fa-envelope',
                                                    'Facebook' => 'fab fa-facebook',
                                                    'Instagram' => 'fab fa-instagram',
                                                    'Twitter' => 'fab fa-twitter',
                                                    'YouTube' => 'fab fa-youtube',
                                                    'TikTok' => 'fab fa-tiktok',
                                                    'WhatsApp' => 'fab fa-whatsapp',
                                                    // Add more if needed
                                                ];

                                                // Build list of label-value-icon triplets (including dynamic fields)
                                                foreach ($fixedFields as $field) {
                                                    $label = $field === 'Web' ? 'Laman Web' : $field;
                                                    $value = $mediaData[$field] ?? 'Sedang dikemaskini';
                                                    $icon = $iconMap[$label] ?? 'fas fa-link';
                                                    $displayFields[] = ['label' => $label, 'value' => $value, 'icon' => $icon];
                                                }

                                                foreach ($mediaData as $key => $value) {
                                                    if (!in_array($key, $fixedFields)) {
                                                        $label = $key;
                                                        $icon = $iconMap[$label] ?? 'fas fa-link';
                                                        $displayFields[] = ['label' => $label, 'value' => $value ?? 'Sedang dikemaskini', 'icon' => $icon];
                                                    }
                                                }

                                                function renderNextLink($displayFields, $i) {
                                                    $nextIndex = $i + 1;

                                                    // Check if next index exists to avoid errors
                                                    if (!isset($displayFields[$nextIndex])) {
                                                        return ''; // or return some default/fallback if you want
                                                    }

                                                    $item = $displayFields[$nextIndex];
                                                    $href = e($item['value']);
                                                    $icon = $item['icon'];
                                                    $label = $item['label'];
                                                    $value = e($item['value']);

                                                    // Build the icon or label part
                                                    $iconOrLabel = $icon/* !== 'fas fa-link'*/
                                                        ? '<i class="' . e($icon) . ' me-1"></i>'
                                                        : e($label);

                                                    // Determine href based on type of value
                                                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                                        $href = 'mailto:' . $value;
                                                    } elseif (preg_match('/^https?:\/\//i', $value)) {
                                                        $href = $value;
                                                    } elseif (preg_match('/^\+?[0-9\s\-]{7,}$/', $value)) {
                                                        // Remove spaces for tel:
                                                        $tel = preg_replace('/\s+/', '', $value);
                                                        $href = 'tel:' . e($tel);
                                                    } else {
                                                        $href = "javascript:void(0)";
                                                        return <<<HTML
                                                            <p>
                                                                <strong style="font-size: 1.25rem;">
                                                                    {$iconOrLabel}&nbsp;&nbsp;&nbsp;:
                                                                </strong> 
                                                                {$value}
                                                            </p>
                                                        HTML;
                                                    }

                                                    // Return full anchor block as raw HTML string
                                                    return <<<HTML
                                                    <a href="{$href}" target="_blank" rel="noopener noreferrer">
                                                        <p>
                                                            <strong style="font-size: 1.25rem;">
                                                                {$iconOrLabel}&nbsp;&nbsp;&nbsp;:
                                                            </strong> 
                                                            {$value}
                                                        </p>
                                                    </a>
                                                    HTML;
                                                }
                                            @endphp

                                            @for ($i = 0; $i < count($displayFields); $i += 2)
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        {!! renderNextLink($displayFields, $i) !!}
                                                    </div>

                                                    @if (isset($displayFields[$i + 1]))
                                                        <div class="col-12 col-md-6">
                                                            {!! renderNextLink($displayFields, $i + 1) !!}
                                                        </div>
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



