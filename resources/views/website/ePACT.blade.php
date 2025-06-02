@extends('layouts.website.secondary')
@section('title', 'Direktori Pentadbiran Kontrak dan Polisi Landskap')

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
                            <h3 class="card-title font-weight-bold my-1">Direktori Pentadbiran Kontrak dan Polisi Landskap</h3>
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
                                                <th class="text-center w-5">Tahun Penerbitan</th>
                                                <th class="w-3">Saiz</th>
                                                <th class="text-center w-1">Tindakan</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = $epacts->firstItem();
                                            @endphp
                                            @if($epacts->isNotEmpty())
                                                @foreach($epacts as $epact)
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ strtoupper($epact->tajuk) }}</td>
                                                        <td>
                                                            {{ strtoupper($epact->kategori->name ?? 'Tiada Maklumat') }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $epact->tahun ?? strtoupper('Tiada Maklumat') }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <!-- <a href="{{ asset($epact->dokumen ? 'storage/uploads/epact/dokumen/' . $epact->dokumen : 'img/no-photos.png') }}" 
                                                                data-toggle="lightbox" 
                                                                data-title="{{ $epact->tajuk }}" 
                                                                data-gallery="gallery"
                                                                target="_blank">
                                                                <div id="pdf-viewer-{{$epact->id}}" style="width: 100px; height: 150px; border: 1px solid #ddd; margin: auto; cursor: pointer; display: flex; justify-content: center; align-items: center;">
                                                                    <div id="loading-{{$epact->id}}" class="text-center" style="padding-top: 80px;">
                                                                        <i class="fas fa-spinner fa-spin"></i>
                                                                    </div>
                                                                    <canvas id="pdf-render-{{$epact->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                                </div>
                                                            </a> -->
                                                            {{ ($epact->dokumen && file_exists(public_path('storage/uploads/epact/dokumen/' . $epact->dokumen))) ? $epact->sizeName . ' MB' : strtoupper('Tiada dokumen') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                @if ($epact->dokumen && file_exists(public_path('storage/uploads/epact/dokumen/' . $epact->dokumen)))
                                                                    <!-- <button 
                                                                        type="button" 
                                                                        class="btn btn-primary btn-sm" 
                                                                        data-title="{{ $epact->tajuk }}" 
                                                                        data-epact="{{ asset($epact->dokumen ? 'storage/uploads/epact/dokumen/' . $epact->dokumen : 'img/no-photos.png') }}"
                                                                        data-toggle="modal" 
                                                                        data-target="#readModal"
                                                                    >
                                                                        <i class="fas fa-search"></i>
                                                                    </button> -->
                                                                    <a href="{{ asset('storage/uploads/epact/dokumen/' . $epact->dokumen) }}" 
                                                                    target="_blank" type="button" class="btn btn-primary btn-sm" >
                                                                        <i class="fas fa-search"></i>
                                                                    </a>
                                                                    @if($epact->kate == '182')
                                                                        <a href="{{ asset('storage/uploads/epact/dokumen/' . $epact->dokumen) }}" target="_blank" download>
                                                                            {!! Form::button('<i class="fas fa-download"></i>', [
                                                                                'class' => 'btn btn-success btn-sm'
                                                                            ]) !!}
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if (isset($epact->url))
                                                                    <a href="{{ $epact->url ?? 'javascript:void(0)' }}" 
                                                                    target="{{ $epact->url ? '_blank' : '' }}" type="button" class="btn btn-warning btn-sm" >
                                                                        <i class="fas fa-link"></i>
                                                                    </a>
                                                                @endif
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
                                @if(count($epacts) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($epacts) !!}
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

        <div id="readModal" class="modal">
            <div class="modal-content" style="background-color:rgb(25, 98, 92) !important;">
                <div class="modal-header justify-content-center bg-white">
                    <h2 class="modal-title" id="modalNama" style="text-align: center;"></h2>
                </div>

                <div class="modal-body bg-white">
                    <iframe id="epactPdf" src="" width="100%" height="500px"></iframe>
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
                    var epact = button.data('epact');
                    
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#modalNama').text(title);
                    }
                    if (epact && epact !== '') {
                        $('#epactPdf').attr('src', epact);
                    }
                });

                $('#readModal').on('hidden.bs.modal', function () {
                    $(this).find('#modalNama').text('');
                    $(this).find('.modal-content').scrollTop(0);
                });
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
        <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

            document.addEventListener('DOMContentLoaded', function() {
                const epacts = @json($epacts);

                epacts.data.forEach(epact => {
                    const url = epact.dokumen ? `{{ asset('storage/uploads/epact/dokumen') }}/${epact.dokumen}` : `{{ asset('img/no-photos.png') }}`;

                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        return pdf.getPage(1);
                    }).then(function(page) {
                        const canvas = document.getElementById('pdf-render-' + epact.id);
                        const loadingElement = document.getElementById('loading-' + epact.id);
                        const context = canvas.getContext('2d');

                        const originalViewport = page.getViewport({ scale: 0.5 });

                        const containerWidth = 150;
                        const containerHeight = 200;
                        const scale = Math.min(
                            containerWidth / originalViewport.width,
                            containerHeight / originalViewport.height
                        );

                        const viewport = page.getViewport({ scale: scale });

                        canvas.width = viewport.width;
                        canvas.height = viewport.height;

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
                console.error('Error loading PDF for ID ' + epact.id + ':', error);
                // Show a placeholder or error message
                const viewerElement = document.getElementById('pdf-viewer-' + epact.id);
                        if (viewerElement) {
                            viewerElement.innerHTML = '<div class="text-center text-muted"><img src="http://127.0.0.1:8000/storage/uploads/no-photos.png" class="img-fluid" alt="Responsive image"></div>';
                        }
                    });
                });
            });
        </script>

    </section>
    <!-- /.section#posts -->

@endsection



