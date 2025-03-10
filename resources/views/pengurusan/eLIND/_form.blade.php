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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row">
        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>Butiran Maklumat {{ $capitalizedSegment ?? '' }}</h4>
                </div>
            </div>
            <div class="form-group required inertClass">
                <label for="name" class="col-md-4 control-label">Nama {{ $capitalizedSegment ?? '' }}</label>
                <div class="col-md-12">
                    <input name="name" class="form-control" maxlength="50" type="text" id="name" value="{{ isset($eLIND->name) ? $eLIND->name : '' }}">
                    <input name="jenis_industri" class="form-control" value="{{ $capitalizedSegment }}" type="hidden" id="jenis_industri" >
                </div>
            </div>

            <div class="row">
                <div class="form-group required col-md-6">
                    <label for="address1" class="col-md-4 control-label">Alamat 1</label>
                    <div class="col-md-12">
                        <input value="{{isset($eLIND->address1) ? $eLIND->address1 : ''}}" name="address1" class="form-control" maxlength="50" type="text" id="address1" >
                    </div>
                </div>

                <div class="form-group required col-md-6">
                    <label for="address2" class="col-md-4 control-label">Alamat 2</label>
                    <div class="col-md-12">
                        <input value="{{isset($eLIND->address2) ? $eLIND->address2 : ''}}" name="address2" class="form-control" maxlength="50" type="text" id="address2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group required col-md-2">
                    <label for="postcode" class="col-md-12 control-label">Poskod</label>
                    <div class="col-md-12">
                        <input value="{{isset($eLIND->postcode) ? $eLIND->postcode : ''}}" name="postcode" class="form-control" type="char" id="postcode" >
                    </div>
                </div>

                <div class="form-group required col-md-4">
                    <label for="locality" class="col-md-12 control-label">Bandar</label>
                    <div class="col-md-12">
                        <input value="{{isset($eLIND->locality) ? $eLIND->locality : ''}}" name="locality" class="form-control" maxlength="50" type="text" id="locality">
                    </div>
                </div>

                <div class="form-group required col-md-6">
                    <label for="state" class="col-md-12 control-label">Negeri</label>
                    <div class="col-md-12">
                        <input value="{{isset($eLIND->state) ? $eLIND->state : ''}}" name="state" class="form-control" type="char" id="state" >
                    </div>
                </div>
            </div>

            <!-- <div class="inertClass">
                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="negeri_penggiat" class="col-md-12 control-label">Negeri</label>
                        <div class="col-md-12">
                            {{ Form::select('negeri_penggiat', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="daerah_penggiat" class="col-md-12 control-label">Daerah</label>
                        <div class="col-md-12">
                            {{ Form::select('daerah_penggiat', [], null, ['class' => 'form-control', 'id' => 'daerah']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="mukim_penggiat" class="col-md-12 control-label">Mukim</label>
                        <div class="col-md-12">
                            {{ Form::select('mukim_penggiat', [], null, ['class' => 'form-control', 'id' => 'mukim']) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="parlimen_penggiat" class="col-md-12 control-label">Parlimen</label>
                        <div class="col-md-12">
                            {{ Form::select('parlimen_penggiat', [], null, ['class' => 'form-control', 'id' => 'parlimen']) }}
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="dun_penggiat" class="col-md-12 control-label">Dun</label>
                        <div class="col-md-12">
                            {{ Form::select('dun_penggiat', [], null, ['class' => 'form-control', 'id' => 'dun']) }}
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
                                var negeriSelected = "{{ isset($eLIND->negeri_penggiat) ? $eLIND->negeri_penggiat : '' }}"; // Assuming you have $eLIND->negeri
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
                                        var daerahSelected = "{{ isset($eLIND->daerah_penggiat) ? $eLIND->daerah_penggiat : '' }}"; // Assuming you have $eLIND->daerah
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
                                        var parlimenSelected = "{{ isset($eLIND->parlimen_penggiat) ? $eLIND->parlimen_penggiat : '' }}"; // Assuming you have $eLIND->parlimen
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
                                        var mukimSelected = "{{ isset($eLIND->mukim_penggiat) ? $eLIND->mukim_penggiat : '' }}"; // Assuming you have $eLIND->mukim
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
                                        var dunSelected = "{{ isset($eLIND->dun_penggiat) ? $eLIND->dun_penggiat : '' }}"; // Assuming you have $eLIND->dun
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
            </div> -->

        </div>

        <div class="col-lg col-separator">
            <div class="form-group">
                <label class="col-xs-4 control-label"></label>
                <div class="col-xs-12">
                    <h4>&nbsp;</h4>
                </div>
            </div>
            @if($capitalizedSegment == 'Kontraktor' || $capitalizedSegment == 'Perunding' || $capitalizedSegment == 'Pembekal')
                <div class="row">
                    <div class="form-group required col-md-4">
                        <label for="no_ssm" class="col-md-12 control-label">No. Pendaftaran Syarikat (SSM)</label>
                        <div class="col-md-12">
                            <input value="{{isset($eLIND->no_ssm) ? $eLIND->no_ssm : ''}}" name="no_ssm" class="form-control" maxlength="50" type="text" id="no_ssm" >
                        </div>
                    </div>

                    <div class="form-group required col-md-4">
                        <label for="no_mof" class="col-md-12 control-label">No. Pendaftaran MoF</label>
                        <div class="col-md-12">
                            <input value="{{isset($eLIND->no_mof) ? $eLIND->no_mof : ''}}" name="no_mof" class="form-control" maxlength="50" type="text" id="no_mof" >
                        </div>
                    </div>
                    <div class="form-group required col-md-4">
                        <label for="bilPekerja" class="col-md-12 control-label">Bilangan Pekerja</label>
                        <div class="col-md-12">
                            <input value="{{isset($eLIND->bilPekerja) ? $eLIND->bilPekerja : ''}}" name="bilPekerja" class="form-control" type="number" id="bilPekerja" min="0">
                        </div>
                    </div>
                </div>
                @if($capitalizedSegment == 'Kontraktor')
                    <div class="row">
                        <div class="form-group required col-md-8">
                            <label for="kelas_kontraktor" class="col-md-4 control-label">Kelas Kontraktor</label>
                            <div class="col-md-12">
                                {!! Form::select('kelas_kontraktor', [
                                    1 => 'A',
                                    2 => 'B',
                                    3 => 'BX',
                                    4 => 'C',
                                    5 => 'D',
                                    6 => 'E',
                                    7 => 'EX',
                                    8 => 'F',
                                    0 => 'TIADA MAKLUMAT'
                                ], isset($eLIND->kelas_kontraktor) ? $eLIND->kelas_kontraktor : '0', ['class' => 'form-control', 'id' => 'kelas_kontraktor']) !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label for="no_cidb" class="col-md-12 control-label">No. Pendaftaran PKK/ CIDB</label>
                            <div class="col-md-12">
                                <input value="{{isset($eLIND->no_cidb) ? $eLIND->no_cidb : ''}}" name="no_cidb" class="form-control" maxlength="50" type="text" id="no_cidb" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group required col-md-4">
                            <label for="taraf_bumiputera" class="col-md-12 control-label">Taraf Bumiputera</label>
                            <div class="col-md-12">
                                {!! Form::select('taraf_bumiputera', [
                                    1 => 'BUMIPUTERA',
                                    2 => 'BUKAN BUMIPUTERA',
                                    0 => 'TIADA MAKLUMAT'
                                ], isset($eLIND->taraf_bumiputera) ? $eLIND->taraf_bumiputera : '0', ['class' => 'form-control', 'id' => 'taraf_bumiputera']) !!}
                            </div>
                        </div>
                        <div class="form-group required col-md-4">
                            <label for="status_eperunding" class="col-md-12 control-label">Status e-Perunding</label>
                            <div class="col-md-12">
                                {!! Form::select('status_eperunding', [
                                    1 => 'BERDAFTAR',
                                    2 => 'TIDAK BERDAFTAR',
                                    0 => 'TIADA MAKLUMAT'
                                ], isset($eLIND->status_eperunding) ? $eLIND->status_eperunding : '0', ['class' => 'form-control', 'id' => 'status_eperunding']) !!}
                            </div>
                        </div>
                        <div class="form-group required col-md-4">
                            <label for="bidang_kepakaran" class="col-md-12 control-label">Bidang Kepakaran</label>
                            <div class="col-md-12">
                                {!! Form::select('bidang_kepakaran', [
                                    1 => 'LANDSKAP ARKITEK',
                                    2 => 'ELEKTRIK',
                                    3 => 'SIVIL DAN STRUKTUR',
                                    4 => 'UKURBAHAN',
                                    0 => 'TIADA MAKLUMAT'
                                ], isset($eLIND->bidang_kepakaran) ? $eLIND->bidang_kepakaran : '0', ['class' => 'form-control', 'id' => 'bidang_kepakaran']) !!}
                            </div>
                        </div>
                    </div>
                @elseif($capitalizedSegment == 'Perunding')
                    <div class="row">
                        <div class="form-group required col-md-4">
                            <label for="no_ilam" class="col-md-12 control-label">No. Pendaftaran ILAM</label>
                            <div class="col-md-12">
                                <input value="{{isset($eLIND->no_ilam) ? $eLIND->no_ilam : ''}}" name="no_ilam" class="form-control" maxlength="50" type="text" id="no_ilam" >
                            </div>
                        </div>

                        <div class="form-group required col-md-4">
                            <label for="tarikh_luput_ilam" class="col-md-12 control-label">Tarikh Luput Keahlian ILAM</label>
                            <div class="col-md-12">
                                <input value="{{isset($eLIND->tarikh_luput_ilam) ? $eLIND->tarikh_luput_ilam : ''}}" name="tarikh_luput_ilam" class="form-control" maxlength="50" type="date" id="tarikh_luput_ilam" >
                            </div>
                        </div>
                        <div class="form-group required col-md-4">
                            <label for="status_eperunding" class="col-md-12 control-label">Status e-Perunding</label>
                            <div class="col-md-12">
                                {!! Form::select('status_eperunding', [
                                    1 => 'BERDAFTAR',
                                    2 => 'TIDAK BERDAFTAR',
                                    0 => 'TIADA MAKLUMAT'
                                ], isset($eLIND->status_eperunding) ? $eLIND->status_eperunding : '0', ['class' => 'form-control', 'id' => 'status_eperunding']) !!}
                            </div>
                        </div>
                    </div>
                @elseif($capitalizedSegment == 'Pembekal')
                    <div class="row">
                        <div class="form-group required col-md-6">
                            <label for="bidang_pembekal" class="col-md-12 control-label">Bidang</label>
                            <div class="col-md-12">
                                {!! Form::select('bidang_pembekal', [
                                    1 => 'Nurseri & Landskap Kejur',
                                    2 => 'Alat Permainan',
                                    3 => 'Lain-lain',
                                    0 => 'Tiada Maklumat'
                                ], isset($eLIND->bidang_pembekal) ? $eLIND->bidang_pembekal : '0', ['class' => 'form-control', 'id' => 'bidang_pembekal', 'onchange' => 'handleBidangChange()']) !!}
                            </div>
                        </div>
                        <div class="form-group required col-md-6" style="display: none;" id="lainLainDiv">
                            <label for="bidang_lain_pembekal" class="col-md-12 control-label">Sila Nyatakan (Contoh: Pasu, Baja, Bunga dll.)</label>
                            <div class="col-md-12">
                                <input value="{{isset($eLIND->bidang_lain_pembekal) ? $eLIND->bidang_lain_pembekal : ''}}" name="bidang_lain_pembekal" class="form-control" maxlength="50" type="text" id="bidang_lain_pembekal">
                            </div>
                        </div>

                        <div class="form-group required col-md-6" style="display: none;" id="nurseriDiv">
                            <label for="saiz_nurseri" class="col-md-12 control-label">Saiz Nurseri</label>
                            <div class="col-md-12">
                                {!! Form::select('saiz_nurseri', [
                                    1 => '< 2 EKAR',
                                    2 => '2 - 10 EKAR',
                                    3 => '> 10 EKAR',
                                    0 => 'TIADA MAKLUMAT'
                                ], isset($eLIND->saiz_nurseri) ? $eLIND->saiz_nurseri : '0', ['class' => 'form-control', 'id' => 'saiz_nurseri']) !!}
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            if ($('#bidang_pembekal').val()) {
                                handleBidangChange();
                            }
                        });
                        const bidangDropdown = document.getElementById('bidang_pembekal');
                        const lainLainDiv = document.getElementById('lainLainDiv');
                        const nurseriDiv = document.getElementById('nurseriDiv');

                        // Function to handle the change event of the dropdown
                        function handleBidangChange() {
                            if (bidangDropdown.value === '3') {
                                lainLainDiv.style.display = 'block'; 
                                nurseriDiv.style.display = 'none'; // Show the textbox if "Lain-lain" is selected
                            } else if (bidangDropdown.value === '1') {
                                nurseriDiv.style.display = 'block';
                                lainLainDiv.style.display = 'none';  // Show the textbox if "Lain-lain" is selected
                            } else {
                                lainLainDiv.style.display = 'none'; 
                                nurseriDiv.style.display = 'none'; // Hide the textbox for other options
                            }
                        }
                    </script>
                @endif
            @elseif($lastSegment == 'antarabangsa')
                <div class="row">
                    <div class="form-group required col-md-6">
                        <label for="nama_presiden" class="col-md-12 control-label">Presiden/Pengurus  {{ $capitalizedSegment }}</label>
                        <div class="col-md-12">
                            <input value="{{isset($eLIND->nama_presiden) ? $eLIND->nama_presiden : ''}}" name="nama_presiden" class="form-control" maxlength="50" type="text" id="nama_presiden" >
                        </div>
                    </div>

                    <div class="form-group required col-md-6">
                        <label for="wakil_negara" class="col-md-12 control-label">Wakil Negara/Asia</label>
                        <div class="col-md-12">
                            <input value="{{isset($eLIND->wakil_negara) ? $eLIND->wakil_negara : ''}}" name="wakil_negara" class="form-control" maxlength="50" type="text" id="wakil_negara" >
                        </div>
                    </div>
                </div>
            @elseif($lastSegment == 'ngo')
                <div class="row">
                    <div class="form-group required col-md-6">
                        <label for="kategori_ngo" class="col-md-12 control-label">Kategori  {{ $capitalizedSegment }}</label>
                        <div class="col-md-12">
                            {!! Form::select('kategori_ngo', [
                                1 => 'Badan Bukan Kerajaan (NGO)',
                                2 => 'Badan Ikhtisas',
                                0 => 'Tiada Maklumat'
                            ], isset($eLIND->kategori_ngo) ? $eLIND->kategori_ngo : '0', ['class' => 'form-control', 'id' => 'kategori_ngo']) !!}
                        </div>
                    </div>
                    <div class="form-group required col-md-6">
                        <label for="nama_presiden" class="col-md-12 control-label">Presiden/Pengurus  {{ $capitalizedSegment }}</label>
                        <div class="col-md-12">
                            <input value="{{isset($eLIND->nama_presiden) ? $eLIND->nama_presiden : ''}}" name="nama_presiden" class="form-control" maxlength="50" type="text" id="nama_presiden" >
                        </div>
                    </div>
                </div>
            @elseif($lastSegment == 'pendidikan')
                <div class="row">
                    <div class="form-group required col-md-12">
                        <label for="jenis_institusi" class="col-md-12 control-label">Jenis {{ $capitalizedSegment }}</label>
                        <div class="col-md-12">
                            {!! Form::select('jenis_institusi', [
                                1 => 'IPTA',
                                2 => 'IPTS',
                                3 => 'KOLEJ',
                                4 => 'SEKOLAH',
                                0 => 'TIADA MAKLUMAT'
                            ], isset($eLIND->jenis_institusi) ? $eLIND->jenis_institusi : '0', ['class' => 'form-control', 'id' => 'jenis_institusi']) !!}
                        </div>
                    </div>
                </div>
            @endif

            
            <div class="row">
                @php
                    if(isset($eLIND->mediaSosial_penggiat)){
                        $mediaSosial_penggiatData = json_decode($eLIND->mediaSosial_penggiat, true);
                        $media1 = isset($mediaSosial_penggiatData['Telefon']) ? $mediaSosial_penggiatData['Telefon'] : '';
                        $media2 = isset($mediaSosial_penggiatData['Emel']) ? $mediaSosial_penggiatData['Emel'] : '';
                        $media3 = isset($mediaSosial_penggiatData['Web']) ? $mediaSosial_penggiatData['Web'] : '';
                        $media4 = isset($mediaSosial_penggiatData['Facebook']) ? $mediaSosial_penggiatData['Facebook'] : '';
                        $media5 = isset($mediaSosial_penggiatData['Instagram']) ? $mediaSosial_penggiatData['Instagram'] : '';
                        $media6 = isset($mediaSosial_penggiatData['LinkedIn']) ? $mediaSosial_penggiatData['LinkedIn'] : '';
                        $media7 = isset($mediaSosial_penggiatData['Twitter']) ? $mediaSosial_penggiatData['Twitter'] : '';
                        $media8 = isset($mediaSosial_penggiatData['TikTok']) ? $mediaSosial_penggiatData['TikTok'] : '';
                        //dd($mediaSosial_penggiatData);
                    }else{
                        $media1 = null; 
                        $media2 = null; 
                        $media3 = null; 
                        $media4 = null; 
                        $media5 = null; 
                        $media6 = null; 
                        $media7 = null; 
                        $media8 = null; 
                        $media9 = null; 
                    }
                @endphp
                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Telefon</label>
                    <div class="col-md-12">
                        <input value="{{$media1}}" name="mediaSosial_penggiat[Telefon]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Emel</label>
                    <div class="col-md-12">
                        <input value="{{$media2}}" name="mediaSosial_penggiat[Emel]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Laman Web</label>
                    <div class="col-md-12">
                        <input value="{{$media3}}" name="mediaSosial_penggiat[Web]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Facebook</label>
                    <div class="col-md-12">
                        <input value="{{$media4}}" name="mediaSosial_penggiat[Facebook]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Instagram</label>
                    <div class="col-md-12">
                        <input value="{{$media5}}" name="mediaSosial_penggiat[Instagram]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">LinkedIn</label>
                    <div class="col-md-12">
                        <input value="{{$media6}}" name="mediaSosial_penggiat[LinkedIn]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">Twitter (X)</label>
                    <div class="col-md-12">
                        <input value="{{$media7}}" name="mediaSosial_penggiat[Twitter]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>

                <div class="form-group required col-md-3">
                    <label for="mediaSosial" class="col-md-12 control-label">TikTok</label>
                    <div class="col-md-12">
                        <input value="{{$media8}}" name="mediaSosial_penggiat[TikTok]" class="form-control" maxlength="50" type="text" id="mediaSosial_penggiat[]" >
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@if($capitalizedSegment == 'Kontraktor' || $capitalizedSegment == 'Perunding' || $capitalizedSegment == 'Pembekal')
    <div class="col-lg">
        <div class="row col-md-12">
            <div class="col-lg col-separator">
                <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-12">
                        <h4 class="d-flex align-items-center justify-content-between">
                            Senarai Pekerja
                            <button type="button" class="btn btn-primary btn-sm showButton" id="addPekerja">
                                Tambah Pekerja
                            </button>
                        </h4>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="table-responsive">
                            <table id="pekerja_table" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <style>
                                        #pekerja_table th, #pekerja_table td {
                                            padding: 2px 5px; /* Minimal padding for smaller cells */
                                            text-align: center; /* Center text horizontally */
                                            height: auto; /* Let the height adjust based on content */
                                        }

                                        #pekerja_table td input {
                                            padding: 3px 5px; /* Small padding inside input fields */
                                            height: 25px; /* Small height for input fields */
                                            font-size: 12px; /* Smaller font size for compact input fields */
                                        }

                                        #pekerja_table th {
                                            padding: 3px 5px; /* Slightly more padding for headers */
                                            font-size: 12px; /* Smaller font size for headers */
                                        }
                                    </style>
                                    <tr>
                                        <th class="w-1">Bil</th>
                                        <th class="w-30">Nama Pekerja</th>
                                        <th class="w-5">Jawatan</th>
                                        <th class="w-1">Tindakan</th>
                                    </tr>
                                </thead>
                                @if(isset($eLIND->pekerja))
                                <?php $dataPekerja = json_decode($eLIND->pekerja, true); //dd($dataPekerja); ?>
                                <tbody id="pekerja_container">
                                    @forelse($dataPekerja as $index => $value)
                                        <tr id="pekerja_row-{{ $index + 1 }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td><input type="text" name="pekerja[{{ $index + 1 }}][nama]" class="form-control" value="{{ $value['nama'] }}"></td>
                                            <td><input type="text" name="pekerja[{{ $index + 1 }}][jawatan]" class="form-control" value="{{ $value['jawatan'] }}"></td>
                                            <td style="text-align: center;">
                                                <button type="button" class="btn btn-danger btn-sm" data-row="pekerja_row-{{ $index + 1 }}"  onclick="confirmDelete_pekerja(this)" style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="pekerja_rowD">
                                            <td colspan="4" class="text-center">Tiada Maklumat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @else
                                <tbody id="pekerja_container">
                                    <tr id="pekerja_rowD">
                                        <td colspan="4" class="text-center">Tiada Maklumat</td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        let rowCount = {{ count($dataPekerja ?? []) }};  // Start counting based on existing data

                        // Add a new row
                        function addNewRow() {
                            rowCount++;

                            let newRow = `
                                <tr id="pekerja_row-${rowCount}">
                                    <td>${rowCount}</td>
                                    <td><input type="text" name="pekerja[${rowCount}][nama]" class="form-control" placeholder="Nama"></td>
                                    <td><input type="text" name="pekerja[${rowCount}][jawatan]" class="form-control" placeholder="Jawatan"></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-danger btn-sm delete-row" data-row="pekerja_row-${rowCount}" style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            
                            // Append new row to the table
                            $('#pekerja_container').append(newRow);
                            $('#pekerja_rowD').hide();  // Hide the "Tiada Maklumat" row if it exists
                            const rows = document.querySelectorAll('#pekerja_container tr');
                            rows.forEach((row, index) => {
                                if (row.id !== 'pekerja_row') {  // Skip the "Tiada Maklumat" row (id="pekerja_row")
                                    const bilCell = row.querySelector('td:first-child');
                                    bilCell.textContent = index + 1;  // Update the "Bil" (row number)
                                }
                            });
                        }

                        window.confirmDelete_pekerja = function(button) {
                            // Show a confirmation dialog
                            if (confirm("Are you sure you want to delete this row?")) {
                                // If the user confirms, delete the row
                                let rowId = $(button).data('row');
                                $(`#${rowId}`).remove();
                                const rows = document.querySelectorAll('#pekerja_container tr');
                                rows.forEach((row, index) => {
                                    if (row.id !== 'pekerja_row') {  // Skip the "Tiada Maklumat" row (id="pekerja_row")
                                        const bilCell = row.querySelector('td:first-child');
                                        bilCell.textContent = index + 1;  // Update the "Bil" (row number)
                                    }
                                });
                            }
                        };

                        // Add a new row when the "Tambah Pekerja" button is clicked
                        $('#addPekerja').on('click', function() {
                            addNewRow();  // Add new empty row
                        });

                        // Handle row deletion
                        $(document).on('click', '.delete-row', function() {
                            let rowId = $(this).data('row');
                            $(`#${rowId}`).remove();
                            const rows = document.querySelectorAll('#pekerja_container tr');
                            rows.forEach((row, index) => {
                                if (row.id !== 'pekerja_row') {  // Skip the "Tiada Maklumat" row (id="pekerja_row")
                                    const bilCell = row.querySelector('td:first-child');
                                    bilCell.textContent = index + 1;  // Update the "Bil" (row number)
                                }
                            });
                            
                            // if ($('#pekerja_container tr').length === 0) {
                            //     $('#pekerja_rowD').show();
                            // }
                        });

                        // Update the Bil numbers
                        function updateBilPekerja() {
                            const rows = document.querySelectorAll('#pekerja_container tr');
                            rows.forEach((row, index) => {
                                if (row.id !== 'pekerja_row') {  // Skip the "Tiada Maklumat" row (id="pekerja_row")
                                    const bilCell = row.querySelector('td:first-child');
                                    bilCell.textContent = index + 1;  // Update the "Bil" (row number)
                                }
                            });
                        }
                    });
                </script>
            </div>
        </div>
        @if($capitalizedSegment == 'Kontraktor' || $capitalizedSegment == 'Perunding')
        <div class="row col-md-12">
            <div class="col-lg col-separator">
                <div class="form-group">
                    <label class="col-xs-4 control-label"></label>
                    <div class="col-xs-12">
                        <h4 class="d-flex align-items-center justify-content-between">
                            Senarai Pengalaman
                            <button type="button" class="btn btn-primary btn-sm showButton" id="addPengalaman">
                                Tambah Pengalaman
                            </button>
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
                                        <th class="w-1">Tindakan</th>
                                    </tr>
                                </thead>
                                @if(isset($eLIND->pengalaman))
                                <?php $dataPengalaman = json_decode($eLIND->pengalaman, true); //dd($dataPengalaman); ?>
                                <tbody id="pengalaman_container">
                                    @forelse($dataPengalaman as $index => $value)
                                        <tr id="pengalaman_row-{{ $index + 1 }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td><input type="text" name="pengalaman[{{ $index + 1 }}][tajuk]" class="form-control" value="{{ $value['tajuk'] }}"></td>
                                            <td><input type="text" name="pengalaman[{{ $index + 1 }}][kos]" class="form-control" value="{{ $value['kos'] }}"></td>
                                            
                                            <td><input type="text" name="pengalaman[{{ $index + 1 }}][tahun]" class="form-control" value="{{ $value['tahun'] }}"></td>

                                            <td><input type="text" name="pengalaman[{{ $index + 1 }}][status]" class="form-control" value="{{ $value['status'] }}"></td>
                                            <td style="text-align: center;">
                                                <button type="button" class="btn btn-danger btn-sm" data-row="pengalaman_row-{{ $index + 1 }}"  onclick="confirmDelete_pengalaman(this)" style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="pengalaman_rowD">
                                            <td colspan="4" class="text-center">Tiada Maklumat</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @else
                                <tbody id="pengalaman_container">
                                    <tr id="pengalaman_rowD">
                                        <td colspan="4" class="text-center">Tiada Maklumat</td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        let rowCount = {{ count($dataPengalaman ?? []) }};  // Start counting based on existing data

                        // Function to add a new row
                        function addNewRow() {
                            // Increase row count
                            rowCount++;

                            // Insert new row
                            let newRow = `
                                <tr id="pengalaman_row-${rowCount}">
                                    <td>${rowCount}</td>
                                    <td><input type="text" name="pengalaman[${rowCount}][tajuk]" placeholder="Tajuk" class="form-control"></td>
                                    <td><input type="text" name="pengalaman[${rowCount}][kos]" placeholder="Kos" class="form-control"></td>
                                    <td><input type="text" name="pengalaman[${rowCount}][tahun]" placeholder="Tahun" class="form-control"></td>
                                    <td><input type="text" name="pengalaman[${rowCount}][status]" placeholder="Status" class="form-control"></td>
                                    <td style="padding: 0; vertical-align: middle; text-align: center;">
                                        <button type="button" class="btn btn-danger btn-sm delete-row" data-row="pengalaman_row-${rowCount}" 
                                                style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;

                            // Append the new row to the table
                            $('#pengalaman_container').append(newRow);
                            $('#pengalaman_rowD').hide();  // Hide the "Tiada Maklumat" row if it exists
                            const rows = document.querySelectorAll('#pengalaman_container tr');
                            rows.forEach((row, index) => {
                                if (row.id !== 'pengalaman_row') {
                                    const bilCell = row.querySelector('td:first-child');
                                    bilCell.textContent = index+1 ;
                                }
                            });
                        }

                        window.confirmDelete_pengalaman = function(button) {
                            // Show a confirmation dialog
                            if (confirm("Are you sure you want to delete this row?")) {
                                // If the user confirms, delete the row
                                let rowId = $(button).data('row');
                                $(`#${rowId}`).remove();
                                const rows = document.querySelectorAll('#pengalaman_container tr');
                                rows.forEach((row, index) => {
                                    if (row.id !== 'pengalaman_row') {
                                        const bilCell = row.querySelector('td:first-child');
                                        bilCell.textContent = index+1 ;
                                    }
                                });  // Recalculate the row numbers after deletion
                            }
                        };

                        // Function to update the Bil numbers
                        function updateBilPengalaman() {
                            const rows = document.querySelectorAll('#pengalaman_container tr');
                            rows.forEach((row, index) => {
                                if (row.id !== 'pengalaman_row') {
                                    const bilCell = row.querySelector('td:first-child');
                                    bilCell.textContent = index ;
                                }
                            });
                        }
                        $('#addPengalaman').on('click', function() {
                            addNewRow();
                        });
                        $(document).on('click', '.delete-row', function() {
                            let rowId = $(this).data('row');
                            $(`#${rowId}`).remove();
                            const rows = document.querySelectorAll('#pengalaman_container tr');
                            rows.forEach((row, index) => {
                                if (row.id !== 'pengalaman_row') {
                                    const bilCell = row.querySelector('td:first-child');
                                    bilCell.textContent = index+1 ;
                                }
                            });
                            if ($('#pengalaman_container tr').length === 0) {
                                $('#pengalaman_rowD').show();
                            }
                        });
                    });
                </script>
            </div>
        </div>
        @elseif($capitalizedSegment == 'Pembekal')
            <div class="row col-md-12">
                <div class="col-lg col-separator">
                    <div class="form-group">
                        <label class="col-xs-4 control-label"></label>
                        <div class="col-xs-12">
                            <h4 class="d-flex align-items-center justify-content-between">
                                Produk {{$capitalizedSegment}}
                                <button type="button" class="btn btn-primary btn-sm showButton" id="addProductBtn">
                                    Tambah Produk
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
                                        
                                        <style>
                                            /* Container for the grid with files and previews */
                                            .grid-container {
                                                display: grid;
                                                grid-template-columns: 1fr 1fr; /* 2 equal-width columns */
                                                gap: 10px; /* Space between grid items */
                                                width: 100%;  /* Ensure the grid fills available width */
                                                max-width: 600px;  /* Limit max width for grid */
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
                                                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                                                gap: 10px;
                                                margin-top: 10px;
                                                width: 100%;
                                                overflow-y: auto; /* Allow scrolling if the preview exceeds height */
                                            }

                                            .image-preview-container img {
                                                width: 100%;
                                                height: 100px;
                                                object-fit: cover;
                                                border-radius: 5px;
                                                border: 1px solid #ddd;
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

                                        <script>
                                            // Function to handle image preview
                                            function previewImage(input, previewContainer) {
                                                const files = input.files;

                                                // Clear the current preview
                                                previewContainer.innerHTML = '';

                                                // Loop through the selected files
                                                for (let i = 0; i < files.length; i++) {
                                                    const file = files[i];
                                                    const imgElement = document.createElement('img');

                                                    // Create a URL for the file and set it as the source for the image element
                                                    imgElement.src = URL.createObjectURL(file);

                                                    previewContainer.appendChild(imgElement);
                                                }
                                            }
                                        </script>

                                        <tr>
                                            <th class="w-1">Bil</th>
                                            <th class="w-10">Nama Produk</th>
                                            <th class="w-10">Keterangan</th>
                                            <th class="w-5">Harga</th>
                                            <th class="w-15">Gambar</th>
                                            <th class="w-1">Tindakan</th>
                                        </tr>
                                    </thead>
                                    @if(isset($eLIND->produk))
                                        <tbody id="projek_container">
                                            <?php $dataProduk = json_decode($eLIND->produk, true); //dd($dataProduk); ?>
                                            @forelse ($dataProduk as $index => $product)
                                                <tr id="produk_row-{{ $index + 1 }}">
                                                    <td>{{ ($index + 1) }}</td>
                                                    <td><input type="text" class="form-control" name="produk[{{ $index + 1 }}][nama]" value="{{ $product['nama'] }}" placeholder="Masukkan Nama Produk"></td>
                                                    <td><input type="text" class="form-control" name="produk[{{ $index + 1 }}][keterangan]" value="{{ $product['keterangan'] }}" placeholder="Masukkan Keterangan Produk"></td>
                                                    <td><input type="number" class="form-control" name="produk[{{ $index + 1 }}][harga]" value="{{ $product['harga'] }}" placeholder="Masukkan Harga" min="1"></td>
                                                    <td>
                                                        <div class="grid-container">
                                                            <div class="grid-item">
                                                                <input type="file" class="form-control-file showButton" id="gambar_produk_1_{{ $index + 1 }}" name="produk[{{ $index + 1 }}][gambar_produk_1]" accept="image/*">
                                                                <div id="imagePreviewContainer_1_{{ $index + 1 }}" class="image-preview-container">
                                                                    @if(isset($product['gambar_produk_1']))
                                                                        <input type="hidden" class="form-control" name="produk[{{ $index + 1 }}][existing_image1]" value="{{ $product['gambar_produk_1'] }}" placeholder="Masukkan Harga" min="1">
                                                                        <img src="{{ asset('storage/uploads/eLIND/' . str_replace(' ', '_', $eLIND->name) . '/' . str_replace(' ', '_', $product['nama']). '/' . $product['gambar_produk_1']) }}" alt="Image Preview">
                                                                    @else
                                                                        <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="No Image">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="grid-item">
                                                                <input type="file" class="form-control-file showButton" id="gambar_produk_2_{{ $index + 1 }}" name="produk[{{ $index + 1 }}][gambar_produk_2]" accept="image/*">
                                                                <div id="imagePreviewContainer_2_{{ $index + 1 }}" class="image-preview-container">
                                                                    @if(isset($product['gambar_produk_2']))
                                                                        <input type="hidden" class="form-control" name="produk[{{ $index + 1 }}][existing_image2]" value="{{ $product['gambar_produk_2'] }}" placeholder="Masukkan Harga" min="1">
                                                                        <img src="{{ asset('storage/uploads/eLIND/' . str_replace(' ', '_', $eLIND->name) . '/' . str_replace(' ', '_', $product['nama']). '/' . $product['gambar_produk_2']) }}" alt="Image Preview">
                                                                    @else
                                                                        <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="No Image">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{ Form::label('', '***Muatnaik semula akan menggantikan gambar sedia ada.', ['class' => 'col-form-label required-field-create showButton', 'style' => 'font-size: 12px;']) }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" data-row="produk_row-{{ $index + 1 }}"  onclick="confirmDelete_produk(this)" style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tiada Maklumat</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    @else
                                    <tbody id="projek_container">
                                        <tr id="produk_rowD">
                                            <td colspan="6" class="text-center">Tiada Maklumat</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let bilCount = {{ count($dataProduk ?? []) }} + 1;
                    let currentRow = null; // To store the current row when selecting images

                    document.getElementById('projek_container').addEventListener('change', function(event) {
                        if (event.target.type === 'file') {
                            const previewContainerId_1 = event.target.id.replace('gambar_produk_1', 'imagePreviewContainer_1');
                            previewImage(event.target, document.getElementById(previewContainerId_1));
                            const previewContainerId_2 = event.target.id.replace('gambar_produk_2', 'imagePreviewContainer_2');
                            previewImage(event.target, document.getElementById(previewContainerId_2));
                        }
                    });

                    // Add new product row when "Tambah Produk" is clicked
                    document.getElementById('addProductBtn').addEventListener('click', function() {
                        var newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${bilCount}</td>
                            <td><input type="text" class="form-control" name="produk[${bilCount}][nama]" placeholder="Masukkan Nama Produk"></td>
                            <td><input type="text" class="form-control" name="produk[${bilCount}][keterangan]" placeholder="Masukkan Keterangan Produk"></td>
                            <td><input type="number" class="form-control" name="produk[${bilCount}][harga]" placeholder="Masukkan Harga" min="1"></td>
                            <td>
                                <div class="grid-container">
                                    <!-- Dynamic Image Inputs and Preview Containers -->
                                    <div class="grid-item">
                                        <input type="file" class="form-control-file" id="gambar_produk_1_${bilCount}" name="produk[${bilCount}][gambar_produk_1]" accept="image/*">
                                        <div id="imagePreviewContainer_1_${bilCount}" class="image-preview-container"></div>
                                    </div>
                                    <div class="grid-item">
                                        <input type="file" class="form-control-file" id="gambar_produk_2_${bilCount}" name="produk[${bilCount}][gambar_produk_2]" accept="image/*">
                                        <div id="imagePreviewContainer_2_${bilCount}" class="image-preview-container"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove_field" style="font-size: 0.4rem; padding: 0.1rem 0.2rem; height: 20px; width: 20px; line-height: 1; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                </button>
                            </td>
                        `;
                        document.getElementById('projek_container').appendChild(newRow);
                        bilCount++;

                        // Hide the dummy row if it's there
                        var dummyRow = document.getElementById('dummy_row');
                        if (dummyRow) {
                            dummyRow.remove();
                        }

                        updateBilNumbers();
                    });

                    // Function to open the image modal
                    function openImageModal(button) {
                        currentRow = button.closest('tr'); // Store the row where the images will be inserted
                        $('#gambarModal').modal('show');
                    }

                    // Remove a row when "Hapus" button is clicked
                    document.addEventListener('click', function(event) {
                        if (event.target.classList.contains('remove_field')) {
                            event.target.closest('tr').remove();
                            updateBilNumbers();
                        } else if (event.target.classList.contains('image-button')) {
                            openImageModal(event.target); // Open the image modal for the specific row
                        }
                        
                        // if ($('#produk_container tr').length === 0) {
                        //     $('#produk_rowD').show();
                        //     var newRow = document.createElement('tr');
                        //     newRow.innerHTML = `
                        //         <td colspan="6" class="text-center">Tiada Maklumat</td>
                        //     `;
                        //     document.getElementById('projek_container').appendChild(newRow);
                        // }
                    });

                    // Update Bil numbers after deletion
                    function updateBilNumbers() {
                        const rows = document.querySelectorAll('#projek_container tr');
                        rows.forEach((row, index) => {
                            const bilCell = row.querySelector('td:first-child');
                            bilCell.textContent = index + 1;
                        });
                    }

                    window.confirmDelete_produk = function(button) {
                        // Show a confirmation dialog
                        if (confirm("Are you sure you want to delete this row?")) {
                            // If the user confirms, delete the row
                            let rowId = $(button).data('row');
                            $(`#${rowId}`).remove();
                            updateBilNumbers();
                        }
                    };
                });
            </script>
        @endif
    </div>

@endif