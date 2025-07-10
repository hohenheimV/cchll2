@extends('layouts.pengurusan.app')

@section('title', 'Maklumat Pelan Induk Landskap')

@section('content')

@php
    //dd(auth()->user()->roles, auth()->user()->permissions);
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem'))
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan Pegawai JLN] --}}</h3>
                @elseif(Auth::user()->hasRole('KP/ TKP JLN|Pentadbir Sistem'))
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan KP/TKP/B. Penilaian] --}}</h3>
                @elseif(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                    <h3 class="card-title font-weight-bold my-1">Senarai @yield('title') {{-- [Paparan PBT] --}}</h3>
                @endif
                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('<i class="fas fa-plus"></i> Daftar', 
                                    ['onclick'=>"window.location='".route('pengurusan.ePIL.create')."'",
                                    'class'=>'btn bg-success btn-sm', Html::tooltip('Daftar PIL')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="w-1">Bil.</th>
                                    <th>Tajuk Pelan Induk Landskap</th>
                                    <th class="text-center w-5">Imej Hadapan</th>
                                    @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|KP/ TKP JLN'))
                                        <th class="text-center w-10">PBT</th>
                                    @endif
                                        <th class="text-center w-12">Paparan Portal</th>
                                        <th class="text-center w-5">Tindakan</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(Auth::user()->hasRole('Pegawai|Pentadbir Sistem|Pihak Berkuasa Tempatan|KP/ TKP JLN'))
                                    @php($index = $ePIL->firstItem())
                                    @php($paparan_portal = [
                                        ['id' => 'Papar', 'label' => 'bg-success'], // Green background for approved
                                        ['id' => 'Tidak Papar', 'label' => 'bg-danger'], // Red background for failed
                                    ])
                                    @php($status_count = count($paparan_portal))
                                    @forelse($ePIL as $pelan)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ strtoupper($pelan->nama_pelan) }}</td>
                                            <td style="text-align: center;">
                                                <?php 
                                                    $folder = str_replace(' ', '_', $pelan->id_pelan.' '.$pelan->nama_pelan); 
                                                    $fileSizeInMB = null;
                                                    $isPdf = false;

                                                    if (isset($pelan->nama_dokumen_pelan)) {
                                                        $filePath = storage_path('app/public/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan);

                                                        if (file_exists($filePath)) {
                                                            $fileSizeInBytes = filesize($filePath);
                                                            $fileSizeInMB = $fileSizeInBytes / 1048576;

                                                            // Check if file ends with .pdf (case-insensitive)
                                                            $isPdf = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'pdf';
                                                        }
                                                    }
                                                ?>
                                                @if ($pelan->nama_dokumen_pelan && file_exists(public_path('storage/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan)) && $fileSizeInMB < 1000 && $isPdf)
                                                    <a href="{{ asset($pelan->nama_dokumen_pelan ? 'storage/uploads/ePIL/'.$folder.'/'.$pelan->nama_dokumen_pelan : 'storage/uploads/no-photos.png' ) }}" 
                                                        target="_blank">
                                                        <div id="pdf-viewer-{{$pelan->id_dokumen_pelan ?? $pelan->id_pelan}}" 
                                                            style="width: 200px; height: 250px; border: 1px solid #ddd; margin: auto; cursor: pointer;">
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
                                                @else
                                                    Dokumen tidak dapat dipaparkan
                                                    <br>&nbsp;
                                                @endif
                                                <p>{{ $fileSizeInMB ? number_format($fileSizeInMB, 2) . " MB" : '' }}</p>
                                            </td>
                                            
                                            @if(Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem'))
                                            <td>
                                                {{ strtoupper($pelan->nama_pbt) }}
                                            </td>
                                            @endif
                                            <td>
                                                @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                                                    <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$pelan->status == 'approved' ? 0 : 1]['label'] }}">{{ $pelan->status == 'approved' ? 'Perubahan telah disahkan' : 'Perubahan belum disahkan' }}</span>
                                                @else
                                                    <span style="white-space: normal; text-align: centre;width: 100%;" class="badge {{ $paparan_portal[$pelan->status == 'approved' ? 0 : 1]['label'] }}">{{ $paparan_portal[$pelan->status == 'approved' ? 0 : 1]['id'] }}</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                            <div class="btn-group">
                                                    {!! 
                                                        Form::button('<i class="fas fa-search"></i>', ['onclick'=>"window.location='".route('pengurusan.ePIL.show',$pelan)."'", 'class'=>'btn bg-info btn-sm', Html::tooltip('Butiran PIL')]); 
                                                    !!}
                                                    {!! 
                                                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.ePIL.edit',$pelan)."'", 'class'=>'btn bg-warning btn-sm', Html::tooltip('Kemaskini PIL')]); 
                                                    !!}
                                                    @if($pelan->id_permohonan == null && ($pelan->status == 'draft'))
                                                    {!! 
                                                        Form::button('<i class="fas fa-trash"></i>', 
                                                        [
                                                            'class' => 'btn btn-danger btn-sm',
                                                            'data-url' => route('pengurusan.ePIL.destroy', $pelan),
                                                            'data-toggle' => 'modal',
                                                            'data-target' => '#modalDelete',
                                                            Html::tooltip('Padam PIL')
                                                        ])  
                                                    !!}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center">No data available</td></tr>
                                    @endforelse
                                
                                @else
                                    <tr><td colspan="6" class="text-center">You do not have the necessary permissions to view this data.</td></tr>
                                @endif
                                
                            </tbody>

                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                @if(count($ePIL) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($ePIL) !!}
                </div>
                <!-- /.card-footer -->
                @endif
            </div><!-- /.card -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script>
    // pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    // document.addEventListener('DOMContentLoaded', function () {
    //     const ePIL = @json($ePIL);

    //     // Use ePIL.data to loop through the records
    //     ePIL.data.forEach(pelan => {
    //         // console.log(pelan);
    //         let namaFolder = pelan.id_pelan+' '+pelan.nama_pelan;
    //         let folder = namaFolder.replace(/\s+/g, '_'); // Replace spaces with underscores in folder name
    //         const url = pelan.nama_dokumen_pelan ?
    //             `/storage/uploads/ePIL/${folder}/${pelan.nama_dokumen_pelan}` : 
    //             '/img/no-photos.png';

    //         // Load and render the first page of the PDF document
    //         pdfjsLib.getDocument(url).promise.then(function(pdf) {
    //             return pdf.getPage(1); // Get the first page of the document
    //         }).then(function(page) {
    //             const canvas = document.getElementById('pdf-render-' + pelan.id_dokumen_pelan);
    //             const loadingElement = document.getElementById('loading-' + pelan.id_dokumen_pelan);
    //             const context = canvas.getContext('2d');

    //             const originalViewport = page.getViewport({ scale: 0.5 });

    //             const containerWidth = 150;
    //             const containerHeight = 200;
    //             const scale = Math.min(
    //                 containerWidth / originalViewport.width,
    //                 containerHeight / originalViewport.height
    //             );

    //             const viewport = page.getViewport({ scale: scale });

    //             canvas.width = viewport.width;
    //             canvas.height = viewport.height;

    //             page.render({
    //                 canvasContext: context,
    //                 viewport: viewport
    //             }).promise.then(() => {
    //                 if (loadingElement) {
    //                     loadingElement.style.display = 'none';
    //                 }
    //                 canvas.style.display = 'block';
    //             });
    //         }).catch(function(error) {
    //             // console.error('Error loading PDF for ID ' + pelan.id_dokumen_pelan + ':', error);
    //             const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
    //             if (viewerElement) {
    //                 viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Dokumen tidak dapat dipaparkan</div>';
    //             }
    //         });
    //     });
    // });
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    document.addEventListener('DOMContentLoaded', function () {
        const ePIL = @json($ePIL);

        ePIL.data.forEach(pelan => {
            let namaFolder = pelan.id_pelan + ' ' + pelan.nama_pelan;
            let folder = namaFolder.replace(/\s+/g, '_');
            const url = pelan.nama_dokumen_pelan ?
                `/storage/uploads/ePIL/${folder}/${pelan.nama_dokumen_pelan}` :
                '/img/no-photos.png';

            if (!url.toLowerCase().endsWith('.pdf')) {
                const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
                if (viewerElement) {
                    viewerElement.innerHTML = `<div class="text-center text-muted" style="padding-top: 80px;">
                        Fail bukan PDF — tidak dapat dipaparkan
                    </div>`;
                }
                return;
            }

            // Check file size first
            fetch(url, { method: 'HEAD' }).then(response => {
                const sizeInBytes = response.headers.get('Content-Length');
                const sizeInMB = sizeInBytes / (1024 * 1024);
                if (sizeInMB > 1000) {
                    // Too large, skip rendering
                    const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
                    if (viewerElement) {
                        viewerElement.innerHTML = `<div class="text-center text-muted" style="padding-top: 80px;">
                            Dokumen melebihi 1000MB — tidak dapat dipaparkan
                        </div>`;
                    }
                    return;
                }
                if(sizeInMB <= 1000){
                    // Load and render first page
                    pdfjsLib.getDocument(url).promise.then(function (pdf) {
                        return pdf.getPage(1);
                    }).then(function (page) {
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
                    }).catch(function (error) {
                        const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
                        if (viewerElement) {
                            viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Dokumen tidak dapat dipaparkan</div>';
                        }
                    });
                }
            }).catch(err => {
                console.error('Error fetching file size:', err);
            });
        });
    });
</script>
