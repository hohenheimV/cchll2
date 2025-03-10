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
{{-- dd($MIB) --}}
<div class="row">
    <div class="col-lg col-separator">
        <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <div class="col-xs-12">
                <h4>&nbsp;</h4>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                {{ Form::label('name', 'Nama Aktiviti') }}
                {{ Form::text('name', $MIB_laporan->name ?? '', ['placeholder' => 'Masukkan Nama Aktiviti', 'class' => 'form-control' . Html::isInvalid($errors, 'name')]) }}
                {!! Html::hasError($errors, 'name') !!}
            </div>
            <div style="display: none;">
                {{ Form::text('taman', $MIB->taman ?? ($MIB_laporan->taman ?? ''), ['placeholder' => 'Masukkan Anggaran Nilai', 'class' => 'form-control' . Html::isInvalid($errors, 'taman')]) }}
                {!! Html::hasError($errors, 'taman') !!}
                <input type="text" name="id_rakan" value="{{ $MIB->id ?? ($MIB_laporan->id_rakan ?? '') }}" required>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('laporan', 'Laporan') }}
            {{ Form::textarea('laporan',$MIB_laporan->laporan ?? '',['placeholder'=>'Sila masukkan laporan','rows'=>14,'class' => 'form-control '.Html::isInvalid($errors,'laporan')]) }}
            {!! Html::hasError($errors,'laporan') !!}
        </div>
    </div>
    <div class="col-lg col-separator inertShow">
        <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <div class="col-xs-12">
                <h4>&nbsp;</h4>
            </div>
        </div>
        <div class="row">
            <div class="form-group required col-md-12">
                <label for="konsep_rekabentuk" class="col-md-12 control-label">Gambar Aktiviti</label>
                @php
                    if(isset($MIB_laporan->fail)){
                        $folderName = str_replace(' ', '_', $MIB->taman ?? ($MIB_laporan->taman ?? 'temp'));
                        $gambarData = $MIB_laporan->fail;

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
                            <input type="file" class="form-control-file" id="gambar_input_modal_1" name="gambar_input_modal_1" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer1" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_1) ? asset('storage/uploads/MIB/'.$gambar_input_modal_1) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_2" name="gambar_input_modal_2" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer2" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_2) ? asset('storage/uploads/MIB/'.$gambar_input_modal_2) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_3" name="gambar_input_modal_3" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer3" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_3) ? asset('storage/uploads/MIB/'.$gambar_input_modal_3) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            <input type="file" class="form-control-file" id="gambar_input_modal_4" name="gambar_input_modal_4" accept="image/*" style="display: none;">
                            <div id="imagePreviewContainer4" class="image-preview-container">
                                <img src="{{ isset($gambar_input_modal_4) ? asset('storage/uploads/MIB/'.$gambar_input_modal_4) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>
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
            </script>
        </div>
    </div>
</div>