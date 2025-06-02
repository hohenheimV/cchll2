@extends('layouts.website.secondary')
@section('title', 'Direktori Aktiviti Rakan Taman')

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
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold my-1">Direktori Aktiviti Rakan Taman</h3>
                            {{--<div class="d-flex justify-content-end" role="group" aria-label="First group">
                                {!! Form::button('Kembali', [
                                'class'=>'btn btn-info btn-sm',
                                'onclick' => "window.location='" . route('website.MIB') . "'"
                                ]) !!}
                            </div>--}}
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
                                    <div class="table-responsive">
                                        <table id="exampleNP" class="responsive table table-bordered table-hover table-striped table-sm mb-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center align-middle w-5">No.</th>
                                                    <th class="text-center align-middle">Nama Aktviti</th>
                                                    <th class="text-center align-middle w-20">Taman Perumahan</th>
                                                    <th class="text-center align-middle w-20">Pihak Berkuasa Tempatan</th>
                                                    <!-- <th class="text-center align-middle w-20">Tarikh Laporan</th> -->
                                                    <th class="text-center align-middle w-5">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                                @php($index = $MIB_laporan->firstItem())
                                                @forelse($MIB_laporan as $laporan)
                                                <tr>
                                                    <td>{{ $index++ }}</td>
                                                    <td>{!! (strtoupper($laporan->name)) !!}</td>
                                                    <td>{{ (strtoupper($laporan->taman)) }}</td>
                                                    <td>{{ (strtoupper($laporan->mib->pbt ?? 'Tiada Maklumat'))  }}</td>
                                                    <!-- <td class="text-center">{!! $laporan->created_at->format('d-m-Y') !!}</td> -->
                                                    <td class="text-center">
                                                        <?php
                                                        if(isset($laporan->gambar)){
                                                            $folderName = str_replace(' ', '_', $laporan->id_rakan.' '.($laporan->taman ?? 'temp'));
                                                            $gambarData = $laporan->gambar;
                                    
                                                            $gambar_input_modal_1 = isset($gambarData['gambar_input_modal_1']) ? $folderName.'/'.$gambarData['gambar_input_modal_1'] : null;
                                                            $gambar_input_modal_2 = isset($gambarData['gambar_input_modal_2']) ? $folderName.'/'.$gambarData['gambar_input_modal_2'] : null;
                                                            $gambar_input_modal_3 = isset($gambarData['gambar_input_modal_3']) ? $folderName.'/'.$gambarData['gambar_input_modal_3'] : null;
                                                            $gambar_input_modal_4 = isset($gambarData['gambar_input_modal_4']) ? $folderName.'/'.$gambarData['gambar_input_modal_4'] : null;
                                                            $gambar_input_modal_5 = isset($gambarData['gambar_input_modal_5']) ? $folderName.'/'.$gambarData['gambar_input_modal_5'] : null;
                                                            $gambar_input_modal_6 = isset($gambarData['gambar_input_modal_6']) ? $folderName.'/'.$gambarData['gambar_input_modal_6'] : null;
                                                            $gambar_input_modal_7 = isset($gambarData['gambar_input_modal_7']) ? $folderName.'/'.$gambarData['gambar_input_modal_7'] : null;
                                                            $gambar_input_modal_8 = isset($gambarData['gambar_input_modal_8']) ? $folderName.'/'.$gambarData['gambar_input_modal_8'] : null;
                                                            $gambar_input_modal_9 = isset($gambarData['gambar_input_modal_9']) ? $folderName.'/'.$gambarData['gambar_input_modal_9'] : null;
                                                            $gambar_input_modal_10 = isset($gambarData['gambar_input_modal_10']) ? $folderName.'/'.$gambarData['gambar_input_modal_10'] : null;
                                                            // dd($gambar_input_modal_1);
                                                        }else{
                                                            $gambar_input_modal_1 = $gambar_input_modal_2 = $gambar_input_modal_3 = $gambar_input_modal_4 = $gambar_input_modal_5 = $gambar_input_modal_6 = $gambar_input_modal_7 = $gambar_input_modal_8 = $gambar_input_modal_9 = $gambar_input_modal_10 = null;
                                                        }
                                                        // if(isset($laporan->fail)){
                                                        //     $folderName = str_replace(' ', '_', ($laporan->taman ?? 'temp'));
                                                        //     $gambarData = $laporan->fail;
                                    
                                                        //     $gambar_input_modal_1 = isset($gambarData['gambar_input_modal_1']) ? $folderName.'/'.$gambarData['gambar_input_modal_1'] : null;
                                                        //     $gambar_input_modal_2 = isset($gambarData['gambar_input_modal_2']) ? $folderName.'/'.$gambarData['gambar_input_modal_2'] : null;
                                                        //     $gambar_input_modal_3 = isset($gambarData['gambar_input_modal_3']) ? $folderName.'/'.$gambarData['gambar_input_modal_3'] : null;
                                                        //     $gambar_input_modal_4 = isset($gambarData['gambar_input_modal_4']) ? $folderName.'/'.$gambarData['gambar_input_modal_4'] : null;
                                                        //     // dd($gambarData);
                                                        // }else{
                                                        //     $gambar_input_modal_1 = null;
                                                        //     $gambar_input_modal_2 = null;
                                                        //     $gambar_input_modal_3 = null;
                                                        //     $gambar_input_modal_4 = null;
                                                        // }
                                                        ?>
                                                        <div class="btn-group">
                                                            <button 
                                                                type="button" 
                                                                class="btn btn-primary btn-sm" 
                                                                data-title="{{ $laporan->name }}" 
                                                                data-laporan="{{ $laporan->laporan }}" 
                                                                data-folder="{{ $laporan->taman }}" 
                                                                data-fail1="{{ $gambar_input_modal_1 }}" 
                                                                data-fail2="{{ $gambar_input_modal_2 }}" 
                                                                data-fail3="{{ $gambar_input_modal_3 }}" 
                                                                data-fail4="{{ $gambar_input_modal_4 }}" 
                                                                data-fail5="{{ $gambar_input_modal_5 }}" 
                                                                data-fail6="{{ $gambar_input_modal_6 }}" 
                                                                data-fail7="{{ $gambar_input_modal_7 }}" 
                                                                data-fail8="{{ $gambar_input_modal_8 }}" 
                                                                data-fail9="{{ $gambar_input_modal_9 }}" 
                                                                data-fail10="{{ $gambar_input_modal_10 }}" 
                                                                data-toggle="modal" 
                                                                data-target="#readModal"
                                                            >
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                {!! Html::forelse_alert(request('keyword'),'Aktiviti') !!}
                                                @endforelse
                                            </tbody>
                                        </table>
                                        @if($MIB_laporan->count() > 0)
                                        <div
                                            class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                            {!! Html::pagination($MIB_laporan) !!}
                                        </div>
                                        <!-- /.card-footer -->
                                        @endif
                                    </div>
                                </div>
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
                z-index: 1050 !important;
                overflow-y: auto;
            }
            .modal-backdrop {
                z-index: 1000 !important;  /* Ensure backdrop is below modal */
            }

            #customModalContent {
                position: relative;
                background-color: white;
                margin: 5% auto;
                padding: 30px;
                width: 80%;
                max-width: 900px;
                max-height: 80%;
                overflow-y: auto; /* Makes the modal content scrollable */
                background-image: url("{{ asset('storage/img/bg-pattern-leaves.png') }}");
            }

            #customModalContent h2 {
                text-align: center;
            }

            #customModalContent span {
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
                justify-content: center;
                gap: 10px;
                margin-top: 10px;
            }

            .park-img {
                width: 195px;
                height: 195px;
                border-radius: 8px;
                border: 0.5px solid black;
            }

            /* For mobile view (screens smaller than 768px) */
            @media (max-width: 767px) {
                .park-img {
                    width: 45%; /* Reduce image size */
                    height: auto; /* Maintain aspect ratio */
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

        <div id="readModal" class="modal">
            <div class="modal-content" id="customModalContent" style="background-color:rgb(25, 98, 92) !important;">
                <div class="modal-header justify-content-center bg-white">
                    <h2 class="modal-title" id="modalNama" style="text-align: center;"></h2>
                </div>

                <div class="modal-body bg-white">
                    <h5>Laporan</h5>
                    <p id="laporan">Tiada Maklumat</p>
                    <br>
                    <h5>Gambar Aktiviti</h5>
                    {{-- <div class="park-images">
                        <a id="parkLink1" href="javascript:void(0)">
                            <img id="parkImage1" src="" alt="Park Image 1" class="park-img" style="border: 0.5px solid black;">
                        </a>
                        <a id="parkLink2" href="javascript:void(0)">
                            <img id="parkImage2" src="" alt="Park Image 2" class="park-img" style="border: 0.5px solid black;">
                        </a>
                        <a id="parkLink3" href="javascript:void(0)">
                            <img id="parkImage3" src="" alt="Park Image 3" class="park-img" style="border: 0.5px solid black;">
                        </a>
                        <a id="parkLink4" href="javascript:void(0)">
                            <img id="parkImage4" src="" alt="Park Image 4" class="park-img" style="border: 0.5px solid black;">
                        </a>
                    </div> --}}
                    {{-- <div id="carouselImages" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" id="carouselInner">
                            <!-- Slides will be added dynamically -->
                        </div>
                        <a class="carousel-control-prev" href="#carouselImages" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carouselImages" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div> --}}
                    <style>
                        .carousel-inner img {
                            height: 400px;
                            object-fit: contain;
                            background-color: #f8f8f8;
                            border-radius: 6px;
                            /* border: 1px solid #ccc; */
                            border: 1px solid rgb(49, 213, 200) !important;
                        }

                        .thumbnail-nav img {
                            width: 50px;
                            height: 50px;
                            object-fit: cover;
                            /* border: 2px solid transparent; */
                            border: 0.25px solid black;
                            margin: 5px;
                            border-radius: 4px;
                            cursor: pointer;
                            transition: border 0.3s;
                        }
                        .thumbnail-nav img.active-thumb {
                            /* border-color: #007bff; */
                            border: 2px solid rgb(49, 213, 200) !important;
                        }
                    </style>
                    <!-- Main Carousel -->
                    <div id="carouselImages" class="carousel slide mb-3" data-ride="carousel">
                        <div class="carousel-inner" id="carouselInner">
                            <!-- JS will inject slides -->
                        </div>
                        <a class="carousel-control-prev" href="#carouselImages" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carouselImages" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>

                    <!-- Thumbnails -->
                    <div class="thumbnail-nav d-flex flex-wrap justify-content-center" id="carouselThumbs">
                        <!-- JS will inject thumbs -->
                    </div>
                    <br>

                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Modal JavaScript (Show and Hide Logic) -->
        <script>
            $(document).ready(function() {
                $('#readModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var title = button.data('title');
                    var laporan = button.data('laporan');
                    var folder = button.data('folder');
                    var fail1 = button.data('fail1');
                    var fail2 = button.data('fail2');
                    var fail3 = button.data('fail3');
                    var fail4 = button.data('fail4');
                    var fail5 = button.data('fail5');
                    var fail6 = button.data('fail6');
                    var fail7 = button.data('fail7');
                    var fail8 = button.data('fail8');
                    var fail9 = button.data('fail9');
                    var fail10 = button.data('fail10');

                    // let imagePath = `/storage/uploads`;
                    // let img1 = document.getElementById('parkImage1');
                    // let link1 = document.getElementById('parkLink1');
                    // if (fail1) {
                    //     img1.src = `${imagePath}/MIB/${fail1}`;
                    //     link1.href = `${imagePath}/MIB/${fail1}`;
                    //     link1.target = '_blank';
                    //     img1.onerror = function () {
                    //         img1.src = `${imagePath}/no-photos.png`;
                    //         link1.href = 'javascript:void(0)';
                    //         link1.target = '';
                    //     };
                    // } else {
                    //     img1.src = `${imagePath}/no-photos.png`;
                    //         link1.href = 'javascript:void(0)';
                    //         link1.target = '';
                    // }
                    // let img2 = document.getElementById('parkImage2');
                    // let link2 = document.getElementById('parkLink2');
                    // if (fail2) {
                    //     img2.src = `${imagePath}/MIB/${fail2}`;
                    //     link2.href = `${imagePath}/MIB/${fail2}`;
                    //     link2.target = '_blank';
                    //     img2.onerror = function () {
                    //         img2.src = `${imagePath}/no-photos.png`;
                    //         link2.href = 'javascript:void(0)';
                    //         link2.target = '';
                    //     };
                    // } else {
                    //     img2.src = `${imagePath}/no-photos.png`;
                    //         link2.href = 'javascript:void(0)';
                    //         link2.target = '';
                    // }
                    // let img3 = document.getElementById('parkImage3');
                    // let link3 = document.getElementById('parkLink3');
                    // if (fail3) {
                    //     img3.src = `${imagePath}/MIB/${fail3}`;
                    //     link3.href = `${imagePath}/MIB/${fail3}`;
                    //     link3.target = '_blank';
                    //     img3.onerror = function () {
                    //         img3.src = `${imagePath}/no-photos.png`;
                    //         link3.href = 'javascript:void(0)';
                    //         link3.target = '';
                    //     };
                    // } else {
                    //     img3.src = `${imagePath}/no-photos.png`;
                    //         link3.href = 'javascript:void(0)';
                    //         link3.target = '';
                    // }
                    // let img4 = document.getElementById('parkImage4');
                    // let link4 = document.getElementById('parkLink4');
                    // if (fail4) {
                    //     img4.src = `${imagePath}/MIB/${fail4}`;
                    //     link4.href = `${imagePath}/MIB/${fail4}`;
                    //     link4.target = '_blank';
                    //     img4.onerror = function () {
                    //         img4.src = `${imagePath}/no-photos.png`;
                    //         link4.href = 'javascript:void(0)';
                    //         link4.target = '';
                    //     };
                    // } else {
                    //     img4.src = `${imagePath}/no-photos.png`;
                    //     link4.href = 'javascript:void(0)';
                    //     link4.target = '';
                    // }

                    // let imagePath = `/storage/uploads/MIB`;
                    // let carouselInner = document.getElementById('carouselInner');
                    // carouselInner.innerHTML = ''; // Clear previous slides

                    // for (let i = 1; i <= 10; i++) {
                    //     let imgName = button.data(`fail${i}`);
                    //     if (imgName) {
                    //         let imgFullPath = `${imagePath}/${imgName}`;
                    //         let isActive = carouselInner.children.length === 0 ? 'active' : '';

                    //         let slide = document.createElement('div');
                    //         slide.className = `carousel-item ${isActive}`;
                    //         slide.innerHTML = `
                    //             <img src="${imgFullPath}" class="d-block w-100" style="max-height:450px; object-fit:contain;" alt="Image ${i}">
                    //         `;
                    //         carouselInner.appendChild(slide);
                    //     }
                    // }

                    // // If no images, show a fallback slide
                    // if (carouselInner.children.length === 0) {
                    //     let fallback = document.createElement('div');
                    //     fallback.className = 'carousel-item active';
                    //     fallback.innerHTML = `<img src="/storage/uploads/no-photos.png" class="d-block w-100" alt="No photo available">`;
                    //     carouselInner.appendChild(fallback);
                    // }

                    let imagePath = `/storage/uploads/MIB`;
                    let carouselInner = document.getElementById('carouselInner');
                    let carouselThumbs = document.getElementById('carouselThumbs');

                    carouselInner.innerHTML = '';
                    carouselThumbs.innerHTML = '';

                    let validImages = [];

                    for (let i = 1; i <= 10; i++) {
                        let imgName = button.data(`fail${i}`);
                        if (imgName) {
                            validImages.push(`${imagePath}/${imgName}`);
                        }
                    }

                    if (validImages.length === 0) {
                        validImages.push(`/storage/uploads/no-photos.png`);
                    }

                    // Inject slides and thumbs
                    validImages.forEach((src, index) => {
                        // Main Slide
                        const activeClass = index === 0 ? 'active' : '';
                        let slide = document.createElement('div');
                        slide.className = `carousel-item ${activeClass}`;
                        slide.innerHTML = `<img src="${src}" class="d-block w-100" alt="Image ${index + 1}">`;
                        carouselInner.appendChild(slide);

                        // Thumbnail
                        let thumb = document.createElement('img');
                        thumb.src = src;
                        thumb.dataset.target = '#carouselImages';
                        thumb.dataset.slideTo = index;
                        thumb.className = `thumb-img ${index === 0 ? 'active-thumb' : ''}`;
                        carouselThumbs.appendChild(thumb);

                        thumb.addEventListener('click', () => {
                            $('.thumb-img').removeClass('active-thumb');
                            thumb.classList.add('active-thumb');
                            $('#carouselImages').carousel(index);
                        });
                    });

                    // Sync thumbnail on slide change
                    $('#carouselImages').on('slide.bs.carousel', function (e) {
                        $('.thumb-img').removeClass('active-thumb');
                        $(`.thumb-img:eq(${e.to})`).addClass('active-thumb');
                    });
                    
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#modalNama').text(title);
                    }
                    if (laporan && laporan !== '') {
                        modal.find('#laporan').text(laporan);
                    }
                });

                $('#readModal').on('hidden.bs.modal', function () {
                    const modal = $(this);
                    // for (let i = 1; i <= 4; i++) {
                    //     const img = document.getElementById(`parkImage${i}`);
                    //     const link = document.getElementById(`parkLink${i}`);
                        
                    //     if (img) img.src = '';
                    //     if (link) link.href = '#';
                    // }
                    let carouselInner = document.getElementById('carouselInner');
                    carouselInner.innerHTML = '';

                    modal.find('#modalNama').text('');
                    modal.find('#laporan').text('');
                    modal.find('.modal-content').scrollTop(0);
                });
            });
        </script>


    </section>
    <!-- /.section#posts -->

@endsection



