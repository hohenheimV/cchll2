@extends('layouts.website.secondary')
@section('title', 'Direktori Rekabentuk Landskap')

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
                        {{-- <div class="card-header">
                            <h3 class="card-title font-weight-bold my-1">Direktori Rekabentuk Landskap {{ $keyword }}</h3>
                        </div> --}}
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold my-1">Direktori Rekabentuk Landskap {{ $keyword }}</h3>

                            <div class="card-tools">
                                @php
                                    if($keyword == "Kejur") $anti = "Lembut";
                                    elseif($keyword == "Lembut") $anti = "Kejur";
                                @endphp
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <a href="/elad-dokumen/{{ strtolower($anti) }}" class="btn btn-primary btn-sm">Landskap {{ $anti }}</a>
                                    </div>
                                </div>
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
                                    <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0">
                                        <thead style="background-color:rgb(0, 0, 0) !important;color: white;">
                                            <tr>
                                                <th class="w-1">Bil.</th>
                                                <th class="w-15">Tajuk </th>
                                                <th class="text-center w-5">Kategori</th>
                                                <!-- <th class="text-center w-5">Tahun Penerbitan</th> -->
                                                <th class="w-3">Saiz</th>
                                                <th class="text-center w-1">Maklumat Lanjut</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = $eLAD->firstItem();
                                            @endphp
                                            @if($eLAD->isNotEmpty())
                                                @foreach($eLAD as $rekabentuk)
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ ucwords(strtolower($rekabentuk->tajuk)) }}</td>
                                                        <td>
                                                            {{ ucwords(strtolower($rekabentuk->kategori->name) ?? 'Sedang dikemaskini') }}
                                                        </td>
                                                        <!-- <td class="text-center">
                                                            {!! Html::datetime($rekabentuk->tarikh, 'Y') !!}
                                                        </td> -->
                                                        <td style="text-align: center;">
                                                            <!-- <a href="{{ asset($rekabentuk->dokumen ? 'storage/uploads/elad/dokumen/' . $rekabentuk->dokumen : 'img/no-photos.png') }}" 
                                                                data-toggle="lightbox" 
                                                                data-title="{{ $rekabentuk->tajuk }}" 
                                                                data-gallery="gallery"
                                                                target="_blank">
                                                                <div id="pdf-viewer-{{$rekabentuk->id}}" style="width: 100px; height: 150px; border: 1px solid #ddd; margin: auto; cursor: pointer; display: flex; justify-content: center; align-items: center;">
                                                                    <div id="loading-{{$rekabentuk->id}}" class="text-center" style="padding-top: 80px;">
                                                                        <i class="fas fa-spinner fa-spin"></i>
                                                                    </div>
                                                                    <canvas id="pdf-render-{{$rekabentuk->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                                </div>
                                                            </a> -->
                                                            {{ ($rekabentuk->dokumen && file_exists(public_path('storage/uploads/elad/dokumen/' . $rekabentuk->dokumen))) ? $rekabentuk->sizeName . ' MB' : strtoupper('-') }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{-- <div class="btn-group">
                                                                @if ($rekabentuk->dokumen && file_exists(public_path('storage/uploads/elad/dokumen/' . $rekabentuk->dokumen)))
                                                                    <!-- <button 
                                                                        type="button" 
                                                                        class="btn btn-primary btn-sm" 
                                                                        data-title="{{ $rekabentuk->tajuk }}" 
                                                                        data-elad="{{ asset($rekabentuk->dokumen ? 'storage/uploads/elad/dokumen/' . $rekabentuk->dokumen : 'img/no-photos.png') }}"
                                                                        data-toggle="modal" 
                                                                        data-target="#ladModal"
                                                                    >
                                                                        <i class="fas fa-search"></i>
                                                                    </button> -->
                                                                    @if(strtolower(pathinfo(public_path('storage/uploads/elad/dokumen/' . $rekabentuk->dokumen), PATHINFO_EXTENSION)) === 'pdf')
                                                                    <a href="{{ asset('storage/uploads/elad/dokumen/' . $rekabentuk->dokumen) }}" 
                                                                    target="_blank" type="button" class="btn btn-primary btn-sm" >
                                                                        <i class="fas fa-search"></i>
                                                                    </a>
                                                                    @endif

                                                                    <a href="{{ asset('storage/uploads/elad/dokumen/' . $rekabentuk->dokumen) }}" target="_blank" download>
                                                                        {!! Form::button('<i class="fas fa-download"></i>', [
                                                                            'class' => 'btn btn-success btn-sm'
                                                                        ]) !!}
                                                                    </a>
                                                                @endif
                                                            </div> --}}
                                                            <div class="btn-group">
                                                                @php
                                                                    $rekabentukPath = 'storage/uploads/elad/dokumen/' . $rekabentuk->dokumen;
                                                                    $hasFile = $rekabentuk->dokumen && file_exists(public_path($rekabentukPath));
                                                                    $isPDF = $hasFile && strtolower(pathinfo($rekabentuk->dokumen, PATHINFO_EXTENSION)) === 'pdf';
                                                                    $fileUrl = asset($rekabentukPath);
                                                                @endphp

                                                                {{-- View PDF --}}
                                                                <button 
                                                                    type="button"
                                                                    class="btn btn-sm {{ $isPDF ? 'btn-primary' : 'btn-secondary' }}"
                                                                    title="{{ $isPDF ? 'Lihat Dokumen' : 'Tiada dokumen PDF' }}"
                                                                    {{ $isPDF ? '' : 'disabled' }}
                                                                    onclick="{{ $isPDF ? "window.open('{$fileUrl}', '_blank')" : '' }}"
                                                                    style="{{ $isPDF ? '' : 'opacity: 0.6; cursor: not-allowed;' }}"
                                                                >
                                                                    <i class="fas fa-search"></i>
                                                                </button>

                                                                {{-- Download --}}
                                                                <a 
                                                                    href="{{ $hasFile ? $fileUrl : 'javascript:void(0)' }}"
                                                                    class="btn btn-sm {{ $hasFile ? 'btn-success' : 'btn-secondary disabled' }}"
                                                                    style="{{ $hasFile ? '' : 'opacity: 0.6; cursor: not-allowed;' }}"
                                                                    {{ $hasFile ? 'download' : 'aria-disabled=true' }}
                                                                    title="{{ $hasFile ? 'Muat Turun Dokumen' : 'Dokumen tidak tersedia untuk dimuat turun' }}"
                                                                >
                                                                    <i class="fas fa-download"></i>
                                                                </a>
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
                                @if(count($eLAD) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($eLAD) !!}
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
                z-index: 1050 !important;
                overflow-y: auto;
            }
            .modal-backdrop {
                z-index: 1000 !important;  /* Ensure backdrop is below modal */
            }

            .modal-content {
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

            h2 {
                margin-bottom: 20px;
            }
        </style>

        <div id="ladModal" class="modal">
            <div class="modal-content" style="background-color:rgb(25, 98, 92) !important;">
                <div class="modal-header justify-content-center bg-white">
                    <h2 class="modal-title" id="modalNama" style="text-align: center;"></h2>
                </div>

                <div class="modal-body bg-white">
                    <iframe id="eladPdf" src="" width="100%" height="500px"></iframe>
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
                $('#ladModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var title = button.data('title');
                    var elad = button.data('elad');
                    
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#modalNama').text(title);
                    }
                    if (elad && elad !== '') {
                        $('#eladPdf').attr('src', elad);
                    }
                });

                $('#ladModal').on('hidden.bs.modal', function () {
                    $(this).find('#modalNama').text('');
                    $(this).find('.modal-content').scrollTop(0);
                });
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
        <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

            document.addEventListener('DOMContentLoaded', function() {
                /*const eLAD = @json($eLAD);

                function renderPDF(elads) {
                    elads.data.forEach(elad => {
                        const url = elad.dokumen ? `{{ asset('storage/uploads/elad/dokumen') }}/${elad.dokumen}` : `{{ asset('img/no-photos.png') }}`;

                        pdfjsLib.getDocument(url).promise.then(function(pdf) {
                            return pdf.getPage(1);
                        }).then(function(page) {
                            const canvas = document.getElementById('pdf-render-' + elad.id);
                            const loadingElement = document.getElementById('loading-' + elad.id);
                            const context = canvas.getContext('2d');

                            // Get the viewport at scale 1
                            const originalViewport = page.getViewport({
                                scale: 0.5
                            });

                            // Calculate scale to fit container while maintaining aspect ratio
                            const containerWidth = 150;
                            const containerHeight = 200;
                            const scale = Math.min(
                                containerWidth / originalViewport.width,
                                containerHeight / originalViewport.height
                            );

                            // Get the viewport with calculated scale
                            const viewport = page.getViewport({
                                scale: scale
                            });

                            // Set canvas dimensions
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;

                            // Render PDF page
                            page.render({
                                canvasContext: context,
                                viewport: viewport
                            }).promise.then(() => {
                                if (loadingElement) {
                                    loadingElement.style.display = 'none';
                                }
                                canvas.style.display = 'block';
                            });
                        }).catch(function(error) {
                            console.error('Error loading PDF for ID ' + elad.id + ':', error);
                            // Show a placeholder or error message
                            const viewerElement = document.getElementById('pdf-viewer-' + elad.id);
                            if (viewerElement) {
                                viewerElement.innerHTML = '<div class="text-center text-muted"><img src="http://127.0.0.1:8000/storage/uploads/no-photos.png" class="img-fluid" alt="Responsive image"></div>';
                            }
                        });
                    });
                }

                renderPDF(eLAD);*/
            });
        </script>

    </section>
    <!-- /.section#posts -->

@endsection



