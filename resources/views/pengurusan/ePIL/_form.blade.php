
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
    <div class="row inertShow">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            <div class="inertClass">
                <div class="form-group required">
                    <label for="nama_pelan" class="col-md-12 control-label">Tajuk Pelan Induk Landskap</label>
                    <div class="col-md-12">
                        {!! Form::textarea('nama_pelan', null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => '1', 'id' => 'nama_pelan', 'required' => 'required']) !!}
                        <script>
                            // Function to resize textarea based on content
                            function resizeTextarea(textarea) {
                                textarea.style.height = 'auto';  // Reset the height
                                textarea.style.height = (textarea.scrollHeight) + 'px';  // Set the height to scrollHeight
                            }

                            // Call resize function when the page loads
                            window.onload = function() {
                                var textarea = document.getElementById('nama_pelan');
                                resizeTextarea(textarea);  // Resize textarea based on content
                            };
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group required col-md-12">
                        <label for="nama_pbt" class="col-md-12 control-label">Pihak Berkuasa Tempatan</label>
                        <div class="col-md-12">
                            {!! Form::text('nama_pbt', $pbt->pbt_name ?? $ePIL->nama_pbt ?? '', ['class' => 'form-control', 'id' => 'nama_pbt']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group required col-md-6">
                    <label for="alamat1_pelan" class="col-md-4 control-label">Alamat 1</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePIL->alamat1_pelan) ? $ePIL->alamat1_pelan : ''}}" name="alamat1_pelan" class="form-control" maxlength="50" type="text" id="alamat1_pelan" required="required">
                    </div>
                </div>

                <div class="form-group required col-md-6">
                    <label for="alamat2_pelan" class="col-md-4 control-label">Alamat 2</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePIL->alamat2_pelan) ? $ePIL->alamat2_pelan : ''}}" name="alamat2_pelan" class="form-control" maxlength="50" type="text" id="alamat2_pelan">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-8">
                    <label for="alamat3_pelan" class="col-md-12 control-label">Alamat 3</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePIL->alamat3_pelan) ? $ePIL->alamat3_pelan : ''}}" name="alamat3_pelan" class="form-control" maxlength="50" type="text" id="alamat3_pelan">
                    </div>
                </div>

                <div class="form-group required col-md-4">
                    <label for="poskod_pelan" class="col-md-4 control-label">Poskod</label>
                    <div class="col-md-12">
                        <input value="{{isset($ePIL->poskod_pelan) ? $ePIL->poskod_pelan : ''}}" name="poskod_pelan" class="form-control" type="char" id="poskod_pelan" required="required">
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
            <div class="inertClass">
                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="negeri_pelan" class="col-md-12 control-label">Negeri</label>
                        <div class="col-md-12">
                            <!-- {{ Form::select('negeri', ['1' => 'JOHOR'], '1', ['class' => 'form-control', 'id' => 'negeri']) }} -->
                            {{ Form::select('negeri_pelan', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="daerah_pelan" class="col-md-12 control-label">Daerah</label>
                        <div class="col-md-12">
                            {{ Form::select('daerah_pelan', [], null, ['class' => 'form-control', 'id' => 'daerah']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="mukim_pelan" class="col-md-12 control-label">Mukim</label>
                        <div class="col-md-12">
                            {{ Form::select('mukim_pelan', [], null, ['class' => 'form-control', 'id' => 'mukim']) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="parlimen_pelan" class="col-md-12 control-label">Parlimen</label>
                        <div class="col-md-12">
                            {{ Form::select('parlimen_pelan', [], null, ['class' => 'form-control', 'id' => 'parlimen']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="dun_pelan" class="col-md-12 control-label">Dun</label>
                        <div class="col-md-12">
                            {{ Form::select('dun_pelan', [], null, ['class' => 'form-control', 'id' => 'dun']) }}
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
                                var negeriSelected = "{{ isset($ePIL->negeri_pelan) ? $ePIL->negeri_pelan : '' }}"; // Assuming you have $ePIL->negeri
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
                                        var daerahSelected = "{{ isset($ePIL->daerah_pelan) ? $ePIL->daerah_pelan : '' }}"; // Assuming you have $ePIL->daerah
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
                                        var parlimenSelected = "{{ isset($ePIL->parlimen_pelan) ? $ePIL->parlimen_pelan : '' }}"; // Assuming you have $ePIL->parlimen
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
                                        var mukimSelected = "{{ isset($ePIL->mukim_pelan) ? $ePIL->mukim_pelan : '' }}"; // Assuming you have $ePIL->mukim
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
                                        var dunSelected = "{{ isset($ePIL->dun_pelan) ? $ePIL->dun_pelan : '' }}"; // Assuming you have $ePIL->dun
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
                @php
                    if(isset($ePIL->mediaSosial_pelan)){
                        $mediaSosial_pelanData = json_decode($ePIL->mediaSosial_pelan, true);
                        $media1 = isset($mediaSosial_pelanData['Telefon']) ? $mediaSosial_pelanData['Telefon'] : '';
                        $media2 = isset($mediaSosial_pelanData['Emel']) ? $mediaSosial_pelanData['Emel'] : '';
                        $media3 = isset($mediaSosial_pelanData['Web']) ? $mediaSosial_pelanData['Web'] : '';
                        $media4 = isset($mediaSosial_pelanData['Facebook']) ? $mediaSosial_pelanData['Facebook'] : '';
                        $media5 = isset($mediaSosial_pelanData['Instagram']) ? $mediaSosial_pelanData['Instagram'] : '';
                        $media6 = isset($mediaSosial_pelanData['LinkedIn']) ? $mediaSosial_pelanData['LinkedIn'] : '';
                        $media7 = isset($mediaSosial_pelanData['Twitter']) ? $mediaSosial_pelanData['Twitter'] : '';
                        $media8 = isset($mediaSosial_pelanData['TikTok']) ? $mediaSosial_pelanData['TikTok'] : '';
                        //dd($mediaSosial_pelanData);
                    }else{
                        $media1 = ''; 
                        $media2 = isset($pbt->email) ? $pbt->email : ''; 
                        $media3 = ''; 
                        $media4 = ''; 
                        $media5 = ''; 
                        $media6 = ''; 
                        $media7 = ''; 
                        $media8 = ''; 
                        $media9 = ''; 
                    }
                @endphp
                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Telefon</label>
                    <div class="col-md-12">
                        <input value="{{$media1}}" name="mediaSosial_pelan[Telefon]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Emel</label>
                    <div class="col-md-12">
                        <input value="{{$media2}}" name="mediaSosial_pelan[Emel]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Laman Web</label>
                    <div class="col-md-12">
                        <input value="{{$media3}}" name="mediaSosial_pelan[Web]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Facebook</label>
                    <div class="col-md-12">
                        <input value="{{$media4}}" name="mediaSosial_pelan[Facebook]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Instagram</label>
                    <div class="col-md-12">
                        <input value="{{$media5}}" name="mediaSosial_pelan[Instagram]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">LinkedIn</label>
                    <div class="col-md-12">
                        <input value="{{$media6}}" name="mediaSosial_pelan[LinkedIn]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Twitter (X)</label>
                    <div class="col-md-12">
                        <input value="{{$media7}}" name="mediaSosial_pelan[Twitter]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">TikTok</label>
                    <div class="col-md-12">
                        <input value="{{$media8}}" name="mediaSosial_pelan[TikTok]" class="form-control" maxlength="50" type="text" id="mediaSosial_pelan[]" >
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row col-md-12">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4 class="d-flex align-items-center justify-content-between">
                        Fail Pelan Induk Landskap
                        <button type="button" class="btn btn-primary btn-sm showButton" id="addProductBtn">
                            Tambah Fail
                        </button>
                    </h4>
                </div>
            </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="table-responsive">
                            <table id="projek_table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="w-1">Bil</th>
                                        <th class="w-10">Nama Fail</th>
                                        <th class="w-10">Keterangan</th>
                                        <!-- <th class="w-5">Gambar</th> -->
                                        <th class="w-5">Fail</th>
                                        <th class="w-5">Tindakan</th>
                                    </tr>
                                </thead>
                                <!-- <tbody id="projek_container">
                                    <tr id="dummy_row">
                                        <td colspan="6" class="text-center">Tiada Maklumat</td>
                                    </tr>
                                </tbody> -->
                                @if(isset($ePIL->dokumen))
                                <?php $folder = str_replace(' ', '_', $ePIL->nama_pelan); ?>
                                <tbody id="projek_container">
                                    @forelse($ePIL->dokumen as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value['nama_fail'] }}</td>
                                            <td>{{ $value['keterangan_dokumen_pelan'] }}</td>

                                            <!-- <td>
                                                @if($value['gambar_dokumen_pelan'])
                                                    <img src="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$value['gambar_dokumen_pelan']) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                {{ $value['status'] }}
                                            </td> -->

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($value['nama_dokumen_pelan'])
                                                    <canvas id="pdf-render-{{ $value['id_dokumen_pelan'] }}" width="200" height="250"></canvas>
                                                    <?php
                                                        if(isset($value['nama_dokumen_pelan'])){
                                                            $filePath = storage_path('app/public/uploads/ePIL/'.$folder.'/'.$value['nama_dokumen_pelan']);
                                                            if (file_exists($filePath)) {
                                                                $fileSizeInBytes = filesize($filePath);
                                                                $fileSizeInMB = number_format($fileSizeInBytes / 1048576, 2);
                                                            }
                                                        }
                                                    ?>
                                                    {{ $fileSizeInMB . " MB" }}
                                                @else
                                                    No PDF available
                                                @endif
                                            </td>

                                            <td style="text-align: center;">
                                                <div>
                                                    {!! 
                                                        Form::button('<i class="fas fa-eye"></i>', 
                                                        [
                                                            'onclick' => "window.open('".asset('storage/uploads/ePIL/'.$folder.'/'.$value['nama_dokumen_pelan'])."', '_blank');",
                                                            'class' => 'btn btn-primary btn-sm',
                                                            Html::tooltip('Papar PIL')
                                                        ]) 
                                                    !!}
                                                    <a href="{{ asset('storage/uploads/ePIL/'.$folder.'/'.$value['nama_dokumen_pelan']) }}" download="{{ $value['nama_dokumen_pelan'] }}">
                                                        {!! 
                                                            Form::button('<i class="fas fa-download"></i>', 
                                                            [
                                                                'class' => 'btn btn-success btn-sm',
                                                                Html::tooltip('Muat turun PIL')
                                                            ]) 
                                                        !!}
                                                    </a>
                                                    {!! 
                                                        Form::button('<i class="fas fa-pencil-alt"></i>', ['onclick'=>"window.location='".route('pengurusan.ePIL_dokumen.edit',$value)."'", 'class'=>'btn bg-warning btn-sm showButton', Html::tooltip('Kemaskini PIL')]); 
                                                    !!}
                                                    {!! 
                                                        Form::button('<i class="fas fa-trash"></i>', 
                                                        [
                                                            'class' => 'btn btn-danger btn-sm showButton',
                                                            'data-url' => route('pengurusan.ePIL_dokumen.destroy', $value),
                                                            'data-id_pelan' => $value,
                                                            'data-toggle' => 'modal',
                                                            'data-target' => '#modalDelete',
                                                            Html::tooltip('Padam PIL')
                                                        ])  
                                                    !!}
                                                </div>
                                                <div>
                                                    <span style="white-space: normal; text-align: centre;width: 80%;" class="badge {{ $value->status == 'active' ? 'bg-success' : 'bg-danger' }}">{{ $value->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="dummy_row">
                                            <td colspan="6" class="text-center">Tiada Maklumat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
                                <script>
                                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Loop through each document and render the first page of the PDF
                                        @foreach($ePIL->dokumen as $value)
                                            const url_{{ $value['id_dokumen_pelan'] }} = '{{ asset('storage/uploads/ePIL/'.$folder.'/'.$value['nama_dokumen_pelan']) }}';
                                            const canvas_{{ $value['id_dokumen_pelan'] }} = document.getElementById('pdf-render-{{ $value['id_dokumen_pelan'] }}');
                                            const context_{{ $value['id_dokumen_pelan'] }} = canvas_{{ $value['id_dokumen_pelan'] }}.getContext('2d');

                                            // Check if the URL is valid (the document exists)
                                            if (url_{{ $value['id_dokumen_pelan'] }}) {
                                                pdfjsLib.getDocument(url_{{ $value['id_dokumen_pelan'] }}).promise.then(function(pdf) {
                                                    // Fetch the first page
                                                    pdf.getPage(1).then(function(page) {
                                                        const scale = 0.25;  // Adjust scale as needed
                                                        const viewport = page.getViewport({ scale: scale });

                                                        // Set canvas dimensions
                                                        canvas_{{ $value['id_dokumen_pelan'] }}.width = viewport.width;
                                                        canvas_{{ $value['id_dokumen_pelan'] }}.height = viewport.height;

                                                        // Render the page
                                                        page.render({
                                                            canvasContext: context_{{ $value['id_dokumen_pelan'] }},
                                                            viewport: viewport
                                                        });
                                                    });
                                                }).catch(function(error) {
                                                    console.error('Error loading PDF:', error);
                                                    // If there's an error, we can display a placeholder
                                                    const canvas_{{ $value['id_dokumen_pelan'] }} = document.getElementById('pdf-render-{{ $value['id_dokumen_pelan'] }}');
                                                    canvas_{{ $value['id_dokumen_pelan'] }}.innerHTML = '<div class="text-center text-muted">Preview not available</div>';
                                                });
                                            }
                                        @endforeach
                                    });
                                </script>
                                @else
                                <tbody id="projek_container">
                                    <tr id="dummy_row">
                                        <td colspan="6" class="text-center">Tiada Maklumat</td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

            @php
                $folder = isset($ePIL->nama_pelan) ? str_replace(' ', '_', $ePIL->nama_pelan) : 'temp';
            @endphp
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let bilCount = 1;

                    document.getElementById('addProductBtn').addEventListener('click', function () {
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${bilCount}</td>
                            <td><input type="text" class="form-control" name="pelan[${bilCount}][nama_fail]" placeholder="Masukkan Nama Fail"></td>
                            <td><input type="text" class="form-control" name="pelan[${bilCount}][keterangan]" placeholder="Masukkan Keterangan Fail"></td>
                            <!--
                                <td>
                                    <input type="file" class="form-control" name="pelan[${bilCount}][gambar]" id="gambar_${bilCount}" accept="image/*">
                                    <div class="image-preview"></div>
                                </td>
                            -->
                            <td>
                                <input type="file" class="form-control" name="pelan[${bilCount}][fail]" id="fail_${bilCount}" accept="application/pdf">
                                <input name="pelan[${bilCount}][large_file_name_new]" type="hidden" id="large_file_name_new_${bilCount}">
                                <input name="pelan[${bilCount}][large_file_name_old]" type="hidden" id="large_file_name_old_${bilCount}">
                                <input name="pelan[${bilCount}][file_type]" type="hidden" id="file_type_${bilCount}">
                                <input name="pelan[${bilCount}][file_size]" type="hidden" id="file_size_${bilCount}">
                                <div id="progress-container_${bilCount}" style="display: none;">
                                    <div id="progress-bar_${bilCount}" style="width: 100%; background-color: #ccc;">
                                        <div id="progress_${bilCount}" style="height: 20px; width: 0; background-color: green;"></div>
                                    </div>
                                    <p>Uploading: <span id="progress-text_${bilCount}">0%</span></p>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-danger btn-sm remove_field"><i class="fas fa-trash remove_field"></i></button>
                            </td>
                        `;
                        document.getElementById('projek_container').appendChild(newRow);
                        bilCount++;

                        // Hide the dummy row if it's there
                        const dummyRow = document.getElementById('dummy_row');
                        if (dummyRow) {
                            dummyRow.remove();
                        }

                        updateBilNumbers();
                    });

                    // Handle image preview when an image is selected
                    document.getElementById('projek_container').addEventListener('change', function (event) {
                        if (event.target.type === 'file' && event.target.id.startsWith('gambar_')) {
                            const input = event.target;
                            const previewContainer = input.closest('td').querySelector('.image-preview');
                            previewContainer.innerHTML = ''; // Clear any existing preview

                            const file = input.files[0];
                            if (file) {
                                const imgElement = document.createElement('img');
                                imgElement.src = URL.createObjectURL(file); // Direct URL for the image preview
                                imgElement.style.width = '50px';
                                imgElement.style.height = '50px';
                                imgElement.style.objectFit = 'cover';
                                previewContainer.appendChild(imgElement);
                            }
                        }
                    });

                    // Remove a row when "Hapus" button is clicked
                    document.addEventListener('click', function (event) {
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

                    // Chunk file upload for each file input field in the rows
                    document.getElementById('projek_container').addEventListener('change', function (event) {
                        if (event.target.type === 'file' && event.target.id.startsWith('fail_')) {
                            const fileInput = event.target;
                            const rowId = fileInput.id.split('_')[1];
                            const file = fileInput.files[0];
                            let file_size = ((file.size)/1048576).toFixed(2);
                            let file_type = file.type;
                            // console.log(((file.size)/1048576).toFixed(2));
                            // console.log(file.type);
                            if (!file) {
                                alert("No file selected!");
                                return;
                            }

                            const timestamp = new Date().getTime();
                            const chunkSize = 20 * 1024 * 1024; // 10MB per chunk
                            const totalChunks = Math.ceil(file.size / chunkSize);
                            let currentChunk = 0;
                            const destinationFolder = `ePIL/`+`{{$folder}}`+`/`;

                            // Show progress bar
                            const progressContainer = document.getElementById(`progress-container_${rowId}`);
                            progressContainer.style.display = 'block';

                            function uploadNextChunk() {
                                let start = currentChunk * chunkSize;
                                let end = Math.min(start + chunkSize, file.size);
                                let chunkBlob = file.slice(start, end);

                                let formData = new FormData();
                                formData.append('large_file', chunkBlob);
                                formData.append('chunk', currentChunk);
                                formData.append('totalChunks', totalChunks);
                                formData.append('fileName', `${timestamp}_${file.name}`);
                                formData.append('destinationFolder', destinationFolder);
                                formData.append('deleteThis', document.getElementById(`large_file_name_old_${rowId}`).value);

                                // Upload the chunk
                                $.ajax({
                                    url: '/upload-chunk', // Update with the appropriate upload URL
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        currentChunk++;
                                        let progress = Math.round((currentChunk / totalChunks) * 100);
                                        document.getElementById(`progress_${rowId}`).style.width = progress + '%';
                                        document.getElementById(`progress-text_${rowId}`).textContent = progress + '%';

                                        // Continue uploading next chunk
                                        if (currentChunk < totalChunks) {
                                            uploadNextChunk();
                                        } else {
                                            setTimeout(function() {
                                                alert("Upload Complete!");
                                            }, 1000);

                                            // Update the input values with the new file name
                                            document.getElementById(`large_file_name_new_${rowId}`).value = `${timestamp}_${file.name}`;
                                            document.getElementById(`large_file_name_old_${rowId}`).value = `${timestamp}_${file.name}`;
                                            document.getElementById(`file_size_${rowId}`).value = `${file_size}`;
                                            document.getElementById(`file_type_${rowId}`).value = `${file_type}`;
                                            fileInput.value = ''; // Clear the file input
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("Error: " + error);
                                    },
                                    complete: function(xhr, status) {
                                        console.log("Request complete with status: " + status);
                                    }
                                });
                            }

                            // Start the chunk upload process
                            uploadNextChunk();
                        }
                    });
                });
            </script>
        </div>
    </div>
