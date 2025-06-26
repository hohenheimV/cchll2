<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold my-1">Direktori Pelan Induk Landskap</h3>
        </div>

    <div class="card-body">
        <div class="card-tools">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="filter-container" role="group" aria-label="Filter Dropdowns">
                    {{-- Negeri Dropdown --}}
                    <select id="negeri" name="negeri" onchange="handleNegeriChange()" class="filter-select">
                        <option value="">PAPAR SEMUA NEGERI</option>
                    </select>

                    @if(isset($namaPbtArray))
                    {{-- PBT Dropdown --}}
                    <form method="GET" action="{{ url('/epil-pelan') }}">
                        <select id="pbt" name="pbt" onchange="handlePbtChange()" class="filter-select">
                            <option value="">PAPAR SEMUA PBT</option>
                            @foreach ($namaPbtArray as $pbt)
                                <option value="{{ $pbt }}" {{ request('keyword') === $pbt ? 'selected' : '' }}>
                                    {{ strtoupper($pbt) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    @endif

                    {{-- Kategori Dropdown --}}
                    {{-- <form method="GET" action="{{ url('/epil-pelan') }}">
                        <select id="kategori" name="kategori" onchange="handleKategoriChange()" class="filter-select">
                            <option value="">PAPAR SEMUA KATEGORI</option>
                            @foreach ($namaKategoriArray as $kategori)
                                <option value="{{ $kategori }}" {{ request('keyword') === $kategori ? 'selected' : '' }}>
                                    {{ strtoupper($kategori) }}
                                </option>
                            @endforeach
                        </select>
                    </form> --}}
                </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $.ajax({
                            url: '/get-negeri-salt',
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                $('#negeri').empty().append('<option value="-1">PAPAR SEMUA NEGERI</option>');
                                $.each(data, function(index, value) {
                                    $('#negeri').append('<option value="' + value.kod_negeri + '">' + value.nama_negeri + '</option>');
                                    });

                                var keyword = "{{ request('keyword') }}";

                                // Set selected if it's a negeri match (based on kod_negeri in your API)
                                let negeriMatch = data.find(item => item.kod_negeri === keyword);

                                if (negeriMatch) {
                                    $('#negeri').val(keyword);
                                    $('#pbt').val(''); // Clear PBT selection
                                } else {
                                    $('#negeri').val('-1');
                                    }
                                },
                            error: function(err) {
                                console.error("Failed to load negeri list:", err);
                                }
                            });
                        });

                    function handleNegeriChange() {
                        var selected = $('#negeri').val();
                        if (selected && selected != '-1') {
                            window.location.href = "/epil-pelan/" + encodeURIComponent(selected);
                            } else {
                            window.location.href = "/epil-pelan";
                        }
                    }
                    function handlePbtChange() {
                        var selected = $('#pbt').val();
                        if (selected) {
                            window.location.href = "/epil-pelan/" + encodeURIComponent(selected);
                        } else {
                            window.location.href = "/epil-pelan";
                        }
                    }
                    function handleKategoriChange() {
                        var selected = $('#kategori').val();
                        if (selected) {
                            window.location.href = "/epil-pelan/" + encodeURIComponent(selected);
                        } else {
                            window.location.href = "/epil-pelan";
                            }
                        }
                    </script>
                </div>
            </div>
        <br>
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
                <table id="example" class="responsive table table-bordered table-hover table-striped mb-0">
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
                                    <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">{{ strtoupper($pelan->negeri)}}</td></tr>
                                @elseif($previousNegeri === $pelan->negeri)
                                @else
                                    <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">{{ strtoupper($pelan->negeri)}}</td></tr>
                                @endif
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ (strtoupper($pelan->nama_pelan)) }}</td>
                                    <td>
                                        {{ (strtoupper($pelan->nama_pbt)) }}
                                    </td>
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
                                        @if ($pelan->gambar_dokumen_pelan && file_exists(public_path('storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan)) && $fileSizeInMB < 1000 && $isPdf)
                                            <!-- <a href="{{ asset($pelan->gambar_dokumen_pelan ? 'storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan : 'storage/uploads/no-photos.png' ) }}" 
                                                target="_blank" download> -->
                                            <button 
                                                data-title="{{ $pelan->nama_pelan }}" 
                                                data-pelan="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan) }}"
                                                data-toggle="modal" 
                                                data-target="#pelanModal"
                                            >
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
                                            </button>
                                            <!-- </a> -->
                                        @else
                                            Tiada paparan dokumen
                                            <br>&nbsp;
                                        @endif
                                        <p>{{ $fileSizeInMB ? number_format($fileSizeInMB, 2) . " MB" : '' }}</p>
                                    </td>
                                    <td class="text-center">
                                        {{-- <div class="btn-group">
                                            @if ($pelan->gambar_dokumen_pelan && file_exists(public_path('storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan)))
                                                <!-- <button 
                                                    type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-title="{{ $pelan->nama_pelan }}" 
                                                    data-pelan="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan) }}"
                                                    data-toggle="modal" 
                                                    data-target="#pelanModal"
                                                > -->
                                                @if($fileSizeInMB < 1000 && $isPdf)
                                                    <a href="{{ asset($pelan->gambar_dokumen_pelan ? 'storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan : 'javascript:void(0)' ) }}" 
                                                    target="_blank" type="button" class="btn btn-primary btn-sm" >
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                @endif
                                                <!-- </button> -->
                                                <a href="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$pelan->gambar_dokumen_pelan) }}" target="_blank" download>
                                                    {!! Form::button('<i class="fas fa-download"></i>', [
                                                        'class' => 'btn btn-success btn-sm'
                                                    ]) !!}
                                                </a>
                                            @endif
                                        </div> --}}
                                        <div class="btn-group">
                                            @php
                                                $hasPelanFile = $pelan->gambar_dokumen_pelan && file_exists(public_path("storage/uploads/ePIL/{$folder}/{$pelan->gambar_dokumen_pelan}"));
                                                $pelanFilePath = "storage/uploads/ePIL/{$folder}/{$pelan->gambar_dokumen_pelan}";
                                                $isPdf = strtolower(pathinfo($pelan->gambar_dokumen_pelan, PATHINFO_EXTENSION)) === 'pdf';
                                                $fileSizeInMB = $hasPelanFile ? filesize(public_path($pelanFilePath)) / 1024 / 1024 : 0;
                                                $canView = $hasPelanFile && $isPdf && $fileSizeInMB < 1000;
                                                $canDownload = $hasPelanFile;
                                            @endphp

                                            {{-- View Button --}}
                                            <button 
                                                type="button"
                                                class="btn btn-sm {{ $canView ? 'btn-primary' : 'btn-secondary' }}"
                                                title="{{ $canView ? 'Lihat Dokumen' : 'Tidak tersedia untuk dilihat (PDF sahaja < 1GB)' }}"
                                                {{ $canView ? '' : 'disabled' }}
                                                onclick="{{ $canView ? "window.open('" . asset($pelanFilePath) . "', '_blank')" : '' }}"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>

                                            {{-- Download Button --}}
                                            <a 
                                                href="{{ $canDownload ? asset($pelanFilePath) : 'javascript:void(0)' }}"
                                                target="_blank"
                                                class="btn btn-sm {{ $canDownload ? 'btn-success' : 'btn-secondary disabled' }}"
                                                style="{{ $canDownload ? '' : 'opacity: 0.6; cursor: not-allowed;' }}"
                                                {{ $canDownload ? 'download' : 'aria-disabled=true' }}
                                                title="{{ $canDownload ? 'Muat Turun Dokumen' : 'Dokumen tidak tersedia untuk dimuat turun' }}"
                                            >
                                                <i class="fas fa-download"></i>
                                            </a>
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

    #customModalContent {
        position: relative;
        background-color: white;
        margin: 5% auto;
        padding: 30px;
        width: 100%;
        max-width: 100%;
        max-height: 100%;
        overflow-y: auto; /* Makes the modal content scrollable */
        background-image: url("{{ asset('storage/img/bg-pattern-leaves.png') }}");
    }
</style>

<div id="pelanModal" class="modal">
    <div class="modal-content" id="customModalContent" style="background-color:rgb(25, 98, 92) !important;">
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
            // let folder = pelan.nama_pelan.replace(/\s+/g, '_'); // Replace spaces with underscores in folder name
            let namaFolder = pelan.id_pelan+' '+pelan.nama_pelan;
            let folder = namaFolder.replace(/\s+/g, '_');
            const url = pelan.gambar_dokumen_pelan ?
                `/storage/uploads/ePIL/${folder}/${pelan.gambar_dokumen_pelan}` : 
                '/img/no-photos.png';

            // Load and render the first page of the PDF document
            // pdfjsLib.getDocument(url).promise.then(function(pdf) {
            //     return pdf.getPage(1); // Get the first page of the document
            // }).then(function(page) {
            //     const canvas = document.getElementById('pdf-render-' + pelan.id_dokumen_pelan);
            //     const loadingElement = document.getElementById('loading-' + pelan.id_dokumen_pelan);
            //     const context = canvas.getContext('2d');

            //     const originalViewport = page.getViewport({ scale: 0.5 });

            //     const containerWidth = 150;
            //     const containerHeight = 200;
            //     const scale = Math.min(
            //         containerWidth / originalViewport.width,
            //         containerHeight / originalViewport.height
            //     );

            //     const viewport = page.getViewport({ scale: scale });

            //     canvas.width = viewport.width;
            //     canvas.height = viewport.height;

            //     page.render({
            //         canvasContext: context,
            //         viewport: viewport
            //     }).promise.then(() => {
            //         if (loadingElement) {
            //             loadingElement.style.display = 'none';
            //         }
            //         canvas.style.display = 'block';
            //     });
            // }).catch(function(error) {
            //     // console.error('Error loading PDF for ID ' + pelan.id_dokumen_pelan + ':', error);
            //     const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
            //     if (viewerElement) {
            //         viewerElement.innerHTML = '<div class="text-center text-muted" style="padding-top: 80px;">Dokumen tidak dapat dipaparkan</div>';
            //     }
            // });

            if (!url.toLowerCase().endsWith('.pdf')) {
                const viewerElement = document.getElementById('pdf-viewer-' + pelan.id_pelan);
                if (viewerElement) {
                    viewerElement.innerHTML = `<div class="text-center text-muted" style="padding-top: 20px;">
                        Fail bukan PDF — tidak dapat dipaparkan
                    </div>`;
                }
                return;
            }

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