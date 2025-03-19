@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini ePIL')

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
                    <!-- Name and Description -->
                    <div class="form-group">
                        <label for="nama_fail">Nama Fail:</label>
                        <input type="text" name="nama_fail" class="form-control" value="{{ $dokumen->nama_fail }}" required>
                        <input type="hidden" name="folder" class="form-control" value="{{ $dokumen->folder }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="keterangan_dokumen_pelan">Keterangan:</label>
                        <input type="text" name="keterangan_dokumen_pelan" class="form-control" value="{{ $dokumen->keterangan_dokumen_pelan }}" required>
                    </div>

                    <!-- Image -->
                    <!-- <div class="form-group">
                        <label for="gambar_dokumen_pelan">Image:</label>
                        @if($dokumen->gambar_dokumen_pelan)
                            <img src="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->gambar_dokumen_pelan) }}" alt="Image" style="width: 100px; height: 100px;">
                        @endif
                        <input type="file" name="gambar_dokumen_pelan" class="form-control" accept="image/*">
                        <input type="text" name="gambar_dokumen_pelan_db" class="form-control" value="{{ $dokumen->gambar_dokumen_pelan }}">
                    </div> -->

                    <!-- File -->
                    <div class="form-group">
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
                    </div>
                    <div class="form-group" style="text-align: center;">
                        @if($dokumen->nama_dokumen_pelan)
                            <object data="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan) }}" type="application/pdf" width="70%" height="1100">
                                <p>Your browser does not support PDFs. <a href="{{ asset('storage/uploads/ePIL/'.$dokumen->folder.'/'.$dokumen->nama_dokumen_pelan) }}">Download the PDF</a>.</p>
                            </object>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::label('status', 'Status Aktif') }}
                        {{ Form::select('status', ['active' => 'Aktif', 'inactive' => 'Tidak Aktif'], $dokumen->status ?? 'inactive', ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to ePIL index) -->
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.ePIL.edit',$dokumen->id_pelan)."'", 'class'=>'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', [
                        'class' => 'btn btn-primary', 
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
                            let destinationFolder = `ePIL/`+`{{$dokumen->folder}}`+`/`;
                            let deleteThis = $('#large_file_name_old').val();
                            // alert(destinationFolder);
                            let fileInput = $('#nama_dokumen_pelan')[0];
                            if (fileInput.files.length === 0) {
                                alert("No file selected!");
                                return;
                            }

                            let file = fileInput.files[0];
                            let chunkSize = 20 * 1024 * 1024;  // 10MB per chunk
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
                                        console.log("Error: " + error);
                                    },
                                    complete: function(xhr, status) {
                                        // Optionally log the completion of the request
                                        console.log("Request complete with status: " + status);
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
