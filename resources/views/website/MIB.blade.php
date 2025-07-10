@extends('layouts.website.secondary')
@section('title', 'Direktori Rakan Taman')

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
                            <h3 class="card-title font-weight-bold my-1">Direktori Rakan Taman</h3>
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
                                    <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0" style="font-size: 12px;">
                                        <thead style="background-color:rgb(0, 0, 0) !important;color: white;">
                                            <tr>
                                                <th class="w-1">Bil.</th>
                                                <th class="w-15">Taman Perumahan </th>
                                                <th class="text-center w-5">PBT</th>
                                                <th class="text-center w-1">Tindakan</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = $mibs->firstItem();
                                            @endphp
                                            @if($mibs->isNotEmpty())
                                                @foreach($mibs as $mib)
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $mib->taman }}</td>
                                                        <td>
                                                            {{ $mib->pbt ?? 'Tiada Maklumat' }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                {!! Form::button('<i class="fas fa-search"></i>', [
                                                                'class'=>'btn btn-info btn-sm',
                                                                'onclick'=>"window.location='".route('website.MIB_aktiviti', ['keyword' => $mib->id])."'"
                                                                ]) !!}
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
                                @if(count($mibs) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($mibs) !!}
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
                    <iframe id="mibPdf" src="" width="100%" height="500px"></iframe>
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
                    var mib = button.data('mib');
                    
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#modalNama').text(title);
                    }
                    if (mib && mib !== '') {
                        $('#mibPdf').attr('src', mib);
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
                const mibs = @json($mibs);

                mibs.data.forEach(mib => {
                    const url = mib.dokumen ? `{{ asset('storage/images/shares/mib/dokumen') }}/${mib.dokumen}` : `{{ asset('img/no-photos.png') }}`;

                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        return pdf.getPage(1);
                    }).then(function(page) {
                        const canvas = document.getElementById('pdf-render-' + mib.id);
                        const loadingElement = document.getElementById('loading-' + mib.id);
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
                console.error('Error loading PDF for ID ' + mib.id + ':', error);
                // Show a placeholder or error message
                const viewerElement = document.getElementById('pdf-viewer-' + mib.id);
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



