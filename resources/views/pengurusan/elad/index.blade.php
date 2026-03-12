@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Rekabentuk Landskap')

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
                                                <th class="w-5">Bil</th>
                                                <th>Tajuk</th>
                                                <th class="text-center w-10">Saiz</th>
                                                <th class="text-center w-15">Kategori </th>
                                                <th class="text-center w-5">Tahun</th>
                                                <th class="text-center w-15">Imej Hadapan</th>
                                                <th class="text-center w-10">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($index = 1)
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
                                                    <a href="{{ asset($elad->dokumen ? 'storage/uploads/elad/dokumen/' . $elad->dokumen : 'img/zip-preview.png') }}" 
                                                    data-toggle="lightbox" 
                                                    data-title="{{ $elad->tajuk }}" 
                                                    data-gallery="gallery"
                                                    target="_blank">
                                                        <div id="pdf-viewer-{{$elad->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
                                                            @if(Str::endsWith($elad->dokumen, '.zip'))
                                                                <img src="{{ asset('img/zip-preview.png') }}" alt="ZIP File Preview" style="width: 100%; height: 100%; object-fit: contain;">
                                                            @else
                                                                <div id="loading-{{$elad->id}}" class="text-center" style="padding-top: 80px;">
                                                                    <i class="fas fa-spinner fa-spin"></i>
                                                                </div>
                                                                <canvas id="pdf-render-{{$elad->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.show', $elad) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Maklumat'),
                                                        ]) !!}

                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.edit', $elad) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Maklumat'),
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
                                {{-- Remove or comment out the pagination footer --}}
                                {{-- 
                                @if (count($eladsLembut) > 0)
                                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                    {!! Html::pagination($eladsLembut) !!}
                                </div>
                                @endif
                                --}}
                            </div>
                            <div class="tab-pane fade" id="kejur" role="tabpanel" aria-labelledby="kejur-tab">
                                <div class="table-responsive">
                                    <table id="example-kejur" class="responsive table table-bordered table-hover table-striped mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="w-5">Bil</th>
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
                                            @php($index = 1)
                                            @foreach($eladsKejur as $elad)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $elad->tajuk }}</td>
                                                <td class="text-center">{{ $elad->sizeName . ' MB' }}</td>
                                                <td class="text-center">
                                                    {{ $elad->kategori->name ?? 'Tiada Maklumat' }}
                                                </td>
                                                <td class="text-center">{!! Html::datetime($elad->tarikh, 'Y') !!}</td>
                                                <td class="text-center">
                                                <a href="{{ asset($elad->dokumen ? 'storage/uploads/elad/dokumen/' . $elad->dokumen : 'img/zip-preview.png') }}" 
                                                data-toggle="lightbox" 
                                                data-title="{{ $elad->tajuk }}" 
                                                data-gallery="gallery"
                                                target="_blank">
                                                    <div id="pdf-viewer-{{$elad->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
                                                        @if(Str::endsWith($elad->dokumen, '.zip'))
                                                            <img src="{{ asset('img/zip-preview.png') }}" alt="ZIP File Preview" style="width: 100%; height: 100%; object-fit: contain;">
                                                        @else
                                                            <div id="loading-{{$elad->id}}" class="text-center" style="padding-top: 80px;">
                                                                <i class="fas fa-spinner fa-spin"></i>
                                                            </div>
                                                            <canvas id="pdf-render-{{$elad->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                        @endif
                                                    </div>
                                                </a>
                                            </td>
                                                <td>
                                                    <div class="btn-group">
                                                        {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.show', $elad) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Maklumat'),
                                                        ]) !!}

                                                        {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.elad.edit', $elad) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Maklumat'),
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
                                {{-- Remove or comment out the pagination footer --}}
                                {{-- 
                                @if (count($eladsKejur) > 0)
                                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                                    {!! Html::pagination($eladsKejur) !!}
                                </div>
                                @endif
                                --}}
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
            const eladsLembut = @json($eladsLembut->values());
            const eladsKejur = @json($eladsKejur->values());

            function renderDocumentsOnPage(elads, tableId) {
                $(`#${tableId} tbody tr`).each(function() {
                    const row = $(this);
                    const id = row.find('[id^="pdf-viewer-"]').attr('id');
                    if (!id) return;
                    const eladId = id.replace('pdf-viewer-', '');
                    const elad = elads.find(e => e.id == eladId);
                    const viewerElement = document.getElementById('pdf-viewer-' + eladId);

                    if (!elad || !viewerElement) return;

                    // ZIP preview
                    if (elad.dokumen && elad.dokumen.endsWith('.zip')) {
                        viewerElement.innerHTML = `<img src="{{ asset('img/zip-preview.png') }}" alt="ZIP File Preview" style="width: 100%; height: 100%; object-fit: contain;">`;
                        return;
                    }

                    // PDF preview
                    if (elad.dokumen && elad.dokumen.endsWith('.pdf')) {
                        const url = `{{ asset('storage/uploads/elad/dokumen') }}/${elad.dokumen}`;
                        pdfjsLib.getDocument(url).promise.then(function(pdf) {
                            return pdf.getPage(1);
                        }).then(function(page) {
                            const canvas = document.getElementById('pdf-render-' + eladId);
                            const loadingElement = document.getElementById('loading-' + eladId);
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
                                if (loadingElement) loadingElement.style.display = 'none';
                                canvas.style.display = 'block';
                            });
                        }).catch(function(error) {
                            viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Preview not available</div>';
                        });
                    } else {
                        // Unsupported file type
                        viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Unsupported file type</div>';
                    }
                });
            }

            // DataTable for Lembut
            const tableLembut = $('#example-lembut').DataTable({
                responsive: true,
                paging: true,
                pageLength: 20,
                searching: true,
                info: false,
                autoWidth: false,
                ordering: false,
                dom: '<"top"fB>rt<"bottom"p><"clear">',
                language: { search: "Carian:" },
                buttons: [
                    // {
                    //     extend: 'copy',
                    //     text: 'Salin',
                    //     exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    // },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    },
                    // {
                    //     extend: 'pdf',
                    //     text: 'PDF',
                    //     exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    // },
                    // {
                    //     extend: 'print',
                    //     text: 'Cetak',
                    //     exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    // }
                ]
            });

            // DataTable for Kejur
            const tableKejur = $('#example-kejur').DataTable({
                responsive: true,
                paging: true,
                pageLength: 20,
                searching: true,
                info: false,
                autoWidth: false,
                ordering: false,
                dom: '<"top"fB>rt<"bottom"p><"clear">',
                language: { search: "Carian:" },
                buttons: [
                    // {
                    //     extend: 'copy',
                    //     text: 'Salin',
                    //     exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    // },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    },
                    // {
                    //     extend: 'pdf',
                    //     text: 'PDF',
                    //     exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    // },
                    // {
                    //     extend: 'print',
                    //     text: 'Cetak',
                    //     exportOptions: { columns: [0,1,2,3,4], modifier: { search: 'applied', order: 'applied', page: 'all' } }
                    // }
                ]
            });

            // Initial render for both tables
            renderDocumentsOnPage(eladsLembut, 'example-lembut');
            renderDocumentsOnPage(eladsKejur, 'example-kejur');

            // Re-render previews on every page/change/search for both tables
            tableLembut.on('draw', function() {
                renderDocumentsOnPage(eladsLembut, 'example-lembut');
            });
            tableKejur.on('draw', function() {
                renderDocumentsOnPage(eladsKejur, 'example-kejur');
            });
        });
    </script>
    <style>
    @media print {
        #example-kejur th:nth-child(5,6),
        #example-kejur td:nth-child(5,6) {
            display: none !important;
        }
    }
    @media print {
        #example-lembut th:nth-child(5,6),
        #example-lembut td:nth-child(5,6) {
            display: none !important;
        }
    }
    </style>
    @stop
</section>
@endsection