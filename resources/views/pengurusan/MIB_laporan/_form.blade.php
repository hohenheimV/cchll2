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
                {{ Form::text('name', $MIB_laporan->name ?? '', ['placeholder' => 'Masukkan Nama Aktiviti', 'required' => 'true', 'class' => 'inertShow form-control' . Html::isInvalid($errors, 'name')]) }}
                {!! Html::hasError($errors, 'name') !!}
            </div>
            <div style="display: none;">
                {{ Form::text('taman', $MIB->taman ?? ($MIB_laporan->taman ?? ''), ['placeholder' => 'Masukkan Anggaran Nilai', 'class' => 'inertShow form-control' . Html::isInvalid($errors, 'taman')]) }}
                {!! Html::hasError($errors, 'taman') !!}
                <input type="text" name="id_rakan" value="{{ $MIB->id ?? ($MIB_laporan->id_rakan ?? '') }}" required>
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('laporan', 'Laporan') }}
            {{ Form::textarea('laporan',$MIB_laporan->laporan ?? '',['placeholder'=>'Sila masukkan laporan', 'required' => 'true','rows'=>10,'class' => 'inertShow form-control '.Html::isInvalid($errors,'laporan')]) }}
            {!! Html::hasError($errors,'laporan') !!}
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                {{ Form::label('fail', 'Fail Laporan') }}
                {{ Form::file('fail', ['class' => 'inertShow form-control ms-2 showButton', 'multiple' => false, 'accept' => '.pdf,.docx,.pptx']) }}
                    @if(isset($MIB_laporan->fail))
                        {{ Form::label('', '***Muatnaik semula akan menggantikan fail sedia ada.', ['class' => 'col-form-label required-field-create showButton', 'style' => 'font-weight: strong;']) }}
                        <br>
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                @php
                                    $folderName = isset($MIB_laporan->fail) ? 'MIB/'.str_replace(' ', '_', $MIB_laporan->id_rakan.' '.$MIB_laporan->taman).'/'.$MIB_laporan->fail : null;

                                    $fileExtension = isset($MIB_laporan->fail) ? pathinfo($MIB_laporan->fail, PATHINFO_EXTENSION) : '';
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
                                    <a href="{{ asset('storage/uploads/' . $folderName) }}" target="_blank" class="" style="border: 0px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;">
                                        <div class="product-image">
                                            <img src="{{ $extensionIcon }}" class="br-5" alt="" style="width: 100px; height: 100px; border-radius: 5px; margin-bottom: 10px;">
                                        </div>
                                        <div class="product-image">
                                            <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Fail Laporan <i class="fas fa-download"></i></span>
                                        </div>
                                        <div class="product-image">
                                            <span class="file-name-1">{{ $MIB_laporan->fail ?? '' }}</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
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
                <label for="gambar" class="col-md-12 control-label">Gambar Aktiviti</label>
                @php
                    if(isset($MIB_laporan->gambar)){
                        $folderName = str_replace(' ', '_', $MIB_laporan->id_rakan.' '.($MIB->taman ?? ($MIB_laporan->taman ?? 'temp')));
                        $gambarData = $MIB_laporan->gambar;

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
                            @if(strpos(request()->url(), 'show') === false)
                            <input type="file" class="inertShow form-control-file" id="gambar_input_modal_1" name="gambar_input_modal_1" accept="image/*" style="display: none;">
                            @endif
                            <div id="imagePreviewContainer1" class="image-preview-container">
                                <a href="{{ (isset($gambar_input_modal_1) && strpos(request()->url(), 'show') !== false) ? asset('storage/uploads/MIB/'.$gambar_input_modal_1) : 'javascript:void(0);' }}" target="{{ (isset($gambar_input_modal_1) && strpos(request()->url(), 'show') !== false) ? '_blank' : '' }}">
                                    <img src="{{ isset($gambar_input_modal_1) ? asset('storage/uploads/MIB/'.$gambar_input_modal_1) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </a>
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            @if(strpos(request()->url(), 'show') === false)
                            <input type="file" class="inertShow form-control-file" id="gambar_input_modal_2" name="gambar_input_modal_2" accept="image/*" style="display: none;">
                            @endif
                            <div id="imagePreviewContainer2" class="image-preview-container">
                                <a href="{{ (isset($gambar_input_modal_2) && strpos(request()->url(), 'show') !== false) ? asset('storage/uploads/MIB/'.$gambar_input_modal_2) : 'javascript:void(0);' }}" target="{{ (isset($gambar_input_modal_2) && strpos(request()->url(), 'show') !== false) ? '_blank' : '' }}">
                                    <img src="{{ isset($gambar_input_modal_2) ? asset('storage/uploads/MIB/'.$gambar_input_modal_2) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </a>
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            @if(strpos(request()->url(), 'show') === false)
                            <input type="file" class="inertShow form-control-file" id="gambar_input_modal_3" name="gambar_input_modal_3" accept="image/*" style="display: none;">
                            @endif
                            <div id="imagePreviewContainer3" class="image-preview-container">
                                <a href="{{ (isset($gambar_input_modal_3) && strpos(request()->url(), 'show') !== false) ? asset('storage/uploads/MIB/'.$gambar_input_modal_3) : 'javascript:void(0);' }}" target="{{ (isset($gambar_input_modal_3) && strpos(request()->url(), 'show') !== false) ? '_blank' : '' }}">
                                    <img src="{{ isset($gambar_input_modal_3) ? asset('storage/uploads/MIB/'.$gambar_input_modal_3) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </a>
                            </div>
                        </div>
                        <br class="mobile-done">
                        <div class="grid-item">
                            @if(strpos(request()->url(), 'show') === false)
                            <input type="file" class="inertShow form-control-file" id="gambar_input_modal_4" name="gambar_input_modal_4" accept="image/*" style="display: none;">
                            @endif
                            <div id="imagePreviewContainer4" class="image-preview-container">
                                <a href="{{ (isset($gambar_input_modal_4) && strpos(request()->url(), 'show') !== false) ? asset('storage/uploads/MIB/'.$gambar_input_modal_4) : 'javascript:void(0);' }}" target="{{ (isset($gambar_input_modal_4) && strpos(request()->url(), 'show') !== false) ? '_blank' : '' }}">
                                    <img src="{{ isset($gambar_input_modal_4) ? asset('storage/uploads/MIB/'.$gambar_input_modal_4) : asset('storage/uploads/no-photos.png') }}" class="img-fluid" alt="Responsive image">
                                </a>
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