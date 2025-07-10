@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Pelan Induk Landskap')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {!! Form::model($dokumen, ['route' => ['pengurusan.ePIL_dokumen.update', $dokumen], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    <!-- <div class="row">
                        <div class="form-group required col-md-4">
                            <label for="nama_fail" class="col-md-12 control-label">Nama Fail:</label>
                            <div class="col-md-12">
                                <input type="text" name="nama_fail" class="form-control" value="{{ $dokumen->nama_fail }}" required>
                                <input type="hidden" name="folder" class="form-control" value="{{ $dokumen->folder }}" required readonly>
                            </div>
                        </div>
                        <div class="form-group required col-md-8">
                            <label for="keterangan_dokumen_pelan" class="col-md-12 control-label">Keterangan:</label>
                            <div class="col-md-12">
                                <input type="text" name="keterangan_dokumen_pelan" class="form-control" value="{{ $dokumen->keterangan_dokumen_pelan }}" required>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group required">
                                <label for="nama_fail" class="control-label">Nama Fail:</label>
                                <input type="text" name="nama_fail" class="form-control" value="{{ $dokumen->nama_fail }}" required>
                                <input type="hidden" name="folder" class="form-control" value="{{ $dokumen->folder }}" readonly>
                            </div>

                            <div class="form-group required">
                                <label for="keterangan_dokumen_pelan" class="control-label">Keterangan:</label>
                                <input type="text" name="keterangan_dokumen_pelan" class="form-control" value="{{ $dokumen->keterangan_dokumen_pelan }}" required>
                            </div>

                            <div class="form-group required">
                                <label for="nama_dokumen_pelan" class="control-label">Fail:</label>
                                <input type="file" name="nama_dokumen_pelan" id="nama_dokumen_pelan" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.zip,.mp4,.kml,.kmz,.dwg,.dxf,.rar">
                                {{ Form::label('', '***Muatnaik semula akan menggantikan fail sedia ada.', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: bold;']) }}
                                <br>

                                <div id="progress-container" style="display: none;">
                                    <div id="progress-bar" style="width: 100%; background-color: #ccc;">
                                        <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
                                    </div>
                                    <p>Uploading: <span id="progress-text">0%</span></p>
                                </div>

                                <input type="hidden" name="nama_dokumen_pelan_db" class="form-control" value="{{ $dokumen->nama_dokumen_pelan }}">
                                <input type="hidden" name="large_file_name_new" id="large_file_name_new">
                                <input type="hidden" name="large_file_name_old" id="large_file_name_old">
                            </div>

                            <div class="form-group required">
                                {{ Form::label('status', 'Status Paparan Portal') }}
                                {{ Form::select('status', ['active' => 'Papar', 'inactive' => 'Tidak Papar'], $dokumen->status ?? 'inactive', ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-lg-6" style="text-align: center;">
                            @php
                                $fileSizeInMB = null;
                                $isPdf = false;

                                if (isset($dokumen->nama_dokumen_pelan)) {
                                    $filePath = storage_path('app/public/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan);

                                    if (file_exists($filePath)) {
                                        $fileSizeInBytes = filesize($filePath);
                                        $fileSizeInMB = $fileSizeInBytes / 1048576;

                                        // Check if file ends with .pdf (case-insensitive)
                                        $isPdf = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'pdf';
                                    }
                                }
                                // dd($fileSizeInMB);
                            @endphp
                            @if($dokumen->nama_dokumen_pelan && $fileSizeInMB < 1000 && $isPdf)
                                <object data="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan) }}" type="application/pdf" width="100%" height="600px">
                                    <p>Dokumen tidak dapat dipaparkan.
                                        <a href="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan) }}">Muat turun dokumen</a>.
                                    </p>
                                </object>

                                <p>{{ $fileSizeInMB ? number_format($fileSizeInMB, 2) . " MB" : '' }}</p>
                            @else
                                Dokumen tidak dapat dipaparkan
                                <br>&nbsp;
                            @endif
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    @php
                                        $folderName = isset($dokumen->nama_dokumen_pelan) ? 'ePIL/'.str_replace(' ', '_', $dokumen->folder).'/'.$dokumen->nama_dokumen_pelan : null;

                                        $fileExtension = isset($dokumen->nama_dokumen_pelan) ? pathinfo($dokumen->nama_dokumen_pelan, PATHINFO_EXTENSION) : '';
                                        $extensionIcon = null;
                                        if ($fileExtension === 'pdf') {
                                            $extensionIcon = "https://img.icons8.com/plasticine/100/pdf-2.png";
                                        } else {
                                            $extensionIcon = "https://img.icons8.com/fluency/48/winrar.png";
                                        }
                                    @endphp
                                    
                                    @if($folderName != null)
                                        <a href="{{ asset('storage/uploads/' . $folderName) }}" target="_blank" class="" style="border: 0px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;" download>
                                            <div class="product-image">
                                                <img src="{{ $extensionIcon }}" class="br-5" alt="" style="width: 100px; height: 100px; border-radius: 5px; margin-bottom: 10px;">
                                            </div>
                                            <div class="product-image">
                                                <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Muat Turun&nbsp;&nbsp;<i class="fas fa-download"></i></span>
                                            </div>
                                            <div class="product-image">
                                                <span class="file-name-1">{{ $dokumen->nama_dokumen_pelan ?? '' }}</span>
                                                <p>{{ $fileSizeInMB ? number_format($fileSizeInMB, 2) . " MB" : '' }}</p>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- <div class="form-group">
                        <label for="nama_fail">Nama Fail:</label>
                        <input type="text" name="nama_fail" class="form-control" value="{{ $dokumen->nama_fail }}" required>
                        <input type="hidden" name="folder" class="form-control" value="{{ $dokumen->folder }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="keterangan_dokumen_pelan">Keterangan:</label>
                        <input type="text" name="keterangan_dokumen_pelan" class="form-control" value="{{ $dokumen->keterangan_dokumen_pelan }}" required>
                    </div> -->
                    
                    <!-- <div class="row">
                        <div class="form-group required col-md-9">
                            <label for="nama_dokumen_pelan" class="col-md-12 control-label">Fail:</label>
                            <div class="col-md-12">
                                <input type="file" name="nama_dokumen_pelan" id="nama_dokumen_pelan" class="form-control" accept=".pdf">
                                {{ Form::label('', '***Muatnaik semula akan menggantikan fail sedia ada.', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                                <br>
                                <div id="progress-container" style="display: none;">
                                    <div id="progress-bar" style="width: 100%; background-color: #ccc;">
                                        <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
                                    </div>
                                    <p>Uploading: <span id="progress-text">0%</span></p>
                                </div>
                                <input type="hidden" name="nama_dokumen_pelan_db" class="form-control" value="{{ $dokumen->nama_dokumen_pelan }}" readonly>
                                <input name="large_file_name_new" type="hidden" id="large_file_name_new" readonly>
                                <input name="large_file_name_old" type="hidden" id="large_file_name_old" readonly>
                            </div>
                        </div>
                        <div class="form-group required col-md-3">
                            {{ Form::label('status', 'Status Aktif') }}
                            <div class="col-md-12">
                                {{ Form::select('status', ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'], $dokumen->status ?? 'inactive', ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="form-group">
                        <label for="nama_dokumen_pelan">Fail:</label>
                        <input type="file" name="nama_dokumen_pelan" id="nama_dokumen_pelan" class="form-control" accept=".pdf">
                        {{ Form::label('', '***Muatnaik semula akan menggantikan fail sedia ada.', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                        <br>
                        <div id="progress-container" style="display: none;">
                            <div id="progress-bar" style="width: 100%; background-color: #ccc;">
                                <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
                            </div>
                            <p>Uploading: <span id="progress-text">0%</span></p>
                        </div>
                        <input type="hidden" name="nama_dokumen_pelan_db" class="form-control" value="{{ $dokumen->nama_dokumen_pelan }}" readonly>
                        <input name="large_file_name_new" type="hidden" id="large_file_name_new" readonly>
                        <input name="large_file_name_old" type="hidden" id="large_file_name_old" readonly>
                    </div> -->
                    <!-- <div class="form-group" style="text-align: center;">
                        @if($dokumen->nama_dokumen_pelan)
                            <object data="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan) }}" type="application/pdf" width="100%" height="400">
                                <p>Dokumen tidak dapat dipaparkan. <a href="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan) }}">Download the PDF</a>.</p>
                            </object>
                            <?php
                                $fileSizeInMB = '';
                                if (isset($dokumen->nama_dokumen_pelan)) {
                                    $filePath = storage_path('app/public/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan);
                                    if (file_exists($filePath)) {
                                        $fileSizeInBytes = filesize($filePath);
                                        $fileSizeInMB = number_format($fileSizeInBytes / 1048576, 2);
                                    }
                                }
                            ?>
                            <p>{{ $fileSizeInMB ? $fileSizeInMB . " MB" : '' }}</p>
                        @endif
                    </div> -->
                    <!-- <div class="form-group">
                        {{ Form::label('status', 'Status Aktif') }}
                        {{ Form::select('status', ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'], $dokumen->status ?? 'inactive', ['class' => 'form-control']) }}
                    </div> -->
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to ePIL index) -->
                    {!! Form::button('Kembali', ['onclick'=>"window.location='".route('pengurusan.ePIL.edit',$dokumen->id_pelan)."'", 'class'=>'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Simpan', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'update'
                    ]) !!}

                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        const timestamp = new Date().getTime();
                        $('#nama_dokumen_pelan').change(function() {
                            document.querySelector('button[type="submit"]').disabled = true;
                            let destinationFolder = `ePIL/`+`{{$dokumen->folder}}`+`/`;
                            let deleteThis = $('#large_file_name_old').val();
                            // alert(destinationFolder);
                            let fileInput = $('#nama_dokumen_pelan')[0];
                            if (fileInput.files.length === 0) {
                                alert("No file selected!");
                                return;
                            }

                            let file = fileInput.files[0];
                            let chunkSize = 15 * 1024 * 1024;  // 10MB per chunk
                            let totalChunks = Math.ceil(file.size / chunkSize);
                            let currentChunk = 0;

                            // Show progress bar
                            $('#progress-container').show();

                            // Function to upload the next chunk
                            function uploadNextChunk() {
                                let start = currentChunk * chunkSize;
                                let end = Math.min(start + chunkSize, file.size);
                                let chunkBlob = file.slice(start, end);

                                let formData = new FormData();
                                formData.append('large_file', chunkBlob);
                                formData.append('chunk', currentChunk);
                                formData.append('totalChunks', totalChunks);
                                formData.append('fileName', timestamp+'_'+file.name);
                                formData.append('destinationFolder', destinationFolder);
                                formData.append('deleteThis', deleteThis);

                                // Upload the chunk
                                $.ajax({
                                    url: '/upload-chunk',
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        currentChunk++;
                                        let progress = Math.round((currentChunk / totalChunks) * 100);
                                        $('#progress').css('width', progress + '%');
                                        $('#progress-text').text(progress + '%');

                                        // Continue uploading next chunk
                                        if (currentChunk < totalChunks) {
                                            document.querySelector('button[type="submit"]').disabled = true;
                                            uploadNextChunk();
                                        } else {
                                            setTimeout(function() {
                                                alert("Upload Complete!");
                                            }, 1000);
                                            $('#large_file_name_new').val(timestamp+'_'+file.name);
                                            $('#large_file_name_old').val(timestamp+'_'+file.name);
                                            $('#nama_dokumen_pelan').val('');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // console.log("Error: " + error);
                                        alert("Error: " + error);
                                    },
                                    complete: function(xhr, status) {
                                        // Optionally log the completion of the request
                                        // console.log("Request complete with status: " + status);
                                        document.querySelector('button[type="submit"]').disabled = false;
                                    }
                                });
                            }

                            // Start the chunk upload process
                            uploadNextChunk();
                        });
                    });
                </script>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
