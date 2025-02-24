@extends('layouts.pengurusan.app')

@section('title', 'Maklumat R&D Landskap ')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-olive card-outline">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold my-1">Senarai @yield('title')</h3>

                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                     @if (Auth::user()->hasRole('Perunding'))
                                     {{--Role is Perunding, Hide Button--}}
                                        
                                    @else
                                    {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                        'onclick' => "window.location='" . route('pengurusan.eread.create') . "'",
                                        'class' => 'btn bg-success btn-sm',
                                        Html::tooltip('Daftar Maklumat R&D Landskap '),
                                    ]) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="example" class="responsive table table-bordered table-hover table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="w-5"></th>
                                        <th>Tajuk</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th class="text-center w-10">Saiz</th>
                                        <th class="text-center w-15">Kategori </th>
                                        <th class="text-center w-5">Tahun</th>
                                        <th class="text-center w-15">Imej Hadapan</th>
                                        <th class="text-center w-10">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($index = $ereads->firstItem())
                                    @foreach($ereads as $eread)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $eread->tajuk }}</td>
                                            <td class="text-center">{{ $eread->sizeName . ' MB' }}</td>
                                            <td class="text-center">
                                                {{ $eread->kategori->name ?? 'Tiada Maklumat' }}
                                            </td>
                                            <td class="text-center">{!! Html::datetime($eread->created_at, 'Y') !!}</td>
                                            <td class="text-center">
                                                <a href="{{ asset($eread->dokumen ? 'storage/images/shares/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}" 
                                                data-toggle="lightbox" 
                                                data-title="{{ $eread->tajuk }}" 
                                                data-gallery="gallery"
                                                target="_blank">
                                                    <div id="pdf-viewer-{{$eread->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
                                                        <div id="loading-{{$eread->id}}" class="text-center" style="padding-top: 80px;">
                                                            <i class="fas fa-spinner fa-spin"></i>
                                                        </div>
                                                        <canvas id="pdf-render-{{$eread->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                    </div>
                                                </a>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.eread.show', $eread) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran R&D Landskap'),
                                                    ]) !!}

                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.eread.edit', $eread) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini R&D Landskap'),
                                                    ]) !!}

                                                    {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data-url' => route('pengurusan.eread.destroy', $eread),
                                                        'data-text' => 'Jawatan : ' . $eread->tajuk,
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#modalDelete',
                                                        Html::tooltip('Padam'),
                                                    ]) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    @if (count($ereads) > 0)
                        <div
                            class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                            {!! Html::pagination($ereads) !!}
                        </div>
                        <!-- /.card-footer -->
                    @endif
                </div><!-- /.card -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    @section('page-js-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
    
    @foreach($ereads as $eread)
        (function(ereadId) {
            const url = "{{ asset($eread->dokumen ? 'storage/images/shares/eread/dokumen/' . $eread->dokumen : 'img/no-photos.png') }}";
            
            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                return pdf.getPage(1);
            }).then(function(page) {
                const canvas = document.getElementById('pdf-render-' + ereadId);
                const loadingElement = document.getElementById('loading-' + ereadId);
                const context = canvas.getContext('2d');
                
                // Get the viewport at scale 1
                const originalViewport = page.getViewport({ scale: 0.5 });
                
                // Calculate scale to fit container while maintaining aspect ratio
                const containerWidth = 150;
                const containerHeight = 200;
                const scale = Math.min(
                    containerWidth / originalViewport.width,
                    containerHeight / originalViewport.height
                );
                
                // Get the viewport with calculated scale
                const viewport = page.getViewport({ scale: scale });
                
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
                console.error('Error loading PDF for ID ' + ereadId + ':', error);
                // Show a placeholder or error message
                const viewerElement = document.getElementById('pdf-viewer-' + ereadId);
                if (viewerElement) {
                    viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Preview not available</div>';
                }
            });
        })({{ $eread->id }});
    @endforeach
    </script>
        <script>
            $(document).ready(function() {
                $('#modalPanorama').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var href = button.data('href'); // Extract info from data-* attributes
                    $('[data-tooltip="tooltip"]').tooltip('hide');
                    // Load URL from data-href
                    $('#modalPanorama .modal-content').load(href, function(responseTxt, statusTxt, xhr) {

                        //Date picker
                        $('input[name="tarikh"]').daterangepicker({
                            singleDatePicker: true,
                            showDropdowns: true,
                            minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year')
                                .format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                            maxDate: moment().endOf('month').format(
                            'DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                            drops: "up",
                            locale: {
                                format: 'DD-MM-YYYY'
                            }
                        });

                        validation();

                        //If success load, show modal
                        if (statusTxt == "success") {
                            $('#modalPanorama').modal('show'); // Show Modal start
                            // clear modal content if modal closed
                            $('#modalPanorama').on('hidden.bs.modal', function() {
                                $('[data-tooltip="tooltip"]').tooltip('hide');
                                $(this).find('.modal-content').empty();
                            });
                        } else {
                            alert("Error: " + xhr.status + ": " + xhr.statusText);
                        }
                    });
                });

                //jquery validation
                function validation() {
                    $('#modalFormPanorama').validate({ //sets up the validator
                        submitHandler: function(form) {
                            form.submit();
                        },
                        rules: {
                            'kod_tag': 'required',
                            'kategori': 'required',
                            'jenis': 'required',
                            'tarikh': 'required',
                            'lat': 'required',
                            'lng': 'required',
                        }
                    });
                }
            });
        </>
    @stop
@endsection
