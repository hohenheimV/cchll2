@php
    $userId = auth()->id();
    $user = \App\User::find($userId);
    $isPBTUser = $user->hasRole('Pihak Berkuasa Tempatan');
    $pbtName = null;
    $pbtNegeri = null;

    if ($isPBTUser) {
        $pbtId = $user->bahagian_jln; // Assuming `bahagian_jln` is the PBT ID
        $pbt = \App\Model\MaklumatPenggunaPbt::find($pbtId);
        $pbtName = $pbt ? $pbt->pbt_name : 'Unknown PBT';
        $pbtNegeri = $pbt ? $pbt->state : 'Unknown Negeri'; 
    }
@endphp
<!-- Nama Kempen and Lokasi -->
<div class="form-row">
    <div class="form-group col-md-9"> <!-- Changed from col-md-8 to col-md-9 -->
        <div class="form-row">
            <div class="form-group col-md-6">
                {{ Form::label('tajuk', 'Nama Program') }}
                {{ Form::text('tajuk', null, [
                    'placeholder' => 'Masukkan Nama Program',
                    'class' => 'form-control ' . ($errors->has('tajuk') ? 'is-invalid' : ''),
                    'oninput' => "this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"
                ]) }}
                @if ($errors->has('tajuk'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tajuk') }}
                    </div>
                @endif
            </div>

            <div class="form-group col-md-5">
                {{ Form::label('lokasi', 'Lokasi') }}
                {{ Form::text('lokasi', null, ['placeholder' => 'Masukkan Lokasi', 
                    'class' => 'form-control ' . ($errors->has('lokasi') ? 'is-invalid' : ''),
                    'oninput' => "this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"
                ]) }}
                @if ($errors->has('lokasi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lokasi') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Negeri and PBT Fields -->
        @if (!$isPBTUser)
        <div class="form-row">
            <div class="form-group col-md-6">
                {{ Form::label('negeri', 'Negeri') }}
                {{ Form::select('negeri', $negeri ?? [], old('negeri', $ktp->negeri ?? null), [
                    'placeholder' => 'Pilih Negeri',
                    'class' => 'form-control select2 ' . ($errors->has('negeri') ? 'is-invalid' : ''),
                    'id' => 'negeri',
                    'onchange' => 'updatePBT()'
                ]) }}
                @if ($errors->has('negeri'))
                    <div class="invalid-feedback">
                        {{ $errors->first('negeri') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-md-5" id="pbt-container">
                {{ Form::label('pbt', 'Pihak Berkuasa Tempatan / Agensi') }} 
                <!-- Loading Spinner -->
                <div id="loading-spinner" style="display: none;">Muatnaik Maklumat...</div>
                {{ Form::select('pbt', $pbt ?? [], old('pbt', $ktp->pbt ?? null), [
                    'class' => 'form-control select2 ' . ($errors->has('pbt') ? 'is-invalid' : ''),
                    'data-toggle' => 'tooltip',
                    'title' => 'Sila Pilih Negeri Terlebih Dahulu',
                    'id' => 'pbt',
                    'autocomplete' => 'off',
                    'oninput' => "this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"
                ]) }}
                @if ($errors->has('pbt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pbt') }}
                    </div>
                @endif
            </div>
        </div>
        @else
            <!-- Display PBT Name -->
            <div class="form-group col-md-5">
                <!-- <label for="pbt_name">Pihak Berkuasa Tempatan</label>
                <input type="text" class="form-control" id="pbt_name" value="{{ $pbtName }}" readonly> -->
                <input type="hidden" name="negeri" value="{{ $pbtNegeri }}"> <!-- Hidden input for form submission -->
                <input type="hidden" name="pbt" value="{{ $pbtName }}"> <!-- Hidden input for form submission -->
            </div>
        @endif
        <!-- Spesis Pokok & Jumlah Pokok -->
        <div class="form-row">
            <div class="form-group col-md-11">
                {{ Form::label('maklumat', 'Maklumat Pokok') }}
                
                <div class="table-responsive">
                    <table id="spesis-pokok-table" class="table table-bordered table-hover mt-2">
                        <thead class="thead-dark">
                            <style>
                                #spesis-pokok-table th {
                                    padding: 5px 5px;  /* Adjust the padding for header cells */
                                    text-align: center;  /* Center the text for better alignment */
                                }
                            </style>
                            <tr>
                                <th class="w-30">Spesis Pokok</th>
                                <th class="w-15">Bilangan Pokok</th>
                                <th class="w-15">Tinggi (m)</th>
                                <th class="w-15">Diameter (cm)</th>
                                <th class="w-8">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="spesis_pokok_container" class="align-items-center">
                                @if(isset($spesisPokokJumlahPairs) && count($spesisPokokJumlahPairs) > 0)
                                    @foreach ($spesisPokokJumlahPairs as $index => $pair)
                                    <tr>
                                        <td><input type="text" name="spesis_pokok[]" class="form-control @error('spesis_pokok.*') is-invalid @enderror" value="{{ $pair['spesis'] }}" placeholder="Spesis Pokok" oninput="this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"></td>
                                        <td><input type="number" name="bilangan_pokok[]" class="form-control bilangan-pokok @error('bilangan_pokok.*') is-invalid @enderror" value="{{ $pair['bilangan'] }}" placeholder="Bilangan" min="1" max="10000"></td>
                                        <td><input type="number" name="tinggi_pokok[]" class="form-control @error('tinggi_pokok.*') is-invalid @enderror" value="{{ $pair['tinggi'] }}" placeholder="Tinggi" min="0" max="1000"></td>
                                        <td><input type="number" name="diameter_pokok[]" class="form-control @error('diameter_pokok.*') is-invalid @enderror" value="{{ $pair['diameter'] }}" placeholder="Diameter" min="0" max="1000"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove_field"><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" name="spesis_pokok[]" class="form-control @error('spesis_pokok.*') is-invalid @enderror" placeholder="Spesis Pokok" oninput="this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"></td>
                                        <td><input type="number" name="bilangan_pokok[]" class="form-control bilangan-pokok @error('bilangan_pokok.*') is-invalid @enderror" placeholder="Bilangan"  min="1" max="10000"></td>
                                        <td><input type="number" name="tinggi_pokok[]" class="form-control @error('tinggi_pokok.*') is-invalid @enderror" placeholder="Tinggi"  min="0" max="1000"></td>
                                        <td><input type="number" name="diameter_pokok[]" class="form-control @error('diameter_pokok.*') is-invalid @enderror" placeholder="Diameter"  min="0" max="1000"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove_field"><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                @endif
                                @error('spesis_pokok.*')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </tbody>
                    </table>
                </div>
                <div>
                    <button type="button" class="btn btn-light btn-sm mt-2" id="add_spesis_pokok"><i class="fas fa-plus"></i> Tambah Spesis</button>
                </div>

                <!-- Hidden input to store the serialized data-->
                <input type="hidden" name="serialized_spesis_pokok" id="serialized_spesis_pokok">
                <input type="hidden" name="jumlah_tanam_pokok" id="jumlah_tanam_pokok"> 
            </div>
        </div>
    </div>
    <div class="form-group col-md-3"> <!-- Changed from col-md-4 to col-md-3 -->
        {{ Form::label('jumlah_pokok', 'Jumlah Keseluruhan Pokok Ditanam') }}
        <p id="jumlah_pokok" class="form-control-static" style="font-size: 2.5rem; font-weight: bold; text-align:center;"></p>
        <input type="hidden" name="jumlah_pokok" id="jumlah_pokok_hidden"> <!-- Hidden input field -->
    </div>
</div>

@section('page-js-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateJumlahPokok() {
            var total = 0;
            document.querySelectorAll('.bilangan-pokok').forEach(function(input) {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('jumlah_pokok').textContent = total;
            document.getElementById('jumlah_pokok_hidden').value = total; // Update hidden input
        }

        document.getElementById('add_spesis_pokok').addEventListener('click', function() {
            var container = document.getElementById('spesis_pokok_container');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="spesis_pokok[]" class="form-control" placeholder="Spesis Pokok" oninput="this.value = this.value.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); })"></td>
                <td><input type="number" name="bilangan_pokok[]" class="form-control bilangan-pokok" placeholder="Bilangan" min="1"></td>
                <td><input type="number" name="tinggi_pokok[]" class="form-control" placeholder="Tinggi" min="0"></td>
                <td><input type="number" name="diameter_pokok[]" class="form-control" placeholder="Diameter" min="0"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove_field"><i class="fas fa-trash"></i></button></td>
            `;
            container.appendChild(newRow);
            updateJumlahPokok();
        });

        // Remove dynamic fields
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove_field')) {
                event.target.closest('tr').remove();
                updateJumlahPokok();
            }
        });

        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('bilangan-pokok')) {
                updateJumlahPokok();
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            var spesis = document.querySelectorAll('input[name="spesis_pokok[]"]');
            var bilangan = document.querySelectorAll('input[name="bilangan_pokok[]"]');
            var tinggi = document.querySelectorAll('input[name="tinggi_pokok[]"]');
            var diameter = document.querySelectorAll('input[name="diameter_pokok[]"]');
            var serializedData = [];
            var bilangan_tanam_pokok = 0;

            // Loop through each set of spesis_pokok, bilangan_pokok, tinggi_pokok, and diameter_pokok fields
            spesis.forEach(function(spesisInput, index) {
                var bilanganInput = bilangan[index];
                var tinggiInput = tinggi[index];
                var diameterInput = diameter[index];
                if (spesisInput.value) {
                    var bilanganValue = parseInt(bilanganInput.value.trim()) || 0;
                    var tinggiValue = parseInt(tinggiInput.value.trim()) || 0;
                    var diameterValue = parseInt(diameterInput.value.trim()) || 0;
                    bilangan_tanam_pokok += bilanganValue;
                    // Concatenate spesis, bilangan, tinggi, and diameter into an object
                    serializedData.push({
                        spesis_pokok: spesisInput.value,
                        bilangan_pokok: bilanganValue,
                        tinggi_pokok: tinggiValue,
                        diameter_pokok: diameterValue
                    });
                }
            });

            // Serialize the data into a JSON string
            document.getElementById('serialized_spesis_pokok').value = JSON.stringify(serializedData);
            document.getElementById('bilangan_tanam_pokok').value = bilangan_tanam_pokok;
        });

        // Initial calculation
        updateJumlahPokok();
    });

    // Function to populate Negeri dropdown on page load
    function updateFields() {
        var $negeri = $('#negeri');
        $negeri.prop('disabled', true);
        $('#loading-spinner').show();
        
        $.getJSON('/get-negeri', function(data) {
            $negeri.empty().append('<option value="">Pilih Negeri</option>');
            $.each(data, function(index, negeri) {
                $negeri.append($('<option>', {
                    value: negeri.kod_negeri,
                    text: negeri.nama_negeri.toUpperCase()
                }));
            });
            // Add 'lain-lain' option
            $negeri.append($('<option>', {
                value: 'lain-lain',
                text: 'Lain-lain (Agensi/NGO)'
            }));
            
            $negeri.prop('disabled', false);
            $('#loading-spinner').hide();
            $negeri.select2({ theme: 'bootstrap4', allowClear: false });

            // Set the selected value if editing
            var selectedNegeri = '{{ old('negeri', $ktp->negeri ?? '') }}';
            if (selectedNegeri) {
                $negeri.val(selectedNegeri).trigger('change');
            }
        }).fail(function() {
            $negeri.prop('disabled', false);
            $('#loading-spinner').hide();
            alert('Failed to load Negeri data.');
        });
    }

    // Function to update PBT based on selected Negeri
    function updatePBT() {
        const negeriId = $('#negeri').val();
        const $pbtContainer = $('#pbt-container'); // Wrap the PBT field in a container

        // Reset PBT container
        $pbtContainer.empty();
        $('#loading-spinner').show();

        if (!negeriId) {
            $('#loading-spinner').hide();
            $pbtContainer.append(`
                <label for="pbt">Pihak Berkuasa Tempatan</label>
                <select id="pbt" name="pbt" class="form-control select2">
                    <option value="">Pilih PBT/Agensi</option>
                </select>
            `);
            return;
        }

        var negeriText = $('#negeri').find('option:selected').text();

        // Handle "Lain-lain" case
        if (negeriId === 'lain-lain') {
            $('#loading-spinner').hide();
            $pbtContainer.append(`
                <label for="pbt">Agensi/NGO</label>
                <input type="text" id="pbt" name="pbt" class="form-control" placeholder="Masukkan Nama Agensi/NGO" value="{{ old('pbt', $ktp->pbt ?? '') }}">
            `);
            return;
        }

        // Fetch PBT data for other Negeri
        $.getJSON('/data/pbt/' + negeriText, function(data) {
            const $dropdown = $('<select>', {
                id: 'pbt',
                name: 'pbt',
                class: 'form-control select2'
            }).append('<option value="">Pilih PBT/Agensi</option>');

            $.each(data, function(index, pbt) {
                $dropdown.append($('<option>', {
                    value: pbt.name,
                    text: pbt.name.toUpperCase()
                }));
            });

            // Add 'lain-lain' option
            $dropdown.append($('<option>', {
                value: 'lain-lain',
                text: 'Lain-lain'
            }));

            $pbtContainer.append(`
                <label for="pbt">Pihak Berkuasa Tempatan</label>
            `);
            $pbtContainer.append($dropdown);
            $('#loading-spinner').hide();

            // Set the selected value if editing
            var selectedPbt = '{{ old('pbt', $ktp->pbt ?? '') }}';
            if (selectedPbt) {
                $dropdown.val(selectedPbt).trigger('change');
            }
        }).fail(function() {
            $('#loading-spinner').hide();
            alert('Failed to load PBT. Sila isi Nama Pihak Berkuasa Tempatan.');
        });
    }

    // Utility function to capitalize each word
    // function capitalizeWords(str) {
    //     return str.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    // }

    // Run function on page load
    $(document).ready(function() {
        updateFields();
    });

</script>
@endsection
