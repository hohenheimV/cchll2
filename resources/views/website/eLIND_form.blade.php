<div class="card card-olive card-outline">
    <div class="card-header">
        <h3 class="card-title font-weight-bold my-1">Direktori Penggiat Industri: {{ $keyword }}</h3>
        <div class="card-tools">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    {{ Form::open(['class' => 'form-inline', 'method' => 'get', 'url' => url()->current()]) }}
                        {{ Form::hidden('negeri', request('negeri')) }}
                        {{ Form::hidden('kelas_kontraktor', request('kelas_kontraktor')) }}
                        {{ Form::hidden('bidang_kepakaran', request('bidang_kepakaran')) }}
                        {{-- Keyword Search --}}
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
                                <a href="{{ request()->route('keyword') }}" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="card-tools">
            <div class="btn-toolbar" role="toolbar">
                <div class="filter-container" role="group">

                    {{-- Negeri Dropdown --}}
                    @if($keyword !== "Pertubuhan Antarabangsa")
                    <select id="negeri" name="negeri" class="filter-select">
                        {{-- <option value="">Papar Semua Negeri</option> --}}
                    </select>
                    @endif

                    {{-- (Only for Kontraktor) --}}
                    @if($keyword == "Kontraktor")
                    {{-- Kelas Kontraktor Dropdown --}}
                    <select id="kelas_kontraktor" name="kelas_kontraktor" class="filter-select">
                        <option value="">Papar Semua Kelas</option>
                        @foreach([
                            'A','B','BX','C','D','E','EX','F',
                            'G1','G2','G3','G4','G5','G6','G7','TIADA'
                        ] as $kod)
                            <option value="{{ $kod }}" {{ request('kelas_kontraktor') == $kod ? 'selected' : '' }}>
                                {{ $kod == 'TIADA' ? 'Tiada Maklumat' : $kod }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Bidang Kepakaran --}}
                    <select id="bidang_kepakaran" name="bidang_kepakaran" class="filter-select">
                        <option value="">Papar Semua Kepakaran</option>
                        @foreach([
                            5 => 'B09',
                            6 => 'CE14',
                            7 => 'B09 & CE14'
                        ] as $kod => $label)
                            <option value="{{ $kod }}" {{ request('bidang_kepakaran') == $kod ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @endif

                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(function () {
                    const keyword = "{{ request()->route('keyword') }}";
                    const selectedNegeri = "{{ request('negeri') }}";
                    const selectedKelas = "{{ request('kelas_kontraktor') }}";

                    $.getJSON('/get-negeri-salt', function (data) {
                        const negeriDropdown = $('#negeri');
                        negeriDropdown.append(`<option value="">Papar Semua Negeri</option>`);
                        data.forEach(item => {
                            const capitalizedName = item.nama_negeri
                                .toLowerCase()
                                .replace(/\b\w/g, char => char.toUpperCase());

                            negeriDropdown.append(
                                `<option value="${item.kod_negeri}" ${selectedNegeri == item.kod_negeri ? 'selected' : ''}>
                                    ${capitalizedName}
                                </option>`
                            );
                        });
                    });

                    $('#negeri, #kelas_kontraktor, #bidang_kepakaran').on('change', function () {
                        const negeri = $('#negeri').val();
                        const kelas = $('#kelas_kontraktor').val();
                        const bidang = $('#bidang_kepakaran').val();
                        let url = `/penggiat-industri/${keyword}`;
                        const params = new URLSearchParams();

                        if (negeri) params.append('negeri', negeri);
                        if (kelas) params.append('kelas_kontraktor', kelas);
                        if (bidang) params.append('bidang_kepakaran', bidang);

                        window.location.href = `${url}?${params.toString()}`;
                    });
                });
            </script>
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
                            <th class="w-15">Nama</th>
                            @if($keyword == "Kontraktor")
                            <th class="text-center w-1">Kelas</th>
                            <th class="text-center w-1">Bidang</th>
                            @endif
                            <th class="w-5">Alamat</th>
                            <!-- <th class="text-center w-5">Prestasi</th> -->
                            <th class="text-center w-1">Tindakan</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $prestasi = [
                                ['id' => 'Sangat Baik', 'label' => 'bg-success'],
                                ['id' => 'Baik', 'label' => 'bg-primary'],
                                ['id' => 'Sederhana', 'label' => 'bg-warning'],
                                ['id' => 'Lemah', 'label' => 'bg-danger'],
                                ['id' => 'Tiada Maklumat', 'label' => 'bg-danger']
                            ];
                            $prestasi_count = count($prestasi);
                            $index = $eLIND->firstItem();
                            $previousNegeri = null; // Initialize a variable to store the previous row's `nama_taman`
                        @endphp
                        @if($eLIND->isNotEmpty())
                            @foreach($eLIND as $user)
                                @if($previousNegeri !== null && $previousNegeri !== $user->negeri)
                                    <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">{{ $user->negeri}}</td></tr>
                                @elseif($previousNegeri === $user->negeri)
                                @else
                                    <tr style="background-color: #31d5c8 !important;color: white;"><td colspan="5" class="text-center">{{ $user->negeri}}</td></tr>
                                @endif
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ strtoupper($user->name) }}</td>
                                    @if($keyword == "Kontraktor")
                                    <td class="text-center w-1">{{ ($user->kelas_kontraktor) ? ($user->kelas_kontraktor) : "-" }}</td>
                                    @php
                                        $bidangOptions = [
                                            // 1 => 'LANDSKAP ARKITEK',
                                            // 2 => 'ELEKTRIK',
                                            // 3 => 'SIVIL DAN STRUKTUR',
                                            // 4 => 'UKURBAHAN',
                                            4 => 'B09',
                                            5 => 'CE14',
                                            6 => 'B09 & CE14',
                                        ];
                                    @endphp

                                    <td class="text-center w-1">
                                        {{ $bidangOptions[$user->bidang_kepakaran] ?? '-' }}
                                    </td>
                                    @endif
                                    <td>
                                        {{--@if(isset($user->email)) {{ $user->email }}<br>@endif--}}
                                        @if(isset($user->address1)) {{ ucwords(strtolower($user->address1.',')) }}<br>@endif
                                        @if(isset($user->address2)) {{ ucwords(strtolower($user->address2.',')) }}<br>@endif
                                        @if(isset($user->postcode)) {{ ucwords(strtolower($user->postcode)) }}@endif
                                        @if(isset($user->locality)) {{ ucwords(strtolower($user->locality.', ')) }}@endif
                                        @if(isset($user->state)) {{ ucwords(strtolower($user->state.'.')) }}<br>@endif
                                    </td>
                                    <!-- <td class="text-center">
                                        <?php
                                            if($user->prestasi != null){
                                                $dataprestasi = json_decode($user->prestasi, true);
                                                $prestasiDB = end($dataprestasi)['prestasi'] ?? 5;
                                            }else{
                                                $prestasiDB = 5;
                                            }
                                        ?>
                                        <span  class="badge {{ $prestasi[$prestasiDB-1 ?? '4']['label'] }}" style="white-space: normal; text-align: centre;width: 100%;">
                                            {{ $prestasi[$prestasiDB-1 ?? '4']['id'] }}
                                        </span>
                                    </td> -->
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button 
                                                type="button" 
                                                class="btn btn-primary btn-sm" 
                                                data-jenis="{{ $keyword }}" 
                                                data-title="{{ $user->name }}" 
                                                data-address="{{--@if(isset($user->email)) {{ $user->email.',' }}@endif--}}
                                                @if(isset($user->address1)) {{ $user->address1.',' }}@endif
                                                @if(isset($user->address2)) {{ $user->address2.',' }}@endif
                                                @if(isset($user->postcode)) {{ $user->postcode }}@endif
                                                @if(isset($user->locality)) {{ $user->locality.', ' }}@endif
                                                @if(isset($user->state)) {{ $user->state.'.' }}@endif"
                                                data-media_sosial="{{ $user->mediaSosial_penggiat }}"
                                                data-emel="{{ $user->email }}"
                                                @if($keyword == "Pembekal" || $keyword == "Perunding" || $keyword == "Kontraktor") 
                                                data-no_ssm="{{ $user->no_ssm }}"
                                                data-no_mof="{{ $user->no_mof }}"
                                                @endif
                                                @if($keyword == "Kontraktor") 
                                                    data-no_cidb="{{ $user->no_cidb }}" 
                                                    data-taraf_bumiputera="{{ $user->taraf_bumiputera }}"
                                                    data-bidang_kepakaran="{{ $user->bidang_kepakaran }}"
                                                @endif
                                                @if($keyword == "Perunding") 
                                                    data-no_ilam="{{ $user->no_ilam }}" 
                                                    data-tarikh_luput_ilam="{{ $user->tarikh_luput_ilam }}"
                                                @endif
                                                @if($keyword == "Pembekal") 
                                                    data-produk="{{ $user->produk }}" 
                                                    data-folder="{{ str_replace(' ', '_', $user->id_elind . ' ' . $user->name) }}" 
                                                @endif
                                                @if($keyword == "Pembekal" || $keyword == "Perunding" || $keyword == "Kontraktor") 
                                                    data-pengalaman="{{ $user->pengalaman }}" 
                                                @endif
                                                @if($keyword == "Institusi Pendidikan") 
                                                    data-jenis_institusi="{{ $user->jenis_institusi }}"
                                                @endif
                                                @if($keyword == "Pertubuhan Antarabangsa" || $keyword == "NGO / Badan Ikhtisas") 
                                                    data-nama_presiden="{{ $user->nama_presiden }}"
                                                @endif
                                                @if($keyword == "NGO / Badan Ikhtisas") 
                                                    data-kategori_ngo="{{ $user->kategori_ngo }}"
                                                @endif
                                                data-toggle="modal" 
                                                data-target="#parkModal"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                            {{-- @if($user->no_cidb && $keyword == "Kontraktor")
                                                &nbsp;
                                                <button 
                                                    type="button" 
                                                    id="link_cidb"
                                                    class="btn btn-success btn-sm" 
                                                    style="color: white;"
                                                >
                                                    CIDB
                                                </button>

                                                <script>
                                                    document.getElementById('link_cidb').addEventListener('click', function(event) {
                                                        event.preventDefault();
                                                        const link_cidb = "{{ $user->no_cidb }}";
                                                        const url = `https://mcp.cidb.gov.my/MCP/ContractorSearch?CidbRegNo=${link_cidb}`;
                                                        window.open(url, '_blank');
                                                    });
                                                </script>
                                            @endif --}}
                                            @if($user->no_cidb && $keyword == "Kontraktor")
                                                @php
                                                    $hasCIDB = $user->no_cidb && $keyword === 'Kontraktor';
                                                @endphp

                                                {{-- CIDB Button --}}
                                                <button 
                                                    type="button"
                                                    class="btn btn-sm {{ $hasCIDB ? 'btn-success' : 'btn-secondary disabled' }}"
                                                    style="{{ $hasCIDB ? '' : 'opacity: 0.6; cursor: not-allowed;' }}"
                                                    title="{{ $hasCIDB ? 'Lihat Profil CIDB' : 'Tiada No. CIDB' }}"
                                                    onclick="{{ $hasCIDB ? "window.open('https://mcp.cidb.gov.my/MCP/ContractorSearch?CidbRegNo={$user->no_cidb}', '_blank')" : 'return false' }}"
                                                    {{ $hasCIDB ? '' : 'disabled' }}
                                                >
                                                    CIDB
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    @php
                                        $previousNegeri = $user->negeri; // Update the previous value
                                    @endphp
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="6" class="text-center">No data available</td></tr>
                        @endif
                    </tbody>

                </table>
            </div>
            @if(count($eLIND) > 0)
                <div class="card-footer bg-light p-2 border-top-0 d-flex flex-column justify-content-center align-items-end">
                    {!! Html::pagination($eLIND) !!}
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
</style>
<div id="parkModal" class="modal">
    <div class="modal-content" id="customModalContent" style="background-color:rgb(25, 98, 92) !important;">
        <div class="modal-header justify-content-center bg-white">
            <h2 class="modal-title" id="title" style="text-align: center;">Park Name</h2>
        </div>

        <div class="modal-body bg-white">
            @if($keyword == "Pertubuhan Antarabangsa" || $keyword == "NGO / Badan Ikhtisas") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Presiden</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="nama_presiden">Tiada Maklumat</p>
                </div>
            </div>
            @endif
            @if($keyword == "NGO / Badan Ikhtisas") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Kategori</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="kategori_ngo">Tiada Maklumat</p>
                </div>
            </div>
            @endif
            @if($keyword == "Institusi Pendidikan") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Jenis Institusi</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="jenis_institusi">Tiada Maklumat</p>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Alamat</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="address">Tiada Maklumat</p>
                    <!-- <p id="address2">Tiada Maklumat</p>
                    <p id="postcode">Tiada Maklumat</p>
                    <p id="locality">Tiada Maklumat</p>
                    <p id="state">Tiada Maklumat</p> -->
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>No Telefon</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="no_telefon">Tiada Maklumat</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Emel</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="emel">Tiada Maklumat</p>
                </div>
            </div> -->
            @if($keyword == "Pembekal" || $keyword == "Perunding" || $keyword == "Kontraktor") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>No. Pendaftaran Syarikat (SSM)</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="no_ssm">Tiada Maklumat</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>No. Pendaftaran MoF</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="no_mof">Tiada Maklumat</p>
                </div>
            </div>
            @endif
            @if($keyword == "Kontraktor") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>No. Pendaftaran PKK/ CIDB</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="no_cidb">Tiada Maklumat</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Taraf Bumiputera</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="taraf_bumiputera">Tiada Maklumat</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Bidang Kepakaran</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="bidang_kepakaran">Tiada Maklumat</p>
                </div>
            </div>
            @endif
            @if($keyword == "Perunding") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>No. Pendaftaran ILAM</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="no_ilam">Tiada Maklumat</p>
                </div>
            </div>
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Tarikh Luput Keahlian ILAM</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="tarikh_luput_ilam">Tiada Maklumat</p>
                </div>
            </div>
            @endif
            @if($keyword == "Pembekal") 
            <div class="row">
                <div class="col-5 col-xs-12">
                    <p><strong>Bidang</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="bidang_pembekal">Tiada Maklumat</p>
                </div>
            </div>
            @endif

            <div id="mediaSosial">
                <div class="col-5 col-xs-12">
                    <p><strong>Media</strong></p>
                </div>
                <div class="col-7 col-xs-12">
                    <p id="">Tiada Maklumat</p>
                </div>
            </div>

            @if($keyword == "Pembekal" || $keyword == "Perunding" || $keyword == "Kontraktor") 
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4 class="d-flex align-items-center justify-content-between">
                        Senarai Pengalaman
                    </h4>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table id="pengalaman_table" class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <style>
                                    #pengalaman_table th, #pengalaman_table td {
                                        padding: 2px 5px; /* Minimal padding for smaller cells */
                                        text-align: center; /* Center text horizontally */
                                        height: auto; /* Let the height adjust based on content */
                                    }

                                    #pengalaman_table td input {
                                        padding: 3px 5px; /* Small padding inside input fields */
                                        height: 25px; /* Small height for input fields */
                                        font-size: 12px; /* Smaller font size for compact input fields */
                                    }

                                    #pengalaman_table th {
                                        padding: 3px 5px; /* Slightly more padding for headers */
                                        font-size: 12px; /* Smaller font size for headers */
                                    }
                                </style>
                                <tr>
                                    <th class="w-1">Bil</th>
                                    <th class="w-30">Tajuk Projek</th>
                                    <th class="w-5">Kos</th>
                                    <th class="w-5">Tahun</th>
                                    <th class="w-5">Status</th>
                                </tr>
                            </thead>
                            <tbody id="pengalaman_container">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if($keyword == "Pembekal") 
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4 class="d-flex align-items-center justify-content-between">
                        Senarai Produk
                    </h4>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="table-responsive">
                        <table id="produk_table" class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <style>
                                    #produk_table th, #produk_table td {
                                        padding: 2px 5px; /* Minimal padding for smaller cells */
                                        text-align: center; /* Center text horizontally */
                                        height: auto; /* Let the height adjust based on content */
                                    }

                                    #produk_table td input {
                                        padding: 3px 5px; /* Small padding inside input fields */
                                        height: 25px; /* Small height for input fields */
                                        font-size: 12px; /* Smaller font size for compact input fields */
                                    }

                                    #produk_table th {
                                        padding: 3px 5px; /* Slightly more padding for headers */
                                        font-size: 12px; /* Smaller font size for headers */
                                    }
                                </style>
                                <tr>
                                    <th class="w-1">Bil</th>
                                    <th class="w-10">Nama Produk</th>
                                    <th class="w-15">Keterangan</th>
                                    <th class="w-5">Harga</th>
                                    <th class="w-5" colspan="2">Gambar</th>
                                </tr>
                            </thead>
                            <tbody id="produk_container">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="park-images" style="display: none;">
                <img id="parkImage1" src="" alt="Park Image 1" class="park-img" style="border: 0.5px solid black;">
                <img id="parkImage2" src="" alt="Park Image 2" class="park-img" style="border: 0.5px solid black;">
                <img id="parkImage3" src="" alt="Park Image 3" class="park-img" style="border: 0.5px solid black;">
                <img id="parkImage4" src="" alt="Park Image 4" class="park-img" style="border: 0.5px solid black;">
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
            var jenis = button.data('jenis');
            var title = button.data('title');
            var address = button.data('address');
            var media_sosial = button.data('media_sosial');
            var emel = button.data('emel');
            var no_ssm = button.data('no_ssm');
            var no_mof = button.data('no_mof');
            var pengalaman = button.data('pengalaman');
            var produk = button.data('produk');
            let folder = button.data('folder');
            var no_cidb = button.data('no_cidb');
            var taraf_bumiputera = button.data('taraf_bumiputera');
            var bidang_kepakaran = button.data('bidang_kepakaran');
            var no_ilam = button.data('no_ilam');
            var tarikh_luput_ilam = button.data('tarikh_luput_ilam');
            var nama_presiden = button.data('nama_presiden');
            var kategori_ngo = button.data('kategori_ngo');
            var jenis_institusi = button.data('jenis_institusi');
            var bidang_pembekal = button.data('bidang_pembekal');
            let telefon = '';
            // let folder = title.replace(/ /g, '_');

            // for (let key in no_telefon) {
            //     if (no_telefon.hasOwnProperty(key)) {
            //         if (no_telefon[key] && key == "Telefon") {
            //             telefon = no_telefon[key];
            //             console.log(no_telefon[key]);
            //         } else {
            //             console.log(key, no_telefon[key]);
            //         }
            //         console.log(key);
            //     }
            // }

            const container = document.getElementById("mediaSosial");

            // Clear existing (optional)
            container.innerHTML = "";

            const priorityOrder = ["Emel", "Telefon", "Web"];
            function appendRow(labelText, valueText) {
                const row = document.createElement("div");
                row.className = "row";

                const colLabel = document.createElement("div");
                colLabel.className = "col-5 col-xs-12";
                colLabel.innerHTML = `<p><strong>${labelText}</strong></p>`;

                const colValue = document.createElement("div");
                colValue.className = "col-7 col-xs-12";
                colValue.innerHTML = `<p>${valueText || 'Tiada Maklumat'}</p>`;

                row.appendChild(colLabel);
                row.appendChild(colValue);
                container.appendChild(row);
            }

            // Add in priority order
            priorityOrder.forEach(key => {
                if (media_sosial.hasOwnProperty(key)) {
                    appendRow(key, media_sosial[key]);
                }
            });

            // Add the remaining keys
            Object.keys(media_sosial).forEach(key => {
                if (!priorityOrder.includes(key)) {
                    appendRow(key, media_sosial[key]);
                }
            });

            // Update the modal's content
            var modal = $(this);
            modal.find('.modal-content').scrollTop(0);
            if (title && title !== '') {
                modal.find('#title').text(title);
            }
            if (address && address !== '') {
                modal.find('#address').text(address);
            }
            // if (telefon && telefon !== '') {
            //     modal.find('#no_telefon').text(telefon);
            // }
            // if (emel && emel !== '') {
            //     modal.find('#emel').text(emel);
            // }

            if(jenis == "Kontraktor"){
                const bidangKepakaranMap = {
                    1: 'LANDSKAP ARKITEK',
                    2: 'ELEKTRIK',
                    3: 'SIVIL DAN STRUKTUR',
                    4: 'UKURBAHAN',
                    5: 'B09 (Lanskap dalam bangunan)',
                    6: 'CE14 (Landskap diluar bangunan)',
                    7: 'B09 & CE14 (Lanskap dalam bangunan), (Landskap diluar bangunan)',
                    0: 'TIADA MAKLUMAT'
                };

                const tarafBumiputeraMap = {
                    1: 'BUMIPUTERA',
                    2: 'BUKAN BUMIPUTERA',
                    0: 'TIADA MAKLUMAT'
                };
                if (taraf_bumiputera && taraf_bumiputera !== '') {
                    // Map the numeric value to the corresponding name
                    const tarafBumiputeraName = tarafBumiputeraMap[taraf_bumiputera];
                    // console.log(tarafBumiputeraName);  // Console log the name
                    modal.find('#taraf_bumiputera').text(tarafBumiputeraName);
                }

                if (bidang_kepakaran && bidang_kepakaran !== '') {
                    // Map the numeric value to the corresponding name
                    const bidangKepakaranName = bidangKepakaranMap[bidang_kepakaran];
                    // console.log(bidangKepakaranName);  // Console log the name
                    modal.find('#bidang_kepakaran').text(bidangKepakaranName);
                }
                if (no_cidb && no_cidb !== '') {
                    modal.find('#no_cidb').text(no_cidb);
                }
            }
            if(jenis == "Perunding"){
                if (no_ilam && no_ilam !== '') {
                    modal.find('#no_ilam').text(no_ilam);
                }
                if (tarikh_luput_ilam && tarikh_luput_ilam !== '') {
                    modal.find('#tarikh_luput_ilam').text(tarikh_luput_ilam);
                }
            }
            if(jenis == "Pembekal"){
                const bidangPembekalMap = {
                    1: 'Nurseri & Landskap Kejur',
                    2: 'Alat Permainan',
                    3: 'Lain-lain',
                    0: 'Tiada Maklumat'
                };
                if (bidang_pembekal && bidang_pembekal !== '') {
                    const bidangPembekalName = bidangPembekalMap[bidang_pembekal];
                    modal.find('#bidang_pembekal').text(bidangPembekalName);
                }
            }
            if(jenis == "NGO / Badan Ikhtisas"){
                const kategoriNgoMap = {
                    1: 'Badan Bukan Kerajaan (NGO)',
                    2: 'Badan Ikhtisas',
                    0: 'Tiada Maklumat'
                };
                if (kategori_ngo && kategori_ngo !== '') {
                    const kategoriNgoName = kategoriNgoMap[kategori_ngo];
                    modal.find('#kategori_ngo').text(kategoriNgoName);
                }
            }
            if(jenis == "Institusi Pendidikan"){
                const jenisInstitusiMap = {
                    1: 'IPTA',
                    2: 'IPTS',
                    3: 'KOLEJ',
                    4: 'SEKOLAH',
                    0: 'TIADA MAKLUMAT'
                };
                if (jenis_institusi && jenis_institusi !== '') {
                    const jenisInstitusiName = jenisInstitusiMap[jenis_institusi];
                    modal.find('#jenis_institusi').text(jenisInstitusiName);
                }
            }
            if(jenis == "NGO / Badan Ikhtisas" || jenis == "Pertubuhan Antarabangsa"){
                if (nama_presiden && nama_presiden !== '') {
                    modal.find('#nama_presiden').text(nama_presiden);
                }
            }
            if(jenis == "Kontraktor" || jenis == "Perunding" || jenis == "Pembekal"){
                if (no_ssm && no_ssm !== '') {
                    modal.find('#no_ssm').text(no_ssm);
                }
                if (no_mof && no_mof !== '') {
                    modal.find('#no_mof').text(no_mof);
                }
            }
            if(jenis == "Kontraktor" || jenis == "Perunding" || jenis == "Pembekal"){
                populateTablePengalaman(pengalaman);
            }
            if(jenis == "Pembekal"){
                populateTableProduk(produk, folder);
            }
        });

        $('#parkModal').on('hidden.bs.modal', function () {
            var modal = $(this);
            modal.find('#title').text('');
            modal.find('#address').text('');
            modal.find('#no_telefon').text('');
            modal.find('#emel').text('');
            modal.find('#no_ssm').text('');
            modal.find('#no_mof').text('');
            modal.find('#no_cidb').text('');
            modal.find('#taraf_bumiputera').text('');
            modal.find('#bidang_kepakaran').text('');
            modal.find('#kategori_ngo').text('');
            modal.find('#jenis_institusi').text('');
            modal.find('#nama_presiden').text('');
            modal.find('#produk_container').empty();
            modal.find('#pengalaman_container').empty();
            modal.find('.modal-content').scrollTop(0);
        });

        function populateTablePengalaman(data) {
            // Get the table body element
            var tableBody = document.getElementById("pengalaman_container");

            // Check if data is empty
            if (data.length === 0) {
                // If no data, add a row indicating no information available
                tableBody.innerHTML = "<tr><td colspan='5' class='text-center'>Tiada Maklumat</td></tr>";
                return;
            }

            // Loop through the data array and create table rows dynamically
            data.forEach(function(item, index) {
                // Create a new row
                var row = document.createElement("tr");
                
                // Create and append the 'Bil' column
                var bilCell = document.createElement("td");
                bilCell.textContent = index + 1;  // 'Bil' is the row number
                row.appendChild(bilCell);

                // Create and append the 'Tajuk Projek' column
                var tajukCell = document.createElement("td");
                tajukCell.textContent = item.tajuk;  // Display the tajuk value
                row.appendChild(tajukCell);

                // Create and append the 'Kos' column
                var kosCell = document.createElement("td");
                kosCell.textContent = item.kos;  // Display the kos value
                row.appendChild(kosCell);

                // Create and append the 'Tahun' column
                var tahunCell = document.createElement("td");
                tahunCell.textContent = item.tahun;  // Display the tahun value
                row.appendChild(tahunCell);

                // Create and append the 'Status' column
                var statusCell = document.createElement("td");
                statusCell.textContent = item.status;  // Display the status value
                row.appendChild(statusCell);

                // Append the row to the table body
                tableBody.appendChild(row);
            });
        }

        
        function populateTableProduk(data, folder) {
            // Get the table body element
            var tableBody = document.getElementById("produk_container");
            // Check if data is empty
            if (data.length === 0) {
                // If no data, add a row indicating no information available
                tableBody.innerHTML = "<tr><td colspan='6' class='text-center'>Tiada Maklumat</td></tr>";
                return;
            }

            // Loop through the data array and create table rows dynamically
            data.forEach(function(item, index) {
                var row = document.createElement("tr");

                // Create and append the 'Bil' column
                var bilCell = document.createElement("td");
                bilCell.textContent = index + 1;  // 'Bil' is the row number
                row.appendChild(bilCell);

                // Create and append the 'Nama Produk' column
                var namaCell = document.createElement("td");
                namaCell.textContent = item.nama;  // Display the nama value
                let subfolder = item.nama.replace(/ /g, '_');
                row.appendChild(namaCell);

                // Create and append the 'Keterangan' column
                var keteranganCell = document.createElement("td");
                keteranganCell.textContent = item.keterangan;  // Display the keterangan value
                row.appendChild(keteranganCell);

                // Create and append the 'Harga' column
                var hargaCell = document.createElement("td");
                hargaCell.textContent = item.harga;  // Display the harga value
                row.appendChild(hargaCell);

                let imagePath = `/storage/uploads`;

                // Create and append the 'Gambar Produk 1' column (Image 1)
                var gambarProduk1Cell = document.createElement("td");
                var gambarProduk1Img = document.createElement("img");
                var gambarProduk1Link = document.createElement("a");

                if (item.gambar_produk_1) {
                    var fullImagePath = imagePath + '/eLIND/' + folder + '/' + subfolder + '/' + item.gambar_produk_1;
                    gambarProduk1Img.src = fullImagePath;
                    gambarProduk1Link.href = fullImagePath;
                    gambarProduk1Img.onerror = function () {
                        gambarProduk1Img.src = `${imagePath}/no-photos.png`;
                        gambarProduk1Link.href = `${imagePath}/no-photos.png`;
                    };
                } else {
                    gambarProduk1Img.src = `${imagePath}/no-photos.png`;
                    gambarProduk1Link.href = `${imagePath}/no-photos.png`;
                }

                gambarProduk1Img.alt = "Gambar Produk 1";
                gambarProduk1Img.style.width = "100px";

                gambarProduk1Link.target = "_blank";
                gambarProduk1Link.appendChild(gambarProduk1Img);

                gambarProduk1Cell.appendChild(gambarProduk1Link);
                row.appendChild(gambarProduk1Cell);


                // Create and append the 'Gambar Produk 2' column (Image 2)
                // var gambarProduk2Cell = document.createElement("td");
                // var gambarProduk2Img = document.createElement("img");
                // if(item.gambar_produk_2){
                //     gambarProduk2Img.src = imagePath + '/eLIND/' + folder+'/'+subfolder+'/'+item.gambar_produk_2 || '';
                //     gambarProduk2Img.onerror = function () {
                //         gambarProduk2Img.src = `${imagePath}/no-photos.png`;
                //     };
                // }else{
                //     gambarProduk2Img.src = `${imagePath}/no-photos.png`;
                // }
                // gambarProduk2Img.alt = "Gambar Produk 2";
                // gambarProduk2Img.style.width = "100px";  // Set a fixed width for the image
                // gambarProduk2Cell.appendChild(gambarProduk2Img);
                // row.appendChild(gambarProduk2Cell);

                var gambarProduk2Cell = document.createElement("td");
                var gambarProduk2Img = document.createElement("img");
                var gambarProduk2Link = document.createElement("a");

                if (item.gambar_produk_2) {
                    var fullImagePath = imagePath + '/eLIND/' + folder + '/' + subfolder + '/' + item.gambar_produk_2;
                    gambarProduk2Img.src = fullImagePath;
                    gambarProduk2Link.href = fullImagePath;
                    gambarProduk2Img.onerror = function () {
                        gambarProduk2Img.src = `${imagePath}/no-photos.png`;
                        gambarProduk2Link.href = `${imagePath}/no-photos.png`;
                    };
                } else {
                    gambarProduk2Img.src = `${imagePath}/no-photos.png`;
                    gambarProduk2Link.href = `${imagePath}/no-photos.png`;
                }

                gambarProduk2Img.alt = "Gambar Produk 2";
                gambarProduk2Img.style.width = "100px";

                gambarProduk2Link.target = "_blank";
                gambarProduk2Link.appendChild(gambarProduk2Img);

                gambarProduk2Cell.appendChild(gambarProduk2Link);
                row.appendChild(gambarProduk2Cell);

                // Append the row to the table body
                tableBody.appendChild(row);
            });
        }
    });
</script>