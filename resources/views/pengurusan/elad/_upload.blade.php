<div class="form-row">
    <div class="form-group row">
        <div class="col-md-12">
            <div class="d-block">
                {{ Form::label('fail_dokumen', 'Muat Naik Dokumen') }}
                <p>Hanya satu (1) dokumen (.pdf) atau (.zip) dibenarkan.</p>
                {{ Form::file('supporting_documents', ['class' => 'form-control d-inline-block ms-2', 'id' => 'supporting_documents', 'multiple' => false, 'style' => 'width: 100%;', 'accept' => 'application/pdf,application/zip']) }}
                <input name="large_file_name_new" type="hidden" id="large_file_name_new">
                <input name="large_file_name_old" type="hidden" id="large_file_name_old">
                <input name="file_type" type="hidden" id="file_type">
                <input name="file_size" type="hidden" id="file_size">
                <input name="file_mime" type="hidden" id="file_mime">
            </div>
            <div id="progress-container" style="display: none;">
                <div id="progress-bar" style="width: 100%; background-color: #ccc;">
                    <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
                </div>
                <p>Sedang memuatnaik, sila tunggu: <span id="progress-text">0%</span></p>
            </div> 
            <div id="uploaded-file-name" style="display: none;">
                <p>Nama Fail: <span id="file-name"></span></p>
            </div>  
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        const timestamp = new Date().getTime();
        const isEditPage = window.location.href.includes('edit');
        
        if (!isEditPage) {
            $('button[type="submit"]').prop('disabled', true); 
        }

        $('#supporting_documents').change(function() {
            if (this.files.length > 0) {
                $('button[type="submit"]').prop('disabled', false); 
            } else if (!isEditPage) {
                $('button[type="submit"]').prop('disabled', true); 
            }
        });

        $('#supporting_documents').change(function() {
            if (this.files.length === 0) {
                Swal.fire('Error', 'No file selected!', 'error');
                return;
            }

            $('button[type="submit"]').prop('disabled', true);
            $('#supporting_documents').prop('disabled', true);
            let fileInput = $('#supporting_documents')[0];
            let file = fileInput.files[0];
            let fileExtension = file.name.split('.').pop().toLowerCase();
            let allowedExtensions = ['pdf', 'zip'];

            if (!allowedExtensions.includes(fileExtension)) {
                Swal.fire('Error', 'Hanya Fail PDF Atau ZIP Sahaja Dibenarkan!', 'error');
                $('#supporting_documents').val(''); // Clear the file input
                $('button[type="submit"]').prop('disabled', true); // Keep the submit button disabled
                $('#supporting_documents').prop('disabled', false); // Re-enable the file input for new selection
                return;
            }

            //console.log('File Type:', file.type);
            //console.log('File Extension:', fileExtension);

            let destinationFolder = 'elad/temp/';
            let deleteThis = $('#large_file_name_old').val();
            let file_size = file.size;
            let file_type = file.type;
            let file_mime = file.type; 
            let chunkSize = 15 * 1024 * 1024;  // 15MB per chunk
            let totalChunks = Math.ceil(file.size / chunkSize);
            let currentChunk = 0;

            // Show progress bar
            $('#progress-container').show();
            $('#progress').css('width', '0%');
            $('#progress-text').text('0%');

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
                                alert('Fail berjaya dimuatnaik.');
                                $('#file-name').text(file.name);
                                $('#uploaded-file-name').show();
                            }, 1000);
                            $('#large_file_name_new').val(timestamp+'_'+file.name);
                            $('#large_file_name_old').val(timestamp+'_'+file.name);
                            $('#file_size').val(file_size);
                            $('#file_type').val(file_type);
                            $('#file_mime').val(file_mime);
                            $('#supporting_documents').val('');
                            $('button[type="submit"]').prop('disabled', false);
                            $('#supporting_documents').prop('disabled', false);
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

