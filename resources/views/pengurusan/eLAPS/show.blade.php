@extends('layouts.pengurusan.app')

@section('title', 'Lihat eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                <div class="card-body table-hardscape form-hardscape text-sm">

                    <!-- Start Table -->
                    <table class="table table-bordered">
                        <!-- First Row: Title (Tajuk Permohonan and Rujukan) -->
                        <tr style="background-color: #ffff00;">
                            <td>{{ Form::label('projectTitle', '1.&nbsp;&nbsp;&nbsp;&nbsp;TAJUK PERMOHONAN PROJEK:', ['class' => 'col-form-label']) }}</td>
                            <!-- <td colspan="3">{{ Form::text('projectTitle', null, ['class' => 'form-control', 'inert' => true]) }}</td> -->
                            <td colspan="3">{{ Form::textarea('projectTitle', null, ['class' => 'form-control', 'inert' => true, 'rows' => 2, 'cols' => 50]) }}</td>
                            <td>{{ Form::label('referenceNumber', '2.&nbsp;&nbsp;&nbsp;&nbsp;RUJUKAN PERMOHONAN:', ['class' => 'col-form-label']) }}</td>
                            <td>{{ Form::text('referenceNumber', null, ['class' => 'form-control', 'inert' => true]) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px;"></td>
                        </tr>

                        <!-- Second Row: KATEGORI PROJEK -->
                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('projectCategory', '3.&nbsp;&nbsp;&nbsp;&nbsp;KATEGORI PROJEK:', ['class' => 'col-form-label']) }}</td>
                        </tr>
                        <!-- Third Row: Rancangan Pembangunan (checkboxes with input fields) -->
                        <tr>
                            <td colspan="6">
                                <!-- Start: Categories Checkboxes -->
                                <!-- <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Taman Awam', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_awam']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_taman_awam', 'Taman Awam', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Taman Botani', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_botani']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_taman_botani', 'Taman Botani', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Pemuliharaan Dan Penyelidikan Landskap', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_pemuliharaan']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_pemuliharaan', 'Pemuliharaan Dan Penyelidikan Landskap', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Landskap Perbandaran', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_landskap_perbandaran']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_landskap_perbandaran', 'Landskap Perbandaran', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Persekitaran Kehidupan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_persekitaran']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_persekitaran', 'Persekitaran Kehidupan', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Penyelenggaraan Landskap', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_penyelenggaraan']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_penyelenggaraan', 'Penyelenggaraan Landskap', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Taman Persekutuan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_persekutuan']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_taman_persekutuan', 'Taman Persekutuan', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Naik Taraf Taman Awam', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_naik_taraf']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_naik_taraf', 'Naik Taraf Taman Awam', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Lain-lain (sila nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_lain', 'onclick' => 'toggleLainLainText()']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_lain', 'Lain-lain (sila nyatakan)', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Taman Awam', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_awam', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_taman_awam', 'Taman Awam', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Taman Botani', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_botani', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_taman_botani', 'Taman Botani', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Pemuliharaan Dan Penyelidikan Landskap', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_pemuliharaan', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_pemuliharaan', 'Pemuliharaan Dan Penyelidikan Landskap', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Landskap Perbandaran', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_landskap_perbandaran', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_landskap_perbandaran', 'Landskap Perbandaran', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Persekitaran Kehidupan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_persekitaran', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_persekitaran', 'Persekitaran Kehidupan', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Penyelenggaraan Landskap', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_penyelenggaraan', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_penyelenggaraan', 'Penyelenggaraan Landskap', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Taman Persekutuan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_taman_persekutuan', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_taman_persekutuan', 'Taman Persekutuan', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Naik Taraf Taman Awam', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_naik_taraf', 'onclick' => 'onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_naik_taraf', 'Naik Taraf Taman Awam', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            {{ Form::checkbox('category[]', 'Lain-lain (sila nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'category_lain', 'onclick' => 'toggleLainLainText();onlyOne1(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('category_lain', 'Lain-lain (sila nyatakan)', ['class' => 'form-check-label bigger-label']) }}
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function onlyOne1(checkbox1) {
                                        var checkboxes1 = document.querySelectorAll('input[name="category[]"]');
                                        checkboxes1.forEach(function(item1) {
                                            if (item1 !== checkbox1) {
                                                item1.checked = false;
                                            }
                                        });
                                    }
                                </script>


                                <!-- Textbox for "Lain-lain" option -->
                                <div class="form-group row" id="lain_lain_details" style="display: none;">
                                    <div class="col-md-12">
                                        {{ Form::label('lain_lain_text', 'Sila Nyatakan:', ['class' => 'col-form-label']) }}
                                        {{ Form::text('lain_lain_text', null, ['class' => 'form-control', 'inert' => true, 'placeholder' => 'Masukkan maklumat lain-lain']) }}
                                    </div>
                                </div>

                                <!-- JavaScript to toggle the display of the "Lain-lain" text box -->
                                <script>
                                    function toggleLainLainText() {
                                        var checkBox = document.getElementById('category_lain');
                                        var textBox = document.getElementById('lain_lain_details');
                                        if (checkBox.checked) {
                                            textBox.style.display = 'block';
                                        } else {
                                            textBox.style.display = 'none';
                                        }
                                    }
                                </script>

                            </td>
                        </tr>
                        <!-- Third Row: Rancangan Pembangunan (checkbox and text box) -->
                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('rancangan_pembangunan', '4.&nbsp;&nbsp;&nbsp;&nbsp;RANCANGAN PEMBANGUNAN:', ['class' => 'col-form-label']) }}</td>
                        </tr>

                        <!-- Third Row: Rancangan Pembangunan (checkboxes with input fields) -->
                        <tr>
                            <td colspan="6">
                                <!-- <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Pelan Induk Landskap', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('pelan_induk_landskap', 'Pelan Induk Landskap : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('pelan_induk_landskap_details', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Struktur', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_2']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('pelan_induk_landskap_2', 'Rancangan Struktur : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('pelan_induk_landskap_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Tempatan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_3']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('pelan_induk_landskap_3', 'Rancangan Tempatan : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('pelan_induk_landskap_details_3', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Kawasan Khas', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_4']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('pelan_induk_landskap_4', 'Rancangan Kawasan Khas : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('pelan_induk_landskap_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Lain-Lain Pelan Pembangunan (Nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_5']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('pelan_induk_landskap_5', 'Lain-Lain Pelan Pembangunan (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('pelan_induk_landskap_details_5', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <!-- First Checkbox with Input -->
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Pelan Induk Landskap', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'rancangan_pembangunan', 'onclick' => 'onlyOne2(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('rancangan_pembangunan', 'Pelan Induk Landskap : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('rancangan_pembangunan_details', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Second Checkbox with Input -->
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Struktur', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'rancangan_pembangunan_2', 'onclick' => 'onlyOne2(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('rancangan_pembangunan_2', 'Rancangan Struktur : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('rancangan_pembangunan_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Rows: More checkboxes and inputs -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Tempatan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'rancangan_pembangunan_3', 'onclick' => 'onlyOne2(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('rancangan_pembangunan_3', 'Rancangan Tempatan : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('rancangan_pembangunan_details_3', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Rancangan Kawasan Khas', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'rancangan_pembangunan_4', 'onclick' => 'onlyOne2(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('rancangan_pembangunan_4', 'Rancangan Kawasan Khas : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('rancangan_pembangunan_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('rancangan_pembangunan[]', 'Lain-Lain Pelan Pembangunan (Nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'rancangan_pembangunan_5', 'onclick' => 'onlyOne2(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('rancangan_pembangunan_5', 'Lain-Lain Pelan Pembangunan (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('rancangan_pembangunan_details_5', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // JavaScript function to ensure only one checkbox is selected
                                    function onlyOne2(checkbox2) {
                                        var checkboxes2 = document.querySelectorAll('input[name="rancangan_pembangunan[]"]');
                                        checkboxes2.forEach(function(item2) {
                                            if (item2 !== checkbox2) {
                                                item2.checked = false;
                                            }
                                        });
                                    }
                                </script>

                            </td>
                        </tr>


                        <!-- Fourth Row: PERIHAL TAPAK -->
                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('tapak_details', '5.&nbsp;&nbsp;&nbsp;&nbsp;PERIHAL TAPAK:', ['class' => 'col-form-label']) }}</td>
                        </tr>

                        <!-- Fifth Row: Keluasan and Panjang -->
                        <tr>
                            <td>{{ Form::label('keluasan', 'a.&nbsp;&nbsp;&nbsp;&nbsp;Keluasan (ekar / hektar) :', ['class' => 'col-form-label']) }}</td>
                            <td>{{ Form::text('keluasan', null, ['class' => 'form-control', 'inert' => true]) }}</td>

                            <!-- Dropdown for Unit (Keluasan) with fixed width -->
                            <td>
                                {{ Form::select('unit_keluasan', ['ekar' => 'Ekar', 'hektar' => 'Hektar'], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 150px;']) }}
                            </td>

                            <td>{{ Form::label('panjang', 'Panjang (Jika berkaitan):', ['class' => 'col-form-label']) }}</td>
                            <td>{{ Form::text('panjang', null, ['class' => 'form-control', 'inert' => true]) }}</td>

                            <!-- Dropdown for Unit (Panjang) with fixed width -->
                            <td>
                                {{ Form::select('unit_panjang', ['meter' => 'Meter', 'kilometer' => 'Kilometer'], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 150px;']) }}
                            </td>
                        </tr>


                        <tr>
                            <td>{{ Form::label('hakmilik_tanah', 'b.&nbsp;&nbsp;&nbsp;&nbsp;Hakmilik Tanah :', ['class' => 'col-form-label']) }}</td>
                            
                            <!-- <td>
                                <div class="form-check d-flex align-items-center">
                                    {{ Form::checkbox('hakmilik_tanah[]', 'PBT', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_4']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::label('pelan_induk_landskap_4', 'PBT', ['class' => 'form-check-label bigger-label ms-2']) }}
                                    {{ Form::text('pelan_induk_landskap_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;']) }}
                                </div>
                            </td>

                            <td>
                                <div class="form-check d-flex align-items-center">
                                    {{ Form::checkbox('hakmilik_tanah[]', 'Negeri', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_4']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::label('pelan_induk_landskap_4', 'Negeri', ['class' => 'form-check-label bigger-label ms-2']) }}
                                    {{ Form::text('pelan_induk_landskap_details_4', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;']) }}
                                </div>
                            </td>

                            <td colspan="3">
                                <div class="form-check d-flex align-items-center">
                                    {{ Form::checkbox('hakmilik_tanah[]', 'Agensi lain (Nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_induk_landskap_5']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::label('pelan_induk_landskap_5', 'Agensi lain (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::text('pelan_induk_landskap_details_5', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;']) }}
                                </div>
                            </td> -->
                            <td>
                                <div class="form-check d-flex align-items-center">
                                    {{ Form::checkbox('hakmilik_tanah[]', 'PBT', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'hakmilik_tanah_1', 'onclick' => 'onlyOne3(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::label('hakmilik_tanah_1', 'PBT', ['class' => 'form-check-label bigger-label ms-2']) }}
                                    {{ Form::text('hakmilik_tanah_details_1', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;']) }}
                                </div>
                            </td>

                            <td>
                                <div class="form-check d-flex align-items-center">
                                    {{ Form::checkbox('hakmilik_tanah[]', 'Negeri', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'hakmilik_tanah_2', 'onclick' => 'onlyOne3(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::label('hakmilik_tanah_2', 'Negeri', ['class' => 'form-check-label bigger-label ms-2']) }}
                                    {{ Form::text('hakmilik_tanah_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;']) }}
                                </div>
                            </td>

                            <td colspan="3">
                                <div class="form-check d-flex align-items-center">
                                    {{ Form::checkbox('hakmilik_tanah[]', 'Agensi lain (Nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'hakmilik_tanah_3', 'onclick' => 'onlyOne3(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::label('hakmilik_tanah_3', 'Agensi lain (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ Form::text('hakmilik_tanah_details_3', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%;']) }}
                                </div>
                            </td>

                            <script>
                                function onlyOne3(checkbox3) {
                                    var checkboxes3 = document.querySelectorAll('input[name="hakmilik_tanah[]"]');
                                    checkboxes3.forEach(function(item3) {
                                        if (item3 !== checkbox3) {
                                            item3.checked = false;
                                        }
                                    });
                                }
                            </script>

                        </tr>

                        <tr>
                            <td colspan="6" style="font-size: 10px; height: 20px; padding-top: 5px; padding-bottom: 5px;">
                                {{ Form::label('note1', '(WAJIB disertakan salinan Surat Hakmilik Tanah dan Pelan Akui (Certified Plan) untuk setiap lot yg terlibat)', ['class' => 'col-form-label']) }}
                            </td>
                        </tr>

                        <!-- c. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td colspan="3">
                                {{ Form::label('keluasan', 'c.&nbsp;&nbsp;&nbsp;&nbsp;Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap', ['class' => 'col-form-label']) }}
                                <br>
                                {{ Form::label('note1', '(WAJIB disertakan salinan surat pewartaan untuk setiap lot yg terlibat)', ['class' => 'col-form-label','style'=>'font-size: 10px; height: 20px; padding-top: 5px; padding-bottom: 5px;']) }}
                            </td>
                            <td colspan="3">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('status_tanah[]', 'Diwartakan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'status_tanah_1', 'onclick' => 'onlyOne4(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('status_tanah_1', 'Diwartakan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::label('status_tanah_1', 'Tarikh:', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::date('status_tanah_details_1', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada','disabled'=>'true', 'id' => 'status_tanah_details_1']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('status_tanah[]', 'Proses Perwartaan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'status_tanah_2', 'onclick' => 'onlyOne4(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('status_tanah_2', 'Proses Perwartaan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::label('status_tanah_2', 'Tarikh:', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::date('status_tanah_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada','disabled'=>'true', 'id' => 'status_tanah_details_2']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('status_tanah[]', 'Belum diwartakan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'status_tanah_3', 'onclick' => 'onlyOne4(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('status_tanah_3', 'Belum diwartakan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function onlyOne4(checkbox4) {
                                        console.log(checkbox4.id);
                                        var checkboxes4 = document.querySelectorAll('input[name="status_tanah[]"]');
                                        checkboxes4.forEach(function(item4) {
                                            if (item4 !== checkbox4) {
                                                item4.checked = false;
                                            }
                                        });

                                        let id;
                                        if(checkbox4.id == 'status_tanah_1'){
                                            id = 'status_tanah_details_1';
                                            document.getElementById(id).disabled = !checkbox4.checked
                                            document.getElementById('status_tanah_details_2').disabled = true
                                        } else if(checkbox4.id == 'status_tanah_2'){
                                            id = 'status_tanah_details_2';
                                            document.getElementById(id).disabled = !checkbox4.checked
                                            document.getElementById('status_tanah_details_1').disabled = true
                                        } else if(checkbox4.id == 'status_tanah_3'){
                                            document.getElementById('status_tanah_details_1').disabled = true
                                            document.getElementById('status_tanah_details_2').disabled = true
                                        }

                                        // // Now, get the corresponding date input by using the dynamically set id
                                        // var element = document.getElementById(id);
                                        // console.log(id);
                                        // console.log(element);

                                        // if (element) {
                                        //     // Enable the corresponding input field if the checkbox is checked, disable it otherwise
                                        //     element.disabled = !checkbox4.checked;
                                        // }
                                    }
                                </script>
                            </td>

                        </tr>

                        <!-- d. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td>{{ Form::label('keluasan', 'd.&nbsp;&nbsp;&nbsp;&nbsp;No Lot/PT :', ['class' => 'col-form-label']) }}</td>
                            <td>{{ Form::text('keluasan', null, ['class' => 'form-control', 'inert' => true]) }}</td>
                            <td colspan="4">
                                <!-- Dropdown for Negeri, Daerah, and Mukim -->
                                <div class="form-group row">
                                    <div class="col-md-1">
                                        {{ Form::label('negeri', 'Negeri:', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::select('negeri', [], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 200px;', 'id' => 'negeri']) }}
                                    </div>
                                <!-- </div>

                                <div class="form-group row"> -->
                                    <div class="col-md-1">
                                        {{ Form::label('daerah', 'Daerah:', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::select('daerah', [], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 200px;', 'id' => 'daerah']) }}
                                    </div>
                                <!-- </div>

                                <div class="form-group row"> -->
                                    <div class="col-md-1">
                                        {{ Form::label('mukim', 'Mukim:', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::select('mukim', [], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 200px;', 'id' => 'mukim']) }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-1">
                                        {{ Form::label('parlimen', 'Parlimen:', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::select('parlimen', [], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 200px;', 'id' => 'parlimen']) }}
                                    </div>
                                <!-- </div>

                                <div class="form-group row"> -->
                                    <div class="col-md-1">
                                        {{ Form::label('dun', 'Dun:', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::select('dun', [], null, ['class' => 'form-control', 'disabled' => true, 'style' => 'width: 200px;', 'id' => 'dun']) }}
                                    </div>
                                </div>



                            </td>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    // Fetch Negeri data on page load (AJAX call)
                                    $.ajax({
                                        url: '/get-negeri', // API endpoint to get negeri data
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                            // Populate the Negeri dropdown with the data
                                            $('#negeri').empty(); // Clear current options
                                            $('#negeri').append('<option value="">Pilih Negeri</option>'); // Add default option

                                            $.each(data, function(key, value) {
                                                // Add each Negeri to the dropdown
                                                $('#negeri').append('<option value="' + value.kod_negeri + '">' + value.nama_negeri + '</option>');
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Error fetching Negeri data: ", error);
                                        }
                                    });

                                    // When the 'Negeri' dropdown changes
                                    $('#negeri').change(function() {
                                        var negeriId = $(this).val();
                                        if (negeriId) {
                                            // Make an AJAX request to get the 'Daerah' based on the selected 'Negeri'
                                            $('#daerah').empty();
                                            $('#daerah').append('<option value="">Pilih Daerah</option>');
                                            $('#mukim').empty();
                                            $('#mukim').append('<option value="">Pilih Mukim</option>');
                                            $('#parlimen').empty();
                                            $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                            $('#dun').empty();
                                            $('#dun').append('<option value="">Pilih Dun</option>');
                                            $.ajax({
                                                url: '/get-daerah/' + negeriId, // Your existing route to fetch daerah
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    // Populate the 'Daerah' dropdown with the response data
                                                    if (data.length<2) {
                                                        // if (data[0].nama_daerah == 'TIADA DAERAH') {
                                                        //     $('#daerah').append('<option value="000" selected disabled>TIADA DAERAH</option>');
                                                        // }else{
                                                            $('#daerah').append('<option value="' + data[0].kod_daerah + '" selected>' + data[0].nama_daerah + '</option>');
                                                        // }
                                                        $('#daerah').trigger('change');
                                                    }else{
                                                        $.each(data, function(key, value) {
                                                            $('#daerah').append('<option value="' + value.kod_daerah + '">' + value.nama_daerah + '</option>');
                                                            // Check if the name of the daerah is 'TIADA DAERAH'
                                                            // if (value.nama_daerah == 'TIADA DAERAH') {
                                                            //     // Set this option as selected
                                                            //     $('#daerah option[value="' + value.kod_daerah + '"]').prop('selected', true);
                                                            //     $('#daerah').trigger('change');
                                                            // }
                                                        });
                                                    }
                                                }
                                            });

                                            // Make an AJAX request to get the 'parlimen' based on the selected 'Negeri'
                                            $.ajax({
                                                url: '/get-parlimen/' + negeriId, // Your existing route to fetch parlimen
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    // Populate the 'parlimen' dropdown with the response data
                                                    $('#parlimen').empty();
                                                    $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                                    $.each(data, function(key, value) {
                                                        $('#parlimen').append('<option value="' + value.kod_parlimen + '">' + value.nama_parlimen + '</option>');
                                                    });
                                                }
                                            });
                                        } else {
                                            // Reset all child dropdowns if Negeri is cleared
                                            $('#daerah').empty();
                                            $('#daerah').append('<option value="">Pilih Daerah</option>');
                                            $('#mukim').empty();
                                            $('#mukim').append('<option value="">Pilih Mukim</option>');
                                            $('#parlimen').empty();
                                            $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                                            $('#dun').empty();
                                            $('#dun').append('<option value="">Pilih Dun</option>');
                                        }
                                    });

                                    // When the 'Daerah' dropdown changes
                                    $('#daerah').change(function() {
                                        var daerahId = $(this).val();
                                        var negeriId = $('#negeri').val(); // Get the selected negeri ID
                                        if (daerahId && negeriId) {
                                            // Make an AJAX request to get the 'Mukim' based on the selected 'Daerah' and 'Negeri'
                                            $.ajax({
                                                url: '/get-mukim/' + negeriId + '/' + daerahId, // Updated URL with both negeriId and daerahId
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    // Populate the 'Mukim' dropdown with the response data
                                                    $('#mukim').empty();
                                                    $('#mukim').append('<option value="">Pilih Mukim</option>');
                                                    if (data.length<2) {
                                                        $('#mukim').append('<option value="' + data[0].kod_mukim + '" selected>' + data[0].nama_mukim + '</option>');
                                                    }else{
                                                        $.each(data, function(key, value) {
                                                            $('#mukim').append('<option value="' + value.kod_mukim + '">' + value.nama_mukim + '</option>');
                                                        });
                                                    }
                                                }
                                            });
                                        } else {
                                            $('#mukim').empty();
                                            $('#mukim').append('<option value="">Pilih Mukim</option>');
                                        }
                                    });

                                    // When the 'parlimen' dropdown changes
                                    $('#parlimen').change(function() {
                                        var parlimenId = $(this).val();
                                        if (parlimenId) {
                                            // Make an AJAX request to get the 'parlimen' based on the selected 'parlimen'
                                            $.ajax({
                                                url: '/get-dun/' + parlimenId, // Your existing route to fetch parlimen
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    // Populate the 'parlimen' dropdown with the response data
                                                    $('#dun').empty();
                                                    $('#dun').append('<option value="">Pilih Dun</option>');
                                                    if (data.length<1) {
                                                        $('#dun').append('<option value="000" selected disabled>TIADA DUN</option>');
                                                    }else{
                                                        $.each(data, function(key, value) {
                                                            $('#dun').append('<option value="' + value.kod_dun + '">' + value.nama_dun + '</option>');
                                                        });
                                                    }
                                                }
                                            });
                                        } else {
                                            $('#dun').empty();
                                            $('#dun').append('<option value="">Pilih Dun</option>');
                                        }
                                    });

                                });
                            </script>




                        </tr>

                        <!-- e. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td colspan="5">
                                <div class="row">
                                    <div class="col-md-3">
                                        {{ Form::label('aktiviti_semasa', 'e.&nbsp;&nbsp;&nbsp;&nbsp;Aktiviti semasa di tapak cadangan :', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-9">
                                        {{ Form::textarea('aktiviti_semasa', null, ['class' => 'form-control summernote', 'inert' => true, 'rows' => 3, 'cols' => 20]) }}
                                    </div>
                                    <!-- Include Summernote CSS -->
                                    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet"> -->

                                    <!-- Include Summernote JS -->
                                    <!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script> -->

                                    <!-- <script>
                                        $(document).ready(function() {
                                            // Initialize Summernote for all textareas with the class 'summernote'
                                            $('.summernote').summernote({
                                                height: 200,  // Set the height of the editor
                                                toolbar: [
                                                    // Define the toolbar buttons (optional, you can customize this)
                                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                                    ['font', ['strikethrough', 'superscript', 'subscript']],
                                                    ['para', ['ul', 'ol', 'paragraph']],
                                                    ['insert', ['link', 'picture']],
                                                    ['view', ['fullscreen', 'codeview', 'help']]
                                                ]
                                            });
                                        });
                                    </script> -->

                                </div>
                            </td>


                            <td>{{ Form::label('jumlah_penduduk', 'f.&nbsp;&nbsp;&nbsp;&nbsp;Jumlah penduduk (kawasan pentadbiran PBT) :', ['class' => 'col-form-label']) }}<!-- </td>
                            <td> -->{{ Form::text('jumlah_penduduk', null, ['class' => 'form-control', 'inert' => true]) }}</td>
                        </tr>

                        <!-- g. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td colspan="6" class="align-middle">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{ Form::label('kemudahsampaian', 'g.&nbsp;&nbsp;&nbsp;&nbsp;Kemudahsampaian ke tapak cadangan menggangu lot-lot bersebelahan.', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check d-flex align-items-center me-4">
                                                {{ Form::checkbox('kemudahsampaian[]', 'Ya', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'kemudahsampaian_1', 'onclick' => 'onlyOne5(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Form::label('kemudahsampaian_1', 'Ya', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            </div>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="form-check d-flex align-items-center">
                                                {{ Form::checkbox('kemudahsampaian[]', 'Tidak', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'kemudahsampaian_2', 'onclick' => 'onlyOne5(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Form::label('kemudahsampaian_2', 'Tidak', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <script>
                                function onlyOne5(checkbox5) {
                                    var checkboxes5 = document.querySelectorAll('input[name="kemudahsampaian[]"]');
                                    checkboxes5.forEach(function(item5) {
                                        if (item5 !== checkbox5) {
                                            item5.checked = false;
                                        }
                                    });
                                }
                            </script>
                        </tr>

                        <!-- h. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px;">
                                {{ Form::label('note1', 'h.&nbsp;&nbsp;&nbsp;&nbsp;Guna tanah atau pembangunan di lot bersebelahan / bersempadanan dengan tapak cadangan.', ['class' => 'col-form-label']) }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="6">
                                <div class="form-group row">
                                    <!-- Perumahan Checkbox -->
                                    <div class="col-md-4">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('guna_tanah[]', 'Perumahan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'guna_tanah_1', 'onclick' => 'onlyOne6(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('guna_tanah_1', 'Perumahan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Institusi Kerajaan Checkbox -->
                                    <div class="col-md-8">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('guna_tanah[]', 'Institusi Kerajaan /Pendidikan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'guna_tanah_2', 'onclick' => 'onlyOne6(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('guna_tanah_2', 'Institusi Kerajaan /Pendidikan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- Perniagaan Checkbox -->
                                    <div class="col-md-4">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('guna_tanah[]', 'Perniagaan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'guna_tanah_3', 'onclick' => 'onlyOne6(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('guna_tanah_3', 'Perniagaan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>

                                    <!-- Institusi Kewangan Checkbox -->
                                    <div class="col-md-8">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('guna_tanah[]', 'Institusi Kewangan', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'guna_tanah_4', 'onclick' => 'onlyOne6(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('guna_tanah_4', 'Institusi Kewangan', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- Kawasan Terbiar Checkbox -->
                                    <div class="col-md-4">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('guna_tanah[]', 'Kawasan terbiar', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'guna_tanah_5', 'onclick' => 'onlyOne6(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('guna_tanah_5', 'Kawasan terbiar', ['class' => 'form-check-label bigger-label ms-2']) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Lain-lain Checkbox and Details Input -->
                                    <div class="col-md-8">
                                        <div class="form-check d-flex align-items-center">
                                            {{ Form::checkbox('guna_tanah[]', 'Lain-lain (nyatakan)', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'guna_tanah_6', 'onclick' => 'onlyOne6(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::label('guna_tanah_6', 'Lain-lain (nyatakan) :', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <!-- Ensure the id matches -->
                                            {{ Form::text('guna_tanah_details_6', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;', 'disabled' => 'true', 'id' => 'guna_tanah_details_6']) }}
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function onlyOne6(checkbox6) {
                                        var checkboxes6 = document.querySelectorAll('input[name="guna_tanah[]"]');
                                        
                                        checkboxes6.forEach(function(item6) {
                                            if (item6 !== checkbox6) {
                                                item6.checked = false;
                                            }
                                        });

                                        // Ensure text input is properly targeted
                                        var textInput = document.getElementById('guna_tanah_details_6');
                                        if (textInput) {
                                            if (checkbox6.id === 'guna_tanah_6') {
                                                textInput.disabled = !checkbox6.checked;
                                            } else {
                                                textInput.disabled = true;
                                            }
                                        }
                                    }
                                </script>
                            </td>

                        </tr>

                        <!-- i. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td colspan="6" class="align-middle">
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ Form::label('pelan_ukur', 'i.&nbsp;&nbsp;&nbsp;&nbsp;Tapak cadangan mempunyai pelan ukur', ['class' => 'col-form-label']) }}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check d-flex align-items-center me-4">
                                                {{ Form::checkbox('pelan_ukur[]', 'Ya', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_ukur_1', 'onclick' => 'onlyOne7(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Form::label('pelan_ukur_1', 'Ya', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            </div>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="form-check d-flex align-items-center">
                                                {{ Form::checkbox('pelan_ukur[]', 'Tidak', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'pelan_ukur_2', 'onclick' => 'onlyOne7(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Form::label('pelan_ukur_2', 'Tidak', ['class' => 'form-check-label bigger-label ms-2']) }}
                                            </div>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="form-check d-flex align-items-center">
                                                <!-- {{ Form::label('pelan_ukur_1', 'Jika Ya tarikh pelan disediakan :', ['class' => 'form-check-label bigger-label ms-2', 'style' => 'white-space: nowrap;']) }} -->
                                                <label for="pelan_ukur_1" class="form-check-label bigger-label ms-2" style="white-space: nowrap;">
                                                    Jika <strong>Ya</strong> tarikh pelan disediakan :
                                                </label>

                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Form::date('pelan_ukur_details_1', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada','disabled'=>'true', 'id' => 'pelan_ukur_details_1']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <script>
                                function onlyOne7(checkbox7) {
                                    var checkboxes7 = document.querySelectorAll('input[name="pelan_ukur[]"]');
                                    checkboxes7.forEach(function(item7) {
                                        if (item7 !== checkbox7) {
                                            item7.checked = false;
                                        }
                                    });

                                    // Ensure text input is properly targeted
                                    var textInput = document.getElementById('pelan_ukur_details_1');
                                    if (textInput) {
                                        if (checkbox7.id === 'pelan_ukur_1') {
                                            textInput.disabled = !checkbox7.checked;
                                        } else {
                                            textInput.disabled = true;
                                        }
                                    }
                                }
                            </script>
                        </tr>

                        <!-- j. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
                        <tr>
                            <td colspan="6" class="align-middle" style="height: 20px; padding-top: 5px; padding-bottom: 5px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ Form::label('masalah', 'j.&nbsp;&nbsp;&nbsp;&nbsp;Adakah tapak cadangan mempunyai sebarang masalah', ['class' => 'col-form-label']) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="align-middle">
                                <div class="row">
                                    @php
                                        // The array of labels
                                        $labels = [
                                            'Bencana alam (banjir, tanah runtuh, hakisan, mendapan tanah, takungan air)',
                                            'Kawasan sensitif alam semulajadi (Hidupan liar, bercerun, berpaya dan lain-lain)',
                                            'Tapak terlibat dengan pengambilan balik tanah',
                                            'Tapak terlibat tidak ada pertindihan dengan projek lain',
                                            'Isu penempatan setinggan (diselesaikan sebelum proses tender / sebut harga)'
                                        ];
                                    @endphp

                                    @foreach($labels as $index => $label)
                                        <div class="col-md-6">
                                            {{ Form::label('masalah_' . $index, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$label, ['class' => 'col-form-label', 'style' => 'font-weight: normal; white-space: nowrap;']) }}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check d-flex align-items-center me-4">
                                                    {{ Form::checkbox('masalah_' . $index . '[]', 'Ya', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'masalah_' . $index . '_1', 'onclick' => 'onlyOne8("masalah_' . $index . '")']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ Form::label('masalah_' . $index . '_1', 'Ya', ['class' => 'form-check-label bigger-label ms-2']) }}
                                                </div>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="form-check d-flex align-items-center">
                                                    {{ Form::checkbox('masalah_' . $index . '[]', 'Tidak', false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'masalah_' . $index . '_2', 'onclick' => 'onlyOne8("masalah_' . $index . '")']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ Form::label('masalah_' . $index . '_2', 'Tidak', ['class' => 'form-check-label bigger-label ms-2']) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            {{ Form::label('masalah_6', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Lain-lain (nyatakan) :', ['class' => 'form-check-label ms-2']) }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ Form::text('masalah_details_6', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;', 'id' => 'masalah_details_6']) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <script>
                                function onlyOne8(group) {
                                    // Get all checkboxes in the group (based on the group name passed dynamically)
                                    var checkboxes = document.querySelectorAll('input[name="' + group + '[]"]');
                                    
                                    checkboxes.forEach(function(item) {
                                        // Uncheck other checkboxes in the same group when one is checked
                                        if (item !== event.target) {
                                            item.checked = false;
                                        }
                                    });
                                }
                            </script>
                        </tr>


                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('projectCategory', '6.&nbsp;&nbsp;&nbsp;&nbsp;MAKLUMAT SOKONGAN:', ['class' => 'col-form-label']) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px;">
                                {{ Form::label('note1', '&nbsp;&nbsp;&nbsp;&nbsp;Maklumat lain yang perlu disertakan', ['class' => 'col-form-label']) }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="6">
                                <div class="form-group row">
                                    @php
                                        // Define the array of labels
                                        $labels = [
                                            'Pelan ukur terkini (dalam tempoh 3 tahun) yang telah disahkan oleh Juruukur Bertauliah',
                                            'Pelan guna tanah bagi kawasan tapak cadangan dan sekitarnya',
                                            'Pelan kontur kawasan tapak cadangan dan sekitarnya',
                                            'Gambar foto tapak cadangan',
                                            'Gambar foto kawasan sekitar tapak cadangan',
                                            'Lain-lain (nyatakan)'
                                        ];
                                    @endphp

                                    @foreach($labels as $index => $label)
                                        <div class="col-md-12">
                                            <div class="form-check d-flex align-items-center" style="padding-right: 20px;">
                                                {{ Form::checkbox('maklumat_sokongan[]', $label, false, ['inert' => true, 'class' => 'form-check-input bigger-checkbox', 'id' => 'maklumat_sokongan_' . ($index + 1)]) }}
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                {{ Form::label('maklumat_sokongan_' . ($index + 1), '-'.$label, ['class' => 'form-check-label bigger-label ms-2', 'style' => 'font-weight: normal; white-space: nowrap;']) }}

                                                @if($index == 5)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ Form::text('maklumat_sokongan_details_6', null, ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;', 'id' => 'maklumat_sokongan_details_6']) }}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        
                        <!-- File Upload Section -->
                        <tr>
                            <td colspan="6" style="padding-top: 15px; padding-bottom: 15px;">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {{ Form::label('file_upload', '&nbsp;&nbsp;&nbsp;&nbsp;Sila muat naik dokumen sokongan:', ['class' => 'col-form-label', 'style' => 'font-weight: normal;']) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center">
                                            <!-- File input field -->
                                            {{ Form::file('supporting_documents[]', ['class' => 'form-control d-inline-block ms-2', 'inert' => true, 'multiple' => true, 'style' => 'width: 50%; margin-top: 0;']) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>

                    <!-- Add custom CSS to make checkboxes bigger -->
                    <style>
                        .bigger-checkbox {
                            transform: scale(2); /* Increases checkbox size */
                            margin-right: 10px;
                        }

                        .bigger-label {
                            font-size: 18px; /* Increases label font size */
                        }

                        .form-control {
                            width: 100%; /* Ensures input boxes stretch across available space */
                        }

                        .form-check {
                            margin-right: 10px; /* Adds spacing between checkboxes */
                        }

                        .form-group {
                            margin-bottom: 15px; /* Adds spacing between form groups */
                        }
                    </style>

                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.eLAPS.index')."'", 'class' => 'btn btn-secondary']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
