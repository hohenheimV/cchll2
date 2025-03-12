@extends('layouts.website.secondary')
@section('title', 'Direktori Pelan Induk Landskap')

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
                            <h3 class="card-title font-weight-bold my-1">Direktori Pelan Induk Landskap</h3>
                            <div class="card-tools">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                <select id="negeri" name="negeri" onchange="handleSelectChange()">
                                    <option value="">Papar Semua</option>
                                </select>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    // Fetch and populate the Negeri dropdown with data
                                    $(document).ready(function() {
                                        function capitalizeWords(str) {
                                            return str
                                                .toLowerCase() // Convert the entire string to lowercase
                                                .split(' ')    // Split the string into an array of words by spaces
                                                .map(function(word) {
                                                    return word.charAt(0).toUpperCase() + word.slice(1); // Capitalize the first letter of each word
                                                })
                                                .join(' ');    // Join the array back into a string
                                        }

                                        $.ajax({
                                            url: '/get-negeri', // API endpoint to get negeri data
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(data) {
                                                // Populate the Negeri dropdown with the data
                                                $('#negeri').empty(); // Clear current options
                                                $('#negeri').append('<option value="">Papar Semua</option>');

                                                $.each(data, function(key, value) {
                                                    // Add each Negeri to the dropdown
                                                    $('#negeri').append('<option value="' + value.kod_negeri + '">' + capitalizeWords(value.nama_negeri) + '</option>');
                                                });

                                                var negeriSelected = "{{ isset($keyword) ? $keyword : '' }}";
                                                if (negeriSelected) {
                                                    $('#negeri').val(negeriSelected);
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error("Error fetching Negeri data: ", error);
                                            }
                                        });
                                    });

                                    // Function to handle the dropdown change event
                                    function handleSelectChange() {
                                        var selectedKeyword = $('#negeri').val(); // Get the selected negeri value

                                        if (selectedKeyword) {
                                            // Redirect to the route with the selected keyword
                                            window.location.href = "/epil-pelan/" + selectedKeyword;
                                        } else {
                                            window.location.href = "/epil-pelan";
                                        }
                                    }
                                </script>
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
                                    <table id="example" class="responsive table table-bordered table-hover table-striped mb-0" style="font-size: 12px;">
                                        <thead style="background-color:rgb(0, 0, 0) !important;color: white;">
                                            <tr>
                                                <th class="w-1">Bil.</th>
                                                <th class="w-15">Nama </th>
                                                <th class="text-center w-5">Pihak Berkuasa Tempatan</th>
                                                <th class="w-3">Pelan Induk Landskap</th>
                                                <th class="text-center w-1">Tindakan</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = $ePIL->firstItem();
                                                $previousNegeri = null;
                                            @endphp
                                            @if($ePIL->isNotEmpty())
                                                @foreach($ePIL as $pelan)
                                                    @if($previousNegeri !== null && $previousNegeri !== $pelan->negeri)
                                                        <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">{{ $pelan->negeri}}</td></tr>
                                                    @elseif($previousNegeri === $pelan->negeri)
                                                    @else
                                                        <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">{{ $pelan->negeri}}</td></tr>
                                                    @endif
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $pelan->nama_pelan}}</td>
                                                        <td>
                                                            {{ $pelan->nama_pbt }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?php $folder = str_replace(' ', '_', $pelan->nama_pelan); ?>
                                                            <a href="{{ asset($pelan->nama_dokumen_pelan ? 'storage/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan : 'storage/uploads/no-photos.png' ) }}" 
                                                                target="_blank" download>
                                                                <div id="pdf-viewer-{{$pelan->id_dokumen_pelan ?? $pelan->id_pelan}}" 
                                                                    style="width: 100px; height: 150px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
                                                                    <div id="loading-{{$pelan->id_dokumen_pelan}}" 
                                                                        class="text-center" 
                                                                        style="padding-top: 80px;">
                                                                        <i class="fas fa-spinner fa-spin"></i>
                                                                    </div>
                                                                    <canvas id="pdf-render-{{$pelan->id_dokumen_pelan}}" 
                                                                            style="width: 100%; height: 100%; object-fit: contain; display: none;">
                                                                    </canvas>
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                @if ($pelan->nama_dokumen_pelan && file_exists(public_path('storage/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan)))
                                                                <button 
                                                                    type="button" 
                                                                    class="btn btn-primary btn-sm" 
                                                                    data-title="{{ $pelan->nama_pelan }}" 
                                                                    data-pelan="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan) }}"
                                                                    data-toggle="modal" 
                                                                    data-target="#pelanModal"
                                                                >
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                    <a href="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan) }}" target="_blank" download>
                                                                        {!! Form::button('<i class="fas fa-download"></i>', [
                                                                            'class' => 'btn btn-success btn-sm'
                                                                        ]) !!}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        @php
                                                            $previousNegeri = $pelan->negeri; // Update the previous value
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr><td colspan="5" class="text-center">No data available</td></tr>
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                                @if(count($ePIL) > 0)
                                    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                        {!! Html::pagination($ePIL) !!}
                                    </div>
                                    <!-- /.card-footer -->
                                @endif
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
        </style>

        <div id="pelanModal" class="modal">
            <div class="modal-content" style="background-color:rgb(25, 98, 92) !important;">
                <div class="modal-header justify-content-center bg-white">
                    <h2 class="modal-title" id="modalNama" style="text-align: center;"></h2>
                </div>

                <div class="modal-body bg-white">
                    <iframe id="pelanPdf" src="" width="100%" height="500px"></iframe>
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
                $('#pelanModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var title = button.data('title');
                    var pelan = button.data('pelan');
                    
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#modalNama').text(title);
                    }
                    if (pelan && pelan !== '') {
                        $('#pelanPdf').attr('src', pelan);
                    }
                });

                $('#pelanModal').on('hidden.bs.modal', function () {
                    $(this).find('#modalNama').text('');
                    $(this).find('.modal-content').scrollTop(0);
                });
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
        <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

            document.addEventListener('DOMContentLoaded', function () {
                const ePIL = @json($ePIL);

                // Use ePIL.data to loop through the records
                ePIL.data.forEach(pelan => {
                    // console.log(pelan);
                    let folder = pelan.nama_pelan.replace(/\s+/g, '_'); // Replace spaces with underscores in folder name
                    const url = pelan.nama_dokumen_pelan ?
                        `/storage/uploads/ePIL/${folder}/${pelan.nama_dokumen_pelan}` : 
                        '/img/no-photos.png';

                    // Load and render the first page of the PDF document
                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        return pdf.getPage(1); // Get the first page of the document
                    }).then(function(page) {
                        const canvas = document.getElementById('pdf-render-' + pelan.id_dokumen_pelan);
                        const loadingElement = document.getElementById('loading-' + pelan.id_dokumen_pelan);
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
                        // console.error('Error loading PDF for ID ' + pelan.id_dokumen_pelan + ':', error);
                        const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
                        if (viewerElement) {
                            viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Preview not available</div>';
                        }
                    });
                });
            });
        </script>

    </section>
    <!-- /.section#posts -->

@endsection



