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
                <input value="{{ isset($pbt) ? strtoupper($pbt) : '' }}" {{-- {{ isset($pbt) ? 'inert' : '' }} --}} type="text" name="pbt" id="pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" class="form-control" required>
                <datalist id="data_pbt">
                </datalist>
            </div>

            <div class="form-group col-md-4">
                {{ Form::label('lokasi', 'Lokasi') }}
                {{ Form::text('lokasi', null, ['placeholder' => 'Masukkan Lokasi', 'class' => 'form-control' . Html::isInvalid($errors, 'lokasi')]) }}
                {!! Html::hasError($errors, 'lokasi') !!}
            </div>
            <div class="form-group required col-md-6">
                <label for="lat" class="col-md-12 control-label">Koordinat X </label>
                <div class="col-md-12">
                    {{ Form::text('lat', null, ['class' => 'form-control', 'placeholder' => 'Masukkan koordinat X']) }}
                </div>
            </div>
            <div class="form-group required col-md-6">
                <label for="lng" class="col-md-12 control-label">Koordinat Y </label>
                <div class="col-md-12">
                    {{ Form::text('lng', null, ['class' => 'form-control', 'placeholder' => 'Masukkan koordinat Y']) }}
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
            {{-- <div class="form-group required col-md-12">
                <label for="gambar" class="col-md-12 control-label">Gambar Entiti</label>
                @php
                    if(isset($entitiLandskapUnik->gambar)){
                        $folderName = str_replace(' ', '_', $entitiLandskapUnik->id.' '.$entitiLandskapUnik->nama_entiti);
                        $gambarData = json_decode($entitiLandskapUnik->gambar, true);

                        $gambar_input_modal_1 = isset($gambarData['gambar_input_modal_1']) ? $folderName.'/'.$gambarData['gambar_input_modal_1'] : null;
                        $gambar_input_modal_2 = isset($gambarData['gambar_input_modal_2']) ? $folderName.'/'.$gambarData['gambar_input_modal_2'] : null;
                        $gambar_input_modal_3 = isset($gambarData['gambar_input_modal_3']) ? $folderName.'/'.$gambarData['gambar_input_modal_3'] : null;
                        $gambar_input_modal_4 = isset($gambarData['gambar_input_modal_4']) ? $folderName.'/'.$gambarData['gambar_input_modal_4'] : null;
                        //dd($gambarData);
                    }else{
                        $gambar_input_modal_1 = null;
                        $gambar_input_modal_2 = null;
                        $gambar_input_modal_3 = null;
                        $gambar_input_modal_4 = null;
                    }

                    $imageFields = [];
                    if(isset($entitiLandskapUnik->gambar)){
                        $folderName = str_replace(' ', '_', $entitiLandskapUnik->id.' '.$entitiLandskapUnik->nama_entiti);
                        $gambarData = json_decode($entitiLandskapUnik->gambar, true);

                        for ($i = 1; $i <= 4; $i++) {
                            $fieldKey = "gambar_input_modal_$i";
                            if (isset($gambarData[$fieldKey])) {
                                $imageFields[$fieldKey] = $folderName . '/' . $gambarData[$fieldKey];
                            } else {
                                $imageFields["gambar_input_modal_$i"] = null;
                            }
                        }
                        //dd($gambarData);
                    }else{
                        for ($i = 1; $i <= 4; $i++) {
                            $fieldKey = "gambar_input_modal_$i";
                            $imageFields[$fieldKey] = null;
                        }
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
                    @if (1 || !(Str::contains(request()->path(), ['create', 'edit'])))
                    <div class="grid-container">
                        @foreach ($imageFields as $fieldKey => $imagePath)
                            <div class="grid-item clickable-preview" data-image="{{ isset($imagePath) ? asset('storage/uploads/entiti_landskap/' . $imagePath) : asset('storage/uploads/no-photos.png') }}">
                                <input type="file" class="form-control-file" id="{{ $fieldKey }}" name="{{ $fieldKey }}" accept="image/*" style="display: none;">
                                <div id="preview_{{ $loop->index + 1 }}" class="image-preview-container">
                                    <img src="{{ isset($imagePath) ? asset('storage/uploads/entiti_landskap/' . $imagePath) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </div>
                                <div class="showButton">
                                    <button type="button" class="btn btn-sm btn-primary trigger-upload" data-target="{{ $fieldKey }}">Pilih</button>
                                    <button type="button" class="btn btn-sm btn-danger delete-image" data-target="{{ $fieldKey }}">Padam</button>
                                </div>
                                <input type="hidden" name="delete_images[]" value="" id="{{ 'delete_'.$fieldKey }}">
                                <script>
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
                                            preview.querySelector('img').src = '/storage/uploads/no-photos.png';
                                            deleteInput.value = field;
                                        });
                                    });
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const currentURL = window.location.href;
                                        const isEditMode = currentURL.includes('/edit');
                                        const totalImages = 4;

                                        for (let i = 1; i <= totalImages; i++) {
                                            const inputId = `gambar_input_modal_${i}`;
                                            const previewId = `preview_${i}`;
                                            const inputEl = document.getElementById(inputId);
                                            const previewEl = document.getElementById(previewId);

                                            if (!inputEl || !previewEl) continue;
                                            inputEl.addEventListener('change', (e) => previewImage(e.target, previewEl));
                                            if (inputEl && previewEl) {
                                                inputEl.addEventListener('change', (e) => previewImage(e.target, previewEl));
                                            }
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
                                        }

                                        if (isEditMode) {
                                            document.querySelectorAll('.trigger-upload').forEach(button => {
                                                button.addEventListener('click', function () {
                                                    const target = this.dataset.target;
                                                    document.getElementById(target).click();
                                                });
                                            });
                                            document.querySelectorAll('.delete-image').forEach(button => {
                                                button.addEventListener('click', function () {
                                                    const target = this.dataset.target;
                                                    const preview = document.getElementById('preview_' + target.split('_').pop());
                                                    const inputHidden = document.getElementById('delete_' + target);
                                                    preview.querySelector('img').src = "{{ asset('storage/uploads/no-photos.png') }}";
                                                    inputHidden.value = target;
                                                });
                                            });
                                        }
                                    });
                                </script>
                            </div>
                            <br class="mobile-done">
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
                        const totalImages = 4;

                        function previewImage(inputElement, previewContainer) {
                            const file = inputElement.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const base64Data = e.target.result;
                                    const imgEl = previewContainer.querySelector('img');
                                    imgEl.src = base64Data;
                                    const gridItem = previewContainer.closest('.grid-item');
                                    if (gridItem) {
                                        gridItem.setAttribute('data-image', base64Data);
                                    }
                                };
                                reader.readAsDataURL(file);
                            }
                        }
                    </script>

                    <br>
                    @else
                    <div class="grid-container">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_1" name="gambar_input_modal_1" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer1" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_1) ? asset('storage/uploads/entiti_landskap/'.$gambar_input_modal_1) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_2" name="gambar_input_modal_2" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer2" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_2) ? asset('storage/uploads/entiti_landskap/'.$gambar_input_modal_2) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_3" name="gambar_input_modal_3" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer3" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_3) ? asset('storage/uploads/entiti_landskap/'.$gambar_input_modal_3) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_4" name="gambar_input_modal_4" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer4" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_4) ? asset('storage/uploads/entiti_landskap/'.$gambar_input_modal_4) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <script>
                const fileInputs = [
                    { inputId: 'gambar_input_modal_1', previewContainerId: 'imagePreviewContainer1' },
                    { inputId: 'gambar_input_modal_2', previewContainerId: 'imagePreviewContainer2' },
                    { inputId: 'gambar_input_modal_3', previewContainerId: 'imagePreviewContainer3' },
                    { inputId: 'gambar_input_modal_4', previewContainerId: 'imagePreviewContainer4' }
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
            </script> --}}

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // $.getJSON('/data/negeri', function(data) {
                        
                    //     $.each(data, function(index, negeri) {
                    //         let pname = negeri.name;
                    //         $('#negeri').append($('<option>', {
                    //             value: negeri.id,
                    //             text: negeri.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                    //         }));
                    //     });
                    //     var negeriSelected = "{{ isset($negeri) ? $negeri : '' }}"; // Assuming you have $entitiLandskapUnik->negeri
                    //     if (negeriSelected) {
                    //         $('#negeri').val(negeriSelected).trigger('change');
                    //     }
                    //     $('#negeri').prop('disabled', false);

                    // }).fail(function() {
                    //     $('#negeri').prop('disabled', false);
                    //     alert('Failed to load data');
                    // });

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
                            var negeriSelected = "{{ isset($negeri) ? $negeri : '' }}"; // Assuming you have $entitiLandskapUnik->negeri
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
                        const $datalist = $('#data_pbt');
                        $datalist.empty();

                        $.getJSON('/data/pbt/' + negeriId, function(data) {
                            $.each(data, function(index, pbt) {
                                $datalist.append($('<option>', {
                                    // value: pbt.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                                    value: pbt.name,
                                    // text: pbt.id,
                                    'data-id': pbt.id,
                                }));
                            });
                        }).fail(function() {
                            alert('Failed to load data. Sila isi Nama Pihak Berkuasa Tempatan.');
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