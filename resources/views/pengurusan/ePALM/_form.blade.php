
    <style>
        .col-separator {
            position: relative;
            padding-left: 15px; /* Optional padding */
        }

        .col-separator::before {
            content: '';
            position: absolute;
            top: 5%;   /* Adjust the starting position of the gradient */
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
    <div class="row">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="inertClass">
                <div class="form-group required">
                    <label for="nama_taman" class="col-md-12 control-label">Nama Taman</label>
                    <div class="col-md-12">
                        <!-- <textarea name="nama_taman" class="form-control" maxlength="50" rows="1" id="nama_taman" required="required" >{{-- old('nama_taman', $ePALM->nama_taman) --}}</textarea> -->
                        {!! Form::textarea('nama_taman', null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => '1', 'id' => 'nama_taman', 'required' => 'required']) !!}
                        <script>
                            // Function to resize textarea based on content
                            function resizeTextarea(textarea) {
                                textarea.style.height = 'auto';  // Reset the height
                                textarea.style.height = (textarea.scrollHeight) + 'px';  // Set the height to scrollHeight
                            }

                            // Call resize function when the page loads
                            window.onload = function() {
                                var textarea = document.getElementById('nama_taman');
                                resizeTextarea(textarea);  // Resize textarea based on content
                            };
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group required col-md-8">
                        <label for="nama_pbt" class="col-md-12 control-label">Pihak Berkuasa Tempatan</label>
                        <div class="col-md-12">
                            <!-- <input name="nama_pbt" class="form-control" maxlength="50" type="text" id="nama_pbt" required="required" value="MAJLIS DAERAH KUALA LANGAT"> -->
                            {!! Form::text('nama_pbt', null, ['class' => 'form-control', 'id' => 'nama_pbt']) !!}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="kategori_taman" class="col-md-12 control-label">Jenis Taman</label>
                        <div class="col-md-12">
                            <!-- <select name="kategori_taman" class="form-control" id="kategori_taman" required="required">
                                <option value="1">Taman Awam</option>
                                <option value="2">Taman Botani</option>
                                <option value="3">Landskap Perbandaran</option>
                                <option value="4">Persekitaran Kehidupan</option>
                                <option value="5">Taman Persekutuan</option>
                                <option value="6">Lain-lain (sila nyatakan)</option>
                            </select> -->
                            {{--
                                {!! Form::select('kategori_taman', [
                                    'Taman Awam' => 'Taman Awam',
                                    'Taman Botani' => 'Taman Botani',
                                    'Landskap Perbandaran' => 'Landskap Perbandaran',
                                    'Persekitaran Kehidupan' => 'Persekitaran Kehidupan',
                                    'Taman Persekutuan' => 'Taman Persekutuan',
                                ], isset($ePALM->kategori_taman) ? $ePALM->kategori_taman : '', ['class' => 'form-control', 'id' => 'kategori_taman', 'required' => 'required']) !!}
                            --}}

                            @php
                                $options = [
                                    'Taman Awam' => 'Taman Awam',
                                    'Taman Botani' => 'Taman Botani',
                                    'Landskap Perbandaran' => 'Landskap Perbandaran',
                                    'Persekitaran Kehidupan' => 'Persekitaran Kehidupan',
                                    'Taman Persekutuan' => 'Taman Persekutuan',
                                    '6' => 'Lain-lain (sila nyatakan)'
                                ];

                                // Check if $ePALM->kategori_taman exists and is not in the options list, then append it
                                if (isset($ePALM->kategori_taman) && !array_key_exists($ePALM->kategori_taman, $options)) {
                                    $options[$ePALM->kategori_taman] = $ePALM->kategori_taman;  // Add it to options
                                }
                                //dd(array_key_exists("Taman Awamw", $options));
                            @endphp

                            {!! Form::select('kategori_taman', $options, isset($ePALM->kategori_taman) ? $ePALM->kategori_taman : '', ['class' => 'form-control', 'id' => 'kategori_taman', 'required' => 'required']) !!}
                        </div>
                    </div>
                </div>

                <!-- Input field that will be displayed when 'Lain-lain' is selected -->
                <div class="row" id="lainlainInputRow" style="display:none;">
                    <div class="form-group col-md-12">
                        <label for="lainlainJenisTaman" class="col-md-12 control-label">Sila Nyatakan Jenis Taman</label>
                        <div class="col-md-12">
                            <input name="lainlainJenisTaman" class="form-control" type="text" id="lainlainJenisTaman" maxlength="50">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="keluasan_taman" class="col-md-12 control-label">Keluasan</label>
                        <div class="col-md-12">
                            {{ Form::text('keluasan_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}
                        </div>
                    </div>
                    <div class="form-group required col-md-2">
                        <label for="keluasan_unit" class="col-md-12 control-label">&nbsp;</label>
                        <div class="col-md-12">
                        {!! Form::select('keluasan_unit', [
                            'ekar' => 'Ekar',
                            'm2' => 'm²',
                            'hektar' => 'Hektar'
                        ], isset($ePALM->keluasan_unit) ? $ePALM->keluasan_unit : '', ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="panjang_taman" class="col-md-12 control-label">Panjang</label>
                        <div class="col-md-12">
                            {{ Form::text('panjang_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}
                        </div>
                    </div>
                    <div class="form-group required col-md-2">
                        <label for="unit_panjang" class="col-md-12 control-label">&nbsp;</label>
                        <div class="col-md-12">
                        {{ Form::select('unit_panjang', ['meter' => 'Meter', 'kilometer' => 'Kilometer'], null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group required col-md-6">
                        <label for="hakmilik_tanah_taman" class="col-md-12 control-label">Hakmilik Tanah</label>
                        <div class="col-md-12">
                            {{ Form::text('hakmilik_tanah_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-6">
                        <label for="status_tanah_taman" class="col-md-12 control-label">Status Tanah</label>
                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::text('status_tanah_taman', 'Proses Perwartaan', ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::date('tarikhWarta_tanah_taman', isset($ePALM->tarikhWarta_tanah_taman) ? $ePALM->tarikhWarta_tanah_taman : '', ['class' => 'form-control d-inline-block ms-2', 'id' => 'tarikhWarta_tanah_taman']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Fasiliti -->
                <style>
                    .parks {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 20px;
                        justify-content: center;
                    }

                    .facility {
                        display: flex;
                        align-items: center; /* Align the checkbox and label */
                        cursor: pointer;
                    }

                    /* Adjust checkbox and label layout */
                    .facility input[type="checkbox"] {
                        margin-right: 10px; /* Space between checkbox and label */
                        vertical-align: middle; /* Align checkbox with label */
                    }

                    /* Ensuring uniform icon size */
                    .parks i {
                        font-size: 36px; /* Uniform size for all icons */
                        transition: transform 0.3s ease, color 0.3s ease;
                    }

                    .parks input[type="checkbox"] {
                        display: inline-block;
                        margin-right: 10px; /* Space between toggle button and icon */
                    }

                    /* Customizing the background color when active (checked) */
                    .parks input[type="checkbox"]:checked + .bg {
                        background-color: green;
                        border-radius: 5px;
                    }

                    /* Changing the icon color to white when active (checked) */
                    .parks input[type="checkbox"]:checked + .bg i {
                        color: white;
                    }

                    /* Styling for the facility label */
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
                        background-color:rgb(174, 169, 169);
                        border-radius: 5px;
                        transition: background-color 0.3s ease;
                    }

                    .parks input[type="checkbox"]:hover + .bg i {
                        transform: scale(1.1); /* Slightly enlarge icon on hover */
                    }

                    /* Tooltip styling */
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
                        width: 20px; /* Set width of the box */
                        height: 20px; /* Set height of the box */
                        display: flex; /* Use flexbox to center the icon */
                        justify-content: center; /* Horizontally center the icon */
                        align-items: center; /* Vertically center the icon */
                        background-color: rgba(240, 240, 240, 0); /* Optional: Set a background color */
                        border: 0px solid #ccc; /* Optional: Add border for visibility */
                    }

                    .icon-container i {
                        font-size: 20px; /* Adjust icon size to fit inside the box */
                    }

                </style>


                <div class="form-group required col-md-12">
                    <label for="park_facilities" class="col-md-12 control-label">Fasiliti</label>
                    @php
                        if(isset($ePALM->fasiliti)){
                            $fasilitiData = ($ePALM->fasiliti);
                            $check1 = isset($fasilitiData['cctv']) && $fasilitiData['cctv'] > 0 ? 'checked' : '';
                            $check2 = isset($fasilitiData['wifi']) && $fasilitiData['wifi'] > 0 ? 'checked' : '';
                            $check3 = isset($fasilitiData['cycling']) && $fasilitiData['cycling'] > 0 ? 'checked' : '';
                            $check4 = isset($fasilitiData['food']) && $fasilitiData['food'] > 0 ? 'checked' : '';
                            $check5 = isset($fasilitiData['oku']) && $fasilitiData['oku'] > 0 ? 'checked' : '';
                            $check6 = isset($fasilitiData['toilet']) && $fasilitiData['toilet'] > 0 ? 'checked' : '';
                            $check7 = isset($fasilitiData['food2']) && $fasilitiData['food2'] > 0 ? 'checked' : '';
                            $check8 = isset($fasilitiData['oku2']) && $fasilitiData['oku2'] > 0 ? 'checked' : '';
                            $check9 = isset($fasilitiData['toilet2']) && $fasilitiData['toilet2'] > 0 ? 'checked' : '';
                            //dd($fasilitiData['cctv']);
                        }else{
                            $check1 = 0; 
                            $check2 = 0; 
                            $check3 = 0; 
                            $check4 = 0; 
                            $check5 = 0; 
                            $check6 = 0; 
                            $check7 = 0; 
                            $check8 = 0; 
                            $check9 = 0; 
                        }
                    @endphp
                    <div class="col-md-12">
                        <div class="col-xs-12">
                            <div class="parks">
                                <div class="col-md-3">
                                    <!-- CCTV -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[cctv]" id="cctv" {{$check1}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-video" data-toggle="tooltip" title="CCTV"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">CCTV</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- WiFi -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[wifi]" id="wifi" {{$check2}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-wifi" data-toggle="tooltip" title="WiFi"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">WiFi</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Kemudahan Berbasikal -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[cycling]" id="cycling" {{$check3}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-bicycle" data-toggle="tooltip" title="Kemudahan Berbasikal"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Kemudahan Berbasikal</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Gerai Makan -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[food]" id="food" {{$check4}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-utensils" data-toggle="tooltip" title="Gerai Makan"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Gerai Makan</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Kemudahan OKU -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[oku]" id="oku" {{$check5}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-wheelchair" data-toggle="tooltip" title="Kemudahan OKU"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Kemudahan OKU</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Tandas Awam -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[toilet]" id="toilet" {{$check6}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-toilet" data-toggle="tooltip" title="Tandas Awam"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Tandas Awam</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Gerai Makan -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[food2]" id="food2" {{$check7}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-utensils" data-toggle="tooltip" title="Gerai Makan"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Gerai Makan</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Kemudahan OKU -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[oku2]" id="oku2" {{$check8}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-wheelchair" data-toggle="tooltip" title="Kemudahan OKU"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Kemudahan OKU</span>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <!-- Tandas Awam -->
                                    <label class="facility">
                                        <input type="checkbox" value="1" name="fasiliti[toilet2]" id="toilet2" {{$check9}}>
                                        <span class="parks bg">
                                            <div class="icon-container">
                                                <i class="fas fa-toilet" data-toggle="tooltip" title="Tandas Awam"></i>
                                            </div>
                                        </span>
                                        <span class="facility-label">Tandas Awam</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-6">
                    <label for="alamat1_taman" class="col-md-4 control-label">Alamat 1</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->alamat1_taman) ? $ePALM->alamat1_taman : ''}}" name="alamat1_taman" class="form-control" maxlength="50" type="text" id="alamat1_taman" required="required">
                    </div>
                </div>

                <div class="form-group required col-md-6">
                    <label for="alamat2_taman" class="col-md-4 control-label">Alamat 2</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->alamat2_taman) ? $ePALM->alamat2_taman : ''}}" name="alamat2_taman" class="form-control" maxlength="50" type="text" id="alamat2_taman">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-8">
                    <label for="alamat3_taman" class="col-md-12 control-label">Alamat 3</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->alamat3_taman) ? $ePALM->alamat3_taman : ''}}" name="alamat3_taman" class="form-control" maxlength="50" type="text" id="alamat3_taman">
                    </div>
                </div>

                <div class="form-group required col-md-4">
                    <label for="poskod_taman" class="col-md-4 control-label">Poskod</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->poskod_taman) ? $ePALM->poskod_taman : ''}}" name="poskod_taman" class="form-control" type="char" id="poskod_taman" required="required">
                    </div>
                </div>
            </div>
            <div class="inertClass">
                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="negeri_taman" class="col-md-12 control-label">Negeri</label>
                        <div class="col-md-12">
                            <!-- {{ Form::select('negeri', ['1' => 'JOHOR'], '1', ['class' => 'form-control', 'id' => 'negeri']) }} -->
                            {{ Form::select('negeri_taman', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="daerah_taman" class="col-md-12 control-label">Daerah</label>
                        <div class="col-md-12">
                            {{ Form::select('daerah_taman', [], null, ['class' => 'form-control', 'id' => 'daerah']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="mukim_taman" class="col-md-12 control-label">Mukim</label>
                        <div class="col-md-12">
                            {{ Form::select('mukim_taman', [], null, ['class' => 'form-control', 'id' => 'mukim']) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="parlimen_taman" class="col-md-12 control-label">Parlimen</label>
                        <div class="col-md-12">
                            {{ Form::select('parlimen_taman', [], null, ['class' => 'form-control', 'id' => 'parlimen']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="dun_taman" class="col-md-12 control-label">Dun</label>
                        <div class="col-md-12">
                            {{ Form::select('dun_taman', [], null, ['class' => 'form-control', 'id' => 'dun']) }}
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Fetch Negeri data on page load (AJAX call)
                        $.ajax({
                            url: '/get-negeri', // API endpoint to get negeri data
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                // Populate the Negeri dropdown with the data
                                $('#negeri').empty(); // Clear current options
                                $('#negeri').append('<option value="">Pilih Negeri</option>');
                                $('#daerah').append('<option value="">Pilih Daerah</option>');
                                $('#mukim').append('<option value="">Pilih Mukim</option>');
                                $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                $('#dun').append('<option value="">Pilih Dun</option>');

                                $.each(data, function(key, value) {
                                    // Add each Negeri to the dropdown
                                    $('#negeri').append('<option value="' + value.kod_negeri + '">' + value.nama_negeri + '</option>');
                                });
                                var negeriSelected = "{{ isset($ePALM->negeri_taman) ? $ePALM->negeri_taman : '' }}"; // Assuming you have $ePALM->negeri
                                if (negeriSelected) {
                                    $('#negeri').val(negeriSelected).trigger('change');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching Negeri data: ", error);
                            }
                        });

                        // When the 'Negeri' dropdown changes
                        $('#negeri').change(function() {
                            var negeriId = $(this).val();
                            if (negeriId) {
                                // Make an AJAX request to get the 'Daerah' based on the selected 'Negeri'
                                $('#daerah').empty();
                                $('#daerah').append('<option value="">Pilih Daerah</option>');
                                $('#mukim').empty();
                                $('#mukim').append('<option value="">Pilih Mukim</option>');
                                $('#parlimen').empty();
                                $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                $('#dun').empty();
                                $('#dun').append('<option value="">Pilih Dun</option>');
                                $.ajax({
                                    url: '/get-daerah/' + negeriId, // Your existing route to fetch daerah
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Populate the 'Daerah' dropdown with the response data
                                        if (data.length<2) {
                                            // if (data[0].nama_daerah == 'TIADA DAERAH') {
                                            //     $('#daerah').append('<option value="000" selected disabled>TIADA DAERAH</option>');
                                            // }else{
                                                $('#daerah').append('<option value="' + data[0].kod_daerah + '" selected>' + data[0].nama_daerah + '</option>');
                                            // }
                                            $('#daerah').trigger('change');
                                        }else{
                                            $.each(data, function(key, value) {
                                                $('#daerah').append('<option value="' + value.kod_daerah + '">' + value.nama_daerah + '</option>');
                                                // Check if the name of the daerah is 'TIADA DAERAH'
                                                // if (value.nama_daerah == 'TIADA DAERAH') {
                                                //     // Set this option as selected
                                                //     $('#daerah option[value="' + value.kod_daerah + '"]').prop('selected', true);
                                                //     $('#daerah').trigger('change');
                                                // }
                                            });
                                        }
                                        var daerahSelected = "{{ isset($ePALM->daerah_taman) ? $ePALM->daerah_taman : '' }}"; // Assuming you have $ePALM->daerah
                                        if (daerahSelected) {
                                            $('#daerah').val(daerahSelected).trigger('change');
                                        }
                                    }
                                });

                                // Make an AJAX request to get the 'parlimen' based on the selected 'Negeri'
                                $.ajax({
                                    url: '/get-parlimen/' + negeriId, // Your existing route to fetch parlimen
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Populate the 'parlimen' dropdown with the response data
                                        $('#parlimen').empty();
                                        $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                        $.each(data, function(key, value) {
                                            $('#parlimen').append('<option value="' + value.kod_parlimen + '">' + value.nama_parlimen + '</option>');
                                        });
                                        var parlimenSelected = "{{ isset($ePALM->parlimen_taman) ? $ePALM->parlimen_taman : '' }}"; // Assuming you have $ePALM->parlimen
                                        if (parlimenSelected) {
                                            $('#parlimen').val(parlimenSelected).trigger('change');
                                        }
                                    }
                                });
                            } else {
                                // Reset all child dropdowns if Negeri is cleared
                                $('#daerah').empty();
                                $('#daerah').append('<option value="">Pilih Daerah</option>');
                                $('#mukim').empty();
                                $('#mukim').append('<option value="">Pilih Mukim</option>');
                                $('#parlimen').empty();
                                $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                $('#dun').empty();
                                $('#dun').append('<option value="">Pilih Dun</option>');
                            }
                        });

                        // When the 'Daerah' dropdown changes
                        $('#daerah').change(function() {
                            var daerahId = $(this).val();
                            var negeriId = $('#negeri').val(); // Get the selected negeri ID
                            if (daerahId && negeriId) {
                                // Make an AJAX request to get the 'Mukim' based on the selected 'Daerah' and 'Negeri'
                                $.ajax({
                                    url: '/get-mukim/' + negeriId + '/' + daerahId, // Updated URL with both negeriId and daerahId
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Populate the 'Mukim' dropdown with the response data
                                        $('#mukim').empty();
                                        $('#mukim').append('<option value="">Pilih Mukim</option>');
                                        if (data.length<2) {
                                            $('#mukim').append('<option value="' + data[0].kod_mukim + '" selected>' + data[0].nama_mukim + '</option>');
                                        }else{
                                            $.each(data, function(key, value) {
                                                $('#mukim').append('<option value="' + value.kod_mukim + '">' + value.nama_mukim + '</option>');
                                            });
                                        }
                                        var mukimSelected = "{{ isset($ePALM->mukim_taman) ? $ePALM->mukim_taman : '' }}"; // Assuming you have $ePALM->mukim
                                        if (mukimSelected) {
                                            $('#mukim').val(mukimSelected).trigger('change');
                                        }
                                    }
                                });
                            } else {
                                $('#mukim').empty();
                                $('#mukim').append('<option value="">Pilih Mukim</option>');
                            }
                        });

                        // When the 'parlimen' dropdown changes
                        $('#parlimen').change(function() {
                            var parlimenId = $(this).val();
                            if (parlimenId) {
                                // Make an AJAX request to get the 'parlimen' based on the selected 'parlimen'
                                $.ajax({
                                    url: '/get-dun/' + parlimenId, // Your existing route to fetch parlimen
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        // Populate the 'parlimen' dropdown with the response data
                                        $('#dun').empty();
                                        $('#dun').append('<option value="">Pilih Dun</option>');
                                        if (data.length<1) {
                                            $('#dun').append('<option value="000" selected disabled>TIADA DUN</option>');
                                        }else{
                                            $.each(data, function(key, value) {
                                                $('#dun').append('<option value="' + value.kod_dun + '">' + value.nama_dun + '</option>');
                                            });
                                        }
                                        var dunSelected = "{{ isset($ePALM->dun_taman) ? $ePALM->dun_taman : '' }}"; // Assuming you have $ePALM->dun
                                        if (dunSelected) {
                                            $('#dun').val(dunSelected).trigger('change');
                                        }
                                    }
                                });
                            } else {
                                $('#dun').empty();
                                $('#dun').append('<option value="">Pilih Dun</option>');
                            }
                        });

                    });
                </script>
            </div>
            <div class="row">
                <div class="form-group required col-md-3">
                    <label for="lat" class="col-md-12 control-label">Koordinat X</label>
                    <div class="col-md-12">
                        {{ Form::text('lat', null, ['class' => 'form-control', 'placeholder' => 'Masukkan koordinat X']) }}
                    </div>
                </div>
                <div class="form-group required col-md-3">
                    <label for="lng" class="col-md-12 control-label">Koordinat Y</label>
                    <div class="col-md-12">
                        {{ Form::text('lng', null, ['class' => 'form-control', 'placeholder' => 'Masukkan koordinat Y']) }}
                    </div>
                </div>
                <div class="form-group required col-md-3">
                    <label for="waktuMula_taman" class="col-md-12 control-label">Waktu Mula Operasi</label>
                    <div class="col-md-12">
                        {{ Form::time('waktuMula_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan waktu mula operasi']) }}
                    </div>
                </div>
                <div class="form-group required col-md-3">
                    <label for="waktuTamat_taman" class="col-md-12 control-label">Waktu Tamat Operasi</label>
                    <div class="col-md-12">
                        {{ Form::time('waktuTamat_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan waktu tamat operasi']) }}
                    </div>
                </div>
                    @php
                        if(isset($ePALM->mediaSosial_taman)){
                            $mediaSosial_tamanData = json_decode($ePALM->mediaSosial_taman, true);
                            $media1 = isset($mediaSosial_tamanData['Telefon']) ? $mediaSosial_tamanData['Telefon'] : '';
                            $media2 = isset($mediaSosial_tamanData['Emel']) ? $mediaSosial_tamanData['Emel'] : '';
                            $media3 = isset($mediaSosial_tamanData['Web']) ? $mediaSosial_tamanData['Web'] : '';
                            $media4 = isset($mediaSosial_tamanData['Facebook']) ? $mediaSosial_tamanData['Facebook'] : '';
                            $media5 = isset($mediaSosial_tamanData['Instagram']) ? $mediaSosial_tamanData['Instagram'] : '';
                            $media6 = isset($mediaSosial_tamanData['LinkedIn']) ? $mediaSosial_tamanData['LinkedIn'] : '';
                            $media7 = isset($mediaSosial_tamanData['Twitter']) ? $mediaSosial_tamanData['Twitter'] : '';
                            $media8 = isset($mediaSosial_tamanData['TikTok']) ? $mediaSosial_tamanData['TikTok'] : '';
                            //dd($mediaSosial_tamanData);
                        }else{
                            $media1 = 0; 
                            $media2 = 0; 
                            $media3 = 0; 
                            $media4 = 0; 
                            $media5 = 0; 
                            $media6 = 0; 
                            $media7 = 0; 
                            $media8 = 0; 
                            $media9 = 0; 
                        }
                    @endphp
                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Telefon</label>
                    <div class="col-md-12">
                        <input value="{{$media1}}" name="mediaSosial_taman[Telefon]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Emel</label>
                    <div class="col-md-12">
                        <input value="{{$media2}}" name="mediaSosial_taman[Emel]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Laman Web</label>
                    <div class="col-md-12">
                        <input value="{{$media3}}" name="mediaSosial_taman[Web]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Facebook</label>
                    <div class="col-md-12">
                        <input value="{{$media4}}" name="mediaSosial_taman[Facebook]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Instagram</label>
                    <div class="col-md-12">
                        <input value="{{$media5}}" name="mediaSosial_taman[Instagram]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">LinkedIn</label>
                    <div class="col-md-12">
                        <input value="{{$media6}}" name="mediaSosial_taman[LinkedIn]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Twitter (X)</label>
                    <div class="col-md-12">
                        <input value="{{$media7}}" name="mediaSosial_taman[Twitter]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">TikTok</label>
                    <div class="col-md-12">
                        <input value="{{$media8}}" name="mediaSosial_taman[TikTok]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]" >
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="form-group required">
                <label for="keterangan_taman" class="col-md-12 control-label">Keterangan Taman</label>
                <div class="col-md-12">
                    <textarea name="keterangan_taman" class="form-control" maxlength="50" rows="5" id="keterangan_taman" required="required">{{ isset($ePALM->keterangan_taman) ? $ePALM->keterangan_taman : '' }}</textarea>
                </div>
            </div>

            
            <div class="row">
                <div class="form-group required col-md-9">
                    <label for="fail_konsep" class="col-md-12 control-label">Konsep Rekabentuk</label>
                    <div class="col-md-12 showButton">
                        @if(!isset($ePALM->fail_konsep))
                            {{ Form::file('fail_konsep', ['class' => 'form-control d-inline-block ms-2', 'multiple' => false]) }}
                        @else
                            <a href="{{ asset('storage/uploads/eLAPS/JLN202514/1740468990941_WhatsApp Image 2024-08-23 at 09.38.28_e35d88e2.jpg') }}" target="_blank">Download File</a>
                        @endif
                    </div>
                </div>
                <div class="form-group required col-md-3">
                    <div class="inertClass">
                        <label for="tarikh_siapBina_taman" class="col-md-12 control-label">Tarikh Siap Bina</label>
                        <div class="col-md-12">
                            {{ Form::date('tarikh_siapBina_taman', isset($ePALM->tarikh_siapBina_taman) ? $ePALM->tarikh_siapBina_taman : '', ['class' => 'form-control d-inline-block ms-2', 'id' => 'tarikh_siapBina_taman']) }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-12">
                    <label for="konsep_rekabentuk" class="col-md-12 control-label">Gambar Taman</label>
                    @php
                        if(isset($ePALM->gambar_taman)){
                            $folderName = str_replace(' ', '_', $ePALM->nama_taman);
                            $gambar_tamanData = json_decode($ePALM->gambar_taman, true);

                            $Xgambar_input_modal_1 = isset($gambar_tamanData['Xgambar_input_modal_1']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_1'] : null;
                            $Xgambar_input_modal_2 = isset($gambar_tamanData['Xgambar_input_modal_2']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_2'] : null;
                            $Xgambar_input_modal_3 = isset($gambar_tamanData['Xgambar_input_modal_3']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_3'] : null;
                            $Xgambar_input_modal_4 = isset($gambar_tamanData['Xgambar_input_modal_4']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_4'] : null;
                            //dd($gambar_tamanData);
                        }else{
                            $Xgambar_input_modal_1 = null;
                            $Xgambar_input_modal_2 = null;
                            $Xgambar_input_modal_3 = null;
                            $Xgambar_input_modal_4 = null;
                        }
                    @endphp
                    <div class="col-md-12">
                        <style>
                            /* Container for the grid with files and previews */
                            .grid-container {
                                display: grid;
                                grid-template-columns: 1fr 1fr; /* 2 equal-width columns */
                                gap: 10px; /* Space between grid items */
                                width: 500px;
                                max-width: 600px;  /* Limit max width for the grid */
                                margin: 0 auto; /* Centers the grid container horizontally */
                                height: auto; /* Allow the height to adjust based on content */
                            }

                            /* Grid item styling */
                            .grid-item {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: space-between;
                                text-align: center;
                                border: 1px solid #ddd;
                                background-color: lightgray;
                                padding: 10px;
                                box-sizing: border-box;
                                overflow: hidden; /* Prevent overflowing content */
                            }

                            /* Image preview container */
                            .image-preview-container {
                            display: grid;
                            place-items: center; /* Center both horizontally and vertically */
                            width: 100%;
                            height: 100%; /* Optional, adjust as needed */
                            overflow-y: auto;
                            }

                            .image-preview-container img {
                            width: 200px; /* Adjust the width as needed */
                            height: 200px; /* Adjust the height as needed */
                            object-fit: cover;
                            border-radius: 5px;
                            border: 0px solid #ddd;
                            padding: 2px;
                            }

                            /* File input button styling */
                            .form-control-file {
                                padding: 5px;
                                font-size: 12px;
                                width: 100%;
                                height: 30px;
                                border-radius: 4px;
                                background-color: #f7f7f7;
                                border: 1px solid #ccc;
                                cursor: pointer;
                            }
                        </style>
                        <div class="grid-container">
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="Xgambar_input_modal_1" name="Xgambar_input_modal_1" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer1" class="image-preview-container">
                                    <img src="{{ isset($Xgambar_input_modal_1) ? asset('storage/uploads/ePALM/'.$Xgambar_input_modal_1) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </div>
                            </div>
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="Xgambar_input_modal_2" name="Xgambar_input_modal_2" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer2" class="image-preview-container">
                                    <img src="{{ isset($Xgambar_input_modal_2) ? asset('storage/uploads/ePALM/'.$Xgambar_input_modal_2) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </div>
                            </div>

                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="Xgambar_input_modal_3" name="Xgambar_input_modal_3" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer3" class="image-preview-container">
                                    <img src="{{ isset($Xgambar_input_modal_3) ? asset('storage/uploads/ePALM/'.$Xgambar_input_modal_3) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </div>
                            </div>

                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="Xgambar_input_modal_4" name="Xgambar_input_modal_4" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer4" class="image-preview-container">
                                    <img src="{{ isset($Xgambar_input_modal_4) ? asset('storage/uploads/ePALM/'.$Xgambar_input_modal_4) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    const fileInputs = [
                        { inputId: 'Xgambar_input_modal_1', previewContainerId: 'XimagePreviewContainer1' },
                        { inputId: 'Xgambar_input_modal_2', previewContainerId: 'XimagePreviewContainer2' },
                        { inputId: 'Xgambar_input_modal_3', previewContainerId: 'XimagePreviewContainer3' },
                        { inputId: 'Xgambar_input_modal_4', previewContainerId: 'XimagePreviewContainer4' }
                    ];

                    // Function to preview image
                    function previewImage(inputElement, previewContainer) {
                        const file = inputElement.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewContainer.querySelector('img').src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    }

                    // Loop through each file input and set up event listeners
                    fileInputs.forEach(({ inputId, previewContainerId }) => {
                        const inputElement = document.getElementById(inputId);
                        const previewContainer = document.getElementById(previewContainerId);

                        // Trigger file input when preview container is clicked
                        previewContainer.addEventListener('click', function() {
                            inputElement.click();
                        });

                        // Handle file input change event
                        inputElement.addEventListener('change', function(event) {
                            previewImage(event.target, previewContainer);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
   
    @if(isset($ePALM->kategori_taman) && ($ePALM->kategori_taman == "Landskap Perbandaran"))
        <div class="row">
            <div class="col-lg col-separator">
                <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-12">
                        <h4 class="d-flex align-items-center justify-content-between">
                            Komponen Landskap (Landskap Perbandaran) {{ $capitalizedSegment ?? '' }}
                            <button type="button" class="btn btn-primary btn-sm showButton" id="addProductBtn">
                                Tambah Komponen
                            </button>
                        </h4>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="table-responsive">
                            <table id="projek_table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <style>
                                        #projek_table th, #projek_table td {
                                            padding: 2px 5px; /* Minimal padding for smaller cells */
                                            text-align: center; /* Center text horizontally */
                                            height: auto; /* Let the height adjust based on content */
                                        }

                                        #projek_table td input {
                                            padding: 3px 5px; /* Small padding inside input fields */
                                            height: 25px; /* Small height for input fields */
                                            font-size: 12px; /* Smaller font size for compact input fields */
                                        }

                                        #projek_table th {
                                            padding: 3px 5px; /* Slightly more padding for headers */
                                            font-size: 12px; /* Smaller font size for headers */
                                        }
                                    </style>
                                    <tr>
                                        <th class="w-1">Bil</th>
                                        <th class="w-10">Nama Komponen</th>
                                        <th class="w-10">Keterangan</th>
                                        <th class="w-15">Gambar</th>
                                        <th class="w-1">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody id="projek_container">
                                    <tr id="dummy_row">
                                        <td colspan="6" class="text-center">Tiada Maklumat</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <script>
                    function updateBilNumbers() {
                        const rows = document.querySelectorAll('#projek_container tr');
                        rows.forEach((row, index) => {
                            const bilCell = row.querySelector('td:first-child');
                            bilCell.textContent = index + 1;
                        });
                    }

                    function fetchUpdatedData() {
                        document.getElementById('projek_container').innerHTML = '';
                        let id_taman = "{{ $ePALM->id_taman }}";
                        $.ajax({
                            url: '/fetchComponents/'+id_taman,  // Define this route in your controller to fetch updated components
                            method: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    // Populate the container with the new rows
                                    const projekContainer = document.getElementById('projek_container');
                                    response.data.forEach((component, index) => {
                                        let newRow = document.createElement('tr');
                                        newRow.innerHTML = `
                                            <td>${index + 1}</td>
                                            <td>${component.nama_taman}</td>
                                            <td>${component.keterangan_taman}</td>
                                            <td>
                                                ${component.images.map(url => `<img src="${url}" alt="image" style="width: 50px; height: 50px; object-fit: cover; margin: 2px;">`).join('')}
                                            </td>
                                            <td style="padding: 0; vertical-align: middle; text-align: center;">
                                                <button 
                                                    type="button" data-row="row-${index + 1}" 
                                                    class="btn btn-danger btn-sm" 
                                                    data-id_taman="${component.id_taman}"
                                                    data-toggle="modal" 
                                                    data-target="#deleteKomponenModal" 
                                                    style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                                </button>
                                                <button 
                                                    type="button" data-row="row-${index + 1}" 
                                                    class="btn btn-warning btn-sm" 
                                                    data-images="${component.images}"
                                                    data-nama_taman="${component.nama_taman}"
                                                    data-keterangan_taman="${component.keterangan_taman}"
                                                    data-id_taman="${component.id_taman}"
                                                    data-gambar_taman='${component.gambar_taman}'
                                                    data-toggle="modal" 
                                                    data-target="#updateModal" 
                                                    style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-pencil-alt" style="font-size: 0.6rem;"></i>
                                                </button>
                                            </td>
                                        `;
                                        projekContainer.appendChild(newRow);
                                    });
                                    updateBilNumbers();
                                } else {
                                    alert('Failed to fetch updated components.');
                                }
                            },
                            error: function(xhr, status, error) {
                                alert('An error occurred while fetching updated data: ' + error);
                            }
                        });
                    }
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let bilCount = 1;
                        let currentRow = null; // To store the current row when selecting images

                        // Add new product row when "Tambah Produk" is clicked
                        document.getElementById('addProductBtn').addEventListener('click', function() {
                            // Clear modal input fields
                            // document.getElementById('productForm').reset();
                            document.getElementById('imagePreviewContainer1').innerHTML = '';
                            document.getElementById('imagePreviewContainer2').innerHTML = '';
                            document.getElementById('imagePreviewContainer3').innerHTML = '';
                            document.getElementById('imagePreviewContainer4').innerHTML = '';

                            // Show the modal for adding a new product
                            $('#productModal').modal('show');
                            currentRow = null; // Reset currentRow for a new product
                        });

                        // Handle the "Simpan Produk" button click to save the product
                        // document.getElementById('saveProductBtn').addEventListener('click', function() {
                        //     $('#saveProductBtn').prop('disabled', true);

                        //     // Gather form data
                        //     var formData = new FormData(document.getElementById('ePALMForm'));

                        //     // Perform AJAX call
                        //     $.ajax({
                        //         url: '{{ route("pengurusan.ePALM.store") }}', // The route to handle the form submission
                        //         method: 'POST',  // The HTTP method for the request
                        //         data: formData, // Send the form data
                        //         contentType: false, // Do not set content type (multipart/form-data)
                        //         processData: false, // Do not process data as a query string
                        //         success: function(response) {
                        //             // Handle the success case here
                        //             // You can show a success message or redirect as needed
                        //             if (response.success) {
                        //                 alert('Data saved successfully!');
                        //                 // Optionally, you can reset the form or redirect to another page
                        //                 $('#ePALMForm')[0].reset();
                        //             } else {
                        //                 alert('Something went wrong. Please try again.');
                        //             }
                        //         },
                        //         error: function(xhr, status, error) {
                        //             // Handle any errors during the AJAX request
                        //             alert('An error occurred: ' + error);
                        //         },
                        //         complete: function() {
                        //             // Re-enable the button after the AJAX request completes
                        //             $('#saveProductBtn').prop('disabled', false);
                        //         }
                        //     });
                        //     // Get the product details from the form
                        //     // const productName = document.getElementById('productName').value;
                        //     // const productDescription = document.getElementById('productDescription').value;

                        //     // // Get the images
                        //     // const images = [];
                        //     // for (let i = 1; i <= 4; i++) {
                        //     //     const fileInput = document.getElementById('gambar_input_modal_' + i);
                        //     //     if (fileInput.files.length > 0) {
                        //     //         images.push(fileInput.files[0]);
                        //     //     }
                        //     // }

                        //     // if (/* productName && productDescription && */ images.length > 0) {
                        //     //     const newRow = document.createElement('tr');
                        //     //     newRow.innerHTML = `
                        //     //         <td>${bilCount}</td>
                        //     //         <td>${bilCount}</td>
                        //     //         <td>${bilCount}</td>
                        //     //         <td>
                        //     //             ${images.map(image => `<img src="${URL.createObjectURL(image)}" alt="image" style="width: 50px; height: 50px; object-fit: cover; margin: 2px;">`).join('')}
                        //     //         </td>
                        //     //         <td style="padding: 0; vertical-align: middle; text-align: center;">
                        //     //             <button type="button" class="btn btn-danger btn-sm remove_field" data-row="row-${bilCount}" 
                        //     //                     style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                        //     //                 <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                        //     //             </button>
                        //     //         </td>
                        //     //     `;
                        //     //     document.getElementById('projek_container').appendChild(newRow);
                        //     //     bilCount++;

                        //     //     // Close the modal after saving
                        //     //     $('#productModal').modal('hide');

                        //     //     // Hide the dummy row if it's there
                        //     //     var dummyRow = document.getElementById('dummy_row');
                        //     //     if (dummyRow) {
                        //     //         dummyRow.remove();
                        //     //     }

                        //     //     updateBilNumbers();
                        //     // } else {
                        //     //     alert('Sila isi semua maklumat produk dan pilih gambar.');
                        //     // }
                        // });

                        document.getElementById('saveProductBtn').addEventListener('click', function() {
                            $('#saveProductBtn').prop('disabled', true);

                            // Gather form data
                            var formData = new FormData(document.getElementById('ePALMForm'));

                            // Perform AJAX call to save data
                            $.ajax({
                                url: '{{ route("pengurusan.ePALM.store") }}', // The route to handle the form submission
                                method: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.message);
                                        $('#ePALMForm')[0].reset();  // Optionally reset the form

                                        // Clear the existing rows in the container
                                        document.getElementById('projek_container').innerHTML = ''; // Or use remove() if needed

                                        // Fetch the latest data (latest ePALM components)
                                        fetchUpdatedData();
                                    } else {
                                        alert('Something went wrong. Please try again.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('An error occurred: ' + error);
                                },
                                complete: function() {
                                    $('#saveProductBtn').prop('disabled', false);
                                }
                            });
                        });

                        document.getElementById('updateProductBtn').addEventListener('click', function() {
                            $('#updateProductBtn').prop('disabled', true);

                            // Gather form data
                            var formData = new FormData(document.getElementById('updateKomponen'));

                            // Perform AJAX call to save data
                            $.ajax({
                                url: '{{ route("pengurusan.ePALM.store") }}', // The route to handle the form submission
                                method: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.message);
                                        $('#updateKomponen')[0].reset();  // Optionally reset the form

                                        // Clear the existing rows in the container
                                        document.getElementById('projek_container').innerHTML = ''; // Or use remove() if needed

                                        // Fetch the latest data (latest ePALM components)
                                        fetchUpdatedData();
                                    } else {
                                        alert('Something went wrong. Please try again.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('An error occurred: ' + error);
                                },
                                complete: function() {
                                    $('#updateProductBtn').prop('disabled', false);
                                }
                            });
                        });

                        document.getElementById('deleteKomponenBtn').addEventListener('click', function() {
                            $('#deleteKomponenBtn').prop('disabled', true);

                            // Gather form data
                            var formData = new FormData(document.getElementById('deleteKomponen'));

                            // Perform AJAX call to save data
                            $.ajax({
                                url: '{{ route("pengurusan.ePALM.store") }}', // The route to handle the form submission
                                method: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        alert(response.message);
                                        $('#deleteKomponen')[0].reset();  // Optionally reset the form

                                        // Clear the existing rows in the container
                                        document.getElementById('projek_container').innerHTML = ''; // Or use remove() if needed

                                        // Fetch the latest data (latest ePALM components)
                                        fetchUpdatedData();
                                    } else {
                                        alert('Something went wrong. Please try again.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('An error occurred: ' + error);
                                },
                                complete: function() {
                                    $('#deleteKomponenBtn').prop('disabled', false);
                                }
                            });
                        });

                        // Function to fetch the latest data from the server
                        // function fetchUpdatedData() {
                        //     $.ajax({
                        //         url: '/fetchComponents',  // Define this route in your controller to fetch updated components
                        //         method: 'GET',
                        //         success: function(response) {
                        //             if (response.success) {
                        //                 // Populate the container with the new rows
                        //                 const projekContainer = document.getElementById('projek_container');
                        //                 response.data.forEach((component, index) => {
                        //                     let newRow = document.createElement('tr');
                        //                     newRow.innerHTML = `
                        //                         <td>${index + 1}</td>
                        //                         <td>${component.is_komponen}</td>
                        //                         <td>${component.is_komponen}</td>
                        //                         <td>
                        //                             ${component.images.map(url => `<img src="${url}" alt="image" style="width: 50px; height: 50px; object-fit: cover; margin: 2px;">`).join('')}
                        //                         </td>
                        //                         <td style="padding: 0; vertical-align: middle; text-align: center;">
                        //                             <button type="button" class="btn btn-danger btn-sm remove_field" data-row="row-${index + 1}" 
                        //                                     style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                        //                                 <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                        //                             </button>
                        //                         </td>
                        //                     `;
                        //                     projekContainer.appendChild(newRow);
                        //                 });
                        //             } else {
                        //                 alert('Failed to fetch updated components.');
                        //             }
                        //         },
                        //         error: function(xhr, status, error) {
                        //             alert('An error occurred while fetching updated data: ' + error);
                        //         }
                        //     });
                        // }


                        // Remove a row when "Hapus" button is clicked
                        document.addEventListener('click', function(event) {
                            if (event.target.classList.contains('remove_field')) {
                                event.target.closest('tr').remove();
                                updateBilNumbers();
                            }
                        });

                        // Update Bil numbers after deletion
                        function updateBilNumbers() {
                            const rows = document.querySelectorAll('#projek_container tr');
                            rows.forEach((row, index) => {
                                const bilCell = row.querySelector('td:first-child');
                                bilCell.textContent = index + 1;
                            });
                        }

                        // Function to handle image preview
                        function previewImage(input, previewContainer) {
                            const files = input.files;
                            previewContainer.innerHTML = '';
                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    const imgElement = document.createElement('img');
                                    imgElement.src = e.target.result;
                                    previewContainer.appendChild(imgElement);
                                };
                                reader.readAsDataURL(file);
                            }
                        }

                        // Add event listeners for image inputs
                        document.getElementById('gambar_input_modal_1').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer1'));
                        });
                        document.getElementById('gambar_input_modal_2').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer2'));
                        });
                        document.getElementById('gambar_input_modal_3').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer3'));
                        });
                        document.getElementById('gambar_input_modal_4').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer4'));
                        });
                    });
                </script>
                @php
                    function getImagePaths($ePALM) {
                        $imagePaths = [];

                        // Loop over each komponen and generate image paths
                        foreach ($ePALM->komponen as $komponen) {
                            if (isset($komponen->gambar_taman)) {
                                $folderName = str_replace(' ', '_', $ePALM->nama_taman);
                                $subfolderName = str_replace(' ', '_', $komponen->nama_taman);
                                $gambar_tamanData = json_decode($komponen->gambar_taman, true);

                                $gambar_input_modal_1 = isset($gambar_tamanData['gambar_input_modal_1']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_1'] : 'no-photos.png';
                                $gambar_input_modal_2 = isset($gambar_tamanData['gambar_input_modal_2']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_2'] : 'no-photos.png';
                                $gambar_input_modal_3 = isset($gambar_tamanData['gambar_input_modal_3']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_3'] : 'no-photos.png';
                                $gambar_input_modal_4 = isset($gambar_tamanData['gambar_input_modal_4']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_4'] : 'no-photos.png';

                                // Add to the array of image paths
                                $imagePaths[] = [
                                    'nama_taman' => $komponen->nama_taman,
                                    'keterangan_taman' => $komponen->keterangan_taman,
                                    'is_komponen' => $komponen->is_komponen,    
                                    'id_taman' => $komponen->id_taman,    
                                    'images' => [
                                        asset('storage/uploads/' . $gambar_input_modal_1),
                                        asset('storage/uploads/' . $gambar_input_modal_2),
                                        asset('storage/uploads/' . $gambar_input_modal_3),
                                        asset('storage/uploads/' . $gambar_input_modal_4)
                                    ],
                                    'gambar_taman' => $komponen->gambar_taman
                                ];
                            } else {
                                // If no gambar_taman data, add empty array for this komponen
                                $imagePaths[] = [
                                    'nama_taman' => null,
                                    'keterangan_taman' => null,
                                    'is_komponen' => null,    
                                    'id_taman' => null,    
                                    'images' => [
                                        asset('storage/uploads/no-photos.png'),
                                        asset('storage/uploads/no-photos.png'),
                                        asset('storage/uploads/no-photos.png'),
                                        asset('storage/uploads/no-photos.png')
                                    ],
                                    'gambar_taman' => null
                                ];
                            }
                        }

                        return $imagePaths;
                    }

                    $imagePaths = isset($ePALM->komponen) ? getImagePaths($ePALM) : null;
                    //dd(json_encode($imagePaths));
                @endphp

                <script>
                    // // Pass PHP variable to JavaScript
                    // const isKomponen = <?php echo isset($ePALM->komponen[0]->is_komponen) ? 'true' : 'false'; ?>;

                    // // Get the image URLs from the PHP function result
                    let imageURLs = <?php echo isset($ePALM->komponen) ? json_encode($imagePaths) : 'false'; ?>;

                    // // Check if the component exists and proceed to add the row for each komponen
                    if (imageURLs.length > 0) {
                        // let bilCount = 1;

                        // Remove any previous dummy row
                        document.getElementById('dummy_row')?.remove();

                        // Loop through each imageURLs set and create rows dynamically
                        // imageURLs.forEach(urlSet => {
                            createRow();
                            // bilCount++;
                        // });

                        // Optionally increment the bilCount (if required) and update row numbers
                        updateBilNumbers();
                    } else {
                        console.log('is_komponen is not set or no components found. No rows will be added.');
                    }
                    
                    function createRow(){
                        let bilCount = 1;
                        const projekContainer = document.getElementById('projek_container');
                        imageURLs.forEach((component, index) => {
                            
                            console.log((component.gambar_taman));
                            let newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                <td>${bilCount++}</td>
                                <td>${component.nama_taman}</td>
                                <td>${component.keterangan_taman}</td>
                                <td>
                                    ${component.images.map(url => `<img src="${url}" alt="${url}" style="width: 50px; height: 50px; object-fit: cover; margin: 2px;">`).join('')}
                                </td>
                                <td style="padding: 0; vertical-align: middle; text-align: center;">
                                    <button 
                                        type="button" data-row="row-${index + 1}" 
                                        class="btn btn-danger btn-sm" 
                                        data-id_taman="${component.id_taman}"
                                        data-toggle="modal" 
                                        data-target="#deleteKomponenModal" 
                                        style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                    </button>
                                    <button 
                                        type="button" data-row="row-${index + 1}" 
                                        class="btn btn-warning btn-sm" 
                                        data-images="${component.images}"
                                        data-nama_taman="${component.nama_taman}"
                                        data-keterangan_taman="${component.keterangan_taman}"
                                        data-id_taman="${component.id_taman}"
                                        data-gambar_taman='${component.gambar_taman}'
                                        data-toggle="modal" 
                                        data-target="#updateModal" 
                                        style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-pencil-alt" style="font-size: 0.6rem;"></i>
                                    </button>
                                </td>
                            `;
                            projekContainer.appendChild(newRow);
                        });
                    }
                </script>


            </div>
        </div>
    @endif
