<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chunk File Upload</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Set up the CSRF token for every AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#upload-btn').click(function() {
                let fileInput = $('#supporting_documents')[0];
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
                    formData.append('supporting_documents', chunkBlob);
                    formData.append('chunk', currentChunk);
                    formData.append('totalChunks', totalChunks);
                    formData.append('fileName', 'zoink_'+file.name);

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
                                alert("Upload Complete!");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                        }
                    });
                }

                // Start the chunk upload process
                uploadNextChunk();
            });
        });
    </script>
</head>
<body>
    <h2>Chunked File Upload</h2>

    <form id="chunk-upload-form" enctype="multipart/form-data">
        <input type="file" name="supporting_documents" id="supporting_documents" multiple>
        <button type="button" id="upload-btn">Upload</button>
    </form>

    <div id="progress-container" style="display: none;">
        <p>Uploading: <span id="progress-text">0%</span></p>
        <div id="progress-bar" style="width: 100%; background-color: #ccc;">
            <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
        </div>
    </div>
</body>
</html>
