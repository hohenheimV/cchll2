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
    <div class="col-lg col-separator inertShow">
        <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <div class="col-xs-12">
                <h4>&nbsp;</h4>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-9 ">
                {{ Form::label('nama_entiti', 'Nama Entiti') }}
                {{ Form::text('nama_entiti', null, ['placeholder' => 'Masukkan Nama Entiti', 'required' => 'required', 'class' => 'form-control' . Html::isInvalid($errors, 'nama_entiti')]) }}
                {!! Html::hasError($errors, 'nama_entiti') !!}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('agensi', 'Anggaran Nilai') }}
                {{ Form::text('agensi', null, ['placeholder' => 'Masukkan Anggaran Nilai', 'class' => 'form-control' . Html::isInvalid($errors, 'agensi')]) }}
                {!! Html::hasError($errors, 'agensi') !!}
            </div>
        </div>
        <div class="form-row" style="">
            @php
                if(isset($entitiLandskapUnik->pbt)){
                    $dataPbt = json_decode($entitiLandskapUnik->pbt, true);
                    if ($dataPbt === null) {
                        $dataPbt = [];
                    } elseif ($dataPbt['pbt'] === null) {
                        $dataPbt = [];
                    } elseif (!is_array($dataPbt)) {
                        $dataPbt = (string) $dataPbt;
                    } else{
                        $negeri = $dataPbt['negeri'];
                        $pbt = $dataPbt['pbt'];
                    }
                } else {
                    $dataPbt = [];
                }
                // dd($dataPbt);
            @endphp
            <div class="form-group col-md-3">
                {{ Form::label('negeri', 'Negeri') }}
                <br>
                <select id="negeri" class="form-control select2" name="negeri">
                    <option value="">Pilih Negeri</option>
                </select>
            </div>

            <div class="form-group col-md-5 {{-- {{ isset($pbt) ? 'inertClass' : '' }} --}}">
                {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
                {{-- <input value="{{ isset($pbt) ? strtoupper($pbt) : '' }}" {{ isset($pbt) ? 'inert' : '' }} type="text" name="pbt" id="pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" class="form-control" required>
                <datalist id="data_pbt">
                </datalist> --}}
                <select name="pbt" id="pbt" class="form-control" required>
                    <option value="">Pilih PBT</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                {{ Form::label('lokasi', 'Lokasi') }}
                {{ Form::text('lokasi', null, ['placeholder' => 'Masukkan Lokasi', 'class' => 'form-control' . Html::isInvalid($errors, 'lokasi')]) }}
                {!! Html::hasError($errors, 'lokasi') !!}
            </div>
            <div class="form-group required col-md-6">
                <label for="lng" class="col-md-12 control-label">Koordinat X </label>
                <div class="col-md-12">
                    {{ Form::text('lng', null, ['class' => 'form-control', 'placeholder' => '103.632857']) }}
                </div>
            </div>
            <div class="form-group required col-md-6">
                <label for="lat" class="col-md-12 control-label">Koordinat Y </label>
                <div class="col-md-12">
                    {{ Form::text('lat', null, ['class' => 'form-control', 'placeholder' => '1.511946']) }}
                </div>
            </div>
        </div>
        <!-- <div class="form-row">
            <div class="form-group col-md-6">
                {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
                {{ Form::text('pbt', null, ['placeholder' => 'Masukkan Pihak Berkuasa Tempatan', 'class' => 'form-control' . Html::isInvalid($errors, 'pbt')]) }}
                {!! Html::hasError($errors, 'pbt') !!}
            </div>

            <div class="form-group col-md-6">
                {{ Form::label('lokasi', 'Lokasi') }}
                {{ Form::text('lokasi', null, ['placeholder' => 'Masukkan Lokasi', 'class' => 'form-control' . Html::isInvalid($errors, 'lokasi')]) }}
                {!! Html::hasError($errors, 'lokasi') !!}
            </div>
        </div> -->
        {{-- <div class="form-group">
            {{ Form::label('keterangan', 'Keterangan') }}
            {{ Form::textarea('keterangan',null,['placeholder'=>'Sila masukkan keterangan','rows'=>10,'class' => 'form-control '.Html::isInvalid($errors,'keterangan')]) }}
            {!! Html::hasError($errors,'keterangan') !!}
        </div> --}}
    </div>
    <div class="col-lg col-separator ">
        <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <div class="col-xs-12">
                <h4>&nbsp;</h4>
            </div>
        </div>
        
        <div class="form-group">
            {{ Form::label('keterangan', 'Keterangan') }}
            {{ Form::textarea('keterangan',null,[
                'placeholder'=>'Sila masukkan keterangan', 
                'rows'=>10, 
                'class' => 'form-control '.Html::isInvalid($errors,'keterangan'),
                !(Str::contains(request()->path(), ['create', 'edit'])) ? 'readonly' : null
                ]) 
            }}
            {!! Html::hasError($errors,'keterangan') !!}
        </div>
        
        <div class="row">

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {

                    $.ajax({
                        url: '/get-negeri', // API endpoint to get negeri data
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Populate the Negeri dropdown with the data
                            $('#negeri').empty(); // Clear current options
                            $('#negeri').append('<option value="">Pilih Negeri</option>');

                            $.each(data, function(key, value) {
                                // Add each Negeri to the dropdown
                                $('#negeri').append('<option value="' + value.nama_negeri + '">' + value.nama_negeri + '</option>');
                            });
                            // var negeriSelected = "{{ isset($negeri) ? $negeri : '' }}"; // Assuming you have $entitiLandskapUnik->negeri
                            var negeriSelected = "{{ $negeri ?? ($MaklumatPenggunaPbt->state ?? '') }}";
                            if (negeriSelected) {
                                $('#negeri').val(negeriSelected).trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching Negeri data: ", error);
                        }
                    });

                    $('#negeri').change(function() {
                        // $('#pbt').val('');
                        const negeriId = $('#negeri').val();

                        $('#pbt').empty().append('<option value="">Pilih PBT</option>');
                        // const selectedPBT = "{{ $pbt->pbt_name ?? isset($pbt) ? strtoupper($pbt) : '' }}";
                        const selectedPBT = "{{ $pbt ?? ($MaklumatPenggunaPbt->pbt_name ?? '') }}";
                        $.getJSON('/data/pbt/' + negeriId, function(data) {
                            $.each(data, function(index, pbt) {
                                const option = $('<option>', {
                                    value: pbt.name,
                                    text: pbt.name,
                                    'data-id': pbt.id
                                });

                                if (pbt.name === selectedPBT) {
                                    option.prop('selected', true);
                                }

                                $('#pbt').append(option);
                            });
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg col-separator ">
        <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <div class="col-xs-12">
                <h4>&nbsp;</h4>
            </div>
        </div>

        <div class="row">
            <div class="row">
                <div class="form-group required col-md-12">
                    <label for="gambar" class="col-md-12 control-label">
                        Gambar Entiti
                    </label>
                    @php
                        $imageFields = [];
                        if(isset($entitiLandskapUnik->gambar)){
                            $folderName = str_replace(' ', '_', $entitiLandskapUnik->id.' '.$entitiLandskapUnik->nama_entiti);
                            $gambarData = json_decode($entitiLandskapUnik->gambar, true);

                            for ($i = 1; $i <= 10; $i++) {
                                $fieldKeyX = "gambar_input_modal_$i";
                                $imageFields[$fieldKeyX] = isset($gambarData["gambar_input_modal_$i"]) ? $folderName . '/' . $gambarData["gambar_input_modal_$i"] : (null);
                            }
                            // dd($entitiLandskapUnik->gambar);
                        }else{
                            for ($i = 1; $i <= 10; $i++) {
                                $fieldKey = "gambar_input_modal_$i";
                                $imageFields[$fieldKey] = null;
                            }
                        }
                    @endphp
                    <div class="col-md-12">
                        <style>
                            .grid-container {
                                display: grid;
                                grid-template-columns: repeat(5, 1fr);
                                gap: 10px;
                                width: 100%;         /* Fixed width */
                                height: 450px;        /* Fixed height */
                                margin: 0 auto;
                                box-sizing: border-box;
                                /* border: 1.5px solid rgb(255, 16, 16) !important; */
                                /* overflow: hidden; */
                            }


                            /* Grid item styling */
                            .grid-item {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: space-between;
                                text-align: center;
                                /* border: 1px solid #ddd; */
                                /* border: 1.5px solid rgb(64, 16, 255, 1) !important; */
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
                        <div class="grid-container">
                            @foreach ($imageFields as $fieldKey => $imagePath)
                                @php
                                    $imageURL = isset($imagePath)
                                        ? asset('storage/uploads/entiti_landskap/' . $imagePath)
                                        : asset('storage/uploads/no-photos.png');
                                @endphp

                                <div class="grid-item clickable-preview"
                                    data-image="{{ $imageURL }}">

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

                                // document.querySelectorAll('.delete-image').forEach(button => {
                                //     button.addEventListener('click', function () {
                                //         const field = this.dataset.target;
                                //         const preview = document.querySelector(`#preview_${field.split('_')[1]}`);
                                //         const deleteInput = document.getElementById(`delete_${field}`);

                                //         preview.querySelector('img').src = "{{ asset('storage/uploads/no-photos.png') }}";
                                //         deleteInput.value = field;
                                //     });
                                // });
                                document.querySelectorAll('.delete-image').forEach(button => {
                                    button.addEventListener('click', function () {
                                        const field = this.dataset.target; // e.g., "gambar_input_modal_10"
                                        const match = field.match(/\d+$/); // Get the trailing number
                                        if (!match) return;

                                        const index = match[0]; // e.g., "10"
                                        const preview = document.querySelector(`#preview_${index}`);
                                        const deleteInput = document.getElementById(`delete_${field}`);

                                        if (preview && preview.querySelector('img')) {
                                            preview.querySelector('img').src = "{{ asset('storage/uploads/no-photos.png') }}";
                                        }

                                        if (deleteInput) {
                                            deleteInput.value = field;
                                        }
                                    });
                                });

                                const totalImages = 10;

                                for (let i = 1; i <= totalImages; i++) {
                                    const input = document.getElementById(`gambar_input_modal_${i}`);
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>