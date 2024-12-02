<!-- Start Table -->
<table class="table table-bordered">
    <!-- First Row: Title (Tajuk Permohonan and Rujukan) -->
    <tr>
        <td>{{ Form::label('projectTitle', 'TAJUK PERMOHONAN PROJEK:', ['class' => 'col-form-label']) }}</td>
        <td colspan="3">{{ Form::text('projectTitle', null, ['class' => 'form-control']) }}</td>
        <td>{{ Form::label('referenceNumber', 'RUJUKAN PERMOHONAN:', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::text('referenceNumber', null, ['class' => 'form-control']) }}</td>
    </tr>

    <!-- Second Row: KATEGORI PROJEK -->
    <tr>
        <td colspan="6">{{ Form::label('projectCategory', 'KATEGORI PROJEK:', ['class' => 'col-form-label']) }}</td>
    </tr>
    <!-- Third Row: Rancangan Pembangunan (checkboxes with input fields) -->
    <tr>
        <td colspan="6">
            <!-- Start: Categories Checkboxes -->
            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Taman Awam', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_awam']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_taman_awam', 'Taman Awam', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Taman Botani', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_botani']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_taman_botani', 'Taman Botani', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Pemuliharaan Dan Penyelidikan Landskap', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_pemuliharaan']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_pemuliharaan', 'Pemuliharaan Dan Penyelidikan Landskap', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Landskap Perbandaran', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_landskap_perbandaran']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_landskap_perbandaran', 'Landskap Perbandaran', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Persekitaran Kehidupan', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_persekitaran']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_persekitaran', 'Persekitaran Kehidupan', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Penyelenggaraan Landskap', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_penyelenggaraan']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_penyelenggaraan', 'Penyelenggaraan Landskap', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Taman Persekutuan', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_persekutuan']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_taman_persekutuan', 'Taman Persekutuan', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Naik Taraf Taman Awam', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_naik_taraf']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_naik_taraf', 'Naik Taraf Taman Awam', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        {{ Form::checkbox('category[]', 'Lain-lain (sila nyatakan)', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'category_lain', 'onclick' => 'toggleLainLainText()']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('category_lain', 'Lain-lain (sila nyatakan)', ['class' => 'form-check-label bigger-label']) }}
                    </div>
                </div>
            </div>

            <!-- Textbox for "Lain-lain" option -->
            <div class="form-group row" id="lain_lain_details" style="display: none;">
                <div class="col-md-12">
                    {{ Form::label('lain_lain_text', 'Sila Nyatakan:', ['class' => 'col-form-label']) }}
                    {{ Form::text('lain_lain_text', null, ['class' => 'form-control', 'placeholder' => 'Masukkan maklumat lain-lain']) }}
                </div>
            </div>

            <!-- JavaScript to toggle the display of the "Lain-lain" text box -->
            <script>
                function toggleLainLainText() {
                    var checkBox = document.getElementById('category_lain');
                    var textBox = document.getElementById('lain_lain_details');
                    if (checkBox.checked) {
                        textBox.style.display = 'block';
                    } else {
                        textBox.style.display = 'none';
                    }
                }
            </script>

        </td>
    </tr>
    <!-- Third Row: Rancangan Pembangunan (checkbox and text box) -->
    <tr>
        <td colspan="6">{{ Form::label('rancangan_pembangunan', 'RANCANGAN PEMBANGUNAN:', ['class' => 'col-form-label']) }}</td>
    </tr>

    <!-- Third Row: Rancangan Pembangunan (checkboxes with input fields) -->
    <tr>
        <td colspan="6">
            <!-- Start: Categories Checkboxes -->
            <div class="form-group row">
                <!-- First Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Pelan Induk Landskap', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap', 'Pelan Induk Landskap : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::text('pelan_induk_landskap_details', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                    </div>
                </div>
                
                <!-- Second Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Struktur', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_2']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap_2', 'Rancangan Struktur : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::text('pelan_induk_landskap_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                    </div>
                </div>
            </div>

            <!-- Additional Rows: More checkboxes and inputs -->
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Tempatan', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_3']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap_3', 'Rancangan Tempatan : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::text('pelan_induk_landskap_details_3', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Kawasan Khas', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_4']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap_4', 'Rancangan Kawasan Khas : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::text('pelan_induk_landskap_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Lain-Lain Pelan Pembangunan (Nyatakan)', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_5']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap_5', 'Lain-Lain Pelan Pembangunan (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::text('pelan_induk_landskap_details_5', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                    </div>
                </div>
            </div>
        </td>
    </tr>


    <!-- Fourth Row: PERIHAL TAPAK -->
    <tr>
        <td colspan="6">{{ Form::label('tapak_details', 'PERIHAL TAPAK:', ['class' => 'col-form-label']) }}</td>
    </tr>

    <!-- Fifth Row: Keluasan and Panjang -->
    <tr>
        <td>{{ Form::label('keluasan', 'a.&nbsp;&nbsp;&nbsp;&nbsp;Keluasan (ekar / hektar) :', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::text('keluasan', null, ['class' => 'form-control']) }}</td>

        <!-- Dropdown for Unit (Keluasan) with fixed width -->
        <td>
            {{ Form::select('unit_keluasan', ['ekar' => 'Ekar', 'hektar' => 'Hektar'], null, ['class' => 'form-control', 'style' => 'width: 150px;']) }}
        </td>

        <td>{{ Form::label('panjang', 'Panjang (Jika berkaitan):', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::text('panjang', null, ['class' => 'form-control']) }}</td>

        <!-- Dropdown for Unit (Panjang) with fixed width -->
        <td>
            {{ Form::select('unit_panjang', ['meter' => 'Meter', 'kilometer' => 'Kilometer'], null, ['class' => 'form-control', 'style' => 'width: 150px;']) }}
        </td>
    </tr>


    <tr>
        <td>{{ Form::label('keluasan', 'b.&nbsp;&nbsp;&nbsp;&nbsp;Hakmilik Tanah :', ['class' => 'col-form-label']) }}</td>
        
        <!-- PBT Checkbox -->
        <td>
            <div class="form-check d-flex align-items-center">
                {{ Form::checkbox('rancangan_pembangunan[]', 'PBT', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_4']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('pelan_induk_landskap_4', 'PBT', ['class' => 'form-check-label bigger-label ms-2']) }}
                <!-- Textbox hidden using inline CSS -->
                {{ Form::text('pelan_induk_landskap_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;']) }}
            </div>
        </td>

        <!-- Negeri Checkbox -->
        <td>
            <div class="form-check d-flex align-items-center">
                {{ Form::checkbox('rancangan_pembangunan[]', 'Negeri', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_4']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('pelan_induk_landskap_4', 'Negeri', ['class' => 'form-check-label bigger-label ms-2']) }}
                <!-- Textbox hidden using inline CSS -->
                {{ Form::text('pelan_induk_landskap_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;']) }}
            </div>
        </td>

        <!-- Agensi lain (Nyatakan) -->
        <td colspan="3">
            <div class="form-check d-flex align-items-center">
                {{ Form::checkbox('rancangan_pembangunan[]', 'Agensi lain (Nyatakan)', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_5']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('pelan_induk_landskap_5', 'Agensi lain (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::text('pelan_induk_landskap_details_5', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
            </div>
        </td>
    </tr>

    <tr>
        <td colspan="6" style="font-size: 10px; height: 20px; padding-top: 5px; padding-bottom: 5px;">
            {{ Form::label('note1', '(WAJIB disertakan salinan Surat Hakmilik Tanah dan Pelan Akui (Certified Plan) untuk setiap lot yg terlibat)', ['class' => 'col-form-label']) }}
        </td>
    </tr>

    <tr>
        <td colspan="3">
            {{ Form::label('keluasan', 'c.&nbsp;&nbsp;&nbsp;&nbsp;Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap', ['class' => 'col-form-label']) }}
            {{ Form::label('note1', '(WAJIB disertakan salinan surat pewartaan untuk setiap lot yg terlibat)', ['class' => 'col-form-label','style'=>'font-size: 10px; height: 20px; padding-top: 5px; padding-bottom: 5px;']) }}
        </td>
        <td colspan="3">
            <div class="form-group row">
                <!-- First Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Diwartakan', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap', 'Diwartakan', ['class' => 'form-check-label bigger-label ms-2']) }}
                    </div>
                </div>
                
                <!-- Second Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::label('pelan_induk_landskap_2', 'Tarikh:', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::date('pelan_induk_landskap_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada']) }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <!-- First Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Proses Perwartaan', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap', 'Proses Perwartaan', ['class' => 'form-check-label bigger-label ms-2']) }}
                    </div>
                </div>
                
                <!-- Second Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::label('pelan_induk_landskap_2', 'Tarikh:', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::date('pelan_induk_landskap_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada']) }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <!-- First Checkbox with Input -->
                <div class="col-md-6">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('rancangan_pembangunan[]', 'Belum diwartakan', false, ['class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('pelan_induk_landskap', 'Belum diwartakan', ['class' => 'form-check-label bigger-label ms-2']) }}
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>{{ Form::label('keluasan', 'd.&nbsp;&nbsp;&nbsp;&nbsp;No Lot/PT :', ['class' => 'col-form-label']) }}</td>
        <td>{{ Form::text('keluasan', null, ['class' => 'form-control']) }}</td>
        <td colspan="4">
        <div class="form-group row">
            <!-- First Label and Select -->
            <div class="col-md-4">
                {{ Form::label('negeri', 'Negeri:', ['class' => 'col-form-label']) }}
            </div>
            <div class="col-md-8">
                {{ Form::select('negeri', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
            </div>
        </div>

        <div class="form-group row">
            <!-- Second Label and Select -->
            <div class="col-md-4">
                {{ Form::label('daerah', 'Daerah:', ['class' => 'col-form-label']) }}
            </div>
            <div class="col-md-8">
                {{ Form::select('daerah', [], null, ['class' => 'form-control', 'id' => 'daerah']) }}
            </div>
        </div>

        <div class="form-group row">
            <!-- Third Label and Select -->
            <div class="col-md-4">
                {{ Form::label('mukim', 'Mukim:', ['class' => 'col-form-label']) }}
            </div>
            <div class="col-md-8">
                {{ Form::select('mukim', [], null, ['class' => 'form-control', 'id' => 'mukim']) }}
            </div>
        </div>

        <div class="form-group row">
            <!-- Fourth Label and Select -->
            <div class="col-md-4">
                {{ Form::label('parlimen', 'Parlimen:', ['class' => 'col-form-label']) }}
            </div>
            <div class="col-md-8">
                {{ Form::select('parlimen', [], null, ['class' => 'form-control', 'id' => 'parlimen']) }}
            </div>
        </div>

        <div class="form-group row">
            <!-- Fifth Label and Select -->
            <div class="col-md-4">
                {{ Form::label('dun', 'Dun:', ['class' => 'col-form-label']) }}
            </div>
            <div class="col-md-8">
                {{ Form::select('dun', [], null, ['class' => 'form-control', 'id' => 'dun']) }}
            </div>
        </div>


            <!-- Dropdown for Negeri, Daerah, and Mukim -->
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('negeri', 'Negeri:', ['class' => 'col-form-label']) }}
                    {{ Form::select('negeri', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::label('daerah', 'Daerah:', ['class' => 'col-form-label']) }}
                    {{ Form::select('daerah', [], null, ['class' => 'form-control', 'id' => 'daerah']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::label('mukim', 'Mukim:', ['class' => 'col-form-label']) }}
                    {{ Form::select('mukim', [], null, ['class' => 'form-control', 'id' => 'mukim']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::label('parlimen', 'Parlimen:', ['class' => 'col-form-label']) }}
                    {{ Form::select('parlimen', [], null, ['class' => 'form-control', 'id' => 'parlimen']) }}
                </div>

                <div class="col-md-4">
                    {{ Form::label('dun', 'Dun:', ['class' => 'col-form-label']) }}
                    {{ Form::select('dun', [], null, ['class' => 'form-control', 'id' => 'dun']) }}
                </div>
            </div>


        </td>

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
                        $('#negeri').append('<option value="">Pilih Negeri</option>'); // Add default option

                        $.each(data, function(key, value) {
                            // Add each Negeri to the dropdown
                            $('#negeri').append('<option value="' + value.kod_negeri + '">' + value.nama_negeri + '</option>');
                        });
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
                        $.ajax({
                            url: '/get-daerah/' + negeriId, // Your existing route to fetch daerah
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                // Populate the 'Daerah' dropdown with the response data
                                $('#daerah').empty();
                                $('#daerah').append('<option value="">Pilih Daerah</option>');
                                $('#mukim').empty();
                                $('#mukim').append('<option value="">Pilih Mukim</option>');
                                $('#dun').empty();
                                $('#dun').append('<option value="">Pilih Dun</option>');
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
                            }
                        });
                    } else {
                        $('#daerah').empty();
                        $('#daerah').append('<option value="">Pilih Daerah</option>');

                        $('#parlimen').empty();
                        $('#parlimen').append('<option value="">Pilih Parlimen</option>');
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
                            }
                        });
                    } else {
                        $('#dun').empty();
                        $('#dun').append('<option value="">Pilih Dun</option>');
                    }
                });

            });
        </script>




    </tr>

    <!-- Sixth Row: Hakmilik Tanah -->
    <tr>
        <td>{{ Form::label('hakmilik_tanah', 'Hakmilik Tanah:', ['class' => 'col-form-label']) }}</td>
        <td colspan="5">
            <div class="form-check form-check-inline">
                {{ Form::checkbox('hakmilik_tanah[]', 'Tanah Kerajaan', false, ['class' => 'form-check-input bigger-checkbox']) }}
                &nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('hakmilik_tanah', 'Tanah Kerajaan', ['class' => 'form-check-label bigger-label']) }}
            </div>&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-check form-check-inline">
                {{ Form::checkbox('hakmilik_tanah[]', 'Tanah Persendirian', false, ['class' => 'form-check-input bigger-checkbox']) }}
                &nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('hakmilik_tanah', 'Tanah Persendirian', ['class' => 'form-check-label bigger-label']) }}
            </div>
        </td>
    </tr>

    <!-- Seventh Row: Status Tanah -->
    <tr>
        <td>{{ Form::label('status_tanah', 'Status Tanah:', ['class' => 'col-form-label']) }}</td>
        <td colspan="5">
            <div class="form-check form-check-inline">
                {{ Form::checkbox('status_tanah[]', 'Milikan Penuh', false, ['class' => 'form-check-input bigger-checkbox']) }}
                &nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('status_tanah', 'Milikan Penuh', ['class' => 'form-check-label bigger-label']) }}
            </div>&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="form-check form-check-inline">
                {{ Form::checkbox('status_tanah[]', 'Sekatan Kepentingan', false, ['class' => 'form-check-input bigger-checkbox']) }}
                &nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('status_tanah', 'Sekatan Kepentingan', ['class' => 'form-check-label bigger-label']) }}
            </div>
        </td>
    </tr>
</table>

<!-- Add custom CSS to make checkboxes bigger -->
<style>
    .bigger-checkbox {
        transform: scale(2); /* Increases checkbox size */
        margin-right: 10px;
    }

    .bigger-label {
        font-size: 18px; /* Increases label font size */
    }

    .form-control {
        width: 100%; /* Ensures input boxes stretch across available space */
    }

    .form-check {
        margin-right: 10px; /* Adds spacing between checkboxes */
    }

    .form-group {
        margin-bottom: 15px; /* Adds spacing between form groups */
    }
</style>
