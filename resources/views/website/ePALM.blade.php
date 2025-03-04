@extends('layouts.website.secondary')
@section('title', 'Direktori Taman')

@php
    if(isset($ePALM_all[0]->gambar_taman)){
        $folderName = str_replace(' ', '_', $ePALM_all[0]->nama_taman);
        $gambar_tamanData = json_decode($ePALM_all[0]->gambar_taman, true);

        $Xgambar_input_modal_1 = isset($gambar_tamanData['Xgambar_input_modal_1']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_1'] : null;
        $Xgambar_input_modal_2 = isset($gambar_tamanData['Xgambar_input_modal_2']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_2'] : null;
        $Xgambar_input_modal_3 = isset($gambar_tamanData['Xgambar_input_modal_3']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_3'] : null;
        $Xgambar_input_modal_4 = isset($gambar_tamanData['Xgambar_input_modal_4']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_4'] : null;
        //dd($gambar_tamanData);
    }else{
        $Xgambar_input_modal_1 = null;
        $Xgambar_input_modal_2 = null;
        $Xgambar_input_modal_3 = null;
        $Xgambar_input_modal_4 = null;
    }
    //dd($jemson);
@endphp
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

    <section id="posts" class="bg-white pt-5 mib">
        <div class="container pt-5">

            <div class="row">
                <div class="col-12 mt-5 d-lg-none">

                    <!-- Search Widget -->
                    <div class="card mb-4 d-none d-lg-block">
                        {!! website_sidebar_search() !!}
                    </div>
                </div>
                <!-- Post Content Column -->
                <div class="col-12 col-lg-8">
                    <div class="card">

                        <div class="card-body">
                            <h1>Direktori Taman</h1>
                            <ul class="list-unstyled list-inline">
                            </ul>
                            <div class="body-content">
                                <div class="table-responsive">
                                    <table id="example" class="responsive table table-bordered table-hover table-striped mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="w-1">Bil.</th>
                                                <th>Nama Taman</th>
                                                <th class="w-15">Kategori Taman</th>
                                                <th class="text-center w-10">PBT</th>
                                                <th class="text-center w-10">Tindakan</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($jenis_pembangunan = [
                                                'Taman Awam',
                                                'Taman Botani',
                                                'Landskap Perbandaran',
                                                'Persekitaran Kehidupan',
                                                'Taman Persekutuan',
                                                'Lain-lain (sila nyatakan)'
                                            ])
                                            @php($jenis_count = count($jenis_pembangunan))
                                            <script>
                                                let arram = '';
                                                let lat = '';
                                                let long = '';
                                            </script>
                                            @php($index = $ePALM_all->firstItem())
                                            @foreach($ePALM_all as $taman)
                                                <tr>
                                                    <td>{{ $index++ }}</td>
                                                    <td>{{ $taman->nama_taman}}</td>
                                                    <td>{!! ((!in_array($taman->kategori_taman, $jenis_pembangunan))) ? '<span class="badge bg-warning">'.$taman->kategori_taman.'</span>' : $taman->kategori_taman !!}</td>
                                                    <td>
                                                        {{ $taman->nama_pbt }}
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if(isset($taman->gambar_taman)){
                                                            $folderName = "ePALM/".str_replace(' ', '_', $taman->nama_taman);
                                                            $gambar_tamanData = json_decode($taman->gambar_taman, true);

                                                            $Xgambar_input_modal_1 = isset($gambar_tamanData['Xgambar_input_modal_1']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_1'] : 'no-photos.png';
                                                            $Xgambar_input_modal_2 = isset($gambar_tamanData['Xgambar_input_modal_2']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_2'] : 'no-photos.png';
                                                            $Xgambar_input_modal_3 = isset($gambar_tamanData['Xgambar_input_modal_3']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_3'] : 'no-photos.png';
                                                            $Xgambar_input_modal_4 = isset($gambar_tamanData['Xgambar_input_modal_4']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_4'] : 'no-photos.png';
                                                            //dd($gambar_tamanData);
                                                        }else{
                                                            $Xgambar_input_modal_1 = 'no-photos.png';
                                                            $Xgambar_input_modal_2 = 'no-photos.png';
                                                            $Xgambar_input_modal_3 = 'no-photos.png';
                                                            $Xgambar_input_modal_4 = 'no-photos.png';
                                                        }
                                                        $arrCheck = [];
                                                        if(isset($taman->fasiliti)){
                                                            $fasilitiData = json_decode(($taman->fasiliti), true);
                                                            $check1 = isset($fasilitiData['cctv']) && $fasilitiData['cctv'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check2 = isset($fasilitiData['wifi']) && $fasilitiData['wifi'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check3 = isset($fasilitiData['cycling']) && $fasilitiData['cycling'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check4 = isset($fasilitiData['food']) && $fasilitiData['food'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check5 = isset($fasilitiData['oku']) && $fasilitiData['oku'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check6 = isset($fasilitiData['toilet']) && $fasilitiData['toilet'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check7 = isset($fasilitiData['food2']) && $fasilitiData['food2'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check8 = isset($fasilitiData['oku2']) && $fasilitiData['oku2'] > 0 ? $arrCheck[] ='checked' : '';
                                                            $check9 = isset($fasilitiData['toilet2']) && $fasilitiData['toilet2'] > 0 ? $arrCheck[] ='checked' : '';
                                                            //dd($fasilitiData['cctv']);
                                                        }else{
                                                            $check1 = 0; 
                                                            $check2 = 0; 
                                                            $check3 = 0; 
                                                            $check4 = 0; 
                                                            $check5 = 0; 
                                                            $check6 = 0; 
                                                            $check7 = 0; 
                                                            $check8 = 0; 
                                                            $check9 = 0; 
                                                        }                                                   
                                                        // dd(($arrCheck));
                                                    ?>
                                                    <script>
                                                        arram = <?php echo json_encode($fasilitiData); ?>;
                                                        lat = <?php echo $taman->lat; ?>;
                                                        long = <?php echo $taman->lng; ?>;
                                                    </script>
                                                        <div class="btn-group">
                                                            <!-- Pass park data to modal -->
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-primary btn-sm" 
                                                                onclick="openParkModal(
                                                                    '{{ addslashes($taman->nama_taman) }}', 
                                                                    [ 
                                                                        '{{ asset('storage/uploads/'.$Xgambar_input_modal_1) }}', 
                                                                        '{{ asset('storage/uploads/'.$Xgambar_input_modal_2) }}', 
                                                                        '{{ asset('storage/uploads/'.$Xgambar_input_modal_3) }}', 
                                                                        '{{ asset('storage/uploads/'.$Xgambar_input_modal_4) }}' 
                                                                    ], 
                                                                    '{{ addslashes($taman->keterangan_taman) }}',
                                                                    arram,
                                                                )">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>

                                    </table>
                                </div>
                                @if(count($ePALM_all) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($ePALM_all) !!}
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

        <style>
            .modal {
                display: none; /* Initially hidden */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                overflow-y: auto;
            }

            .modal-content {
                position: relative;
                background-color: white;
                margin: 5% auto;
                padding: 20px;
                width: 80%;
                max-width: 900px;
                max-height: 80%;
                overflow-y: auto; /* Makes the modal content scrollable */
            }

            .modal-content h2 {
                text-align: center;
            }

            .modal-content span {
                text-align: right;
            }

            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 30px;
                cursor: pointer;
            }

            h2 {
                margin-bottom: 20px;
            }

            /* Modal body for content */
            .modal-body p {
                margin-bottom: 15px;
            }

            .park-images {
                display: flex;
                justify-content: space-between;
                margin-top: 10px;
            }

            .park-img {
                width: 200px;
                height: 200px;
                border-radius: 8px;
            }
        </style>
        <div id="parkModal" class="modal">
            <div class="modal-content">
                <span id="closeModal" class="close">&times;</span>
                <h2 id="parkName">Park Name</h2>

                <div class="modal-body">

                    <!-- Images -->
                    <div class="park-images">
                        <img id="parkImage1" src="" alt="Park Image 1" class="park-img">
                        <img id="parkImage2" src="" alt="Park Image 2" class="park-img">
                        <img id="parkImage3" src="" alt="Park Image 3" class="park-img">
                        <img id="parkImage4" src="" alt="Park Image 4" class="park-img">
                    </div>

                    <!-- Description (Keterangan) -->
                    <h5>Keterangan</h5>
                    <p id="parkDescription">Description of the park goes here. Keterangan.</p>

                    <div class="row">
                        <div class="col-3">
                            <h5>Kategori</h5>
                        </div>
                        <div class="col-3">
                            <p id="kategori">Description of the park goes here. Keterangan.</p>
                        </div>
                        <div class="col-3">
                            <h5>Waktu Operasi</h5>
                        </div>
                        <div class="col-3">
                            <p id="waktu">Description of the park goes here. Keterangan.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <h5>Keluasan</h5>
                        </div>
                        <div class="col-3">
                            <p id="keluasan">Description of the park goes here. Keterangan.</p>
                        </div>
                        <div class="col-3">
                            <h5>Koordinat</h5>
                        </div>
                        <div class="col-3">
                            <p id="coordinate">Description of the park goes here. Keterangan.</p>
                        </div>
                    </div>
                    <p id="coordinate">Description of the park goes here. Keterangan.</p>
                    
                    

                    <div class="col-md-12">
                        <h5>Fasiliti</h5>
                        <style>
                            .parks {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 20px;
                                justify-content: center;
                            }

                            .facility {
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                            }

                            .facility input[type="checkbox"] {
                                margin-right: 10px;
                                vertical-align: middle;
                            }

                            .parks i {
                                font-size: 36px;
                                transition: transform 0.3s ease, color 0.3s ease;
                            }

                            .parks input[type="checkbox"] {
                                display: inline-block;
                                margin-right: 10px;
                            }

                            .parks input[type="checkbox"]:checked + .bg {
                                background-color: green;
                                border-radius: 5px;
                            }

                            .parks input[type="checkbox"]:checked + .bg i {
                                color: white;
                            }

                            .facility-label {
                                display: inline-block;
                                margin-left: 8px;
                                font-size: 14px;
                                color: #555;
                                font-weight: bold;
                                text-align: left;
                            }

                            .parks .bg {
                                display: inline-block;
                                padding: 10px;
                                background-color: rgb(174, 169, 169);
                                border-radius: 5px;
                                transition: background-color 0.3s ease;
                            }

                            .parks input[type="checkbox"]:hover + .bg i {
                                transform: scale(1.1);
                            }

                            [data-toggle="tooltip"] {
                                position: relative;
                                display: inline-block;
                                cursor: pointer;
                            }

                            [data-toggle="tooltip"]:hover::after {
                                content: attr(title);
                                position: absolute;
                                top: -20px;
                                background-color: #333;
                                color: #fff;
                                font-size: 12px;
                                padding: 5px;
                                border-radius: 5px;
                            }

                            .icon-container {
                                width: 20px;
                                height: 20px;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                            }

                            .icon-container i {
                                font-size: 20px;
                            }
                        </style>
                        <div class="col-xs-12">
                            <div class="parks" inert>
                                <label class="facility" for="cctv">
                                    <input type="checkbox" value="1" name="fasiliti[cctv]" id="cctv" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-video" data-toggle="tooltip" title="CCTV"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="wifi">
                                    <input type="checkbox" value="1" name="fasiliti[wifi]" id="wifi" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-wifi" data-toggle="tooltip" title="WiFi"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="cycling">
                                    <input type="checkbox" value="1" name="fasiliti[cycling]" id="cycling" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-bicycle" data-toggle="tooltip" title="Kemudahan Berbasikal"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="food">
                                    <input type="checkbox" value="1" name="fasiliti[food]" id="food" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-utensils" data-toggle="tooltip" title="Gerai Makan"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="oku">
                                    <input type="checkbox" value="1" name="fasiliti[oku]" id="oku" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-wheelchair" data-toggle="tooltip" title="Kemudahan OKU"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="toilet">
                                    <input type="checkbox" value="1" name="fasiliti[toilet]" id="toilet" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-toilet" data-toggle="tooltip" title="Tandas Awam"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="food2">
                                    <input type="checkbox" value="1" name="fasiliti[food2]" id="food2" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-utensils" data-toggle="tooltip" title="Gerai Makan"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="oku2">
                                    <input type="checkbox" value="1" name="fasiliti[oku2]" id="oku2" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-wheelchair" data-toggle="tooltip" title="Kemudahan OKU"></i>
                                        </div>
                                    </span>
                                </label>

                                <label class="facility" for="toilet2">
                                    <input type="checkbox" value="1" name="fasiliti[toilet2]" id="toilet2" style="display:none;">
                                    <span class="bg">
                                        <div class="icon-container">
                                            <i class="fas fa-toilet" data-toggle="tooltip" title="Tandas Awam"></i>
                                        </div>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-3">
                            <h5>Gambar Panorama</h5>
                        </div>
                        <div class="col-9">
                        <style>
                            #photosphere {
                                width: 100%;
                                height: 400px;
                            }
                        </style>
                        <!-- <div id="photosphere"></div> -->
                        <script src="{{ asset('js/pano/three/build/three.js') }}"></script>
                        <script src="{{ asset('js/pano/uevent/browser.js') }}"></script>
                        <script src="{{ asset('js/pano/photo-sphere-viewer.js') }}"></script>
                        <script src="{{ asset('js/pano/viewer-compat.js') }}"></script>
                        <script>
                            var PSV = new PhotoSphereViewer.ViewerCompat({
                                container: 'photosphere',
                                panorama: 'http://127.0.0.1:8000/storage/uploads/ePALM/PERMOHONAN_PROJEK_2_(updated)_with_imeji/pano.jpg',
                                caption: 'ePokok<b>&copy; Panorama</b>',
                                loading_img: 'https://tpbk.jln.gov.my/img/photosphere-logo.gif',
                                time_anim: false,
                                anim_speed: '-2rpm',
                                default_fov: 50,
                                fisheye: false,
                                move_speed: 1.1,
                                time_anim: false,
                                });
                        </script>
                        </div>
                    </div>
                    <br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
                    <p>Nulla facilisi. Sed malesuada, erat ac pretium venenatis, turpis libero vestibulum dui, ut convallis eros sapien vel orci. Donec tincidunt, metus in malesuada tempor, enim nulla bibendum felis, a luctus leo arcu in ante. Aenean convallis velit nec est eleifend interdum.</p>
                    <p>Pellentesque non dolor nec ipsum tincidunt vehicula eget a nisi. Mauris suscipit erat non erat ullamcorper, sit amet cursus lorem pharetra.</p>
                    <p>Nam ac tortor tincidunt, consectetur nulla ac, vulputate purus. Quisque at erat a lorem euismod mollis non eget lectus.</p>
                    <p>Phasellus imperdiet, leo ut facilisis auctor, eros augue convallis odio, at euismod libero urna non augue. Nunc accumsan risus a urna lacinia, eu elementum eros laoreet. Vivamus non libero ac nunc venenatis gravida. Phasellus eu purus in orci viverra maximus.</p>
                    <p>Curabitur suscipit dui in nisl auctor, non facilisis urna posuere. Suspendisse potenti. Fusce a risus ac dui tincidunt varius ut nec turpis.</p>
                    <p>Suspendisse pharetra nunc orci, nec volutpat tortor mollis ut. Donec nec quam eu elit interdum convallis. Morbi ac cursus velit.</p>
                    <p>Donec convallis nec erat et iaculis. Nulla vitae nibh viverra, tincidunt leo at, egestas ligula. Curabitur vehicula vel risus eget facilisis. Morbi feugiat ligula non elit convallis, vel gravida felis pharetra.</p>
                    <p>Aenean ac justo ante. Integer eget massa tincidunt, auctor nulla eget, ultricies risus. Sed viverra purus felis, sed tincidunt neque venenatis at.</p>
                    <p>Phasellus tristique purus ac erat bibendum, sed luctus nunc tincidunt. Mauris vestibulum, velit eu tristique tincidunt, neque augue feugiat magna, ac suscipit eros sapien vitae eros.</p>
                </div>
            </div>
        </div>

        <!-- Modal JavaScript (Show and Hide Logic) -->
        <script>
            // Get the modal
            var modal = document.getElementById("parkModal");

            // Get the <span> element that closes the modal
            var span = document.getElementById("closeModal");

            // Function to open the modal and set the park data dynamically
            function openParkModal(parkName, parkImages, parkDescription, arr) {
                // console.log((lat));
                // console.log((arr.cctv));
                for (let key in arr) {
                if (arr.hasOwnProperty(key)) {
                    if(arr[key] > 0){
                        $('#'+key).prop('checked', true);
                    }
                    console.log(key, arr[key]);
                }
                }
                document.getElementById("parkName").innerText = parkName;
                for (let i = 0; i < 4; i++) {
                    let imageId = `parkImage${i + 1}`;
                    document.getElementById(imageId).src = parkImages[i] || ""; // Set default empty string if no image
                }
                document.getElementById("parkDescription").innerText = parkDescription;
                
                document.getElementById("coordinate").textContent = `(${lat}, ${long})`;
                // document.getElementById("kategori").textContent = `(${lat}, ${long})`;

                // Show the modal
                modal.style.display = "flex";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

    </section>
    <!-- /.section#posts -->

@endsection



