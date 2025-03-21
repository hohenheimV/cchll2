@extends('layouts.pengurusan.app')

@section('title', 'Pengurusan Rekabentuk Landskap (eLAD)')

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col">
                <div class="card card-outline card-dark">
                    <div class="card-header border-0">
                        <h5 class="card-title">@yield('title')</h5>
                        <div class="card-tools">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

                                <div class="btn-group" role="group" aria-label="First group">
                                    {!! Form::button('<i class="fas fa-plus"></i> Daftar', [
                                    'class'=>'btn btn-success btn-sm',
                                    'onclick'=>"window.location='".route('pengurusan.elad.create')."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="landsakapTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="lembut-tab" data-toggle="tab" href="#lembut" role="tab" aria-controls="lembut" aria-selected="true">Landskap Lembut</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kejur-tab" data-toggle="tab" href="#kejur" role="tab" aria-controls="kejur" aria-selected="false">Landskap Kejur</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="landsakapTabsContent">
                            <div class="tab-pane fade show active" id="lembut" role="tabpanel" aria-labelledby="lembut-tab">
                                <div class="table-responsive">
                                    <table id="example-lembut" class="responsive table table-bordered table-hover table-striped mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="w-5">No</th>
                                                <th>Tajuk</th>
                                                <th class="text-center w-10">Saiz</th>
                                                <th class="text-center w-15">Kategori </th>
                                                <th class="text-center w-5">Tahun</th>
                                                <th class="text-center w-15">Imej Hadapan</th>
                                                <th class="text-center w-10">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($index = $eladsLembut->firstItem())
                                            @foreach($eladsLembut as $elad)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $elad->tajuk }}</td>
                                                <td class="text-center">{{ $elad->sizeName . ' MB' }}</td>
                                                <td class="text-center">
                                                    {{ $elad->kategori->name ?? 'Tiada Maklumat' }}
                                                </td>
                                                <td class="text-center">{!! Html::datetime($elad->created_at, 'Y') !!}</td>
                                                <td class="text-center">
                                                    <div id="pdf-viewer-{{$elad->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;"
                                                        onclick="window.location='{{ route('pengurusan.elad.show', $elad)}}'">
                                                        <div id="loading-{{$elad->id}}" class="text-center" style="padding-top: 80px;">
                                                            <i class="fas fa-spinner fa-spin"></i>
                                                        </div>
                                                        <canvas id="pdf-render-{{$elad->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.show', $elad) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Rekabentuk Landskap'),
                                                        ]) !!}

                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.edit', $elad) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Rekabentuk Landskap'),
                                                        ]) !!}

                                                        {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data-url' => route('pengurusan.elad.destroy', $elad),
                                                        'data-text' => 'Jawatan : ' . $elad->tajuk,
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
                                @if (count($eladsLembut) > 0)
                                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                    {!! Html::pagination($eladsLembut) !!}
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="kejur" role="tabpanel" aria-labelledby="kejur-tab">
                                <div class="table-responsive">
                                    <table id="example-kejur" class="responsive table table-bordered table-hover table-striped mb-0">
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
                                            @php($index = $eladsKejur->firstItem())
                                            @foreach($eladsKejur as $elad)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $elad->tajuk }}</td>
                                                <td class="text-center">{{ $elad->sizeName . ' MB' }}</td>
                                                <td class="text-center">
                                                    {{ $elad->kategori->name ?? 'Tiada Maklumat' }}
                                                </td>
                                                <td class="text-center">{!! Html::datetime($elad->created_at, 'Y') !!}</td>
                                                <td class="text-center">
                                                    <div id="pdf-viewer-{{$elad->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;"
                                                        onclick="window.location='{{ route('pengurusan.elad.show', $elad) }}'">
                                                        <div id="loading-{{$elad->id}}" class="text-center" style="padding-top: 80px;">
                                                            <i class="fas fa-spinner fa-spin"></i>
                                                        </div>
                                                        <canvas id="pdf-render-{{$elad->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.show', $elad) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Rekabentuk Landskap'),
                                                        ]) !!}

                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.edit', $elad) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Rekabentuk Landskap'),
                                                        ]) !!}

                                                        {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data-url' => route('pengurusan.elad.destroy', $elad),
                                                        'data-text' => 'Jawatan : ' . $elad->tajuk,
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
                                @if (count($eladsKejur) > 0)
                                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                    {!! Html::pagination($eladsKejur) !!}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    @section('page-js-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

        document.addEventListener('DOMContentLoaded', function() {
            const eladsLembut = @json($eladsLembut);
            const eladsKejur = @json($eladsKejur);

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
                            viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Preview not available</div>';
                        }
                    });
                });
            }

            renderPDF(eladsLembut);
            renderPDF(eladsKejur);

            $('#example-lembut').DataTable({
                responsive: true,
                paging: false, // Disable pagination
                searching: false, // Disable the search bar
                info: false, // Disable the "Showing X to Y of Z entries" text
                autoWidth: false, // Prevent automatic column width calculations
                ordering: false,
                dom: 'Bfrtip', // Position of the buttons
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            $('#example-kejur').DataTable({
                responsive: true,
                paging: false, // Disable pagination
                searching: false, // Disable the search bar
                info: false, // Disable the "Showing X to Y of Z entries" text
                autoWidth: false, // Prevent automatic column width calculations
                ordering: false,
                dom: 'Bfrtip', // Position of the buttons
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        });
    </script>
    @stop
</section>
@endsection