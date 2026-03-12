@extends('layouts.pengurusan.app')

{{-- @section('title', 'Maklumat Polisi Landskap (ePACT)') --}}

@section('title', 'Maklumat Polisi Landskap dan Pentadbiran Kontrak')

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
                                    'onclick'=>"window.location='".route('pengurusan.epact.create')."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="w-2">Bil</th>
                                        <th class="text-center">Tajuk</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th class="text-center w-10">Saiz</th>
                                        <th class="text-center w-15">Kategori </th>
                                        <th class="text-center w-15">Sumber Terbitan </th>
                                        <th class="text-center w-5">Tahun Terbitan</th>
                                        <th class="text-center w-15">Imej Hadapan</th>
                                        <th class="text-center w-10">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($index = 1)
                                    @foreach($epacts as $epact)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $epact->tajuk }}</td>
                                            <td class="text-center">{{ $epact->sizeName . ' MB' }}</td>
                                            <td class="text-center">
                                                {{ $epact->kategori->name ?? 'Tiada Maklumat' }}
                                            </td>
                                            <td class="text-center">
                                            @if ($epact->sumber == '11')
                                                {{ $epact->subkat ?? 'Tiada Maklumat' }}
                                            @else
                                                <?php
                                                    $sumber = [
                                                        '0' => 'Tiada Maklumat',
                                                        '1' => 'Bahagian Pengurusan Landskap',
                                                        '2' => 'Bahagian Taman Awam',
                                                        '3' => 'Bahagian Pembangunan Landskap',
                                                        '4' => 'Bahagian Khidmat Teknikal',
                                                        '5' => 'Bahagian Penyelidikan & Pemuliharaan',
                                                        '6' => 'Bahagian Penilaian & Penyelenggaraan',
                                                        '7' => 'Bahagian Teknologi Maklumat',
                                                        '8' => 'Bahagian Promosi & Industri Landskap',
                                                        '9' => 'Bahagian Dasar & Pengurusan Korporat',
                                                        '10' => 'Bahagian Kontrak & Ukur Bahan',
                                                    ];
                                                ?>
                                                {{ $sumber[$epact->sumber] ?? 'Tiada Maklumat' }}
                                            @endif
                                        </td>
                                            <td class="text-center">{{ $epact->tahun }}</td>
                                            <td class="text-center">
                                                <a href="{{ $epact->dokumen ? asset('storage/uploads/epact/dokumen/' . $epact->dokumen) : asset('img/no-photos.png') }}" 
                                                data-toggle="lightbox" 
                                                data-title="{{ $epact->tajuk }}" 
                                                data-gallery="gallery"
                                                target="_blank">
                                                    <div id="pdf-viewer-{{$epact->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
                                                        <div id="loading-{{$epact->id}}" class="text-center" style="padding-top: 80px;">
                                                            <i class="fas fa-spinner fa-spin"></i>
                                                        </div>
                                                        <canvas id="pdf-render-{{$epact->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.epact.show', $epact) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Maklumat'),
                                                    ]) !!}

                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.epact.edit', $epact) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Maklumat'),
                                                    ]) !!}

                                                    {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'data-url' => route('pengurusan.epact.destroy', $epact),
                                                        'data-text' => 'Jawatan : ' . $epact->tajuk,
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
                </div><!-- /.card -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    @section('page-js-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    document.addEventListener('DOMContentLoaded', function() {
        const epacts = @json($epacts->values());

        function renderDocumentsOnPage() {
            $('#epacttable tbody tr').each(function() {
                const row = $(this);
                const id = row.find('[id^="pdf-viewer-"]').attr('id');
                if (!id) return;
                const epactId = id.replace('pdf-viewer-', '');
                const epact = epacts.find(e => e.id == epactId);
                const viewerElement = document.getElementById('pdf-viewer-' + epactId);

                if (!epact || !viewerElement) return;

                if (epact.dokumen && epact.dokumen.endsWith('.pdf')) {
                    const url = `{{ asset('storage/uploads/epact/dokumen') }}/${epact.dokumen}`;
                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        return pdf.getPage(1);
                    }).then(function(page) {
                        const canvas = document.getElementById('pdf-render-' + epactId);
                        const loadingElement = document.getElementById('loading-' + epactId);
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
                    viewerElement.innerHTML = `<img src="{{ asset('img/no-photos.png') }}" alt="No Preview Available" style="width: 100%; height: 100%; object-fit: contain;">`;
                }
            });
        }

        const table = $('#epacttable').DataTable({
            responsive: true,
            paging: true,
            pageLength: 10,
            searching: true,
            info: false,
            autoWidth: false,
            ordering: false,
            dom: '<"top"fB>rt<"bottom"p><"clear">',
            language: {
                search: "Carian:"
            },
            buttons: [
                // {
                //     extend: 'copy',
                //     text: 'Salin',
                //     exportOptions: {
                //         columns: [0,1,2,3,4,5],
                //         modifier: { search: 'applied', order: 'applied', page: 'all' }
                //     }
                // },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        modifier: { search: 'applied', order: 'applied', page: 'all' }
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        modifier: { search: 'applied', order: 'applied', page: 'all' }
                    }
                },
                // {
                //     extend: 'pdf',
                //     text: 'PDF',
                //     exportOptions: {
                //         columns: [0,1,2,3,4,5],
                //         modifier: { search: 'applied', order: 'applied', page: 'all' }
                //     }
                // },
                // {
                //     extend: 'print',
                //     text: 'Cetak',
                //     exportOptions: {
                //         columns: [0,1,2,3,4,5],
                //         modifier: { search: 'applied', order: 'applied', page: 'all' }
                //     }
                // }
            ]
        });

        // Initial render
        renderDocumentsOnPage();

        // Re-render previews on every page/change/search
        table.on('draw', function() {
            renderDocumentsOnPage();
        });
    });
    </script>
    <style>
    @media print {
        #epacttable th:nth-child(7),
        #epacttable th:nth-child(8),
        #epacttable td:nth-child(7),
        #epacttable td:nth-child(8) {
            display: none !important;
        }
    }
    </style>
    @stop
@endsection
