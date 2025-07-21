@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Penyelidikan dan Penerbitan Landskap')

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
                                    'onclick'=>"window.location='".route('pengurusan.eread.create')."'",
                                    Html::tooltip('Daftar')
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ereadtable" class="responsive table table-bordered table-hover table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="w-5">Bil</th>
                                        <th>Tajuk</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th class="text-center w-10">Saiz</th>
                                        <th class="text-center w-15">Terbitan Bahagian</th>
                                        <th class="text-center w-15">Kategori </th>
                                        <th class="text-center w-5">Tahun Terbitan</th>
                                        <th class="text-center w-15">Imej Hadapan</th>
                                        <th class="text-center w-10">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($index = 1)
                                    @foreach($ereads as $eread)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $eread->tajuk }}</td>
                                            <td class="text-center">{{ $eread->sizeName . ' MB' }}</td>
                                            <td class="text-center">
                                                <?php
                                                    $bahagian_jln = [
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
                                                {{ $bahagian_jln[$eread->bahagian_jln] ?? 'Tiada Maklumat' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $eread->kategori->name ?? 'Tiada Maklumat' }}
                                            </td>
                                            <td class="text-center">{!! Html::datetime($eread->tarikh, 'Y') !!}</td>
                                            <td class="text-center">
                                                <a href="{{ asset($eread->dokumen ? 'storage/uploads/eread/dokumen/' . $eread->dokumen : 'img/zip-preview.png') }}" 
                                                data-toggle="lightbox" 
                                                data-title="{{ $eread->tajuk }}" 
                                                data-gallery="gallery"
                                                target="_blank">
                                                    <div id="pdf-viewer-{{$eread->id}}" style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
                                                        @if(Str::endsWith($eread->dokumen, '.zip'))
                                                            <img src="{{ asset('img/zip-preview.png') }}" alt="ZIP File Preview" style="width: 100%; height: 100%; object-fit: contain;">
                                                        @else
                                                            <div id="loading-{{$eread->id}}" class="text-center" style="padding-top: 80px;">
                                                                <i class="fas fa-spinner fa-spin"></i>
                                                            </div>
                                                            <canvas id="pdf-render-{{$eread->id}}" style="width: 100%; height: 100%; object-fit: contain; display: none;"></canvas>
                                                        @endif
                                                    </div>
                                                </a>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    {!! Form::button('<i class="fas fa-search"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.eread.show', $eread) . "'",
                                                        'class' => 'btn bg-info btn-sm',
                                                        Html::tooltip('Butiran Maklumat'),
                                                    ]) !!}

                                                    {!! Form::button('<i class="fas fa-pencil-alt"></i>', [
                                                        'onclick' => "window.location='" . route('pengurusan.eread.edit', $eread) . "'",
                                                        'class' => 'btn bg-warning btn-sm',
                                                        Html::tooltip('Kemaskini Maklumat'),
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
                    {{-- 
@if (count($ereads) > 0)
    <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
        {!! Html::pagination($ereads) !!}
    </div>
@endif
--}}
                </div><!-- /.card -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    @section('page-js-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    document.addEventListener('DOMContentLoaded', function() {
        const ereads = @json($ereads->values());

        function renderDocumentsOnPage() {
            $('#ereadtable tbody tr').each(function() {
                const row = $(this);
                const id = row.find('[id^="pdf-viewer-"]').attr('id');
                if (!id) return;
                const ereadId = id.replace('pdf-viewer-', '');
                const eread = ereads.find(e => e.id == ereadId);
                const viewerElement = document.getElementById('pdf-viewer-' + ereadId);

                if (!eread || !viewerElement) return;

                if (eread.dokumen && eread.dokumen.endsWith('.pdf')) {
                    const url = `{{ asset('storage/uploads/eread/dokumen') }}/${eread.dokumen}`;
                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        return pdf.getPage(1);
                    }).then(function(page) {
                        const canvas = document.getElementById('pdf-render-' + ereadId);
                        const loadingElement = document.getElementById('loading-' + ereadId);
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
                    viewerElement.innerHTML = `<img src="{{ asset('img/zip-preview.png') }}" alt="ZIP File Preview" style="width: 100%; height: 100%; object-fit: contain;">`;
                }
            });
        }

        const table = $('#ereadtable').DataTable({
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
        #ereadtable th:nth-child(7),
        #ereadtable th:nth-child(8),
        #ereadtable td:nth-child(7),
        #ereadtable td:nth-child(8) {
            display: none !important;
        }
    }
    </style>
    @stop
@endsection
