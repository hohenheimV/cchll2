@extends('layouts.website.secondary')
@section('title', 'Direktori Maklumat Polisi Landskap')

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
                @include('layouts.website.elements.sidebar-widgets')
                <!-- Post Content Column -->
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold my-1">{{ $MIB->taman }}</h3>
                            <div class="d-flex justify-content-end" role="group" aria-label="First group">
                                {!! Form::button('Kembali', [
                                'class'=>'btn btn-info btn-sm',
                                'onclick' => "window.location='" . route('website.MIB') . "'"
                                ]) !!}
                            </div>
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
                                                    <th class="text-center align-middle w-20">Tarikh Laporan</th>
                                                    <th class="text-center align-middle w-5">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($null = '<span class="badge badge-light">Tiada Maklumat</span>')
                                                @php($index = $MIB_laporan->firstItem())
                                                @forelse($MIB_laporan as $laporan)
                                                <tr>
                                                    <td>{{ $index++ }}</td>
                                                    <td>{!! $laporan->name !!}</td>
                                                    <td class="text-center">{!! $laporan->created_at->format('d-m-Y') !!}</td>
                                                    <td class="text-center">
                                                        <?php
                                                        if(isset($laporan->fail)){
                                                            $folderName = str_replace(' ', '_', $MIB->taman ?? ($laporan->taman ?? 'temp'));
                                                            $gambarData = $laporan->fail;
                                    
                                                            $gambar_input_modal_1 = isset($gambarData['gambar_input_modal_1']) ? $folderName.'/'.$gambarData['gambar_input_modal_1'] : null;
                                                            $gambar_input_modal_2 = isset($gambarData['gambar_input_modal_2']) ? $folderName.'/'.$gambarData['gambar_input_modal_2'] : null;
                                                            $gambar_input_modal_3 = isset($gambarData['gambar_input_modal_3']) ? $folderName.'/'.$gambarData['gambar_input_modal_3'] : null;
                                                            $gambar_input_modal_4 = isset($gambarData['gambar_input_modal_4']) ? $folderName.'/'.$gambarData['gambar_input_modal_4'] : null;
                                                            // dd($gambarData);
                                                        }else{
                                                            $gambar_input_modal_1 = null;
                                                            $gambar_input_modal_2 = null;
                                                            $gambar_input_modal_3 = null;
                                                            $gambar_input_modal_4 = null;
                                                        }
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
                    <div class="park-images">
                        <img id="parkImage1" src="" alt="Park Image 1" class="park-img" style="border: 0.5px solid black;">
                        <img id="parkImage2" src="" alt="Park Image 2" class="park-img" style="border: 0.5px solid black;">
                        <img id="parkImage3" src="" alt="Park Image 3" class="park-img" style="border: 0.5px solid black;">
                        <img id="parkImage4" src="" alt="Park Image 4" class="park-img" style="border: 0.5px solid black;">
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

                    let imagePath = `/storage/uploads`;
                    let img1 = document.getElementById('parkImage1');
                    if (fail1) {
                        img1.src = `${imagePath}/MIB/${fail1}`;
                        img1.onerror = function () {
                            img1.src = `${imagePath}/no-photos.png`;
                        };
                    } else {
                        img1.src = `${imagePath}/no-photos.png`;
                    }
                    let img2 = document.getElementById('parkImage2');
                    if (fail2) {
                        img2.src = `${imagePath}/MIB/${fail2}`;
                        img2.onerror = function () {
                            img2.src = `${imagePath}/no-photos.png`;
                        };
                    } else {
                        img2.src = `${imagePath}/no-photos.png`;
                    }
                    let img3 = document.getElementById('parkImage3');
                    if (fail3) {
                        img3.src = `${imagePath}/MIB/${fail3}`;
                        img3.onerror = function () {
                            img3.src = `${imagePath}/no-photos.png`;
                        };
                    } else {
                        img3.src = `${imagePath}/no-photos.png`;
                    }
                    let img4 = document.getElementById('parkImage4');
                    if (fail4) {
                        img4.src = `${imagePath}/MIB/${fail4}`;
                        img4.onerror = function () {
                            img4.src = `${imagePath}/no-photos.png`;
                        };
                    } else {
                        img4.src = `${imagePath}/no-photos.png`;
                    }
                    
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
                    $(this).find('#modalNama').text('');
                    $(this).find('.modal-content').scrollTop(0);
                });
            });
        </script>


    </section>
    <!-- /.section#posts -->

@endsection



