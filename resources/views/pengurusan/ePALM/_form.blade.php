
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
        .new-change {
            border: 2px solid red !important;
            /* background-color:rgb(220, 248, 215); */
        }
    </style>
    <!-- <h3>Perubahan Terkini</h3> -->
    @php
        $arrChanges = [];
    @endphp

    <!-- <h3>3 Perubahan Terkini</h3> -->

    @if(Auth::user()->hasRole('KP/ TKP JLN|Pegawai|Pentadbir Sistem') && isset($latestAudit))
        @foreach ($latestAudit as $audit)
            <!-- <div style="margin-bottom: 20px;">
                <p><strong>Dikemaskini oleh:</strong> {{ $audit->user->name ?? 'Sistem' }}</p>
                <p><strong>Tarikh:</strong> {{ $audit->created_at->format('d-m-Y H:i') }}</p>
                <table border="1" cellpadding="8" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Medan</th>
                            <th>Sebelum</th>
                            <th>Selepas</th>
                        </tr>
                    </thead>
                    <tbody> -->
                        @foreach ($audit->new_values as $field => $newValue)
                            @php
                                if($field == 'mediaSosial_taman'){
                                    $mediaSosial_tamanData = json_decode($newValue, true);
                                    
                                    $oldValue = json_decode($audit->old_values[$field] ?? '{}', true);
                                    //dd($oldValue);

                                    // Loop through each key of mediaSosial_taman to detect changes
                                    foreach ($mediaSosial_tamanData as $key => $value) {
                                        // If the value has changed (or is new)
                                        if (!isset($oldValue[$key]) || $oldValue[$key] !== $value) {
                                            // Store the field name that has changed
                                            $arrChanges[] = $field . '.' . $key;  // You can combine the field name with the key for clarity
                                        }
                                    }
                                }else if ($field == 'gambar_taman') {
                                    $gambar_tamanData = json_decode($newValue, true);
                                    $oldValue = json_decode($audit->old_values[$field] ?? '{}', true);

                                    // Check for added/changed values
                                    foreach ($gambar_tamanData as $key => $value) {
                                        if (!isset($oldValue[$key]) || $oldValue[$key] !== $value) {
                                            $arrChanges[] = $field . '.' . $key;
                                        }
                                    }

                                    // Check for removed keys
                                    foreach ($oldValue as $key => $value) {
                                        if (!isset($gambar_tamanData[$key])) {
                                            $arrChanges[] = $field . '.' . $key;
                                        }
                                    }
                                }else{
                                    $arrChanges[] = $field;
                                }
                                //dump($arrChanges);
                            @endphp
                        @endforeach
                    <!-- </tbody>
                </table>
            </div> -->
        @endforeach
    @endif

    {{--
        @if(isset($arrChanges))
            <div class="alert alert-info mt-3">
                <strong>Nota:</strong> Perubahan pada medan berikut tidak akan dipaparkan di portal:
                <ul>
                    @foreach($arrChanges as $change)
                        <li>{{ ucfirst($change) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    --}}
    <div class="row inertShow">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="inertClass">
                <div class="row">
                    <div class="form-group required col-md-8">
                        <label for="nama_taman" class="col-md-12 control-label">Nama Taman</label>
                        <div class="col-md-12">
                            {!! Form::textarea('nama_taman', null, ['class' => 'form-control', 'maxlength' => '150', 'rows' => '1', 'id' => 'nama_taman', 'required' => 'required']) !!}
                            <script>
                                function resizeTextarea(textarea) {
                                    textarea.style.height = 'auto';
                                    textarea.style.height = (textarea.scrollHeight) + 'px';
                                }

                                window.onload = function() {
                                    var textarea = document.getElementById('nama_taman');
                                    resizeTextarea(textarea);
                                };
                                window.onkeyup = function() {
                                    var textarea = document.getElementById('nama_taman');
                                    resizeTextarea(textarea);
                                };
                            </script>
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="kategori_taman" class="col-md-12 control-label">Jenis Taman {!! in_array('kategori_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                        <div class="col-md-12">
                            @php
                                $options = [
                                    'Taman Awam' => 'Taman Awam',
                                    'Taman Botani' => 'Taman Botani',
                                    'Landskap Perbandaran' => 'Landskap Perbandaran',
                                    'Persekitaran Kehidupan' => 'Persekitaran Kehidupan',
                                    'Taman Persekutuan' => 'Taman Persekutuan',
                                    //'6' => 'Lain-lain (sila nyatakan)'
                                ];

                                // Check if $ePALM->kategori_taman exists and is not in the options list, then append it
                                if (isset($ePALM->kategori_taman) && !array_key_exists($ePALM->kategori_taman, $options)) {
                                    $options[$ePALM->kategori_taman] = $ePALM->kategori_taman;  // Add it to options
                                }
                                //dd(array_key_exists("Taman Awamw", $options));
                            @endphp

                            {!! Form::select('kategori_taman', $options, isset($ePALM->kategori_taman) ? $ePALM->kategori_taman : '', ['class' => 'form-control ', 'id' => 'kategori_taman', 'required' => 'required']) !!}
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group required">
                    <label for="nama_taman" class="col-md-12 control-label">Nama Taman</label>
                    <div class="col-md-12">
                        {!! Form::textarea('nama_taman', null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => '1', 'id' => 'nama_taman', 'required' => 'required']) !!}
                        <script>
                            function resizeTextarea(textarea) {
                                textarea.style.height = 'auto';  // Reset the height
                                textarea.style.height = (textarea.scrollHeight) + 'px';
                            }

                            // Call resize function when the page loads
                            window.onload = function() {
                                var textarea = document.getElementById('nama_taman');
                                resizeTextarea(textarea);
                            };
                        </script>
                    </div>
                </div> -->
                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="negeri_taman" class="col-md-12 control-label">Negeri {!! in_array('negeri_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                        <div class="col-md-12">
                            {{ Form::select('negeri_taman', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
                        </div>
                    </div>
                    <div class="form-group required col-md-8">
                        <label for="nama_pbt" class="col-md-12 control-label">Pihak Berkuasa Tempatan</label>
                        <div class="col-md-12">
                            <input type="text" name="nama_pbt" id="nama_pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" class="form-control" required value="{{ $pbt->pbt_name ?? $ePALM->nama_pbt ?? '' }}">
                            <datalist id="data_pbt">
                            </datalist>
                        </div>
                    </div>
                    <!-- <div class="form-group required col-md-8">
                        <label for="nama_pbt" class="col-md-12 control-label">Pihak Berkuasa Tempatan</label>
                        <div class="col-md-12">
                            {!! Form::text('nama_pbt', $pbt->pbt_name ?? $ePALM->nama_pbt ?? '', ['class' => 'form-control', 'id' => 'nama_pbt']) !!}
                        </div>
                    </div> -->

                    <!-- <div class="form-group required col-md-4">
                        <label for="kategori_taman" class="col-md-12 control-label">Jenis Taman {!! in_array('kategori_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                        <div class="col-md-12">
                            @php
                                $options = [
                                    'Taman Awam' => 'Taman Awam',
                                    'Taman Botani' => 'Taman Botani',
                                    'Landskap Perbandaran' => 'Landskap Perbandaran',
                                    'Persekitaran Kehidupan' => 'Persekitaran Kehidupan',
                                    'Taman Persekutuan' => 'Taman Persekutuan',
                                    //'6' => 'Lain-lain (sila nyatakan)'
                                ];

                                // Check if $ePALM->kategori_taman exists and is not in the options list, then append it
                                if (isset($ePALM->kategori_taman) && !array_key_exists($ePALM->kategori_taman, $options)) {
                                    $options[$ePALM->kategori_taman] = $ePALM->kategori_taman;  // Add it to options
                                }
                                //dd(array_key_exists("Taman Awamw", $options));
                            @endphp

                            {!! Form::select('kategori_taman', $options, isset($ePALM->kategori_taman) ? $ePALM->kategori_taman : '', ['class' => 'form-control ', 'id' => 'kategori_taman', 'required' => 'required']) !!}
                        </div>
                    </div> -->
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

                
                <div class="inertClass">
                    <div class="row">
                        <!-- <div class="form-group required col-md-4">
                            <label for="negeri_taman" class="col-md-12 control-label">Negeri {!! in_array('negeri_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                            <div class="col-md-12">
                                {{ Form::select('negeri_taman', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
                            </div>
                        </div> -->

                        <div class="form-group required col-md-4">
                            <label for="daerah_taman" class="col-md-12 control-label">Daerah {!! in_array('daerah_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                            <div class="col-md-12">
                                {{ Form::select('daerah_taman', [], null, ['class' => 'form-control', 'id' => 'daerah']) }}
                            </div>
                        </div>

                        <div class="form-group required col-md-4">
                            <label for="mukim_taman" class="col-md-12 control-label">Mukim {!! in_array('mukim_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                            <div class="col-md-12">
                                {{ Form::select('mukim_taman', [], null, ['class' => 'form-control', 'id' => 'mukim']) }}
                            </div>
                        </div>

                        <div class="form-group required col-md-4">
                            <label for="parlimen_taman" class="col-md-12 control-label">Parlimen {!! in_array('parlimen_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                            <div class="col-md-12">
                                {{ Form::select('parlimen_taman', [], null, ['class' => 'form-control', 'id' => 'parlimen']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group required col-md-4">
                            <label for="dun_taman" class="col-md-12 control-label">Dun {!! in_array('dun_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
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
                                var negeriText = $(this).find('option:selected').text();
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

                                    $('#data_pbt').empty();
                                    $.getJSON('/data/pbt/' + negeriText, function(data) {
                                        $.each(data, function(index, pbt) {
                                            $('#data_pbt').append($('<option>', {
                                                value: pbt.name,
                                                'data-id': pbt.id,
                                            }));
                                        });
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
                                                $('#dun').append('<option value="000" selected>TIADA DUN</option>');
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
                    <label for="alamat1_taman" class="col-md-4 control-label">Alamat 1 {!! in_array('alamat1_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->alamat1_taman) ? $ePALM->alamat1_taman : ''}}" name="alamat1_taman" class="form-control" maxlength="50" type="text" id="alamat1_taman" required="required">
                    </div>
                </div>

                <div class="form-group required col-md-6">
                    <label for="alamat2_taman" class="col-md-4 control-label">Alamat 2 {!! in_array('alamat2_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->alamat2_taman) ? $ePALM->alamat2_taman : ''}}" name="alamat2_taman" class="form-control" maxlength="50" type="text" id="alamat2_taman">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-8">
                    <label for="alamat3_taman" class="col-md-12 control-label">Alamat 3 {!! in_array('alamat3_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->alamat3_taman) ? $ePALM->alamat3_taman : ''}}" name="alamat3_taman" class="form-control" maxlength="50" type="text" id="alamat3_taman">
                    </div>
                </div>

                <div class="form-group required col-md-4">
                    <label for="poskod_taman" class="col-md-4 control-label">Poskod {!! in_array('poskod_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        <input value="{{isset($ePALM->poskod_taman) ? $ePALM->poskod_taman : ''}}" name="poskod_taman" class="form-control" type="char" id="poskod_taman" required="required">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group required col-md-4">
                    <label for="keluasan_taman" class="col-md-12 control-label">Keluasan {!! in_array('keluasan_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
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
                    <label for="panjang_taman" class="col-md-12 control-label">Panjang {!! in_array('panjang_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
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
                <div class="form-group required col-md-5">
                    <label for="hakmilik_tanah_taman" class="col-md-12 control-label">Hakmilik Tanah {!! in_array('hakmilik_tanah_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        {{ Form::text('hakmilik_tanah_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}
                    </div>
                </div>

                <div class="form-group required col-md-7">
                    <label for="status_tanah_taman" class="col-md-12 control-label">Status Tanah {!! in_array('status_tanah_taman', $arrChanges) || in_array('tarikhWarta_tanah_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::text('status_tanah_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::date('tarikhWarta_tanah_taman', isset($ePALM->tarikhWarta_tanah_taman) ? $ePALM->tarikhWarta_tanah_taman : '', ['class' => 'form-control d-inline-block ms-2', 'id' => 'tarikhWarta_tanah_taman']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row inertShow">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>

            <div class="row">
                <div class="form-group required col-md-6">
                    <label for="lat" class="col-md-12 control-label">Koordinat X {!! in_array('lat', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        {{ Form::text('lat', null, ['class' => 'form-control', 'placeholder' => 'Masukkan koordinat X']) }}
                    </div>
                </div>
                <div class="form-group required col-md-6">
                    <label for="lng" class="col-md-12 control-label">Koordinat Y {!! in_array('lng', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        {{ Form::text('lng', null, ['class' => 'form-control', 'placeholder' => 'Masukkan koordinat Y']) }}
                    </div>
                </div>
                <div class="form-group required col-md-6">
                    <label for="waktuMula_taman" class="col-md-12 control-label">Waktu Mula Operasi {!! in_array('waktuMula_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        {{ Form::time('waktuMula_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan waktu mula operasi']) }}
                    </div>
                </div>
                <div class="form-group required col-md-6">
                    <label for="waktuTamat_taman" class="col-md-12 control-label">Waktu Tamat Operasi {!! in_array('waktuTamat_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12">
                        {{ Form::time('waktuTamat_taman', null, ['class' => 'form-control', 'placeholder' => 'Masukkan waktu tamat operasi']) }}
                    </div>
                </div>
            </div>

            <div class="row">
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

                @php
                    if(isset($ePALM->fasiliti) && $ePALM->fasiliti != null){
                        $fasilitiData = json_decode($ePALM->fasiliti, true);
                        if (!(is_array($fasilitiData) || is_object($fasilitiData))) {
                            $fasilitiData = json_decode($ePALM->fasiliti, true);
                        }
                    }else{
                        $fasilitiData = [];
                    }
                    $facilityOptions = [
                        'cctv'    => ['label' => 'CCTV', 'icon' => 'fas fa-video'],
                        'wifi'    => ['label' => 'WiFi', 'icon' => 'fas fa-wifi'],
                        'cycling' => ['label' => 'Kemudahan Berbasikal', 'icon' => 'fas fa-bicycle'],
                        'food'    => ['label' => 'Gerai Makan', 'icon' => 'fas fa-utensils'],
                        'oku'     => ['label' => 'Kemudahan OKU', 'icon' => 'fas fa-wheelchair'],
                        'toilet'  => ['label' => 'Tandas Awam', 'icon' => 'fas fa-toilet'],
                        //'food2'   => ['label' => 'Gerai Makan', 'icon' => 'fas fa-utensils'],
                        //'oku2'    => ['label' => 'Kemudahan OKU', 'icon' => 'fas fa-wheelchair'],
                        //'toilet2' => ['label' => 'Tandas Awam', 'icon' => 'fas fa-toilet'],
                    ];

                    $facilityKeys = array_keys($facilityOptions);
                    //dd($fasilitiData);
                @endphp

                <div class="form-group required col-md-12">
                    <label for="park_facilities" class="col-md-12 control-label">
                        Kemudahan {!! in_array('fasiliti', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!}
                    </label>

                    <div class="col-md-12">
                        <div class="col-xs-12">
                            <div class="parks" id="facility-list">
                                {{-- Loop known facilities --}}
                                @foreach($facilityOptions as $key => $option)
                                    @php $isChecked = isset($fasilitiData[$key]) && $fasilitiData[$key] == '1' ? 'checked' : ''; @endphp
                                    <div class="col-md-3 facility-wrapper">
                                        <label class="facility">
                                            <input type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                            <input type="checkbox" value="1" name="fasiliti[{{ $key }}]" id="{{ $key }}" {{ $isChecked }}>
                                            <span class="parks bg">
                                                <div class="icon-container">
                                                    <i class="{{ $option['icon'] }}" data-toggle="tooltip" title="{{ $option['label'] }}"></i>
                                                </div>
                                            </span>
                                            <span class="facility-label">{{ $option['label'] }}</span>
                                        </label>
                                    </div>
                                @endforeach

                                {{-- Loop custom (unknown) facilities --}}
                                @foreach($fasilitiData as $key => $val)
                                    @if (!in_array($key, $facilityKeys))
                                        @php $isChecked = isset($fasilitiData[$key]) && $fasilitiData[$key] == '1' ? 'checked' : ''; @endphp
                                        <div class="col-md-3 facility-wrapper">
                                            <label class="facility">
                                                <input type="hidden" name="fasiliti[{{ $key }}]" value="0">
                                                <input type="checkbox" value="1" name="fasiliti[{{ $key }}]" id="{{ $key }}" {{ $isChecked }}>
                                                <span class="parks bg">
                                                    <div class="icon-container">
                                                        <i class="fas fa-chart-pie" data-toggle="tooltip" title="{{ ucfirst($key) }}"></i>
                                                    </div>
                                                </span>
                                                <span class="facility-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            {{-- Add Facility Button --}}
                            <div class="mt-3 showButton">
                                <button type="button" class="btn btn-sm btn-primary" onclick="addFacility()">Tambah Kemudahan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function addFacility() {
                        const name = prompt("Masukkan nama kemudahan (cth. Tempat Parkir)");
                        if (!name) return;

                        const key = name.toLowerCase().replace(/\s+/g, '_'); // make safe input name
                        const container = document.getElementById('facility-list');

                        // Check if already exists
                        if (document.getElementById(key)) {
                            alert("Facility already added.");
                            return;
                        }

                        const div = document.createElement('div');
                        div.classList.add('col-md-3', 'facility-wrapper');
                        div.innerHTML = `
                            <label class="facility">
                                <input type="checkbox" value="1" name="fasiliti[${key}]" id="${key}" checked>
                                <span class="parks bg">
                                    <div class="icon-container">
                                        <i class="fas fa-chart-pie" data-toggle="tooltip" title="${name}"></i>
                                    </div>
                                </span>
                                <span class="facility-label">${name}</span>
                            </label>
                        `;
                        container.appendChild(div);
                    }
                </script>
            </div>
            
        </div>
        <div class="col-lg col-separator ">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            
            <div class="row" id="dynamic-media-fields">
                @php
                    if(isset($ePALM->mediaSosial_taman)){
                        $mediaSosial_tamanData = json_decode($ePALM->mediaSosial_taman, true);
                        $mediaData = json_decode($ePALM->mediaSosial_taman, true);
                        //$media1 = isset($mediaSosial_tamanData['Telefon']) ? $mediaSosial_tamanData['Telefon'] : '';
                        //$media2 = isset($mediaSosial_tamanData['Emel']) ? $mediaSosial_tamanData['Emel'] : '';
                        //$media3 = isset($mediaSosial_tamanData['Web']) ? $mediaSosial_tamanData['Web'] : '';
                        //$media4 = isset($mediaSosial_tamanData['Facebook']) ? $mediaSosial_tamanData['Facebook'] : '';
                        //$media5 = isset($mediaSosial_tamanData['Instagram']) ? $mediaSosial_tamanData['Instagram'] : '';
                        //$media6 = isset($mediaSosial_tamanData['LinkedIn']) ? $mediaSosial_tamanData['LinkedIn'] : '';
                        //$media7 = isset($mediaSosial_tamanData['Twitter']) ? $mediaSosial_tamanData['Twitter'] : '';
                        //$media8 = isset($mediaSosial_tamanData['TikTok']) ? $mediaSosial_tamanData['TikTok'] : '';
                    }else{
                        $media1 = $media2 = $media3 = $media4 = $media5 = $media6 = $media7 = $media8 = null;
                        $mediaData = null;
                    }
                    $fixedFields = ['Emel', 'Web', 'Telefon', 'Facebook'];
                    //dd($arrChanges);
                @endphp

                @foreach ($fixedFields as $index => $field)
                    @php $value = $mediaData[$field] ?? ''; @endphp
                    <div class="form-group required {{ $field == 'Emel' || $field == 'Web' ? 'col-md-6' : 'col-md-3' }}">
                        <label for="mediaSosial" class="col-md-12 control-label">{{ $field == 'Web' ? 'Laman Web' : $field }} {!! in_array('mediaSosial_taman.'.$field, $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!}</label>
                        <div class="col-md-12">
                            <input value="{{ $value }}" name="mediaSosial_taman[{{ $field }}]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]">
                        </div>
                    </div>
                @endforeach
                @if (isset($mediaData))
                    @foreach ($mediaData as $key => $value)
                        @if (!in_array($key, $fixedFields))
                            <div class="form-group required col-md-3">
                                <label for="mediaSosial" class="col-md-12 control-label">{{ $key }} {!! in_array('mediaSosial_taman.'.$key, $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!}</label>
                                <div class="col-md-12">
                                    <input value="{{ $value }}" name="mediaSosial_taman[{{ $key }}]" class="form-control" maxlength="50" type="text" id="mediaSosial_taman[]">
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
            <div class="form-group col-md-3 showButton">
                <button type="button" onclick="addMedia()" class="btn btn-primary">Tambah Media Sosial</button>
            </div>

            <script>
                function addMedia() {
                    const name = prompt("Masukkan nama media sosial (contoh: TikTok)");
                    if (!name) return;

                    const key = name.trim().replace(/\s+/g, ''); // safer key
                    const container = document.getElementById('dynamic-media-fields');

                    // Avoid duplicates
                    if (document.querySelector(`[name="mediaSosial_taman[${key}]"]`)) {
                        alert("Media sosial ini telah ditambah.");
                        return;
                    }

                    const div = document.createElement('div');
                    div.classList.add('form-group', 'required', 'col-md-3');
                    div.innerHTML = `
                        <label class="col-md-12 control-label">${name}</label>
                        <div class="col-md-12">
                            <input name="mediaSosial_taman[${key}]" class="form-control" maxlength="50" type="text">
                        </div>
                    `;
                    container.appendChild(div);
                }
            </script>
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
            <div class="form-group required inertShow">
                <label for="keterangan_taman" class="col-md-12 control-label">Keterangan Taman {!! in_array('keterangan_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                <div class="col-md-12">
                    <textarea name="keterangan_taman" class="form-control" maxlength="250" rows="5" id="keterangan_taman" required="required">{{ isset($ePALM->keterangan_taman) ? $ePALM->keterangan_taman : '' }}</textarea>
                </div>
            </div>

            
            <div class="row">
                <div class="form-group required col-md-8">
                    <label for="fail_konsep" class="col-md-12 control-label">Konsep Rekabentuk {!! in_array('fail_konsep', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                    <div class="col-md-12 showButton">
                        {{ Form::file('fail_konsep', ['class' => 'form-control d-inline-block ms-2', 'multiple' => false, 'accept' => '.pdf,.docx,.pptx']) }}
                        
                    </div>
                    @if(isset($ePALM->fail_konsep))
                        {{ Form::label('', '***Muatnaik semula akan menggantikan fail sedia ada.', ['class' => 'col-form-label required-field-create showButton', 'style' => 'font-weight: strong;']) }}
                        <br>
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                @php
                                    $folderName = isset($ePALM->fail_konsep) ? 'ePALM/'.str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman).'/'.$ePALM->fail_konsep : null;

                                    $fileExtension = isset($ePALM->fail_konsep) ? pathinfo($ePALM->fail_konsep, PATHINFO_EXTENSION) : '';
                                    $extensionIcon = null;
                                    if ($fileExtension === 'pdf') {
                                        $extensionIcon = "https://img.icons8.com/plasticine/100/pdf-2.png";
                                    } elseif ($fileExtension === 'docx') {
                                        $extensionIcon = "https://img.icons8.com/plasticine/100/google-docs--v2.png";
                                    } elseif ($fileExtension === 'pptx') {
                                        $extensionIcon = "https://img.icons8.com/plasticine/100/google-slides.png";
                                    }
                                @endphp
                                
                                @if($folderName != null)
                                    <a href="{{ asset('storage/uploads/' . $folderName) }}" target="_blank" class="" style="border: 0px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;" download>
                                        <div class="product-image">
                                            <img src="{{ $extensionIcon }}" class="br-5" alt="" style="width: 100px; height: 100px; border-radius: 5px; margin-bottom: 10px;">
                                        </div>
                                        <div class="product-image">
                                            <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Konsep Rekabentuk <i class="fas fa-download"></i></span>
                                        </div>
                                        <div class="product-image">
                                            <span class="file-name-1">{{ $ePALM->fail_konsep ?? '' }}</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="form-group required col-md-4 ">
                    <div class="">
                        <label for="tarikh_siapBina_taman" class="col-md-12 control-label">Tarikh Siap Bina {!! in_array('tarikh_siapBina_taman', $arrChanges) ? '<span class="text-danger newC">!</span>' : '' !!} </label>
                        <div class="col-md-12">
                            {{ Form::date('tarikh_siapBina_taman', isset($ePALM->tarikh_siapBina_taman) ? $ePALM->tarikh_siapBina_taman : '', ['class' => 'form-control d-inline-block ms-2', 'id' => 'tarikh_siapBina_taman']) }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-lg col-separator ">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-12">
                <label for="gambar_taman" class="col-md-12 control-label">
                    Gambar Taman 
                    {!! collect($arrChanges)->contains(fn($i) => Str::startsWith($i, 'gambar_taman')) 
                        ? '<span class="text-danger newC">!</span>' 
                        : '' !!}
                </label>
                    @php
                        $imageFields = [];
                        if(isset($ePALM->gambar_taman)){
                            $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
                            $rootFolder = str_replace(' ', '_', $ePALM->nama_pbt);
                            $gambar_tamanData = json_decode($ePALM->gambar_taman, true);

                            for ($i = 1; $i <= 6; $i++) {
                                //$fieldKey = "XGIM_$i";
                                //$fieldKey2 = "Xgambar_input_modal_$i";
                                //$imageFields[$fieldKey] = isset($gambar_tamanData[$fieldKey]) ? $folderName . '/' . $gambar_tamanData[$fieldKey] : (isset($gambar_tamanData[$fieldKey2]) ? $folderName . '/' . $gambar_tamanData[$fieldKey2] : null);


                                $fieldKeyX = "XGIM_$i";
                                $fieldKeyX2 = "Xgambar_input_modal_$i";
                                $imageFields[$fieldKeyX] = isset($gambar_tamanData["XGIM_$i"]) ? $folderName . '/' . $gambar_tamanData["XGIM_$i"] : (isset($gambar_tamanData[$fieldKeyX2]) ? $folderName . '/' . $gambar_tamanData[$fieldKeyX2] : null);
                            }
                            //dd($gambar_tamanData);
                        }else{
                            for ($i = 1; $i <= 6; $i++) {
                                $fieldKey = "XGIM_$i";
                                $imageFields[$fieldKey] = null;
                            }
                        }
                    @endphp
                    <div class="col-md-12">
                        <style>
                            .grid-container {
                                display: grid;
                                grid-template-columns: repeat(3, 1fr);
                                gap: 10px;
                                width: 500px;         /* Fixed width */
                                height: 450px;        /* Fixed height */
                                margin: 0 auto;
                                box-sizing: border-box;
                                /* overflow: hidden; */
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
                            height: 100%;
                            overflow-y: auto;
                            }

                            .image-preview-container img {
                            width: 250px;
                            max-height: 150px;
                            height: auto;
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
                            @media only screen and (max-width: 768px) {
                                .grid-container {
                                    display: grid;
                                    grid-template-columns: 1fr 1fr ; /* 2 equal-width columns */
                                    gap: 10px; /* Space between grid items */
                                    width: 300px;
                                    max-width: 600px;  /* Limit max width for the grid */
                                    margin: 0 auto; /* Centers the grid container horizontally */
                                    height: auto; /* Allow the height to adjust based on content */
                                }
                                .image-preview-container img {
                                    width: 200px; /* Adjust the width as needed */
                                    height: 100px; /* Adjust the height as needed */
                                    object-fit: cover;
                                    border-radius: 10px;
                                    border: 0px solid #ddd;
                                    padding: 2px;
                                }
                            }
                            @keyframes blink2 {
                                0% {
                                    border-color: #008000;
                                }
                                50% {
                                    border-color: transparent;
                                }
                                100% {
                                    border-color: #008000;
                                }
                            }
                        </style>
                        <!-- <div class="grid-container">
                            @foreach ($imageFields as $fieldKey => $imagePath)
                                <div class="grid-item clickable-preview" data-image="{{ isset($imagePath) ? asset('storage/uploads/ePALM/' . $imagePath) : asset('storage/uploads/no-photos.png') }}" {!! in_array('gambar_taman.' . $fieldKey, $arrChanges) ? 'style="border: 2px solid #008000; animation: blink2 3s infinite;"' : '' !!}>
                                    <input type="file" class="form-control-file" id="{{ $fieldKey }}" name="{{ $fieldKey }}" accept="image/*" style="display: none;">
                                    <div id="preview_{{ $loop->index + 1 }}" class="image-preview-container">
                                        <img src="{{ isset($imagePath) ? asset('storage/uploads/ePALM/' . $imagePath) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div class="showButton">
                                        <button type="button" class="btn btn-sm btn-primary trigger-upload" data-target="{{ $fieldKey }}">Pilih</button>
                                        <button type="button" class="btn btn-sm btn-danger delete-image" data-target="{{ $fieldKey }}">Padam</button>
                                    </div>
                                    <input type="hidden" name="delete_images[]" value="" id="{{ 'delete_'.$fieldKey }}">
                                    <script>
                                        // document.querySelector('.delete-image').addEventListener('click', function() {
                                        //     const target = this.getAttribute('data-target');
                                        //     document.getElementById(target).value = ''; // Clear the file input value
                                        //     document.getElementById('preview_' + ({{ $loop->index + 1 }})).querySelector('img').src = '{{ asset('storage/uploads/no-photos.png') }}'; // Reset the image preview
                                        //     this.style.display = 'none'; // Hide the delete button
                                        //     document.getElementById('delete_' + target).value = target; // Set the hidden input value to the deleted image key
                                        // });
                                        document.querySelectorAll('.trigger-upload').forEach(button => {
                                            button.addEventListener('click', function () {
                                                const field = this.dataset.target;
                                                document.getElementById(field).click();
                                            });
                                        });
                                        document.querySelectorAll('.delete-image').forEach(button => {
                                            button.addEventListener('click', function () {
                                                const field = this.dataset.target;
                                                const preview = document.getElementById(`preview_${field.split('_')[1]}`);
                                                const deleteInput = document.getElementById(`delete_${field}`);
                                                
                                                // Replace image with placeholder
                                                preview.querySelector('img').src = '/storage/uploads/no-photos.png';

                                                // Mark as deleted
                                                deleteInput.value = field;
                                            });
                                        });
                                        document.addEventListener("DOMContentLoaded", function () {
                                            // document.querySelectorAll('.clickable-preview').forEach(function (el) {
                                            //     el.addEventListener('click', function () {
                                            //         const imageUrl = this.dataset.image;
                                            //         document.getElementById('modalImage').src = imageUrl;
                                            //         $('#imageModal').modal('show');
                                            //     });
                                            // });
                                            const currentURL = window.location.href;
                                            const isEditMode = currentURL.includes('/edit');
                                            const totalImages = 6; // or set dynamically if needed

                                            for (let i = 1; i <= totalImages; i++) {
                                                const inputId = `XGIM_${i}`;
                                                const previewId = `preview_${i}`;
                                                const inputEl = document.getElementById(inputId);
                                                const previewEl = document.getElementById(previewId);

                                                if (!inputEl || !previewEl) continue;

                                                // Always bind preview on file select
                                                inputEl.addEventListener('change', (e) => previewImage(e.target, previewEl));
                                                if (inputEl && previewEl) {
                                                    // previewEl.addEventListener('click', () => inputEl.click());
                                                    inputEl.addEventListener('change', (e) => previewImage(e.target, previewEl));
                                                }
                                                // if (isEditMode) {
                                                //     // Enable "Upload" button separately
                                                //     previewEl.style.cursor = 'default';
                                                // } else {
                                                    // View mode: modal preview on click
                                                    if(!currentURL.includes('/create')){
                                                        const imageUrl = previewEl.querySelector('img').src;
                                                        previewEl.parentElement.classList.add('clickable-preview');
                                                        previewEl.parentElement.dataset.image = previewEl.querySelector('img').src;
                                                        previewEl.style.cursor = 'zoom-in';
                                                        previewEl.parentElement.setAttribute('title', 'Lihat Gambar');

                                                        previewEl.addEventListener('click', function (e) {
                                                            if (e.target.closest('.showButton')) return;
                                                            document.getElementById('modalImage').src = previewEl.querySelector('img').src;
                                                            $('#imageModal').modal('show');
                                                        });
                                                    }
                                                // }
                                            }

                                            if (isEditMode) {
                                                // Upload buttons (edit mode only)
                                                document.querySelectorAll('.trigger-upload').forEach(button => {
                                                    button.addEventListener('click', function () {
                                                        const target = this.dataset.target;
                                                        document.getElementById(target).click();
                                                    });
                                                });

                                                // Delete buttons (edit mode only)
                                                document.querySelectorAll('.delete-image').forEach(button => {
                                                    button.addEventListener('click', function () {
                                                        const target = this.dataset.target;
                                                        const preview = document.getElementById('preview_' + target.split('_').pop());
                                                        const inputHidden = document.getElementById('delete_' + target);

                                                        // Set preview to default image
                                                        preview.querySelector('img').src = "{{ asset('storage/uploads/no-photos.png') }}";

                                                        // Flag it for deletion
                                                        inputHidden.value = target;
                                                    });
                                                });
                                            }
                                        });
                                    </script>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-0">
                                        <img id="modalImage" src="" class="img-fluid w-100" alt="Full Size Image">
                                    </div>
                                    <div class="modal-footer py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            const totalImages = 6;

                            function previewImage(inputElement, previewContainer) {
                                const file = inputElement.files[0];
                                // if (file) {
                                //     const reader = new FileReader();
                                //     reader.onload = function(e) {
                                //         previewContainer.querySelector('img').src = e.target.result;
                                //     };
                                //     reader.readAsDataURL(file);
                                // }
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const base64Data = e.target.result;

                                        // Update the image preview
                                        const imgEl = previewContainer.querySelector('img');
                                        imgEl.src = base64Data;

                                        // Update the data-image on the parent .grid-item
                                        const gridItem = previewContainer.closest('.grid-item');
                                        if (gridItem) {
                                            gridItem.setAttribute('data-image', base64Data);
                                        }
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }

                            // for (let i = 1; i <= totalImages; i++) {
                            //     const inputId = `XGIM_${i}`;
                            //     const previewId = `preview_${i}`;

                            //     const inputEl = document.getElementById(inputId);
                            //     const previewEl = document.getElementById(previewId);

                            //     if (inputEl && previewEl) {
                            //         previewEl.addEventListener('click', () => inputEl.click());
                            //         inputEl.addEventListener('change', (e) => previewImage(e.target, previewEl));
                            //     }
                            // }
                            
                        </script> -->
                        <div class="grid-container">
                            @foreach ($imageFields as $fieldKey => $imagePath)
                                @php
                                    $imageURL = isset($imagePath)
                                        ? asset('storage/uploads/ePALM/' . $imagePath)
                                        : asset('storage/uploads/no-photos.png');
                                    $isChanged = in_array('gambar_taman.' . $fieldKey, $arrChanges);
                                @endphp

                                <div class="grid-item clickable-preview"
                                    data-image="{{ $imageURL }}"
                                    @if($isChanged)
                                        style="border: 2px solid #008000; animation: blink2 3s infinite;"
                                    @endif>

                                    <input type="file" class="form-control-file" id="{{ $fieldKey }}" name="{{ $fieldKey }}" accept="image/*" style="display: none;">
                                    
                                    <div id="preview_{{ $loop->index + 1 }}" class="image-preview-container">
                                        <img src="{{ $imageURL }}" class="img-fluid" alt="Preview">
                                    </div>

                                    <div class="showButton">
                                        <button type="button" class="btn btn-sm btn-primary trigger-upload" data-target="{{ $fieldKey }}">Pilih</button>
                                        <button type="button" class="btn btn-sm btn-danger delete-image" data-target="{{ $fieldKey }}">Padam</button>
                                    </div>

                                    <input type="hidden" name="delete_images[]" value="" id="delete_{{ $fieldKey }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-0">
                                        <img id="modalImage" src="" class="img-fluid w-100" alt="Full Size Image">
                                    </div>
                                    <div class="modal-footer py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const currentURL = window.location.href;
                                const isEditMode = currentURL.includes('/edit');
                                const isCreateMode = currentURL.includes('/create');

                                document.querySelectorAll('.trigger-upload').forEach(button => {
                                    button.addEventListener('click', function () {
                                        const field = this.dataset.target;
                                        document.getElementById(field).click();
                                    });
                                });

                                document.querySelectorAll('.delete-image').forEach(button => {
                                    button.addEventListener('click', function () {
                                        const field = this.dataset.target;
                                        const preview = document.querySelector(`#preview_${field.split('_')[1]}`);
                                        const deleteInput = document.getElementById(`delete_${field}`);

                                        preview.querySelector('img').src = "{{ asset('storage/uploads/no-photos.png') }}";
                                        deleteInput.value = field;
                                    });
                                });

                                const totalImages = 6;

                                for (let i = 1; i <= totalImages; i++) {
                                    const input = document.getElementById(`XGIM_${i}`);
                                    const preview = document.getElementById(`preview_${i}`);

                                    if (!input || !preview) continue;

                                    input.addEventListener('change', () => previewImage(input, preview));

                                    if (!isCreateMode) {
                                        const imageUrl = preview.querySelector('img').src;
                                        const parent = preview.closest('.grid-item');

                                        if (parent) {
                                            parent.classList.add('clickable-preview');
                                            parent.dataset.image = imageUrl;
                                            preview.style.cursor = 'zoom-in';
                                            parent.title = 'Lihat Gambar';

                                            preview.addEventListener('click', function (e) {
                                                if (!e.target.closest('.showButton')) {
                                                    document.getElementById('modalImage').src = imageUrl;
                                                    $('#imageModal').modal('show');
                                                }
                                            });
                                        }
                                    }
                                }

                                function previewImage(inputElement, previewContainer) {
                                    const file = inputElement.files[0];
                                    if (!file) return;

                                    const reader = new FileReader();
                                    reader.onload = function (e) {
                                        const imgEl = previewContainer.querySelector('img');
                                        imgEl.src = e.target.result;

                                        const gridItem = previewContainer.closest('.grid-item');
                                        if (gridItem) {
                                            gridItem.dataset.image = e.target.result;
                                        }
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>
                        <br>
                        {{--
                        <div class="grid-container" style="display: none;">
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="XGIMtemp_1" name="XGIMtemp_1" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer1" class="image-preview-container">
                                    <!-- <a href="{{ isset($XGIMtemp_1) ? asset('storage/uploads/ePALM/'.$XGIMtemp_1) : asset('storage/uploads/no-photos.png') }}" target="_blank"> -->
                                        <img src="{{ isset($XGIMtemp_1) ? asset('storage/uploads/ePALM/'.$XGIMtemp_1) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    <!-- </a> -->
                                </div>
                            </div>
                            <!-- <br class="mobile-done"> -->
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="XGIMtemp_2" name="XGIMtemp_2" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer2" class="image-preview-container">
                                    <!-- <a href="{{ isset($XGIMtemp_2) ? asset('storage/uploads/ePALM/'.$XGIMtemp_2) : asset('storage/uploads/no-photos.png') }}" target="_blank"> -->
                                        <img src="{{ isset($XGIMtemp_2) ? asset('storage/uploads/ePALM/'.$XGIMtemp_2) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    <!-- </a> -->
                                </div>
                            </div>
                            <!-- <br class="mobile-done"> -->
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="XGIMtemp_3" name="XGIMtemp_3" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer3" class="image-preview-container">
                                    <!-- <a href="{{ isset($XGIMtemp_3) ? asset('storage/uploads/ePALM/'.$XGIMtemp_3) : asset('storage/uploads/no-photos.png') }}" target="_blank"> -->
                                        <img src="{{ isset($XGIMtemp_3) ? asset('storage/uploads/ePALM/'.$XGIMtemp_3) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    <!-- </a> -->
                                </div>
                            </div>
                            <!-- <br class="mobile-done"> -->
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="XGIMtemp_4" name="XGIMtemp_4" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer4" class="image-preview-container">
                                    <!-- <a href="{{ isset($XGIMtemp_4) ? asset('storage/uploads/ePALM/'.$XGIMtemp_4) : asset('storage/uploads/no-photos.png') }}" target="_blank"> -->
                                        <img src="{{ isset($XGIMtemp_4) ? asset('storage/uploads/ePALM/'.$XGIMtemp_4) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    <!-- </a> -->
                                </div>
                            </div>
                            <!-- <br class="mobile-done"> -->
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="XGIMtemp_3" name="XGIMtemp_3" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer3" class="image-preview-container">
                                    <!-- <a href="{{ isset($XGIMtemp_3) ? asset('storage/uploads/ePALM/'.$XGIMtemp_3) : asset('storage/uploads/no-photos.png') }}" target="_blank"> -->
                                        <img src="{{ isset($XGIMtemp_3) ? asset('storage/uploads/ePALM/'.$XGIMtemp_3) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    <!-- </a> -->
                                </div>
                            </div>
                            <!-- <br class="mobile-done"> -->
                            <div class="grid-item">
                                <input type="file" class="form-control-file" id="XGIMtemp_4" name="XGIMtemp_4" accept="image/*" style="display: none;">
                                <div id="XimagePreviewContainer4" class="image-preview-container">
                                    <!-- <a href="{{ isset($XGIMtemp_4) ? asset('storage/uploads/ePALM/'.$XGIMtemp_4) : asset('storage/uploads/no-photos.png') }}" target="_blank"> -->
                                        <img src="{{ isset($XGIMtemp_4) ? asset('storage/uploads/ePALM/'.$XGIMtemp_4) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                    <!-- </a> -->
                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
                <!-- <script>
                    const fileInputs = [
                        { inputId: 'XGIM_1', previewContainerId: 'XimagePreviewContainer1' },
                        { inputId: 'XGIM_2', previewContainerId: 'XimagePreviewContainer2' },
                        { inputId: 'XGIM_3', previewContainerId: 'XimagePreviewContainer3' },
                        { inputId: 'XGIM_4', previewContainerId: 'XimagePreviewContainer4' }
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
                </script> -->
            </div>
        </div>
    </div>
    
    @if((isset($ePALM->kategori_taman) /*&& ($ePALM->kategori_taman == "Landskap Perbandaran") || 1*/) && (!$ePALM->komponen->isEmpty() || (strpos(request()->url(), 'edit') !== false)))
        <div class="row">
            <div class="col-lg col-separator">
                <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-12">
                        <h4 class="d-flex align-items-center justify-content-between">
                            Komponen Landskap
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
                                        <td colspan="5" class="text-center">Tiada Maklumat</td>
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
                        let id_taman = "{{ $ePALM->id_taman ?? '' }}";
                        // Destroy existing DataTable if initialized
                        if ($.fn.DataTable.isDataTable('#projek_table')) {
                            $('#projek_table').DataTable().destroy();
                        }

                        // Clear tbody manually
                        $('#projek_container').html('');
                        $.ajax({
                            url: '/fetchComponents/'+id_taman,  // Define this route in your controller to fetch updated components
                            method: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    // console.log(response.data);
                                    // Populate the container with the new rows
                                    const projekContainer = document.getElementById('projek_container');
                                    if(response.data.length > 0){
                                        response.data.forEach((component, index) => {
                                            let newRow = document.createElement('tr');
                                            newRow.innerHTML = `
                                                <td>${index + 1}</td>
                                                <td>${component.nama_taman}</td>
                                                <td>${component.keterangan_taman}</td>
                                                <td>
                                                    ${component.images.map(url => `
                                                        <img src="${url}" 
                                                            alt="Thumbnail" 
                                                            class="preview-thumbnail" 
                                                            data-toggle="modal" 
                                                            data-target="#imagePreviewModal" 
                                                            data-image="${url}" 
                                                            style="width: 100px; height: 100px; object-fit: cover; margin: 2px; cursor: zoom-in;">
                                                    `).join('')}
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
                                    }else{
                                        let newRow = document.createElement('tr');
                                            newRow.innerHTML = `
                                                <td colspan="6" class="text-center">Tiada Maklumat</td>
                                            `;
                                            projekContainer.appendChild(newRow);
                                    }
                                    // Reinitialize DataTable
                                    $('#projek_table').DataTable({
                                        "pageLength": 2,
                                        "lengthChange": false,
                                        "ordering": true,
                                        "info": false,
                                        "searching": true
                                    });
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
                                    $('#productModal').modal('hide');
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
                                    $('#updateModal').modal('hide');
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
                                    $('#deleteKomponenModal').modal('hide');
                                }
                            });
                        });


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
                        document.getElementById('GIM_1').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer1'));
                        });
                        document.getElementById('GIM_2').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer2'));
                        });
                        document.getElementById('GIM_3').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer3'));
                        });
                        document.getElementById('GIM_4').addEventListener('change', function () {
                            previewImage(this, document.getElementById('imagePreviewContainer4'));
                        });

                        document.body.addEventListener('click', function (e) {
                            if (e.target.classList.contains('preview-thumbnail')) {
                                const imgUrl = e.target.getAttribute('data-image');
                                const modalImg = document.getElementById('modalPreviewImage');
                                modalImg.src = imgUrl;
                                const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                                modal.show();
                            }
                        });
                    });
                </script>
                @php
                    function getImagePaths($ePALM) {
                        $imagePaths = [];

                        // Loop over each komponen and generate image paths
                        foreach ($ePALM->komponen as $komponen) {
                            if (isset($komponen->gambar_taman)) {
                                $folderName = str_replace(' ', '_', $ePALM->id_taman.' '.$ePALM->nama_taman);
                                $subfolderName = str_replace(' ', '_', $komponen->nama_taman);
                                $gambar_tamanData = json_decode($komponen->gambar_taman, true);

                                $GIM_1 = isset($gambar_tamanData['GIM_1']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['GIM_1'] : 'no-photos.png';
                                $GIM_2 = isset($gambar_tamanData['GIM_2']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['GIM_2'] : 'no-photos.png';
                                $GIM_3 = isset($gambar_tamanData['GIM_3']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['GIM_3'] : 'no-photos.png';
                                $GIM_4 = isset($gambar_tamanData['GIM_4']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['GIM_4'] : 'no-photos.png';
                                for ($i = 1; $i <= 6; $i++) {
                                    $fieldKey = "GIM_$i";
                                    $fieldKey2 = "gambar_input_modal_$i";
                                    $$fieldKey = isset($gambar_tamanData[$fieldKey]) ? 'ePALM/' . $folderName . '/' . $subfolderName.'/' . $gambar_tamanData[$fieldKey] : (isset($gambar_tamanData[$fieldKey2]) ? 'ePALM/' . $folderName . '/' . $subfolderName.'/' . $gambar_tamanData[$fieldKey2] : 'no-photos.png');
                                }
                                // Add to the array of image paths
                                $imagePaths[] = [
                                    'nama_taman' => $komponen->nama_taman,
                                    'keterangan_taman' => $komponen->keterangan_taman,
                                    'is_komponen' => $komponen->is_komponen,    
                                    'id_taman' => $komponen->id_taman,  
                                    'status' => $ePALM->status == 'approved' ? $komponen->status : '', 
                                    'images' => [
                                        asset('storage/uploads/' . $GIM_1),
                                        asset('storage/uploads/' . $GIM_2),
                                        asset('storage/uploads/' . $GIM_3),
                                        asset('storage/uploads/' . $GIM_4)
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
                    let imageURLs = <?php echo isset($ePALM->komponen) ? json_encode($imagePaths) : 'false'; ?>;
                    if (imageURLs.length > 0) {
                        document.getElementById('dummy_row')?.remove();
                        createRow();
                        updateBilNumbers();
                    } else {
                        // console.log('is_komponen is not set or no components found. No rows will be added.');
                    }
                    
                    function createRow(){
                        let bilCount = 1;
                        const projekContainer = document.getElementById('projek_container');
                        imageURLs.forEach((component, index) => {
                            let rowClass = component.status === 'draft' ? 'blink-border' : '';
                            // console.log((component.status));
                            let newRow = document.createElement('tr');
                            newRow.className = rowClass;
                            newRow.innerHTML = `
                                <td>${bilCount++}</td>
                                <td>${component.nama_taman}</td>
                                <td>${component.keterangan_taman}</td>
                                <td>
                                    ${component.images.map(url => `
                                        <img src="${url}" 
                                            alt="Thumbnail" 
                                            class="preview-thumbnail" 
                                            data-toggle="modal" 
                                            data-target="#imagePreviewModal" 
                                            data-image="${url}" 
                                            style="width: 100px; height: 100px; object-fit: cover; margin: 2px; cursor: zoom-in;">
                                    `).join('')}
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
                <style>
                    @keyframes blink-border {
                        0%   { border-color: #ff0000; }
                        50%  { border-color: transparent; }
                        100% { border-color: #ff0000; }
                    }

                    .blink-border {
                        border: 2px solid #ff0000;
                        animation: blink-border 1.5s infinite;
                    }
                </style>
                <!-- Fullscreen Image Modal -->
                <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content text-white">
                            <div class="modal-body text-center p-0">
                                <img id="modalPreviewImage" src="" class="img-fluid w-100" alt="Full Size Image">
                            </div>
                            <div class="modal-footer py-2">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables CSS & JS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                @if(!($ePALM->komponen->isEmpty()))
                $('#projek_table').DataTable({
                    "pageLength": 2,
                    "lengthChange": false,
                    "ordering": true, // if you don’t want sorting
                    "info": false, // remove the “Showing X to Y” text
                    "searching": true // optional: disable search if not needed
                });
                @endif
            });
        </script>
    @endif
