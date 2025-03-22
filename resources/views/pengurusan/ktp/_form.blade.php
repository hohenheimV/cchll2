<!-- Nama Kempen and Lokasi -->
<div class="form-row">
    <div class="form-group col-md-4">
        {{ Form::label('tajuk', 'Nama Program') }}
        {{ Form::text('tajuk', null, ['placeholder' => 'Masukkan Nama Program', 'class' => 'form-control ' . ($errors->has('tajuk') ? 'is-invalid' : '')]) }}
        @if ($errors->has('tajuk'))
            <div class="invalid-feedback">
                {{ $errors->first('tajuk') }}
            </div>
        @endif
    </div>

    <div class="form-group col-md-4">
        {{ Form::label('lokasi', 'Lokasi') }}
        {{ Form::text('lokasi', null, ['placeholder' => 'Masukkan Lokasi', 'class' => 'form-control ' . ($errors->has('lokasi') ? 'is-invalid' : '')]) }}
        @if ($errors->has('lokasi'))
            <div class="invalid-feedback">
                {{ $errors->first('lokasi') }}
            </div>
        @endif
    </div>
</div>

<!-- Negeri and PBT Fields -->
<div class="form-row">
    <div class="form-group col-md-4">
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
    <div class="form-group col-md-4">
        {{ Form::label('pbt', 'Pihak Berkuasa Tempatan / Agensi') }} 
        <!-- Loading Spinner -->
        <div id="loading-spinner" style="display: none;">Muatnaik Maklumat...</div>
        {{ Form::select('pbt', $pbt ?? [], old('pbt', $ktp->pbt ?? null), [
            'class' => 'form-control select2 ' . ($errors->has('pbt') ? 'is-invalid' : ''),
            'data-toggle' => 'tooltip',
            'title' => 'Sila Pilih Negeri Terlebih Dahulu',
            'id' => 'pbt',
            'autocomplete' => 'off',
        ]) }}
        @if ($errors->has('pbt'))
            <div class="invalid-feedback">
                {{ $errors->first('pbt') }}
            </div>
        @endif
    </div>
</div>

<!-- Spesis Pokok & Jumlah Pokok -->
<div class="form-row">
    <div class="form-group col-md-8">
        {{ Form::label('maklumat', 'Maklumat Pokok') }}
        <div>
            <button type="button" class="btn btn-light btn-sm mt-2" id="add_spesis_pokok"><i class="fas fa-plus"></i> Tambah Spesis</button>
        </div>
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
                                <td><input type="text" name="spesis_pokok[]" class="form-control @error('spesis_pokok.*') is-invalid @enderror" value="{{ $pair['spesis'] }}" placeholder="Spesis Pokok"></td>
                                <td><input type="number" name="bilangan_pokok[]" class="form-control bilangan-pokok @error('bilangan_pokok.*') is-invalid @enderror" value="{{ $pair['bilangan'] }}" placeholder="Bilangan" min="1" max="10000"></td>
                                <td><input type="number" name="tinggi_pokok[]" class="form-control @error('tinggi_pokok.*') is-invalid @enderror" value="{{ $pair['tinggi'] }}" placeholder="Tinggi" min="0" max="1000"></td>
                                <td><input type="number" name="diameter_pokok[]" class="form-control @error('diameter_pokok.*') is-invalid @enderror" value="{{ $pair['diameter'] }}" placeholder="Diameter" min="0" max="1000"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove_field"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><input type="text" name="spesis_pokok[]" class="form-control @error('spesis_pokok.*') is-invalid @enderror" placeholder="Spesis Pokok"></td>
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
            

            <div class="form-group col-md-4">
                    {{ Form::label('jumlah_pokok', 'Jumlah Keseluruhan Pokok Ditanam') }}
                    {{ Form::text('jumlah_pokok', null, ['class' => 'form-control ' . ($errors->has('jumlah_pokok') ? 'is-invalid' : ''), 'readonly' => true]) }}
                    @if ($errors->has('jumlah_pokok'))
                        <div class="invalid-feedback">
                            {{ $errors->first('jumlah_pokok') }}
                        </div>
                    @endif
            </div>
        </div>

        <!-- Hidden input to store the serialized data -->
        <input type="hidden" name="serialized_spesis_pokok" id="serialized_spesis_pokok">
        <input type="hidden" name="jumlah_tanam_pokok" id="jumlah_tanam_pokok">
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
            document.querySelector('input[name="jumlah_pokok"]').value = total;
        }

        document.getElementById('add_spesis_pokok').addEventListener('click', function() {
            var container = document.getElementById('spesis_pokok_container');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="spesis_pokok[]" class="form-control" placeholder="Spesis Pokok"></td>
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
        
        $.getJSON('/data/negeri', function(data) {
            $negeri.empty().append('<option value="">Pilih Negeri</option>');
            $.each(data, function(index, negeri) {
                $negeri.append($('<option>', {
                    value: negeri.id,
                    text: capitalizeWords(negeri.name)
                }));
            });
            // Add 'lain-lain' option
            $negeri.append($('<option>', {
                value: 'lain-lain',
                text: 'Lain-lain'
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
        const $pbt = $('#pbt');

        // Reset PBT dropdown
        $pbt.empty().append('<option value="">Pilih PBT/Agensi</option>');
        $('#loading-spinner').show();

        if (!negeriId) {
            $('#loading-spinner').hide();
            return;
        }

        $.getJSON('/data/pbt/' + negeriId, function(data) {
            $.each(data, function(index, pbt) {
                $pbt.append($('<option>', {
                    value: capitalizeWords(pbt.name), // Change value to name
                    text: capitalizeWords(pbt.name)
                }));
            });
            // Add 'lain-lain' option
            $pbt.append($('<option>', {
                value: 'NGO',
                text: 'NGO'
            }));

            $('#loading-spinner').hide();

            // Set the selected value if editing
            var selectedPbt = '{{ old('pbt', $ktp->pbt ?? '') }}';
            if (selectedPbt) {
                $pbt.val(selectedPbt).trigger('change');
            }
        }).fail(function() {
            $('#loading-spinner').hide();
            alert('Failed to load PBT. Sila isi Nama Pihak Berkuasa Tempatan.');
        });
    }

    // Utility function to capitalize each word
    function capitalizeWords(str) {
        return str.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    }

    // Run function on page load
    $(document).ready(function() {
        updateFields();
    });

</script>
@endsection
