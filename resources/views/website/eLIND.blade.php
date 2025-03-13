@extends('layouts.website.secondary')
@section('title', 'Direktori Penggiat Industri: '. $keyword)

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
                            <h3 class="card-title font-weight-bold my-1">Direktori Penggiat Industri: {{ $keyword }}</h3>
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
                                                // var selectedKeyword = $('#negeri').val(); // Get the selected negeri value

                                                // if (selectedKeyword) {
                                                //     // Redirect to the route with the selected keyword
                                                //     window.location.href = "/epalm-taman/" + selectedKeyword;
                                                // } else {
                                                //     window.location.href = "/epalm-taman";
                                                // }
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
                                    <table id="exampleNP" class="responsive table table-bordered table-hover table-striped mb-0" style="font-size: 12px;">
                                        <thead style="background-color:rgb(0, 0, 0) !important;color: white;">
                                            <tr>
                                                <th class="w-1">Bil.</th>
                                                <th class="w-15">Nama</th>
                                                <th class="w-5">Alamat</th>
                                                <th class="text-center w-5">Prestasi</th>
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
                                                        <td>
                                                        @if(isset($user->email)) {{ $user->email }}<br>@endif
                                                        @if(isset($user->address1)) {{ $user->address1 }}<br>@endif
                                                        @if(isset($user->address2)) {{ $user->address2 }}<br>@endif
                                                        @if(isset($user->postcode)) {{ $user->postcode }}<br>@endif
                                                        @if(isset($user->locality)) {{ $user->locality }}<br>@endif
                                                        @if(isset($user->state)) {{ $user->state }}<br>@endif
                                                        </td>
                                                        <td class="text-center">
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
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button 
                                                                    type="button" 
                                                                    class="btn btn-primary btn-sm" 
                                                                    data-title="{{ $user->name }}" 
                                                                    data-address="@if(isset($user->email)) {{ $user->email.',' }}@endif
                                                                    @if(isset($user->address1)) {{ $user->address1.',' }}@endif
                                                                    @if(isset($user->address2)) {{ $user->address2.',' }}@endif
                                                                    @if(isset($user->postcode)) {{ $user->postcode.',' }}@endif
                                                                    @if(isset($user->locality)) {{ $user->locality.',' }}@endif
                                                                    @if(isset($user->state)) {{ $user->state.',' }}@endif"
                                                                    data-no_telefon="{{ $user->mediaSosial_penggiat }}"
                                                                    data-emel="{{ $user->email }}"
                                                                    data-no_ssm="{{ $user->no_ssm }}"
                                                                    data-no_mof="{{ $user->no_mof }}"
                                                                    data-no_cidb="{{ $user->no_cidb }}"
                                                                    data-taraf_bumiputera="{{ $user->taraf_bumiputera }}"
                                                                    data-bidang_kepakaran="{{ $user->bidang_kepakaran }}"
                                                                    data-pengalaman="{{ $user->pengalaman }}"
                                                                    data-toggle="modal" 
                                                                    data-target="#parkModal"
                                                                >
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        @php
                                                            $previousNegeri = $user->negeri; // Update the previous value
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr><td colspan="5" class="text-center">No data available</td></tr>
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

            .modal-content h2 {
                text-align: center;
            }

            .modal-content span {
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
            }
        </style>
        <style>
            .col-separator {
                position: relative;
                padding-left: 15px; /* Optional padding */
            }

            .col-separator::before {
                content: '';
                position: absolute;
                top: 15%;   /* Adjust the starting position of the gradient */
                bottom: 5%; /* Adjust the ending position of the gradient */
                left: 0;
                width: 3px;   /* Border thickness */
                background: linear-gradient(to bottom, #ff7f50, #00bfff); /* Gradient effect */
            }

            /* Optionally, you can remove the border for the first column */
            .col-separator:first-child::before {
                background: none; /* Remove the left border for the first column */
            }
        </style>
        <div id="parkModal" class="modal">
            <div class="modal-content" style="background-color:rgb(25, 98, 92) !important;">
                <div class="modal-header justify-content-center bg-white">
                    <h2 class="modal-title" id="title" style="text-align: center;">Park Name</h2>
                </div>

                <div class="modal-body bg-white">
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
                    <div class="row">
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
                    </div>
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

                    <div class="park-images">
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
                    var title = button.data('title');
                    var address = button.data('address');
                    var no_telefon = button.data('no_telefon');
                    var emel = button.data('emel');
                    var no_ssm = button.data('no_ssm');
                    var no_mof = button.data('no_mof');
                    var no_cidb = button.data('no_cidb');
                    var taraf_bumiputera = button.data('taraf_bumiputera');
                    var bidang_kepakaran = button.data('bidang_kepakaran');
                    var pengalaman = button.data('pengalaman');
                    let telefon = '';

                    for (let key in no_telefon) {
                        if (no_telefon.hasOwnProperty(key)) {
                            if (no_telefon[key] && key == "Telefon") {
                                telefon = no_telefon[key];
                                console.log(no_telefon[key]);
                            } else {
                                console.log(key, no_telefon[key]);
                            }
                        }
                    }
                    // Update the modal's content
                    var modal = $(this);
                    modal.find('.modal-content').scrollTop(0);
                    if (title && title !== '') {
                        modal.find('#title').text(title);
                    }
                    if (address && address !== '') {
                        modal.find('#address').text(address);
                    }
                    if (telefon && telefon !== '') {
                        modal.find('#no_telefon').text(telefon);
                    }
                    if (emel && emel !== '') {
                        modal.find('#emel').text(emel);
                    }
                    if (no_ssm && no_ssm !== '') {
                        modal.find('#no_ssm').text(no_ssm);
                    }
                    if (no_mof && no_mof !== '') {
                        modal.find('#no_mof').text(no_mof);
                    }
                    if (no_cidb && no_cidb !== '') {
                        modal.find('#no_cidb').text(no_cidb);
                    }
                    if (taraf_bumiputera && taraf_bumiputera !== '') {
                        modal.find('#taraf_bumiputera').text(taraf_bumiputera);
                    }
                    if (bidang_kepakaran && bidang_kepakaran !== '') {
                        modal.find('#bidang_kepakaran').text(bidang_kepakaran);
                    }
                    populateTable(pengalaman)
                });

                $('#parkModal').on('hidden.bs.modal', function () {
                    $(this).find('#title').text('');
                    $(this).find('#address').text('');
                    $(this).find('#no_telefon').text('');
                    $(this).find('#emel').text('');
                    $(this).find('#no_ssm').text('');
                    $(this).find('#no_mof').text('');
                    $(this).find('#no_cidb').text('');
                    $(this).find('#taraf_bumiputera').text('');
                    $(this).find('#bidang_kepakaran').text('');
                    $(this).find('.modal-content').scrollTop(0);
                });

                function populateTable(data) {
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
            });
        </script>

    </section>
    <!-- /.section#posts -->

@endsection



