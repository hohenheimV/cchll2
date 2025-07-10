@extends('layouts.website.secondary')
@section('title', 'Direktori Penyelidikan dan Penerbitan Landskap')

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
                            <h3 class="card-title font-weight-bold my-1">Direktori Penyelidikan dan Penerbitan Landskap</h3>
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
                                                $index = $ereads->firstItem();
                                            @endphp
                                            @if($ereads->isNotEmpty())
                                                @foreach($ereads as $eread)
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ ucwords(strtolower($eread->tajuk ))}}</td>
                                                        <td>
                                                            {{ ucwords(strtolower($eread->kategori->name ?? 'Tiada Maklumat'))}}
                                                        </td>
                                                        <td class="text-center">
                                                            {!! Html::datetime($eread->tarikh, 'Y') !!}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <!-- <a href="{{ asset($eread->dokumen ? 'storage/uploads/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}" 
                                                                data-toggle="lightbox" 
                                                                data-title="{{ $eread->tajuk }}" 
                                                                data-gallery="gallery"
                                                                target="_blank">
                                                                <div id="pdf-viewer-{{$eread->id}}" style="width: 100px; height: 150px; border: 1px solid #ddd; margin: auto; cursor: pointer; display: flex; justify-content: center; align-items: center;">
                                                                    <div id="loading-{{$eread->id}}" class="text-center" style="padding-top: 80px;">
                                                                        <i class="fas fa-spinner fa-spin"></i>
                                                                    </div>
                                                                    <canvas id="pdf-render-{{$eread->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                                </div>
                                                            </a> -->
                                                            {{ ($eread->dokumen && file_exists(public_path('storage/uploads/eread/dokumen/' . $eread->dokumen))) ? $eread->sizeName . ' MB' : '-' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{-- <div class="btn-group">
                                                                @if ($eread->dokumen && file_exists(public_path('storage/uploads/eread/dokumen/' . $eread->dokumen)))
                                                                    <!-- <button 
                                                                        type="button" 
                                                                        class="btn btn-primary btn-sm" 
                                                                        data-title="{{ $eread->tajuk }}" 
                                                                        data-eread="{{ asset($eread->dokumen ? 'storage/uploads/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}"
                                                                        data-toggle="modal" 
                                                                        data-target="#readModal"
                                                                    >
                                                                        <i class="fas fa-search"></i>
                                                                    </button> -->
                                                                    @if(strtolower(pathinfo(public_path('storage/uploads/eread/dokumen/' . $eread->dokumen), PATHINFO_EXTENSION)) === 'pdf')
                                                                    <a href="{{ asset('storage/uploads/eread/dokumen/' . $eread->dokumen) }}" 
                                                                    target="_blank" type="button" class="btn btn-primary btn-sm" >
                                                                        <i class="fas fa-search"></i>
                                                                    </a>
                                                                    @endif
                                                                    <a href="{{ asset('storage/uploads/eread/dokumen/' . $eread->dokumen) }}" target="_blank" download>
                                                                        {!! Form::button('<i class="fas fa-download"></i>', [
                                                                            'class' => 'btn btn-success btn-sm'
                                                                        ]) !!}
                                                                    </a>
                                                                @endif
                                                            </div> --}}
                                                            <div class="btn-group">
                                                                @php
                                                                    $ereadPath = 'storage/uploads/eread/dokumen/' . $eread->dokumen;
                                                                    $hasFile = $eread->dokumen && file_exists(public_path($ereadPath));
                                                                    $isPDF = $hasFile && strtolower(pathinfo($eread->dokumen, PATHINFO_EXTENSION)) === 'pdf';
                                                                    $fileUrl = asset($ereadPath);
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
                                @if(count($ereads) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($ereads) !!}
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
                    <iframe id="ereadPdf" src="" width="100%" height="500px"></iframe>
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
                    var eread = button.data('eread');
                    
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#modalNama').text(title);
                    }
                    if (eread && eread !== '') {
                        $('#ereadPdf').attr('src', eread);
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
                const ereads = @json($ereads);

                ereads.data.forEach(eread => {
                    const url = eread.dokumen ? `{{ asset('storage/uploads/eread/dokumen') }}/${eread.dokumen}` : `{{ asset('img/no-photos.png') }}`;

                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        return pdf.getPage(1);
                    }).then(function(page) {
                        const canvas = document.getElementById('pdf-render-' + eread.id);
                        const loadingElement = document.getElementById('loading-' + eread.id);
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
                console.error('Error loading PDF for ID ' + eread.id + ':', error);
                // Show a placeholder or error message
                const viewerElement = document.getElementById('pdf-viewer-' + eread.id);
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



