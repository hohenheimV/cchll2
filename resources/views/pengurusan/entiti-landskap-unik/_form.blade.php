<!-- 
<div class="form-row">
    <div class="col">
        <div class="form-group">
            {{ Form::label('lat', 'Koordinat X') }}
            {{ Form::text('lat',null,['placeholder'=>'Koordinat X : x.xxxxxx','class' => 'form-control '.Html::isInvalid($errors,'lat')]) }}
            {!! Html::hasError($errors,'lat') !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {{ Form::label('lng', 'Koordinat Y') }}
            {{ Form::text('lng',null,['placeholder'=>'Koordinat Y  : xxx.xxxxxx','class' => 'form-control '.Html::isInvalid($errors,'lng')]) }}
            {!! Html::hasError($errors,'lng') !!}
        </div>
    </div>
</div>
<div class="form-group">
    {{ Form::label('tajuk', 'Tajuk') }}
    {{ Form::text('tajuk',null,['placeholder'=>'Sila masukkan Tajuk','class' => 'form-control '.Html::isInvalid($errors,'tajuk')]) }}
    {!! Html::hasError($errors,'tajuk') !!}
</div>
<div class="form-group">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan',null,['placeholder'=>'Sila masukkan keterangan','rows'=>3,'class' => 'form-control '.Html::isInvalid($errors,'keterangan')]) }}
    {!! Html::hasError($errors,'keterangan') !!}
</div>
 -->

<!-- Nama Kempen and Lokasi -->
<div class="form-row">
    <div class="form-group col-md-6">
        {{ Form::label('nama_kempen', 'Nama Pokok/ Kawasan Unik') }}
        {{ Form::text('nama_kempen', null, ['placeholder' => 'Masukkan Nama Pokok/ Kawasan Unik', 'class' => 'form-control' . Html::isInvalid($errors, 'nama_kempen')]) }}
        {!! Html::hasError($errors, 'nama_kempen') !!}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('lokasi', 'Lokasi') }}
        {{ Form::text('lokasi', null, ['placeholder' => 'Masukkan Lokasi', 'class' => 'form-control' . Html::isInvalid($errors, 'lokasi')]) }}
        {!! Html::hasError($errors, 'lokasi') !!}
    </div>
</div>
<div class="form-group">
    {{ Form::label('keterangan', 'Keterangan') }}
    {{ Form::textarea('keterangan',null,['placeholder'=>'Sila masukkan keterangan','rows'=>3,'class' => 'form-control '.Html::isInvalid($errors,'keterangan')]) }}
    {!! Html::hasError($errors,'keterangan') !!}
</div>
<!-- PBT and Agensi -->
<div class="form-row">
    <div class="form-group col-md-6">
        {{ Form::label('pbt', 'PBT') }}
        {{ Form::text('pbt', null, ['placeholder' => 'Masukkan PBT', 'class' => 'form-control' . Html::isInvalid($errors, 'pbt')]) }}
        {!! Html::hasError($errors, 'pbt') !!}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('agensi', 'Agensi') }}
        {{ Form::text('agensi', null, ['placeholder' => 'Masukkan Agensi', 'class' => 'form-control' . Html::isInvalid($errors, 'agensi')]) }}
        {!! Html::hasError($errors, 'agensi') !!}
    </div>
</div>

<!-- Entiti Unik & Anggaran Nilai -->
<div class="form-row">
    <div class="form-group col-md-7">
        <div class="table-responsive">
            <table id="spesis-pokok-table" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <style>
                        #spesis-pokok-table th {
                            padding: 5px 5px;  /* Adjust the padding for header cells */
                            text-align: center;  /* Center the text for better alignment */
                        }
                    </style>
                    <tr>
                        <th class="w-50">Entiti Unik</th>
                        <th class="w-20">Anggaran Nilai</th>
                        <th class="w-15" id="add_spesis_pokok">[Tambah Entiti]</th>
                    </tr>
                </thead>
                <tbody id="spesis_pokok_container">
                    @if(isset($spesisPokokJumlahPairs))
                        @foreach ($spesisPokokJumlahPairs as $index => $pair)
                        <tr>
                            <td><input type="text" name="spesis_pokok[]" class="form-control" value="{{ $pair['spesis_pokok'] }}" placeholder="Masukkan Entiti Unik"></td>
                            <td><input type="text" name="jumlah_pokok[]" class="form-control" value="{{ $pair['jumlah_pokok'] }}" placeholder="Masukkan Anggaran Nilai" min="1"></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove_field">Hapus</button></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td><input type="text" name="spesis_pokok[]" class="form-control" placeholder="Masukkan Entiti Unik"></td>
                            <td><input type="text" name="jumlah_pokok[]" class="form-control" placeholder="Masukkan Anggaran Nilai" min="1"></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove_field">Hapus</button></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Button to add more fields -->
            <!-- <button type="button" class="btn btn-primary btn-sm mt-2" id="add_spesis_pokok">Tambah Entiti Unik</button> -->
        </div>
        <!-- Hidden input to store the serialized data -->
        <input type="hidden" name="serialized_spesis_pokok" id="serialized_spesis_pokok">
        <input type="hidden" name="jumlah_tanam_pokok" id="jumlah_tanam_pokok">
    </div>

</div>



                

@section('page-js-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add_spesis_pokok').addEventListener('click', function() {
            var container = document.getElementById('spesis_pokok_container');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="spesis_pokok[]" class="form-control" placeholder="Masukkan Entiti Unik"></td>
                <td><input type="number" name="jumlah_pokok[]" class="form-control" placeholder="Masukkan Anggaran Nilai" min="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove_field">Hapus</button></td>
            `;
            container.appendChild(newRow);
        });


        // Remove dynamic fields
        // Remove field functionality
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove_field')) {
                event.target.closest('tr').remove();
            }
        });
        document.querySelector('form').addEventListener('submit', function(event) {
            var spesis = document.querySelectorAll('input[name="spesis_pokok[]"]');
            var jumlah = document.querySelectorAll('input[name="jumlah_pokok[]"]');
            var serializedData = [];
            var jumlah_tanam_pokok = 0;

            // Loop through each set of spesis_pokok and jumlah_pokok fields
            spesis.forEach(function(spesisInput, index) {
                var jumlahInput = jumlah[index];
                if (spesisInput.value) {
                    var jumlahValue = parseInt(jumlahInput.value.trim()) || 0;
                    jumlah_tanam_pokok += jumlahValue;
                    // Concatenate spesis and jumlah into an object
                    serializedData.push({
                        spesis_pokok: spesisInput.value,
                        jumlah_pokok: jumlahValue
                    });
                }
                // var jumlahValue = jumlahInput.value.trim() || '0';  // Default to '0' if empty

                // // Concatenate spesis and jumlah into an object
                // serializedData.push({
                //     spesis_pokok: spesisInput.value,
                //     jumlah_pokok: jumlahValue
                // });
            });

            // Serialize the data into a JSON string
            document.getElementById('serialized_spesis_pokok').value = JSON.stringify(serializedData);
            document.getElementById('jumlah_tanam_pokok').value = jumlah_tanam_pokok;
        });
    });
</script>
@endsection
