<table class="table table-bordered" style="border: none; font-size: 12px;">
    <!-- First Row: Title (Tajuk Permohonan and Rujukan) -->
    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;background-color: #ffff00;">
        <td style="border: none; padding: 8px; text-align: left;" rowspan="2" >
            {{ Form::label('projectTitle', '1.&nbsp;&nbsp;&nbsp;&nbsp;TAJUK PERMOHONAN PROJEK:', ['class' => 'col-form-label required-field-create']) }}

        </td>
        <td style="border: none; padding: 8px; text-align: left;" colspan="3" rowspan="2">{{ Form::textarea('projectTitle', null, ['class' => 'form-control', 'rows' => 3, 'cols' => 50, 'placeholder' => 'Masukkan butiran jika ada', 'required' => 'required']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::label('referenceNumber', '2.&nbsp;&nbsp;&nbsp;&nbsp;RUJUKAN PERMOHONAN:', ['class' => 'col-form-label']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;" >
            {{ Form::text('referenceNumber', $eLAPS->referenceNumber ?? '', ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'text-align: right; width: 70%; margin-top: 0; margin-left: auto; margin-right: 0;', 'inert' => 'true']) }}
        </td>
    </tr>
    <tr style="border-bottom: 1px solid black; border-top: 1px solid black; background-color: #ffff00;">
        <td style="border: none; padding: 8px; text-align: left;">
            {{ Form::label('anggaranKos', '&nbsp;&nbsp;&nbsp;&nbsp;ANGGARAN KOS PEMBANGUNAN (RM):', ['class' => 'col-form-label required-field-create']) }}
        </td>
        <td style="border: none; padding: 8px; text-align: left;">
            {{ Form::text('anggaranKos', null, ['class' => 'form-control currency-input', 'placeholder' => '0.00', 'style' => 'text-align: right; width: 70%; margin-left: auto; margin-right: 0;', 'oninput' => 'formatCurrency(this);']) }}
        </td>
        <style>
            .currency-input {
                font-size: 1.2em;
                padding: 10px;
                width: 200px;
            }
        </style>

        <script>
            function formatCurrency(input) {
                // Remove non-numeric characters except for the decimal point
                let value = input.value.replace(/[^\d.]/g, '');
                
                // Split the value into integer and decimal parts
                let [integer, decimal] = value.split('.');

                // Format the integer part with commas
                integer = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // If there's no decimal part, initialize it to '00'
                if (!decimal) {
                    decimal = '00';
                } else {
                    // If there's a decimal part, limit it to two digits
                    decimal = decimal.slice(0, 2);
                }

                // Rejoin the integer and decimal parts, ensuring two decimal places
                input.value = integer + '.' + decimal;  // Concatenate integer and two decimal digits
            }
        </script>
    </tr>

    


    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px;"></td>
    </tr>

    <!-- Second Row: KATEGORI PROJEK -->
    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td colspan="6" style="border: none; height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('projectCategory', '3.&nbsp;&nbsp;&nbsp;&nbsp;KATEGORI PROJEK:', ['class' => 'col-form-label required-field']) }}</td>
    </tr>
    <!-- Third Row: Rancangan Pembangunan (checkboxes with input fields) -->
    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6">

            <style>
                /* Add space before the checkbox */
                .space-checkbox {
                    margin-left: 10px; /* Adjust this value for the desired space before the checkbox */
                }

                /* Add space between the checkbox and the label */
                .space-label {
                    margin-left: 40px; /* Adjust this value for the desired space between checkbox and label */
                }
            </style>
            @php
                $allLabels = [];
                //$eLAPS->category = isset($eLAPS->category) ? $eLAPS->category : '';
            @endphp
            @foreach ([
                [
                    ['id' => 'category_taman_awam', 'label' => 'Taman Awam'],
                    ['id' => 'category_taman_botani', 'label' => 'Taman Botani'],
                    ['id' => 'category_pemuliharaan', 'label' => 'Pemuliharaan Dan Penyelidikan Landskap']
                ],
                [
                    ['id' => 'category_landskap_perbandaran', 'label' => 'Landskap Perbandaran'],
                    ['id' => 'category_persekitaran', 'label' => 'Persekitaran Kehidupan'],
                    ['id' => 'category_penyelenggaraan', 'label' => 'Penyelenggaraan Landskap']
                ],
                [
                    ['id' => 'category_taman_persekutuan', 'label' => 'Taman Persekutuan'],
                    ['id' => 'category_naik_taraf', 'label' => 'Naik Taraf Taman Awam'],
                    ['id' => 'category_pelan_induk', 'label' => 'Pelan Induk Landskap']
                ],
                [
                    ['id' => 'category_lain', 'label' => 'Lain-lain (sila nyatakan)', 'onclick' => 'toggleLainLainText();onlyOne1(this);']
                ]
            ] as $categoryGroup)
                @php
                    $allLabels = array_merge($allLabels, array_column($categoryGroup, 'label'));
                @endphp
                <div class="form-group row">
                    @foreach ($categoryGroup as $category)
                        <div class="col-md-4">
                            <div class="form-check">
                            @php
                                $isChecked = $category['label'] == (isset($eLAPS->category) ? $eLAPS->category : '');
                                //dump($isChecked);
                            @endphp
                                {{ Form::checkbox('category[]', $category['label'], $isChecked, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => $category['id'], 'onclick' => $category['onclick'] ?? 'onlyOne1(this)']) }}
                                {{ Form::label($category['id'], $category['label'], ['class' => 'form-check-label bigger-label space-label']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            
            <!-- Textbox for "Lain-lain" option -->
            <div class="form-group row" id="lain_lain_details" style="display: none;">
                <div class="col-md-12">
                    {{ Form::label('lain_lain_text', 'Sila Nyatakan:', ['class' => 'col-form-label']) }}
                    {{ Form::text('category[lain-lain]', null, ['class' => 'form-control', 'placeholder' => 'Masukkan maklumat lain-lain', 'id' => 'lain_lain_text', 'disabled' => true]) }}
                </div>
            </div>
            @php
                // Check if the category is not in the list of predefined categories
                $lainLainChecked = isset($eLAPS->category) && !in_array($eLAPS->category, ['Taman Awam', 'Taman Botani', 'Pemuliharaan Dan Penyelidikan Landskap', 'Landskap Perbandaran', 'Persekitaran Kehidupan', 'Penyelenggaraan Landskap', 'Taman Persekutuan', 'Naik Taraf Taman Awam', 'Pelan Induk Landskap']);
                $findString = (isset($eLAPS->category)) ? $eLAPS->category : '';
                $isMatch = empty(array_intersect($allLabels, [$findString]));
                //dd($isMatch);
            @endphp

            @if($isMatch && isset($eLAPS->category))
                <script>
                    document.getElementById('category_lain').checked = true;
                    document.getElementById('lain_lain_details').style.display = 'block';
                    document.getElementById('lain_lain_text').disabled = false;
                    document.getElementById('lain_lain_text').value = "{{$eLAPS->category ?? ''}}";
                </script>
            @endif

            <script>
                function onlyOne1(checkbox1) {
                    var checkboxes1 = document.querySelectorAll('input[name="category[]"]');
                    checkboxes1.forEach(function(item1) {
                        if (item1 !== checkbox1) {
                            item1.checked = false;
                        }
                    });
                    if(checkbox1.id != 'category_lain'){document.getElementById('lain_lain_details').style.display = 'none';document.getElementById('lain_lain_text').disabled = true;}
                    else{
                        if (document.getElementById('category_lain').checked) {
                            document.getElementById('lain_lain_details').style.display = 'block';
                            document.getElementById('lain_lain_text').disabled = false;
                            setTimeout(function() {
                                document.getElementById('lain_lain_text').focus();
                            }, 100);
                        } else {
                            document.getElementById('lain_lain_details').style.display = 'none';
                        }
                        // document.getElementById('lain_lain_details').style.display = 'block';
                        // setTimeout(function() {
                        //     document.getElementById('lain_lain_text').focus();
                        // }, 100);
                    }
                }
            </script>


            

            <!-- JavaScript to toggle the display of the "Lain-lain" text box -->
            <script>
                function toggleLainLainText() {
                    // alert("DA");
                    // var checkBox = document.getElementById('category_lain');
                    // var textBox = document.getElementById('lain_lain_details');
                    // if (checkBox.checked) {
                    //     textBox.style.display = 'block';
                    //     setTimeout(function() {
                    //         document.getElementById('lain_lain_text').focus();
                    //     }, 100);
                    // } else {
                    //     textBox.style.display = 'none';
                    // }
                }
            </script>

        </td>
    </tr>
    <!-- Third Row: Rancangan Pembangunan (checkbox and text box) -->
    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td colspan="6" style="border: none; height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('rancangan_pembangunan', '4.&nbsp;&nbsp;&nbsp;&nbsp;RANCANGAN PEMBANGUNAN: ', ['class' => 'col-form-label required-field']) }}<h7>&nbsp;(Adakah tapak cadangan berasaskan kepada Rancangan Pembangunan tersebut?)</h7></td>
    </tr>

    <!-- Third Row: Rancangan Pembangunan (checkboxes with input fields) -->
    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6">
            @php
                $rancangan_pembangunan = [
                    ['label' => 'Pelan Induk Landskap', 'id' => '1'],
                    ['label' => 'Rancangan Struktur&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'id' => '2'],
                    ['label' => 'Rancangan Tempatan&nbsp;', 'id' => '3'],
                    ['label' => 'Rancangan Kawasan Khas', 'id' => '4'],
                    ['label' => 'Lain-Lain Pelan Pembangunan (Nyatakan)', 'id' => '5'],
                ];
            @endphp
            @php
                if(isset($eLAPS->rancangan_pembangunan)){
                    $rancanganPembangunanData = json_decode($eLAPS->rancangan_pembangunan, true);
                    //dd($rancanganPembangunanData)
                }
            @endphp
            @foreach ($rancangan_pembangunan as $index => $item)
                @if ($index % 2 == 0)
                    <div class="form-group row">
                @endif

                    <div class="{{ $index == count($rancangan_pembangunan) - 1 ? 'col-md-12' : 'col-md-6' }}">
                        <div class="form-check d-flex align-items-center">
                            @php
                                if(isset($eLAPS->rancangan_pembangunan) && isset($rancanganPembangunanData['jenis'])){
                                    $isChecked = $rancanganPembangunanData['jenis'] == str_replace('&nbsp;', '', $item['label']);
                                }
                            @endphp
                            {{ Form::checkbox('rancangan_pembangunan[jenis]', str_replace('&nbsp;', '', $item['label']), $isChecked, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'rancangan_pembangunan_' . $item['id'], 'onclick' => 'onlyOne2(this)']) }}
                            {{ Form::label('rancangan_pembangunan_' . $item['id'], str_replace('&nbsp;', '', $item['label']) . ' :&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
                            {{ Form::text('rancangan_pembangunan[keterangan]', $isChecked ? $rancanganPembangunanData['keterangan'] : null, ['class' => 'form-control d-inline-block ms-2', 'id' => 'rancangan_pembangunan_details_' . str_replace('&nbsp;', '', $item['id']), 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;', 'disabled' => !$isChecked]) }}
                        </div>
                    </div>

                @if ($index % 2 == 1 || $index == count($rancangan_pembangunan) - 1)
                    </div>
                @endif
            @endforeach

            <script>
                // JavaScript function to ensure only one checkbox is selected
                function onlyOne2(checkbox2) {
                    var checkboxes2 = document.querySelectorAll('input[name="rancangan_pembangunan[jenis]"]');
                    checkboxes2.forEach(function(item2) {
                        let id = item2.id.replace("rancangan_pembangunan", "rancangan_pembangunan_details");
                        if (item2 !== checkbox2) {
                            item2.checked = false;
                            document.getElementById(id).disabled = true;
                        }else{
                            document.getElementById(id).disabled = false;
                            setTimeout(function() {
                                document.getElementById(id).focus();
                            }, 100); 
                        }
                    });

                    // switch(checkbox2.id) {
                    //     case 'rancangan_pembangunan_1':
                    //         document.getElementById('rancangan_pembangunan_details_1').disabled = false;
                    //         setTimeout(function() {
                    //             document.getElementById('rancangan_pembangunan_details_1').focus();
                    //         }, 100); // Delay the focus by 100ms
                    //         break;
                    //     case 'rancangan_pembangunan_2':
                            
                    //         setTimeout(function() {
                    //             document.getElementById('rancangan_pembangunan_details_2').focus();
                    //         }, 100); // Delay the focus by 100ms
                    //         break;
                    //     case 'rancangan_pembangunan_3':
                            
                    //         setTimeout(function() {
                    //             document.getElementById('rancangan_pembangunan_details_3').focus();
                    //         }, 100); // Delay the focus by 100ms
                    //         break;
                    //     case 'rancangan_pembangunan_4':
                            
                    //         setTimeout(function() {
                    //             document.getElementById('rancangan_pembangunan_details_4').focus();
                    //         }, 100); // Delay the focus by 100ms
                    //         break;
                    //     case 'rancangan_pembangunan_5':
                            
                    //         setTimeout(function() {
                    //             document.getElementById('rancangan_pembangunan_details_5').focus();
                    //         }, 100); // Delay the focus by 100ms
                    //         break;
                    //     default:
                    //         console.log('No matching case');
                    // }
                }
            </script>

        </td>
    </tr>


    <!-- Fourth Row: PERIHAL TAPAK -->
    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td colspan="6" style="border: none; height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('tapak_details', '5.&nbsp;&nbsp;&nbsp;&nbsp;PERIHAL TAPAK:', ['class' => 'col-form-label required-field']) }}</td>
    </tr>

    <!-- Fifth Row: Keluasan and Panjang -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::label('keluasan', 'a.&nbsp;&nbsp;&nbsp;&nbsp;Keluasan (ekar / hektar) :', ['class' => 'col-form-label required-field']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::text('keluasan', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}</td>

        <!-- Dropdown for Unit (Keluasan) with fixed width -->
        <td style="border: none; padding: 8px; text-align: left;" >
            {{ Form::select('unit_keluasan', ['ekar' => 'Ekar', 'hektar' => 'Hektar'], null, ['class' => 'form-control required-field', 'style' => 'width: 150px;']) }}
        </td>

        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::label('panjang', 'Panjang (Jika berkaitan):', ['class' => 'col-form-label']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::text('panjang', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}</td>

        <!-- Dropdown for Unit (Panjang) with fixed width -->
        <td style="border: none; padding: 8px; text-align: left;" >
            {{ Form::select('unit_panjang', ['meter' => 'Meter', 'kilometer' => 'Kilometer'], null, ['class' => 'form-control', 'style' => 'width: 150px;']) }}
        </td>
    </tr>


    <tr>
        @php  
            //dd((in_array($eLAPS->hakmilik_tanah, ["PBT", "Negeri"])))
            //dd($eLAPS->hakmilik_tanah)
            $pbt = (isset($eLAPS->hakmilik_tanah) && $eLAPS->hakmilik_tanah == "PBT");
            $negeri = (isset($eLAPS->hakmilik_tanah) && $eLAPS->hakmilik_tanah == "Negeri");
            $agensi = (isset($eLAPS->hakmilik_tanah) && !in_array($eLAPS->hakmilik_tanah, ["PBT", "Negeri"]));
            $agensiName = (isset($eLAPS->hakmilik_tanah) && !in_array($eLAPS->hakmilik_tanah, ["PBT", "Negeri"])) ? $eLAPS->hakmilik_tanah : '';
        @endphp
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::label('hakmilik_tanah', 'b.&nbsp;&nbsp;&nbsp;&nbsp;Hakmilik Tanah :', ['class' => 'col-form-label']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;" >
            <div class="form-check d-flex align-items-center">
                {{ Form::checkbox('hakmilik_tanah[hakmilik]', 'PBT', $pbt, ['class' => 'form-check-input bigger-checkbox', 'id' => 'hakmilik_tanah_1', 'onclick' => 'onlyOne3(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('hakmilik_tanah_1', 'PBT', ['class' => 'form-check-label bigger-label ms-2']) }}
                {{ Form::text('hakmilik_tanah_details_1', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;', 'disabled' => true]) }}
            </div>
        </td>

        <td style="border: none; padding: 8px; text-align: left;" >
            <div class="form-check d-flex align-items-center">
                {{ Form::checkbox('hakmilik_tanah[hakmilik]', 'Negeri', $negeri, ['class' => 'form-check-input bigger-checkbox', 'id' => 'hakmilik_tanah_2', 'onclick' => 'onlyOne3(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('hakmilik_tanah_2', 'Negeri', ['class' => 'form-check-label bigger-label ms-2']) }}
                {{ Form::text('hakmilik_tanah_details_2', null, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'visibility: hidden; width: 0; margin-top: 0;', 'disabled' => true]) }}
            </div>
        </td>

        <td style="border: none; padding: 8px; text-align: left;"  colspan="3">
            <div class="form-check d-flex align-items-center">
                {{ Form::checkbox('hakmilik_tanah[hakmilik]', 'Agensi lain (Nyatakan)', $agensi, ['class' => 'form-check-input bigger-checkbox', 'id' => 'hakmilik_tanah_3', 'onclick' => 'onlyOne3(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::label('hakmilik_tanah_3', 'Agensi lain (Nyatakan) : ', ['class' => 'form-check-label bigger-label ms-2']) }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {{ Form::text('hakmilik_tanah[keterangan]', $agensiName, ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%;', 'id' => 'hakmilik_tanah_details_3', 'disabled' => !$agensi]) }}
            </div>
        </td>

        <script>
            function onlyOne3(checkbox3) {
                var checkboxes3 = document.querySelectorAll('input[name="hakmilik_tanah[hakmilik]"]');
                checkboxes3.forEach(function(item3) {
                    if (item3 !== checkbox3) {
                        item3.checked = false;
                    }
                    if(checkbox3.id == 'hakmilik_tanah_3'){
                        document.getElementById('hakmilik_tanah_details_3').disabled = false;
                        setTimeout(function() {
                            document.getElementById('hakmilik_tanah_details_3').focus();
                        }, 100);
                    }else{
                        document.getElementById('hakmilik_tanah_details_3').disabled = true;
                    }
                });
            }
        </script>

    </tr>

    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" style="font-size: 10px; height: 20px; padding-top: 5px; padding-bottom: 5px;">
            {{ Form::label('note1', '(WAJIB disertakan salinan Surat Hakmilik Tanah dan Pelan Akui (Certified Plan) untuk setiap lot yg terlibat)', ['class' => 'col-form-label']) }}
        </td>
    </tr>

    <!-- c. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="3">
            {{ Form::label('keluasan', 'c.&nbsp;&nbsp;&nbsp;&nbsp;Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap', ['class' => 'col-form-label']) }}
            <br>
            {{ Form::label('note1', '(WAJIB disertakan salinan surat pewartaan untuk setiap lot yg terlibat)', ['class' => 'col-form-label','style'=>'font-size: 10px; height: 20px; padding-top: 5px; padding-bottom: 5px;']) }}
        </td>
        @php
            if(isset($eLAPS->status_tanah)){
                $status_tanahData = json_decode($eLAPS->status_tanah, true);
                //dd($status_tanahData);
                if(isset($status_tanahData['status'])){
                    $warta = $status_tanahData['status'] == "Diwartakan";
                    $prosesWarta = $status_tanahData['status'] == "Proses Perwartaan";
                    $belumWarta = $status_tanahData['status'] == "Belum diwartakan";
                    $TarikhWarta = (isset($status_tanahData['tarikh'])) ? $status_tanahData['tarikh'] : "";
                }else{
                    $warta = '';
                    $prosesWarta = '';
                    $belumWarta = '';
                    $TarikhWarta = '';
                }
            }else{
                $warta = '';
                $prosesWarta = '';
                $belumWarta = '';
                $TarikhWarta = '';
            }
        @endphp
        <td style="border: none; padding: 8px; text-align: left;"  colspan="3">
            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('status_tanah[status]', 'Diwartakan', $warta, ['class' => 'form-check-input bigger-checkbox', 'id' => 'status_tanah_1', 'onclick' => 'onlyOne4(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('status_tanah_1', 'Diwartakan', ['class' => 'form-check-label bigger-label ms-2']) }}
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::label('status_tanah_1', 'Tarikh:', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::date('status_tanah[tarikh]', $warta ? $TarikhWarta : '', ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada','disabled'=>!$warta, 'id' => 'status_tanah_details_1']) }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('status_tanah[status]', 'Proses Perwartaan', $prosesWarta, ['class' => 'form-check-input bigger-checkbox', 'id' => 'status_tanah_2', 'onclick' => 'onlyOne4(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('status_tanah_2', 'Proses Perwartaan', ['class' => 'form-check-label bigger-label ms-2']) }}
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::label('status_tanah_2', 'Tarikh:', ['class' => 'form-check-label bigger-label ms-2']) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::date('status_tanah[tarikh]', $prosesWarta ? $TarikhWarta : '', ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada','disabled'=>!$prosesWarta, 'id' => 'status_tanah_details_2']) }}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <div class="form-check d-flex align-items-center">
                        {{ Form::checkbox('status_tanah[status]', 'Belum diwartakan', $belumWarta, ['class' => 'form-check-input bigger-checkbox', 'id' => 'status_tanah_3', 'onclick' => 'onlyOne4(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::label('status_tanah_3', 'Belum diwartakan', ['class' => 'form-check-label bigger-label ms-2']) }}
                    </div>
                </div>
            </div>

            <script>
                function onlyOne4(checkbox4) {
                    console.log(checkbox4.id);
                    var checkboxes4 = document.querySelectorAll('input[name="status_tanah[status]"]');
                    checkboxes4.forEach(function(item4) {
                        if (item4 !== checkbox4) {
                            item4.checked = false;
                        }
                    });

                    let id;
                    if(checkbox4.id == 'status_tanah_1'){
                        id = 'status_tanah_details_1';
                        document.getElementById(id).disabled = !checkbox4.checked;
                        setTimeout(function() {
                            document.getElementById(id).focus();
                        }, 100);
                        document.getElementById('status_tanah_details_2').disabled = true
                    } else if(checkbox4.id == 'status_tanah_2'){
                        id = 'status_tanah_details_2';
                        document.getElementById(id).disabled = !checkbox4.checked;
                        setTimeout(function() {
                            document.getElementById(id).focus();
                        }, 100);
                        document.getElementById('status_tanah_details_1').disabled = true
                    } else if(checkbox4.id == 'status_tanah_3'){
                        document.getElementById('status_tanah_details_1').disabled = true
                        document.getElementById('status_tanah_details_2').disabled = true
                    }
                }
            </script>
        </td>

    </tr>

    <!-- d. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::label('no_lot', 'd.&nbsp;&nbsp;&nbsp;&nbsp;No Lot/PT :', ['class' => 'col-form-label required-field']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::text('no_lot', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}</td>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="4">
            <!-- Dropdown for Negeri, Daerah, and Mukim -->
            <div class="form-group row">
                <div class="col-md-1">
                    {{ Form::label('negeri', 'Negeri:', ['class' => 'col-form-label required-field']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('negeri', [], null, ['class' => 'form-control', 'style' => 'width: 200px;', 'id' => 'negeri']) }}
                </div>
            <!-- </div>

            <div class="form-group row"> -->
                <div class="col-md-1">
                    {{ Form::label('daerah', 'Daerah:', ['class' => 'col-form-label required-field']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('daerah', [], null, ['class' => 'form-control', 'style' => 'width: 200px;', 'id' => 'daerah']) }}
                </div>
            <!-- </div>

            <div class="form-group row"> -->
                <div class="col-md-1">
                    {{ Form::label('mukim', 'Mukim:', ['class' => 'col-form-label required-field']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('mukim', [], null, ['class' => 'form-control', 'style' => 'width: 200px;', 'id' => 'mukim']) }}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1">
                    {{ Form::label('parlimen', 'Parlimen:', ['class' => 'col-form-label required-field']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('parlimen', [], null, ['class' => 'form-control', 'style' => 'width: 200px;', 'id' => 'parlimen']) }}
                </div>
            <!-- </div>

            <div class="form-group row"> -->
                <div class="col-md-1">
                    {{ Form::label('dun', 'Dun:', ['class' => 'col-form-label required-field']) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('dun', [], null, ['class' => 'form-control', 'style' => 'width: 200px;', 'id' => 'dun']) }}
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
                        $('#negeri').append('<option value="">Pilih Negeri</option>');
                        $('#daerah').append('<option value="">Pilih Daerah</option>');
                        $('#mukim').append('<option value="">Pilih Mukim</option>');
                        $('#parlimen').append('<option value="">Pilih Parlimen</option>');
                        $('#dun').append('<option value="">Pilih Dun</option>');

                        $.each(data, function(key, value) {
                            // Add each Negeri to the dropdown
                            $('#negeri').append('<option value="' + value.kod_negeri + '">' + value.nama_negeri + '</option>');
                        });
                        var negeriSelected = "{{ isset($eLAPS->negeri) ? $eLAPS->negeri : '' }}"; // Assuming you have $eLAPS->negeri
                        if (negeriSelected) {
                            $('#negeri').val(negeriSelected).trigger('change');
                        }
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
                                var daerahSelected = "{{ isset($eLAPS->daerah) ? $eLAPS->daerah : '' }}"; // Assuming you have $eLAPS->daerah
                                if (daerahSelected) {
                                    $('#daerah').val(daerahSelected).trigger('change');
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
                                var parlimenSelected = "{{ isset($eLAPS->parlimen) ? $eLAPS->parlimen : '' }}"; // Assuming you have $eLAPS->parlimen
                                if (parlimenSelected) {
                                    $('#parlimen').val(parlimenSelected).trigger('change');
                                }
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
                                var mukimSelected = "{{ isset($eLAPS->mukim) ? $eLAPS->mukim : '' }}"; // Assuming you have $eLAPS->mukim
                                if (mukimSelected) {
                                    $('#mukim').val(mukimSelected).trigger('change');
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
                                var dunSelected = "{{ isset($eLAPS->dun) ? $eLAPS->dun : '' }}"; // Assuming you have $eLAPS->dun
                                if (dunSelected) {
                                    $('#dun').val(dunSelected).trigger('change');
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
        <td style="border: none; padding: 8px; text-align: left;"  colspan="5">
            <div class="row">
                <div class="col-md-3">
                    {{ Form::label('aktiviti_semasa', 'e.&nbsp;&nbsp;&nbsp;&nbsp;Aktiviti semasa di tapak cadangan :', ['class' => 'col-form-label required-field']) }}
                </div>
                <div class="col-md-9">
                    {{ Form::textarea('aktiviti_semasa', null, ['class' => 'form-control summernote', 'rows' => 3, 'cols' => 20, 'placeholder' => 'Masukkan butiran jika ada']) }}
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


        <td style="border: none; padding: 8px; text-align: left;" >{{ Form::label('jumlah_penduduk', 'f.&nbsp;&nbsp;&nbsp;&nbsp;Jumlah penduduk (kawasan pentadbiran PBT) :', ['class' => 'col-form-label required-field']) }}<!-- </td>
        <td style="border: none; padding: 8px; text-align: left;" > -->{{ Form::text('jumlah_penduduk', null, ['class' => 'form-control', 'placeholder' => 'Masukkan butiran jika ada']) }}</td>
    </tr>

    <!-- g. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" class="align-middle">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::label('kemudahsampaian', 'g.&nbsp;&nbsp;&nbsp;&nbsp;Kemudahsampaian ke tapak cadangan menggangu lot-lot bersebelahan.', ['class' => 'col-form-label']) }}
                </div>
                @php
                    $isCheckedY = (isset($eLAPS->kemudahsampaian) && $eLAPS->kemudahsampaian == "Ya");
                    $isCheckedN = (isset($eLAPS->kemudahsampaian) && $eLAPS->kemudahsampaian == "Tidak");
                @endphp
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="form-check d-flex align-items-center me-4">
                            {{ Form::checkbox('kemudahsampaian[]', 'Ya', $isCheckedY, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'kemudahsampaian_1', 'onclick' => 'onlyOne5(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Form::label('kemudahsampaian_1', 'Ya', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="form-check d-flex align-items-center">
                            {{ Form::checkbox('kemudahsampaian[]', 'Tidak', $isCheckedN, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'kemudahsampaian_2', 'onclick' => 'onlyOne5(this)']) }}&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Form::label('kemudahsampaian_2', 'Tidak', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
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
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px;">
            {{ Form::label('note1', 'h.&nbsp;&nbsp;&nbsp;&nbsp;Guna tanah atau pembangunan di lot bersebelahan / bersempadanan dengan tapak cadangan.', ['class' => 'col-form-label']) }}
        </td>
    </tr>

    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6">
            @php
                $guna_tanah = [
                    ['label' => 'Perumahan', 'id' => '1'],
                    ['label' => 'Institusi Kerajaan /Pendidikan', 'id' => '2'],
                    ['label' => 'Perniagaan', 'id' => '3'],
                    ['label' => 'Institusi Kewangan', 'id' => '4'],
                    ['label' => 'Kawasan terbiar', 'id' => '5'],
                    ['label' => 'Lain-lain (nyatakan) : ', 'id' => '6', 'has_input' => true],
                ];
                if(isset($eLAPS->guna_tanah)){
                    $gunaTanahData = json_decode($eLAPS->guna_tanah, true);
                    //dd($gunaTanahData['jenis']);
                }
            @endphp

            @foreach ($guna_tanah as $index => $item)
                @php
                    if(isset($eLAPS->guna_tanah)){
                        $isChecked = isset($eLAPS->guna_tanah) ? in_array($item['id'], $gunaTanahData['jenis']) : 'false';
                        //dump($isChecked);
                    }
                @endphp
                @if ($index % 2 == 0)
                    <div class="form-group row">
                @endif

                    <div class="col-md-6">
                        <div class="form-check d-flex align-items-center">
                            {{ Form::checkbox('guna_tanah[jenis][]', $item['id'], $isChecked ?? '', ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'guna_tanah_' . $item['id'], 'onclick' => 'onlyOne6(this)']) }}
                            {{ Form::label('guna_tanah_' . $item['id'], $item['label'], ['class' => 'form-check-label bigger-label space-label ms-2']) }}
                            
                            @if (isset($item['has_input']))
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                {{ Form::text('guna_tanah[keterangan]', $gunaTanahData['keterangan'] ?? '', [
                                    'class' => 'form-control d-inline-block ms-2',
                                    'placeholder' => 'Masukkan butiran jika ada',
                                    'style' => 'width: 50%; margin-top: 0;',
                                    'disabled' => !$isChecked,
                                    'id' => 'guna_tanah_details_' . $item['id']
                                ]) }}
                            @endif
                        </div>
                    </div>

                @if ($index % 2 == 1 || $index == count($guna_tanah) - 1)
                    </div>
                @endif
            @endforeach

            <script>
                function onlyOne6(checkbox6) {
                    var checkboxes6 = document.querySelectorAll('input[name="guna_tanah[jenis]"]');
                    
                    // checkboxes6.forEach(function(item6) {
                    //     if (item6 !== checkbox6) {
                    //         item6.checked = false;
                    //     }
                    // });

                    // Ensure text input is properly targeted
                    var textInput = document.getElementById('guna_tanah_details_6');
                    if (textInput) {
                        if (checkbox6.id === 'guna_tanah_6') {
                            textInput.disabled = !checkbox6.checked;
                            setTimeout(function() {
                                textInput.focus();
                            }, 100);
                        } else {
                            // textInput.disabled = true;
                        }
                    }
                }
            </script>
        </td>

    </tr>

    <!-- i. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" class="align-middle">
            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('pelan_ukur', 'i.&nbsp;&nbsp;&nbsp;&nbsp;Tapak cadangan mempunyai pelan ukur', ['class' => 'col-form-label']) }}
                </div>
                @php
                    if(isset($eLAPS->pelan_ukur)){
                        $pelan_ukurData = json_decode($eLAPS->pelan_ukur, true);
                        //dd($pelan_ukurData);
                        $pelan_ukurY = $pelan_ukurData[0] == "Ya";
                        $pelan_ukurN = $pelan_ukurData[0] == "Tidak";
                        $Tarikhpelan_ukur = (($pelan_ukurData['tarikh']) != null) ? $pelan_ukurData['tarikh'] : "";
                    }else{
                        $pelan_ukurY = '';
                        $pelan_ukurN = '';
                        $Tarikhpelan_ukur = '';
                    }
                @endphp
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <!-- Yes checkbox -->
                        <div class="form-check d-flex align-items-center me-4">
                            {{ Form::checkbox('pelan_ukur[]', 'Ya', $pelan_ukurY, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'pelan_ukur_1', 'onclick' => 'onlyOne7(this)']) }}
                            {{ Form::label('pelan_ukur_1', 'Ya', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
                        </div>

                        <!-- No checkbox -->
                        <div class="form-check d-flex align-items-center me-4">
                            {{ Form::checkbox('pelan_ukur[]', 'Tidak', $pelan_ukurN, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'pelan_ukur_2', 'onclick' => 'onlyOne7(this)']) }}
                            {{ Form::label('pelan_ukur_2', 'Tidak', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
                        </div>

                        <!-- Date input if 'Ya' is selected -->
                        <div class="form-check d-flex align-items-center">
                            <label for="pelan_ukur_1" class="form-check-label bigger-label ms-2" style="white-space: nowrap;margin-left: 30px;">
                                Jika <strong>Ya</strong> tarikh pelan disediakan :
                            </label>
                            {{ Form::date('pelan_ukur[tarikh]', $Tarikhpelan_ukur, ['class' => 'form-control d-inline-block ms-2 space-label', 'placeholder' => 'Masukkan butiran jika ada', 'disabled' => !$pelan_ukurY, 'id' => 'pelan_ukur_details_1']) }}
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
                        setTimeout(function() {
                            textInput.focus();
                        }, 100);
                    } else {
                        textInput.disabled = true;
                    }
                }
            }
        </script>
    </tr>

    <!-- j. Status Tanah : Diwartakan sebagai tanah lapang /rezab landskap -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" class="align-middle" style="height: 20px; padding-top: 5px; padding-bottom: 5px;">
            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('masalah', 'j.&nbsp;&nbsp;&nbsp;&nbsp;Adakah tapak cadangan mempunyai sebarang masalah', ['class' => 'col-form-label']) }}
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" class="align-middle">
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
                    if(isset($eLAPS->masalah)){
                        $masalahData = json_decode($eLAPS->masalah, true);
                    }else{
                        $masalahY = '';
                        $masalahN = '';
                        $Tarikhmasalah = '';
                    }
                @endphp

                @foreach($labels as $index => $label)
                    <div class="col-md-6">
                        {{ Form::label('masalah_' . $index, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$label, ['class' => 'col-form-label', 'style' => 'font-weight: normal; white-space: nowrap;']) }}
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="form-check d-flex align-items-center me-4">
                                {{ Form::checkbox('masalah['.$index.'][]', 1, isset($masalahData[$index]) && $masalahData[$index] == 1, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'masalah_' . $index . '_1', 'onclick' => 'onlyOne8(this)']) }}
                                {{ Form::label('masalah_' . $index . '_1', 'Ya', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
                            </div>
                            
                            <div class="form-check d-flex align-items-center">
                                {{ Form::checkbox('masalah['.$index.'][]', 0, isset($masalahData[$index]) && $masalahData[$index] == 0, ['class' => 'form-check-input bigger-checkbox space-checkbox', 'id' => 'masalah_' . $index . '_2', 'onclick' => 'onlyOne8(this)']) }}
                                {{ Form::label('masalah_' . $index . '_2', 'Tidak', ['class' => 'form-check-label bigger-label space-label ms-2']) }}
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
                        {{ Form::text('masalah[-1][]', isset($masalahData[-1]) ? $masalahData[-1] : 'Tiada Maklumat', ['class' => 'form-control d-inline-block ms-2', 'placeholder' => 'Masukkan butiran jika ada', 'style' => 'width: 50%; margin-top: 0;', 'id' => 'masalah_details_6']) }}
                    </div>
                </div>
            </div>
        </td>
        <script>
            function onlyOne8(checkbox8) {
                console.log(checkbox8);
                var checkboxes8 = document.querySelectorAll('input[name="' + checkbox8.name + '"]');
                checkboxes8.forEach(function(item8) {
                    if (item8 !== checkbox8) {
                        item8.checked = false;
                    }
                });
            }
        </script>
    </tr>


    <tr style="border-bottom: 1px solid black;border-top: 1px solid black;" >
        <td colspan="6" style="border: none; height: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #ffff00;">{{ Form::label('projectCategory', '6.&nbsp;&nbsp;&nbsp;&nbsp;MAKLUMAT SOKONGAN:', ['class' => 'col-form-label']) }}</td>
    </tr>
    @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" style="height: 20px; padding-top: 5px; padding-bottom: 5px;">
            {{ Form::label('note1', '&nbsp;&nbsp;&nbsp;&nbsp;Maklumat lain yang perlu disertakan', ['class' => 'col-form-label']) }}
        </td>
    </tr>

    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6">
            <div class="form-group row">
            @php
                // Define the array of labels
                $labels = [
                    'Surat Permohonan Beserta Cop Pengesahan Datuk Bandar/YDP/SU *',
                    'Pelan ukur terkini (dalam tempoh 3 tahun) yang telah disahkan oleh Juruukur Bertauliah *',
                    'Pelan guna tanah bagi kawasan tapak cadangan dan sekitarnya *',
                    'Pelan kontur kawasan tapak cadangan dan sekitarnya *',
                    'Gambar foto tapak cadangan *',
                    'Gambar foto kawasan sekitar tapak cadangan *',
                    'Salinan surat hakmilik tanah untuk setiap lot yang terlibat',
                    'Salinan surat pewartaan untuk setiap lot yang terlibat',
                    'Lain-lain gambar',
                ];
            @endphp

            <ol>
                @foreach($labels as $index => $label)
                    <li class="mb-2">
                    @if(strpos($label, '*') !== false)
                        {!! str_replace('*', '<span style="color: red;">*</span>', $label) !!}
                    @else
                        {{ $label }}
                    @endif
                    </li>
                @endforeach
            </ol>
            </div>
        </td>
    </tr>
    @endif
    <!-- File Upload Section -->
    <tr>
        <td style="border: none; padding: 8px; text-align: left;"  colspan="6" style="padding-top: 15px; padding-bottom: 15px;">
            @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
                <div class="form-group row">
                    <div class="col-md-12">
                        {{ Form::label('file_upload', '&nbsp;&nbsp;&nbsp;&nbsp;Sila muat naik dokumen sokongan:', ['class' => 'col-form-label', 'style' => 'font-weight: normal;']) }}
                        <br>
                        @if(isset($eLAPS->file_path))
                        {{ Form::label('', '&nbsp;&nbsp;&nbsp;&nbsp;Muatnaik semula akan menggantikan fail sedia ada.', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="d-block">
                            <!-- File input field with the same width as the progress bar -->
                            {{ Form::file('supporting_documents', ['class' => 'form-control d-inline-block ms-2', 'id' => 'supporting_documents', 'multiple' => true, 'style' => 'width: 100%;']) }}
                            <input name="large_file_name_new" type="hidden" id="large_file_name_new">
                            <input name="large_file_name_old" type="hidden" id="large_file_name_old">
                        </div>

                        <!-- <div id="progress-container" class="d-block mt-2" style="width: 100%; display: none;">
                            <div id="progress-bar" style="width: 100%; background-color: #ccc;">
                                <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
                            </div>
                            <p>Uploading: <span id="progress-text">0%</span></p>
                        </div> -->
                        <div id="progress-container" style="display: none;">
                            <div id="progress-bar" style="width: 100%; background-color: #ccc;">
                                <div id="progress" style="height: 20px; width: 0; background-color: green;"></div>
                            </div>
                            <p>Uploading: <span id="progress-text">0%</span></p>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        {{ Form::label('', '&nbsp;&nbsp;&nbsp;&nbsp;Fail hendaklah dikepil bersama (compress) dan dimuatnaik format rar atau zip.', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                        <br>
                        {{ Form::label('', '&nbsp;&nbsp;&nbsp;&nbsp;Saiz fail muatnaik tidak melebihi 50 MB.', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                    </div>
                </div>
                
                @if(isset($eLAPS->file_path))
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            @php
                                $folderName = isset($eLAPS->file_path) ? 'eLAPS/'.str_replace('/', '', $eLAPS->referenceNumber).'/'.$eLAPS->file_path : null;
                            @endphp
                            
                            @if($folderName != null)
                            <a href="{{ asset('storage/uploads/' . $folderName) }}" target="_blank" class="" style="border: 1px solid #ddd; border-radius: 10px; padding: 10px; display: inline-block; text-align: center; background-color: #fff;" download>
                                <div class="product-image">
                                    <img src="https://img.icons8.com/fluency/48/winrar.png" class="br-5" alt="" style="width: 48px; height: 48px; border-radius: 5px; margin-bottom: 10px;">
                                </div>
                                <div class="product-image">
                                    <span class="file-name-1" style="background-color: #008000; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: 600; display: inline-block; font-size: 14px;">Dokumen Sokongan <i class="fas fa-download"></i></span>
                                </div>
                                <div class="product-image">
                                    <span class="file-name-1">{{ $eLAPS->file_path }}</span>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                @endif
            
            @endif

            @if(Auth::user()->hasRole('Pihak Berkuasa Tempatan'))
            <div class="row">
                <div class="form-group mb-6 col-md-12" style="background-color:#fef7f8; border-left: 5px solid #f0868e; padding: 15px;">
                    <label for="anggaran_penduduk"><h4>Pengesahan dan pengakuan pemohon:</h4></label>
                    <div style="background-color: transparent; border: none; padding: 10px; width: 100%; font-size: 16px;">
                        Dengan ini saya mengesahkan segala maklumat yang diberikan adalah <strong>betul, tepat, lengkap</strong> dan sebarang kesalahan dan percanggahan maklumat adalah dibawah tanggungan pihak saya sendiri. Diperakukan bahawa tapak cadangan ini tidak terlibat dengan pembangunan-pembangunan semasa dan pihak saya juga tidak mengemukakan apa-apa permohonan selain cadangan pembangunan yang dipohon untuk projek ini sahaja.
                    </div>
                </div>
            </div>
            @endif
        </td>
    </tr>

</table>
<script>

    $(document).ready(function() {
        const timestamp = new Date().getTime();
        $('#supporting_documents').change(function() {
            $('button[type="submit"]').prop('disabled', true);
            $('#supporting_documents').prop('disabled', true);
            let destinationFolder = `eLAPS/temp/`;
            let deleteThis = $('#large_file_name_old').val();
            // alert(destinationFolder);
            let fileInput = $('#supporting_documents')[0];
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
<!-- Add custom CSS to make checkboxes bigger -->
<style>
    .bigger-checkbox {
        transform: scale(2); /* Increases checkbox size */
        margin-right: 10px;
    }

    .bigger-label {
        font-size: 14px; /* Increases label font size */
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

<style>
    @media (max-width: 768px) {
        .card {
            width: 1000px; /* Make sure the card has the same fixed width */
            margin: 0 auto; /* Center the card */
        }
    }
    .required-field-create::after {
        content: "***"; /* Add the asterisk */
        color: red; /* Make the asterisk red */
    }
</style>

@if(isset($eLAPS))
    <style>
        .required-field::after {
            content: "**"; /* Add the asterisk */
            color: red; /* Make the asterisk red */
        }
    </style>
@endif