<div class="card card-olive card-outline">
    <div class="card-header">
        <h3 class="card-title font-weight-bold my-1">Direktori Taman dan Landskap</h3>
        <div class="card-tools">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    {{ Form::open(['class' => 'form-inline', 'method' => 'get', 'url' => url()->current()]) }}
                        {{-- Optional: carry forward current keyword in case it's in the route --}}
                        @if(request()->route('keyword'))
                            {{ Form::hidden('keyword', request()->route('keyword')) }}
                        @endif

                        {{-- Search box --}}
                        <div class="input-group mr-2">
                            {{ Form::search('search', request('search'), [
                                'aria-label' => 'Search',
                                'placeholder' => 'Carian Pantas',
                                'class' => 'form-control form-control-sm ' . Html::isInvalid($errors, 'search')
                            ]) }}
                            &nbsp;
                            <div class="input-group-append">
                                {!! Form::button('<i class="fas fa-search"></i> Cari', [
                                    'class' => 'btn btn-success btn-sm',
                                    'type' => 'submit'
                                ]) !!}
                                &nbsp;
                                <a href="/epalm" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="card-tools">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="filter-container" role="group" aria-label="Filter Dropdowns">
                    {{-- Negeri Dropdown --}}
                    <select id="negeri" name="negeri" onchange="handleNegeriChange()" class="filter-select">
                        <option value="">Papar Semua Negeri</option>
                    </select>

                    {{-- PBT Dropdown --}}
                    @if(isset($namaPbtArray))
                    <form method="GET" action="{{ url('/epalm') }}">
                        <select id="pbt" name="pbt" onchange="handlePbtChange()" class="filter-select">
                            <option value="">Papar Semua PBT</option>
                            @foreach ($namaPbtArray as $pbt)
                                <option value="{{ $pbt }}" {{ request('keyword') === $pbt ? 'selected' : '' }}>
                                    {{ ucwords(strtolower($pbt)) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    @endif
                    {{-- Kategori Dropdown --}}
                    @if(isset($namaKategoriArray))
                    <form method="GET" action="{{ url('/epalm') }}">
                        <select id="kategori" name="kategori" onchange="handleKategoriChange()" class="filter-select">
                            <option value="">Papar Semua Kategori</option>
                            @foreach ($namaKategoriArray as $kategori)
                                <option value="{{ str_replace('/', '|', $kategori) }}" {{ request('keyword') === str_replace('/', '|', $kategori) ? 'selected' : '' }}>
                                    {{ ucwords(strtolower($kategori)) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    @endif
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $.ajax({
                            url: '/get-negeri-salt',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#negeri').empty().append('<option value="-1">Papar Semua Negeri</option>');
                                $.each(data, function(index, value) {
                                    let capitalized = value.nama_negeri.toLowerCase().replace(/\b\w/g, function(char) {
                                        return char.toUpperCase();
                                    });
                                    $('#negeri').append('<option value="' + value.kod_negeri + '">' + capitalized + '</option>');
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
                            window.location.href = "/epalm/" + encodeURIComponent(selected);
                        } else {
                            window.location.href = "/epalm";
                        }
                    }
                    function handlePbtChange() {
                        var selected = $('#pbt').val();
                        if (selected) {
                            window.location.href = "/epalm/" + encodeURIComponent(selected);
                        } else {
                            window.location.href = "/epalm";
                        }
                    }
                    function handleKategoriChange() {
                        var selected = $('#kategori').val();
                        if (selected) {
                            window.location.href = "/epalm/" + encodeURIComponent(selected);
                        } else {
                            window.location.href = "/epalm";
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
                            <th class="w-15">Nama Taman</th>
                            <th class="w-5">Kategori</th>
                            <th class="text-center w-5">Pihak Berkuasa Tempatan</th>
                            <th class="text-center w-1">Maklumat Lanjut</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $jenis_pembangunan = [
                                'Taman Awam',
                                'Taman Botani',
                                'Landskap Perbandaran',
                                'Persekitaran Kehidupan',
                                'Taman Persekutuan',
                                'Lain-lain (sila nyatakan)'
                            ];
                            $jenis_count = count($jenis_pembangunan);
                            $index = $ePALM_all->firstItem();
                            $previousNegeri = null; // Initialize a variable to store the previous row's `nama_taman`
                        @endphp
                        @if($ePALM_all->isNotEmpty())
                            @foreach($ePALM_all as $taman)
                                @if($previousNegeri !== null && $previousNegeri !== $taman->negeri)
                                    <!-- <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">
                                        <a href="{{ url('epalm/' . $taman->negeri_taman) }}" style="color: white; text-decoration: underline;">
                                            {{ ucwords(strtolower($taman->negeri)) }}
                                        </a>
                                    </td></tr> -->
                                    <tr onclick="window.location='{{ url('epalm/' . $taman->negeri_taman) }}'" style="background-color: #31d5c8 !important; color: white; cursor: pointer;">
                                        <td colspan="5" class="text-center">
                                            {{ ucwords(strtolower($taman->negeri)) }}
                                        </td>
                                    </tr>
                                @elseif($previousNegeri === $taman->negeri)
                                @else
                                    <!-- <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">
                                        <a href="{{ url('epalm/' . $taman->negeri_taman) }}" style="color: white; text-decoration: underline;">
                                            {{ ucwords(strtolower($taman->negeri)) }}
                                        </a>
                                    </td></tr> -->
                                    <tr onclick="window.location='{{ url('epalm/' . $taman->negeri_taman) }}'" style="background-color: #31d5c8 !important; color: white; cursor: pointer;">
                                        <td colspan="5" class="text-center">
                                            {{ ucwords(strtolower($taman->negeri)) }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-center">{{ $index++ }}</td>
                                    <td>{{ ucwords(strtolower($taman->nama_taman))}}</td>
                                    {{-- <td>{!! ((!in_array($taman->kategori_taman, $jenis_pembangunan))) ? '<span class="badge bg-warning">'.strtoupper($taman->kategori_taman).'</span>' : strtoupper($taman->kategori_taman) !!}</td> --}}
                                    <td>
                                        {{ ucwords(strtolower($taman->kategori_taman)) }}
                                    </td>
                                    <td>
                                        {{ ucwords(strtolower($taman->nama_pbt)) }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button style="display: none;" 
                                                type="button" 
                                                class="btn btn-primary btn-sm" 
                                                data-title="{{ $taman->nama_pbt }}" 
                                                data-kategori="{{ $taman->kategori_taman }}"
                                                data-nama="{{ $taman->nama_taman }}"
                                                data-komponen="{{ $taman->is_komponen }}"
                                                data-folder="{{ $taman->komponen ?? $taman->nama_taman }}"
                                                data-pbt="{{ $taman->nama_pbt }}"
                                                data-keterangan="{{ $taman->keterangan_taman }}"
                                                data-id="{{ $taman->id_taman }}"
                                                data-fasiliti="{{ $taman->fasiliti }}"
                                                data-lat="{{ $taman->lat }}"
                                                data-lng="{{ $taman->lng }}"
                                                data-gambar_360="{{ $taman->gambar_360 }}"
                                                data-keluasan="{{ $taman->keluasan_taman }}"
                                                data-unit="{{ $taman->keluasan_unit }}"
                                                data-mula="{{ $taman->waktuMula_taman }}"
                                                data-tamat="{{ $taman->waktuTamat_taman }}"
                                                data-gambar="{{ $taman->gambar_taman }}"
                                                data-toggle="modal" 
                                                data-target="#parkModal"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a id="open_taman" target="_self" class="btn bg-success btn-sm mr-1" href="/taman/{{ $taman->slug }}"><i class="fas fa-search"></i></a>
                                        </div>
                                    </td>
                                    @php
                                        $previousNegeri = $taman->negeri; // Update the previous value
                                    @endphp
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5" class="text-center">No data available</td></tr>
                        @endif
                    </tbody>

                </table>
            </div>
            @if(count($ePALM_all) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($ePALM_all) !!}
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
        width: 80%;
        max-width: 900px;
        max-height: 80%;
        overflow-y: auto; /* Makes the modal content scrollable */
        background-image: url("{{ asset('storage/img/bg-pattern-leaves.png') }}");
    }

    #customModalContent h2 {
        text-align: center;
    }

    #customModalContent span {
        text-align: right;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        cursor: pointer;
    }

    h2 {
        margin-bottom: 20px;
    }

    /* Modal body for content */
    .modal-body p {
        margin-bottom: 15px;
    }

    .park-images {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .park-img {
        width: 195px;
        height: 195px;
        border-radius: 8px;
        border: 0.5px solid black;
    }

    /* For mobile view (screens smaller than 768px) */
    @media (max-width: 767px) {
        .park-img {
            width: 45%; /* Reduce image size */
            height: auto; /* Maintain aspect ratio */
        }

        .park-images {
            justify-content: space-between;
            flex-wrap: wrap; /* Ensure the images wrap to the next line */
        }
    }

    /* For tablet and larger view (screens 768px and above) */
    @media (min-width: 768px) and (max-width: 1024px) {
        .park-img {
            width: 195px; /* Keep the original size */
            height: 195px;
        }
        .park-images {
            flex-wrap: wrap;
        }
    }
</style>

<div id="parkModal" class="modal">
    <div class="modal-content" id="customModalContent" style="background-color:rgb(25, 98, 92) !important;">
        <div class="modal-header justify-content-center bg-white">
            <h2 class="modal-title" id="modalNamaTaman" style="text-align: center;">Park Name</h2>
        </div>

        <div class="modal-body bg-white">

            <div class="park-images">
                <img id="parkImage1" src="" alt="Park Image 1" class="park-img" style="border: 0.5px solid black;">
                <img id="parkImage2" src="" alt="Park Image 2" class="park-img" style="border: 0.5px solid black;">
                <img id="parkImage3" src="" alt="Park Image 3" class="park-img" style="border: 0.5px solid black;">
                <img id="parkImage4" src="" alt="Park Image 4" class="park-img" style="border: 0.5px solid black;">
            </div>
            <br>
            <br>
            <h5>Pihak Berkuasa Tempatan</h5>
            <p id="modalpbt">Sedang dikemaskini</p>
            <h5>Keterangan</h5>
            <p id="modalKeterangan">Sedang dikemaskini</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
            <p>Nulla facilisi. Sed malesuada, erat ac pretium venenatis, turpis libero vestibulum dui, ut convallis eros sapien vel orci. Donec tincidunt, metus in malesuada tempor, enim nulla bibendum felis, a luctus leo arcu in ante. Aenean convallis velit nec est eleifend interdum.</p>

            <div class="row">
                <div class="col-12 col-md-3">
                    <h5>Kategori</h5>
                </div>
                <div class="col-12 col-md-3">
                    <p id="modalKategoriTaman">Sedang dikemaskini</p>
                </div>
                <div class="col-12 col-md-3">
                    <h5>Waktu Operasi</h5>
                </div>
                <div class="col-12 col-md-3">
                    <p id="modalWaktu">Sedang dikemaskini</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <h5>Keluasan</h5>
                </div>
                <div class="col-12 col-md-3">
                    <p id="modalKeluasan">Sedang dikemaskini</p>
                </div>
                <div class="col-12 col-md-3">
                    <h5>Koordinat</h5>
                </div>
                <div class="col-12 col-md-3">
                    <p id="modalCoordinate">Sedang dikemaskini</p>
                </div>
            </div>
            <p id="coordinate">Sedang dikemaskini</p>
            
            

            <div class="col-md-12">
                <h5>Fasiliti</h5>
                <style>
                    .parks {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 20px;
                        justify-content: center;
                    }

                    .facility {
                        display: flex;
                        align-items: center;
                        cursor: pointer;
                    }

                    .facility input[type="checkbox"] {
                        margin-right: 10px;
                        vertical-align: middle;
                    }

                    .parks i {
                        font-size: 36px;
                        transition: transform 0.3s ease, color 0.3s ease;
                    }

                    .parks input[type="checkbox"] {
                        display: inline-block;
                        margin-right: 10px;
                    }

                    .parks input[type="checkbox"]:checked + .bg {
                        background-color: green;
                        border-radius: 5px;
                    }

                    .parks input[type="checkbox"]:checked + .bg i {
                        color: white;
                    }

                    .facility-label {
                        display: inline-block;
                        margin-left: 8px;
                        font-size: 14px;
                        color: #555;
                        font-weight: bold;
                        text-align: left;
                    }

                    .parks .bg {
                        display: inline-block;
                        padding: 10px;
                        background-color: rgb(174, 169, 169);
                        border-radius: 5px;
                        transition: background-color 0.3s ease;
                    }

                    .parks input[type="checkbox"]:hover + .bg i {
                        transform: scale(1.1);
                    }

                    [data-toggle="tooltip"] {
                        position: relative;
                        display: inline-block;
                        cursor: pointer;
                    }

                    [data-toggle="tooltip"]:hover::after {
                        content: attr(title);
                        position: absolute;
                        top: -20px;
                        background-color: #333;
                        color: #fff;
                        font-size: 12px;
                        padding: 5px;
                        border-radius: 5px;
                    }

                    .icon-container {
                        width: 20px;
                        height: 20px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    .icon-container i {
                        font-size: 20px;
                    }
                </style>
                <div class="col-xs-12">
                    <div class="parks" inert>
                        <label class="facility" for="cctv">
                            <input type="checkbox" value="1" name="fasiliti[cctv]" id="cctv" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-video" data-toggle="tooltip" title="CCTV"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="wifi">
                            <input type="checkbox" value="1" name="fasiliti[wifi]" id="wifi" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-wifi" data-toggle="tooltip" title="WiFi"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="cycling">
                            <input type="checkbox" value="1" name="fasiliti[cycling]" id="cycling" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-bicycle" data-toggle="tooltip" title="Kemudahan Berbasikal"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="food">
                            <input type="checkbox" value="1" name="fasiliti[food]" id="food" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-utensils" data-toggle="tooltip" title="Gerai Makan"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="oku">
                            <input type="checkbox" value="1" name="fasiliti[oku]" id="oku" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-wheelchair" data-toggle="tooltip" title="Kemudahan OKU"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="toilet">
                            <input type="checkbox" value="1" name="fasiliti[toilet]" id="toilet" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-restroom" data-toggle="tooltip" title="Tandas Awam"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="food2">
                            <input type="checkbox" value="1" name="fasiliti[food2]" id="food2" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-utensils" data-toggle="tooltip" title="Gerai Makan"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="oku2">
                            <input type="checkbox" value="1" name="fasiliti[oku2]" id="oku2" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-wheelchair" data-toggle="tooltip" title="Kemudahan OKU"></i>
                                </div>
                            </span>
                        </label>

                        <label class="facility" for="toilet2">
                            <input type="checkbox" value="1" name="fasiliti[toilet2]" id="toilet2" style="display:none;">
                            <span class="bg">
                                <div class="icon-container">
                                    <i class="fas fa-restroom" data-toggle="tooltip" title="Tandas Awam"></i>
                                </div>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <br>
            <!-- <div class="row">
                <div class="col-3">
                    <h5>Gambar Panorama</h5>
                </div>
                <div class="col-9">
                <link rel="stylesheet" href="{{ asset('js/pano/photo-sphere-viewer.css') }}">
                <style>
                    #photosphere {
                        width: 100%;
                        height: 400px;
                    }
                </style>
                
                <div id="photosphere"></div>
                <script src="{{ asset('js/pano/three/build/three.js') }}"></script>
                <script src="{{ asset('js/pano/uevent/browser.js') }}"></script>
                <script src="{{ asset('js/pano/photo-sphere-viewer.js') }}"></script>
                <script src="{{ asset('js/pano/viewer-compat.js') }}"></script>
                <script>
                    var PSV = new PhotoSphereViewer.ViewerCompat({
                        container: 'photosphere',
                        panorama: 'http://127.0.0.1:8000/storage/uploads/ePALM/PERMOHONAN_PROJEK_2_(updated)_with_imeji/pano.jpg',
                        caption: 'ePokok<b>&copy; Panorama</b>',
                        loading_img: 'https://tpbk.jln.gov.my/img/photosphere-logo.gif',
                        time_anim: false,
                        anim_speed: '-2rpm',
                        default_fov: 50,
                        fisheye: false,
                        move_speed: 1.1,
                        time_anim: false,
                        });
                </script>
                </div>
            </div> -->

            
            <div class="row" id="komponen" style="display: none;">
                <div class="col-3">
                    <h5>Gambar Panorama</h5>
                </div>
                <div class="col-9">
                    <iframe src="{{ route('pano', ['folder' => 'PERMOHONAN_PROJEK_2_(updated)_with_imeji', 'image' => 'pano.jpg']) }}"
                id="panoIframe" width="100%" height="300" frameborder="0" scrolling="no" style="overflow: hidden;"></iframe>
                </div>
            </div>
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
        $('#parkModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var title = button.data('title');
            var kategori = button.data('kategori');
            var nama = button.data('nama');
            var folder = button.data('folder');
            var komponen = button.data('komponen');
            var keterangan = button.data('keterangan');
            var pbt = button.data('pbt');
            var mula = button.data('mula');
            var tamat = button.data('tamat');
            var id = button.data('id');
            var fasiliti = button.data('fasiliti');
            var gambar = button.data('gambar');
            var unit = button.data('unit');
            var keluasan = button.data('keluasan');
            var lat = button.data('lat');
            var lng = button.data('lng');
            var gambar_360 = button.data('gambar_360');
            // console.log(gambar_360);
            if ((komponen && komponen === '') && (gambar_360 && gambar_360 !== '')) {
                $('#komponen').show();
                var iframeSrc = "{{ route('pano', ['folder' => 'FOLDER_PLACEHOLDER', 'image' => 'IMAGE_PLACEHOLDER']) }}";

                iframeSrc = iframeSrc.replace('FOLDER_PLACEHOLDER', folder.replace(/ /g, '_'));
                iframeSrc = iframeSrc.replace('IMAGE_PLACEHOLDER', gambar_360);
                $('#panoIframe').attr('src', iframeSrc);
            }else{
                $('#komponen').hide();
            }

            for (let key in fasiliti) {
                if (fasiliti.hasOwnProperty(key)) {
                    if (fasiliti[key] > 0) {
                        $('#'+key).prop('checked', true);
                    } else {
                        $('#'+key).prop('checked', false);
                    }
                }
            }
            let folderN = folder.replace(/ /g, '_');
            // console.log(folderN);
            // console.log(gambar);
            for (let i = 1; i <= 4; i++) {
                let imageId = `parkImage${i}`;
                let imageSource = `XGIM_${i}`;
                let imagePath = `/storage/uploads`;

                let img = document.getElementById(imageId);
                if (gambar.hasOwnProperty(imageSource) && gambar[imageSource]) {
                    img.src = `${imagePath}/ePALM/${folderN}/${gambar[imageSource]}`;
                    img.onerror = function () {
                        img.src = `${imagePath}/no-photos.png`;
                    };
                } else {
                    img.src = `${imagePath}/no-photos.png`;
                }
            }
            // Update the modal's content
            var modal = $(this);
            modal.find('.modal-content').scrollTop(0);
            if (nama && nama !== '') {
                modal.find('#modalNamaTaman').text(nama);
            }
            if (kategori && kategori !== '') {
                modal.find('#modalKategoriTaman').text(kategori);
            }
            if (pbt && pbt !== '') {
                modal.find('#modalpbt').text(pbt);
            }
            if (keterangan && keterangan !== '') {
                modal.find('#modalKeterangan').text(keterangan);
            }
            if (lat && lat !== '' && lng && lng !== '') {
                modal.find('#modalCoordinate').text(`(${lat}, ${lng})`);
            }
            if (keluasan && keluasan !== '') {
                modal.find('#modalKeluasan').text(`${keluasan} ${unit}`);
            }
            if (mula && mula !== '' && tamat && tamat !== '') {
                modal.find('#modalWaktu').text(`${mula} - ${tamat}`);
            }
        });

        $('#parkModal').on('hidden.bs.modal', function () {
            $(this).find('#modalNamaTaman').text('');
            $(this).find('#modalKategoriTaman').text('');
            $(this).find('#modalpbt').text('');
            $(this).find('#modalKeterangan').text('');
            $(this).find('#modalWaktu').text('');
            $(this).find('#modalCoordinate').text('');
            $(this).find('#modalKeluasan').text('');
            
            $('input[type="checkbox"]').prop('checked', false);
            
            for (let i = 1; i <= 4; i++) {
                let imageId = `parkImage${i}`;
                document.getElementById(imageId).src = '/storage/uploads/no-photos.png';
            }
            $(this).find('.modal-content').scrollTop(0);
        });
    });
</script>