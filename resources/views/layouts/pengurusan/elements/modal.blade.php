<!-- Modal Logout -->
<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-power-off"></i> Log keluar</h5>
            </div>
            <div class="modal-body text-center border-0">Anda pasti untuk log keluar?</div>
            <div class="modal-footer d-flex  border-0">
                {!! Form::hidden('id', null, ['id'=>'id']) !!}
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1','data-dismiss'=>'modal']) !!}
                {!! Form::button('Log Keluar', ['onclick'=>'event.preventDefault();
                document.getElementById(\'logout-form\').submit();','class'=>'btn bg-green btn-lg btn-flat btn-block m-0
                ml-1']) !!}
                {!! Form::open(['id'=>'logout-form','style'=>'display: none;','method'=>'POST','route'=>['logout']]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            {!! Form::open(['method'=>'DELETE','id'=>'modalFormDelete']) !!}
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-trash"></i> Padam Rekod</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Adakan anda pasti untuk padam rekod ini?</strong></p>
            </div>
            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1','data-dismiss'=>'modal']) !!}
                {!! Form::button('Padam', ['type'=>'submit','class'=>'btn btn-success btn-lg btn-flat btn-block m-0
                ml-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Modal Serahan -->
 
<div class="modal" id="modalSerahan" tabindex="-1" role="dialog" aria-labelledby="modalSerahanLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-l">
        <div class="modal-content">
        {!! Form::open(['method' => 'PUT', 'id' => 'modalFormSerahan', 'route' => ['pengurusan.eLAPS.update', ''], 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-header d-flex justify-content-center bg-dark border-0">
                <h5 class="modal-title"><i class="fa fa-check"></i> Pilih Bahagian dan Serah Permohonan</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Sila pilih bahagian untuk diserah permohonan:</strong></p>
                <div class="form-group">
                    <!-- {!! Form::label('department', 'Pilih Bahagian:') !!} -->
                    {!! Form::select('bahagian_jln', [
                        //'Bahagian Penilaian & Penyelenggaraan' => 'Bahagian Penilaian & Penyelenggaraan',
                        '1' => 'Bahagian Pengurusan Landskap',
                        '2' => 'Bahagian Taman Awam',
                        '3' => 'Bahagian Pembangunan Landskap',
                        '4' => 'Bahagian Khidmat Teknikal',
                        '5' => 'Bahagian Penyelidikan & Pemulihan'
                    ], null, ['class' => 'form-control']) !!}
                    {!! Form::hidden('eLAPS_id', null, ['id' => 'eLAPS_id']) !!}
                </div>
            </div>

            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0 mr-1', 'data-dismiss'=>'modal']) !!}
                {!! Form::button('Serah Permohonan', ['type'=>'submit', 'name' => 'action', 'value' => 'serahan', 'class'=>'btn btn-success btn-lg btn-flat btn-block m-0 ml-1']) !!}
            </div>
        {!! Form::close() !!}

        </div>
    </div>
</div>

<!-- Modal Keputusan -->

<div class="modal" id="modalKeputusan" tabindex="-1" role="dialog" aria-labelledby="modalKeputusanLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-l">
        <div class="modal-content">
        {!! Form::open(['method' => 'PUT', 'id' => 'modalFormKeputusan', 'route' => ['pengurusan.eLAPS.update', ''], 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-header d-flex justify-content-center bg-dark border-0">
                <h5 class="modal-title">Status Keputusan JPT</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Sila pilih Status Keputusan JPT:</strong></p>
                <div class="form-group">
                    {!! Form::select('keputusan', [
                        '10' => 'Lulus',
                        '11' => 'Gagal'
                    ], null, ['class' => 'form-control']) !!}
                    {!! Form::hidden('eLAPS_id', null, ['id' => 'eLAPS_idK']) !!}
                </div>
            </div>

            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0 mr-1', 'data-dismiss'=>'modal']) !!}
                {!! Form::button('Kemaskini Status', ['type'=>'submit', 'name' => 'action', 'value' => 'keputusan', 'class'=>'btn btn-success btn-lg btn-flat btn-block m-0 ml-1']) !!}
            </div>
        {!! Form::close() !!}

        </div>
    </div>
</div>


<!-- Modal StatusProjek -->
<div class="modal" id="modalStatusProjek" tabindex="-1" role="dialog" aria-labelledby="modalStatusProjekLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-l">
        <div class="modal-content">
        {!! Form::open(['method' => 'PUT', 'id' => 'modalFormStatus', 'route' => ['pengurusan.eLAPS.update', ''], 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-header d-flex justify-content-center bg-dark border-0">
                <h5 class="modal-title">Status Projek</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Sila pilih Status Projek:</strong></p>
                <div class="form-group">
                    {!! Form::select('statusProjek', [], null, ['class' => 'form-control', 'id' => 'statusProjekSelect']) !!}
                    {{ Form::hidden('eLAPS_id', null, ['id' => 'eLAPS_idP']) }}
                </div>
            </div>

            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0 mr-1', 'data-dismiss'=>'modal']) !!}
                {!! Form::button('Kemaskini Status', ['type'=>'submit', 'name' => 'action', 'value' => 'status', 'class'=>'btn btn-success btn-lg btn-flat btn-block m-0 ml-1']) !!}
            </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal" id="modalKomenPrestasi" tabindex="-1" role="dialog" aria-labelledby="modalKomenPrestasiLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-l">
        <div class="modal-content">
            {!! Form::open(['method'=>'PUT', 'id'=>'modalFormKomenPrestasi']) !!}
            <div class="modal-header d-flex justify-content-center bg-dark border-0">
                <h5 class="modal-title">Komen dan Prestasi</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Sila pilih Prestasi dan masukkan Komen:</strong></p>

                <!-- Prestasi Options -->
                <div class="form-group">
                    {!! Form::label('prestasi', 'Prestasi:') !!}
                    {!! Form::select('prestasi', [
                        '1' => 'Sangat Baik',
                        '2' => 'Baik',
                        '3' => 'Sederhana',
                        '4' => 'Lemah',
                        '0' => 'Tiada Maklumat'
                    ], null, ['class' => 'form-control', 'id' => 'prestasiSelect']) !!}
                </div>

                <!-- Komen Field -->
                <div class="form-group">
                    {!! Form::label('komen', 'Komen:') !!}
                    {!! Form::textarea('komen', null, ['class' => 'form-control', 'id' => 'komenTextarea', 'rows' => 3, 'placeholder' => 'Masukkan komen di sini...']) !!}
                </div>
                {{ Form::hidden('elind_id', null, ['id' => 'elind_idP']) }}
                <input type="hidden" class="form-control" id="action" name="action" value="prestasi">
            </div>

            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0 mr-1', 'data-dismiss'=>'modal']) !!}
                {!! Form::button('Simpan', ['type'=>'submit', 'class'=>'btn btn-success btn-lg btn-flat btn-block m-0 ml-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Komponen Landskap Perbandaran -->
 
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Tambah Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => ['pengurusan.ePALM.store'], 'method' => 'POST', 'id' => 'ePALMForm', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_taman">Nama Komponen</label>
                        <input type="hidden" class="form-control" id="id_taman" name="id_taman" placeholder="Masukkan Nama Komponen" value="{{ $ePALM->id_taman ?? ''}}">
                        <input type="hidden" class="form-control" id="nama_taman" name="nama_taman" placeholder="Masukkan Nama Komponen" value="{{ $ePALM->nama_taman ?? ''}}">
                        <input type="hidden" class="form-control" id="jenis" name="jenis" placeholder="Masukkan Nama Komponen" value="komponen">
                        <input type="text" class="form-control" id="nama_komponen" name="nama_komponen" placeholder="Masukkan Nama Komponen" value="">
                    </div>
                    <div class="form-group">
                        <label for="keterangan_taman">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan_taman" name="keterangan_taman" placeholder="Masukkan Keterangan Komponen">
                    </div>
                    <style>

                        /* Container for the grid with files and previews */
                        .grid2-container {
                            display: grid;
                            grid-template-columns: 1fr 1fr; /* 2 equal-width columns */
                            gap: 10px; /* Space between grid items */
                            width: 100%;  /* Ensure the grid fills available width */
                            max-width: 600px;  /* Limit max width for grid */
                            height: auto; /* Allow the height to adjust based on content */
                        }

                        /* Grid item styling */
                        .grid2-item {
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
                        .image2-preview-container {
                            display: grid;
                            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                            gap: 10px;
                            margin-top: 10px;
                            width: 100%;
                            overflow-y: auto; /* Allow scrolling if the preview exceeds height */
                        }

                        .image2-preview-container img {
                            width: 100%;
                            height: 100px;
                            object-fit: cover;
                            border-radius: 5px;
                            border: 1px solid #ddd;
                            padding: 2px;
                        }

                        /* File input button styling */
                        .form2-control-file {
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

                    <!-- Grid for file input and image preview containers -->
                    <div class="grid2-container">
                        <!-- First Image Preview and File Input -->
                        <div class="grid2-item">
                            <input type="file" class="form2-control-file" id="gambar_input_modal_1" name="gambar_input_modal_1" accept="image/*">
                            <div id="imagePreviewContainer1" class="image2-preview-container"></div>
                        </div>

                        <!-- Second Image Preview and File Input -->
                        <div class="grid2-item">
                            <input type="file" class="form2-control-file" id="gambar_input_modal_2" name="gambar_input_modal_2" accept="image/*">
                            <div id="imagePreviewContainer2" class="image2-preview-container"></div>
                        </div>

                        <!-- Third Image Preview and File Input -->
                        <div class="grid2-item">
                            <input type="file" class="form2-control-file" id="gambar_input_modal_3" name="gambar_input_modal_3" accept="image/*">
                            <div id="imagePreviewContainer3" class="image2-preview-container"></div>
                        </div>

                        <!-- Fourth Image Preview and File Input -->
                        <div class="grid2-item">
                            <input type="file" class="form2-control-file" id="gambar_input_modal_4" name="gambar_input_modal_4" accept="image/*">
                            <div id="imagePreviewContainer4" class="image2-preview-container"></div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveProductBtn">Simpan Komponen</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Kemaskini Komponen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Form for adding/updating product -->
            {{ Form::open(['route' => ['pengurusan.ePALM.update', ':id'], 'method' => 'POST', 'id' => 'updateKomponen', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama_taman">Nama Komponen</label>
                    <!-- Hidden field to store the ID of the product you're updating -->
                    <input type="hidden" class="form-control" id="id_tamanX" name="id_tamanX" placeholder="Masukkan Nama Komponen" value="">
                    <input type="hidden" class="form-control" id="nama_taman" name="nama_taman" placeholder="Masukkan Nama Komponen" value="{{ $ePALM->nama_taman ?? ''}}">
                    <input type="hidden" class="form-control" id="jenis" name="jenis" placeholder="Masukkan Nama Komponen" value="komponen">
                    <input type="hidden" class="form-control" id="update" name="update" placeholder="Masukkan Nama Komponen" value="komponen">
                    <input type="text" class="form-control" id="nama_komponenX" name="nama_komponenX" placeholder="Masukkan Nama Komponen" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="keterangan_taman">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan_tamanX" name="keterangan_tamanX" placeholder="Masukkan Keterangan Komponen" value="">
                    <input type="hidden" class="form-control" id="gambar_taman" name="gambar_taman" placeholder="Masukkan Keterangan Komponen" value="">
                </div>
                <style>
                    .grid2-container {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 10px;
                        width: 100%;
                        max-width: 600px;
                        height: auto;
                    }

                    .grid2-item {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: space-between;
                        text-align: center;
                        border: 1px solid #ddd;
                        background-color: lightgray;
                        padding: 10px;
                        box-sizing: border-box;
                    }

                    .image2-preview-container {
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                        gap: 10px;
                        margin-top: 10px;
                        width: 100%;
                    }

                    .image2-preview-container img {
                        width: 100%;
                        height: 100px;
                        object-fit: cover;
                        border-radius: 5px;
                        border: 1px solid #ddd;
                    }

                    .form2-control-file {
                        padding: 5px;
                        font-size: 12px;
                        width: 100%;
                        height: 30px;
                        border-radius: 4px;
                        background-color: #f7f7f7;
                        border: 1px solid #ccc;
                    }
                </style>
                <div class="grid2-container">
                    <div class="grid2-item">
                        <input type="file" class="form2-control-file" id="gambar_update_modal_1" name="gambar_update_modal_1" accept="image/*">
                        <div id="imageUpdate1" class="image2-preview-container">
                        </div>
                    </div>
                    <div class="grid2-item">
                        <input type="file" class="form2-control-file" id="gambar_update_modal_2" name="gambar_update_modal_2" accept="image/*">
                        <div id="imageUpdate2" class="image2-preview-container">
                        </div>
                    </div>
                    <div class="grid2-item">
                        <input type="file" class="form2-control-file" id="gambar_update_modal_3" name="gambar_update_modal_3" accept="image/*">
                        <div id="imageUpdate3" class="image2-preview-container">
                        </div>
                    </div>
                    <div class="grid2-item">
                        <input type="file" class="form2-control-file" id="gambar_update_modal_4" name="gambar_update_modal_4" accept="image/*">
                        <div id="imageUpdate4" class="image2-preview-container">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="updateProductBtn">Kemaskini Komponen</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal" id="deleteKomponenModal" tabindex="-1" role="dialog" aria-labelledby="deleteKomponenModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            {{ Form::open(['route' => ['pengurusan.ePALM.update', ':id'], 'method' => 'POST', 'id' => 'deleteKomponen', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-header d-flex justify-content-center bg-dark  border-0">
                <h5 class="modal-title"><i class="fa fa-trash"></i> Padam Komponen</h5>
            </div>

            <div class="modal-body text-center">
                <p><strong>Adakan anda pasti untuk padam rekod ini?</strong></p>
                <input type="hidden" class="form-control" id="id_tamanD" name="id_tamanD" placeholder="Masukkan Nama Komponen" value="">
                <input type="hidden" class="form-control" id="jenis" name="jenis" placeholder="Masukkan Nama Komponen" value="komponen">
                <input type="hidden" class="form-control" id="delete" name="delete" placeholder="Masukkan Nama Komponen" value="komponen">
            </div>
            <div class="modal-footer d-flex">
                {!! Form::button('Batal', ['class'=>'btn btn-danger btn-lg btn-flat btn-block m-0
                mr-1','data-dismiss'=>'modal']) !!}
                {!! Form::button('Padam', ['type'=>'button', 'id'=>'deleteKomponenBtn', 'class'=>'btn btn-success btn-lg btn-flat btn-block m-0 ml-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Komponen Landskap Perbandaran -->






@section('modal')
<script>
    $(document).ready(function () {

        // BS4 Modal Via JavaScript
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);       
            var url = button.data('url'); // Extract info from data-* attributes
            $('#modalFormDelete').attr('action', url);
            console.log(url);
        });

        
        $('#updateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_taman = button.data('id_taman');
            var gambar_taman = button.data('gambar_taman');
            // alert(gambar_taman);
            var nama_komponenX = button.data('nama_taman');
            var keterangan_taman = button.data('keterangan_taman');
            var images = button.data('images');
            let result = images.split(',');

            result.forEach(function(src, index) {
                var image = $('<img>', {
                    src: src,
                    alt: 'Image preview'
                });
                $('#imageUpdate' + (index+1)).append(image);
            });
            $('#id_tamanX').val(id_taman);
            $('#nama_komponenX').val(nama_komponenX);
            $('#keterangan_tamanX').val(keterangan_taman);
            $('#gambar_taman').val(JSON.stringify(gambar_taman));

            document.getElementById('gambar_update_modal_1').addEventListener('change', function () {
                previewImage(this, document.getElementById('imageUpdate1'));
            });
            document.getElementById('gambar_update_modal_2').addEventListener('change', function () {
                previewImage(this, document.getElementById('imageUpdate2'));
            });
            document.getElementById('gambar_update_modal_3').addEventListener('change', function () {
                previewImage(this, document.getElementById('imageUpdate3'));
            });
            document.getElementById('gambar_update_modal_4').addEventListener('change', function () {
                previewImage(this, document.getElementById('imageUpdate4'));
            });

            // $('#updateKomponen').attr('action', url);
        });

        $('#deleteKomponenModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_taman = button.data('id_taman');

            $('#id_tamanD').val(id_taman);
        });


        $('#modalSerahan').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var elapsId = button.data('elaps-id');

            // Update the hidden input field with the eLAPS ID
            $('#eLAPS_id').val(elapsId);
            let url = document.querySelector('#modalSerahan form').getAttribute('action');
            document.querySelector('#modalSerahan form').setAttribute('action', url + '/' + elapsId);
            // alert(document.querySelector('#modalSerahan form').getAttribute('action'));
        });

        $('#modalKeputusan').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var elapsId = button.data('elaps-id');

            // Update the hidden input field with the eLAPS ID
            $('#eLAPS_idK').val(elapsId);
            let url = document.querySelector('#modalKeputusan form').getAttribute('action');
            document.querySelector('#modalKeputusan form').setAttribute('action', url + '/' + elapsId);
            // alert(document.querySelector('#modalKeputusan form').getAttribute('action'));
        });

        $('#modalStatusProjek').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var elapsId = button.data('elaps-id');

            // Update the hidden input field with the eLAPS ID
            $('#eLAPS_idP').val(elapsId);
            let url = document.querySelector('#modalStatusProjek form').getAttribute('action');
            document.querySelector('#modalStatusProjek form').setAttribute('action', url + '/' + elapsId);

            var text = button.data('text');
            var select = $('#statusProjekSelect');
            select.empty();
            if (text === 10) {
                select.append('<option value="12">Projek dalam pembinaan</option>');
            }
            if (text >= 10) {
                select.append('<option value="13">Projek Batal</option>');
                select.append('<option value="14">Projek Siap</option>');
            }
        });

        $('#modalKomenPrestasi').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var elindId = button.data('elind-id'); // Extract the elind ID from the button

            // Update the hidden input field with the elind ID
            $('#elind_idP').val(elindId);
            let url = document.querySelector('#modalKomenPrestasi form').getAttribute('action');
            document.querySelector('#modalKomenPrestasi form').setAttribute('action', url + '/' + elindId);
            console.log(document.querySelector('#modalKomenPrestasi form'));
            // alert(url);
        });

        
        $('#modalSerahan').on('hidden.bs.modal', function (event) {
            document.querySelector('#modalSerahan form').setAttribute('action', '{{ route("pengurusan.eLAPS.update", "") }}');
        });
        
        $('#modalKeputusan').on('hidden.bs.modal', function (event) {
            document.querySelector('#modalKeputusan form').setAttribute('action', '{{ route("pengurusan.eLAPS.update", "") }}');
        });
        
        $('#modalStatusProjek').on('hidden.bs.modal', function (event) {
            document.querySelector('#modalStatusProjek form').setAttribute('action', '{{ route("pengurusan.eLAPS.update", "") }}');
        });
        
        $('#modalKomenPrestasi').on('hidden.bs.modal', function (event) {
            document.querySelector('#modalKomenPrestasi form').setAttribute('action', '{{ route("pengurusan.eLAPS.update", "") }}');
        });




    
    });
</script>

@endsection
