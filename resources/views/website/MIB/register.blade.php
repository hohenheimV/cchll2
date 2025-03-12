@extends('layouts.pengurusan.auth')

@section('title', 'Daftar Rakan Taman')
@section('content')
    <!-- <section class="content">
        
    </section> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        /* Basic reset for body */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .card-body {
            width: 100%; /* Use full width on smaller screens */
            padding: 20px; /* Add padding */
        }


        /* Responsive styles */
        @media (max-width: 992px) {
            .card-body {
                width: 100%; /* Use full width on smaller screens */
                padding: 20px; /* Add padding */
            }

            .input-group {
                flex-direction: column; /* Stack elements vertically */
                width: 100%;
            }

            .input-group .form-control {
                width: 100%; /* Ensure inputs are full width */
            }
        }

        @media (min-width: 992px) {
            .card-body {
                width: 400px; /* Fixed width for larger screens */
            }    
            .mobile-label {
            display: block; /* Make sure it's a block element */
            margin-right: 15px; /* Space between label and input */
        }
        }
        
    </style>
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da; /* Match the default Bootstrap border */
            border-radius: 0.25rem; /* Match the default Bootstrap border radius */
            height: calc(2.25rem + 2px); /* Match the height */
            padding: 0.375rem 0.75rem; /* Match the padding */
            font-size: 1rem; /* Match the font size */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem; /* Align text vertically */
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d; /* Match the placeholder color */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 2.25rem; /* Match arrow height */
            top: 50%; /* Center the arrow */
            transform: translateY(-50%); /* Center the arrow */
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            color: #dc3545; /* Clear button color */
        }

    </style>

    <br>
    <br>
    <section class="content">
        @include('layouts.pengurusan.notification')
    </section>
    <div class="row">
        <div class="col-lg-12 col-12 rounded-right bg-white">
            <div class="card-body">
                <div class="text-center d-lg-none">
                    <img height="96" src="{{ asset('img/logo-jln.png') }}" />
                    <h3><span class="font-weight-bold">{{ config('app.name_short') }}</span> {{ config('app.agency_short') }}</h3>
                </div>
                <div class="login-logo h-100 d-flex flex-column justify-content-center align-items-center">
                    <div>
                        <img src="{{ asset('storage/images/logo-jln.png') }}" alt="" style="height:60px;">
                        <img src="{{ asset('storage/images/jata_malaysia.png') }}" alt="" style="height:60px;">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="" style="height:60px;">
                    </div>
                    <h4 class="login-box-msg text-dark">MALAYSIA IN BLOOM (MiB)</h4>
                    <h6 class="login-box-msg text-dark">Permohonan Pendaftaran Rakan Taman</h6>
                </div>

                <!-- Registration form Input Fields -->
                <form id="myForm" method="POST" action="{{ route('website.MIB.simpan') }}" class="m-lg-5" enctype="multipart/form-data">
                    @csrf

                    <div id="user_details" style="display: block;">
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('name', 'Nama') }}
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama"  autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('email', 'Emel') }}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Emel" >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Fields for PBT Account Type -->
                    <div id="pbt_fields" style="display: block;">
                        <div class="form-group mb-3">
                            {{ Form::label('negeri', 'Negeri') }}
                            <br>
                            <select id="negeri" class="form-control select2" name="negeri" onchange="updatePBT()">
                                <option value="">Pilih Negeri</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
                            <input type="text" name="pbt" id="pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" class="form-control" >
                            <datalist id="data_pbt">
                            </datalist>
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('taman', 'Taman Perumahan') }}
                            <input id="taman" type="text" class="form-control" name="taman" placeholder="Taman Perumahan (House No./Lot No./Floor and Building Name)" >
                        </div>
                    </div>
                    

                    <div id="user_address" style="display: block;">
                        <div class="row">
                            <div class="form-group mb-6 col-md-12">
                                <table id="senarai_kawasan_lapang" class="table table-bordered" style="margin-bottom:0;">
                                    <thead>
                                        <tr style="background-color: #e5e5e5;height: 5px;">
                                            <th style="padding: 4px 8px; line-height: 1.2;">Nama Kawasan Lapang <span class="font-red"> * </span></th>
                                            <th style="padding: 4px 8px; line-height: 1.2;">Keluasan (Ekar) <span class="font-red"> * </span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:middle;">
                                                <input type="text" name="kawasan[0][nama]" class="form-control" maxlength="150" value="">
                                            </td>
                                            <td style="vertical-align:middle;">
                                                <input type="text" name="kawasan[0][keluasan]" class="form-control decimal" maxlength="20" value="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e5e5e5;height: 5px;">
                                            <td style="padding: 4px 8px; line-height: 1.2;">Jumlah Keluasan</td>
                                            <td style="padding: 4px 8px; line-height: 1.2;"><span id="jumlah_keluasan">0</span> ekar</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                                <p>
                                    <button type="button" id="addKawasan" class="btn btn-info" style="margin-right:20px;">Tambah</button>
                                    * Minimum keluasan bagi kawasan lapang adalah 0.5 ekar
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="pelan_lokasi_1">Pelan Lokasi 1 <span class="font-red"> * </span></label>
                                <input type="file" name="fail[pelan_lokasi_1]" class="form-control" >
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                            <div class="form-group mb-3 col-md-4">
                                <label for="pelan_lokasi_2">Pelan Lokasi 2</label>
                                <input type="file" name="fail[pelan_lokasi_2]" class="form-control">
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                            <div class="form-group mb-3 col-md-4">
                                <label for="pelan_lokasi_3">Pelan Lokasi 3</label>
                                <input type="file" name="fail[pelan_lokasi_3]" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-md-4">
                                <label for="gambar_kawasan_lapang_1">Gambar Kawasan Lapang 1 <span class="font-red"> * </span></label>
                                <input type="file" name="fail[gambar_kawasan_lapang_1]" class="form-control" >
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                            <div class="form-group mb-3 col-md-4">
                                <label for="gambar_kawasan_lapang_2">Gambar Kawasan Lapang 2</label>
                                <input type="file" name="fail[gambar_kawasan_lapang_2]" class="form-control">
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                            <div class="form-group mb-3 col-md-4">
                                <label for="gambar_kawasan_lapang_3">Gambar Kawasan Lapang 3</label>
                                <input type="file" name="fail[gambar_kawasan_lapang_3]" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8 col-xs-12">
                                <p class="help-block font-red"> <i class="fa fa-info-circle"></i> Format yang dibenarkan: pdf, gif, jpg, png, jpeg. Saiz maksimum fail adalah  10MB.</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group mb-6 col-md-12">
                                {{ Form::label('penduduk', 'Anggaran Penduduk * ') }}
                                <input id="penduduk" type="text" class="form-control" name="penduduk" placeholder="Anggaran Penduduk">
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-bordered" style="margin-bottom:0;">
                                <thead>
                                    <tr style="background-color: #e5e5e5;height: 5px;">
                                        <th colspan="4" class="text-center bold" style="padding: 4px 8px; line-height: 1.2;">
                                            SENARAI JAWATANKUASA MiB
                                        </th>
                                    </tr>
                                    <tr style="background-color: #e5e5e5;height: 5px;">
                                        <th style="padding: 4px 8px; line-height: 1.2;">Jawatan</th>
                                        <th style="padding: 4px 8px; line-height: 1.2;">Nama <span class="font-red"> * </span></th>
                                        <th style="padding: 4px 8px; line-height: 1.2;">No. Telefon Bimbit <span class="font-red"> * </span></th>
                                        <th style="padding: 4px 8px; line-height: 1.2;">Alamat Emel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 4px 8px; line-height: 1;">Pengerusi <span class="font-red"> * </span></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="pengerusi_nama" name="pengerusi_nama" class="form-control" maxlength="150" value=""></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="pengerusi_tel_bimbit" name="pengerusi_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="pengerusi_email" name="pengerusi_email" class="form-control lowercase" maxlength="100" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 8px; line-height: 1;">Timbalan Pengerusi <span class="font-red"> * </span></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="timbalan_pengerusi_nama" name="timbalan_pengerusi_nama" class="form-control" maxlength="150" value=""></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="timbalan_pengerusi_tel_bimbit" name="timbalan_pengerusi_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="timbalan_pengerusi_email" name="timbalan_pengerusi_email" class="form-control lowercase" maxlength="100" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 8px; line-height: 1;">Setiausaha <span class="font-red"> * </span></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="setiausaha_nama" name="setiausaha_nama" class="form-control " maxlength="150" value="" ></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="setiausaha_tel_bimbit" name="setiausaha_tel_bimbit" class="form-control" maxlength="20" value="" ></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="setiausaha_email" name="setiausaha_email" class="form-control lowercase" maxlength="100" value=""></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 8px; line-height: 1;">Bendahari <span class="font-red"> * </span></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="bendahari_nama" name="bendahari_nama" class="form-control " maxlength="150" value="" ></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="bendahari_tel_bimbit" name="bendahari_tel_bimbit" class="form-control " maxlength="20" value="" ></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="bendahari_email" name="bendahari_email" class="form-control lowercase" maxlength="100" value=""></td>
                                    </tr>
                                    <!-- Repeat for other rows with similar structure -->
                                    @for ($i = 1; $i <= 6; $i++)
                                        <tr>
                                            <td style="padding: 4px 8px; line-height: 1;">AJK {{ $i }}</td>
                                            <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="ajk{{ $i }}_nama" name="ajk{{ $i }}_nama" class="form-control" maxlength="150" value=""></td>
                                            <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="ajk{{ $i }}_tel_bimbit" name="ajk{{ $i }}_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                                            <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="ajk{{ $i }}_email" name="ajk{{ $i }}_email" class="form-control lowercase" maxlength="100" value=""></td>
                                        </tr>
                                    @endfor
                                    <!-- <tr>
                                        <td style="padding: 4px 8px; line-height: 1;">Penyelaras (Pemegang ID) <span class="font-red"> * </span></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="penyelaras_nama" name="penyelaras_nama" class="form-control" maxlength="150" value=""></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="penyelaras_tel_bimbit" name="penyelaras_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="penyelaras_email" name="penyelaras_email" class="form-control lowercase" maxlength="100" value=""></td>
                                    </tr> -->
                                    <tr>
                                        <td style="padding: 4px 8px; line-height: 1;">Alamat Surat Menyurat Penyelaras <span class="font-red"> * </span></td>
                                        <td colspan="3" style="padding: 4px 8px; line-height: 1;">
                                            <textarea id="alamat" name="alamat" class="form-control" rows="5"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: #e5e5e5;height: 5px;">
                                        <td colspan="4" style="padding: 4px 8px; line-height: 1.2;">
                                            Jumlah Keluasan
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="form-group mb-6 col-md-12" style="background-color:#fef7f8; border-left: 5px solid #f0868e; padding: 15px;">
                                <label><h4>Pengesahan dan pengakuan pemohon:</h4></label>
                                <textarea style="background-color: transparent; border: none; outline: none; padding: 10px; width: 100%; resize: none;" rows="3" class="form-control" readonly disabled>Saya mengaku segala maklumat yang saya nyatakan di dalam borang ini adalah benar dan betul. Saya faham sekiranya ada di antara maklumat yang saya nyatakan di atas tidak benar/palsu, permohonan ini akan terbatal dengan sendirinya.</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="row" style="display: block;" id="daftar">
                        <div class="col-12">
                            <button type="submit" class="btn bg-olive btn-block btn-flat">Daftar</button>
                            <!-- <button type="reset" class="btn bg-gray btn-block btn-flat">Reset</button> -->
                        </div>
                    </div>
                    &nbsp;
                    <div class="row" style="display: block;" id="daftar">
                        <div class="col-12">
                            <button type="reset" class="btn bg-gray btn-block btn-flat">Reset</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
@endsection
@section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // function updateFields() {
        //     $('.card-body').css('width', '100%');
        //     var accountType = $('#roles').val();
        //     var $pbtFields = $('#pbt_fields');
        //     var $daftarButton = $('#daftar');

        //     $('#user_details').show();
        //     $pbtFields.show();
        //     $pbtFields.find('input, select').prop('disabled', false);
        //     $daftarButton.show();
        //     var $negeri = $('#negeri');
        //     // Disable the PBT dropdown and show the spinner
        //     $negeri.prop('disabled', true);
        //     $('#loading-spinner').show(); // Show the spinner
        //     // Load Negeri options
        //     $.getJSON('/data/negeri', function(data) {
                
        //         $.each(data, function(index, negeri) {
        //             let pname = negeri.name;
        //             $negeri.append($('<option>', {
        //                 value: negeri.id,
        //                 text: negeri.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
        //             }));
        //         });
        //         // Re-enable the negeri dropdown and hide the spinner
        //         $negeri.prop('disabled', false);
        //         $('#loading-spinner').hide(); // Hide the spinner

        //         // Initialize Select2
        //         $negeri.select2({
        //             // placeholder: 'Pilih Negeri',
        //             allowClear: false
        //         });
        //     }).fail(function() {
        //         // Handle errors if needed
        //         $negeri.prop('disabled', false);
        //         $('#loading-spinner').hide(); // Hide the spinner in case of error
        //         alert('Failed to load data');
        //     });
        // }

        function updatePBT() {
            // const negeriId = $('#negeri').val();
            // const $datalist = $('#data_pbt');  // Target the datalist element
            
            // // Clear previous options in the datalist
            // $datalist.empty();
            
            // // Show the spinner while loading
            // $('#loading-spinner').show(); 

            // $.getJSON('/data/pbt/' + negeriId, function(data) {
            //     // Loop through the data and populate the datalist
            //     $.each(data, function(index, pbt) {
            //         // Create a new option element for the datalist
            //         $datalist.append($('<option>', {
            //             value: pbt.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
            //             // text: pbt.id,
            //             'data-id': pbt.id,
            //         }));
            //     });

            //     // Hide the spinner once the data is loaded
            //     $('#loading-spinner').hide(); 
            // }).fail(function() {
            //     // Hide the spinner in case of error
            //     $('#loading-spinner').hide();
            //     alert('Failed to load data. Sila isi Nama Pihak Berkuasa Tempatan.');
            // });
        }

        // Initialize fields based on the default dropdown value
        $(document).ready(function() {
            $('.card-body').css('width', '100%');
            var $negeri = $('#negeri');
            // Disable the PBT dropdown and show the spinner
            $negeri.prop('disabled', true);
            $('#loading-spinner').show(); // Show the spinner
            // Load Negeri options
            $.getJSON('/data/negeri', function(data) {
                
                $.each(data, function(index, negeri) {
                    let pname = negeri.name;
                    $negeri.append($('<option>', {
                        value: negeri.id,
                        text: negeri.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                    }));
                });
                // Re-enable the negeri dropdown and hide the spinner
                $negeri.prop('disabled', false);
                $('#loading-spinner').hide(); // Hide the spinner

                // Initialize Select2
                $negeri.select2({
                    // placeholder: 'Pilih Negeri',
                    allowClear: false
                });
            }).fail(function() {
                // Handle errors if needed
                $negeri.prop('disabled', false);
                $('#loading-spinner').hide(); // Hide the spinner in case of error
                alert('Failed to load data');
            });

            // When the 'Negeri' dropdown changes
            $('#negeri').change(function() {
                const negeriId = $('#negeri').val();
                const $datalist = $('#data_pbt');  // Target the datalist element
                $('#pbt').val('');
                // Clear previous options in the datalist
                $datalist.empty();
                
                // Show the spinner while loading
                $('#loading-spinner').show(); 

                $.getJSON('/data/pbt/' + negeriId, function(data) {
                    // Loop through the data and populate the datalist
                    $.each(data, function(index, pbt) {
                        // Create a new option element for the datalist
                        $datalist.append($('<option>', {
                            value: pbt.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                            // text: pbt.id,
                            'data-id': pbt.id,
                        }));
                    });
                    
                    // Hide the spinner once the data is loaded
                    $('#loading-spinner').hide(); 
                }).fail(function() {
                    // Hide the spinner in case of error
                    $('#loading-spinner').hide();
                    alert('Failed to load data. Sila isi Nama Pihak Berkuasa Tempatan.');
                });
            });
            // $('#myForm')[0].reset();
            // // $('#roles').val('');
            // if($('#roles').val() != ''){
            //     updateFields();
            // }

            let rowIndex = 1; // Initialize the row index.

            $('#addKawasan').click(function() {
                var newRow = `
                    <tr>
                        <td style="vertical-align:middle;">
                            <input type="text" name="kawasan[${rowIndex}][nama]" class="form-control" maxlength="150" value="">
                        </td>
                        <td style="vertical-align:middle;">
                            <input type="text" name="kawasan[${rowIndex}][keluasan]" class="form-control decimal" maxlength="20" value="">
                        </td>
                    </tr>
                `;
                $('#senarai_kawasan_lapang tbody').append(newRow);
                
                // Increment the rowIndex for the next row
                rowIndex++;
            });

            // Update total area (jumlah_keluasan) when a field changes
            $(document).on('input', 'input[name^="kawasan"][name$="[keluasan]"]', function() {
                var totalArea = 0;
                $('input[name$="[keluasan]"]').each(function() {
                    var area = parseFloat($(this).val());
                    if (!isNaN(area)) {
                        totalArea += area;
                    }
                });
                $('#jumlah_keluasan').text(totalArea.toFixed(2));
            });
            
        });
    </script>
@endsection

