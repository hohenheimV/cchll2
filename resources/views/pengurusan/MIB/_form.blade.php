@section('page-css-style')
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    <style>
        input.error,
        textarea.error {
            border: 1px solid #e83e8c !important;
        }

        label.error {
            color: #e83e8c;
            font-weight: 400 !important;
        }
    </style>
@endsection

@section('page-js-script')
    <!-- jquery-validation -->
    <script src="{{ asset('web/plugins/jquery-validation/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('web/plugins/jquery-validation/jquery-validation-methods.min.js') }}"></script>
    <script src="{{ asset('web/plugins/jquery-validation/jquery-validation-additional.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

@endsection

<?php
    // $message = json_decode($MIB->message, true);
?>


    <!-- <div id="user_details" style="display: block;">
        <div class="row">
            <div class="form-group mb-3 col-md-6">
                {{ Form::label('name', 'Nama Wakil') }}
                <input value="{{ isset($MIB->name) ? $MIB->name : '' }}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama"  autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-md-6">
                {{ Form::label('email', 'Emel Wakil') }}
                <input value="{{ isset($MIB->email) ? $MIB->email : '' }}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Emel" >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div> -->

    <!-- Fields for PBT Account Type -->
    <div id="pbt_fields" style="display: block;" class="inertClass">
        <div class="form-group mb-3">
            {{ Form::label('negeri', 'Negeri') }}
            <br>
            {{ Form::select('negeri', [], null, ['class' => 'form-control', 'id' => 'negeri']) }}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
            <input value="{{ isset($MIB->pbt) ? $MIB->pbt : '' }}" type="text" name="pbt" id="pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" class="form-control" >
            <datalist id="data_pbt">
            </datalist>
        </div>
        <div class="form-group mb-3">
            {{ Form::label('taman', 'Taman Perumahan') }}
            <input value="{{ isset($MIB->taman) ? $MIB->taman : '' }}" id="taman" type="text" class="form-control" name="taman" placeholder="Taman Perumahan (House No./Lot No./Floor and Building Name)" >
        </div>
    </div>


    <div id="user_address" style="display: block;">
        <div class="row">
            <div class="form-group mb-6 col-md-12">
                <table id="senarai_kawasan_lapang" class="table table-bordered" style="margin-bottom:0;">
                    <thead>
                        <tr style="background-color: #e5e5e5;height: 5px;">
                            <th style="padding: 4px 8px; line-height: 1.2;">Nama Kawasan Lapang <span class="font-red"> * </span></th>
                            <th style="padding: 4px 8px; line-height: 1.2;">Keluasan (Ekar) <span class="font-red"> * </span></th>
                        </tr>
                    </thead>
                    <tbody id="senarai_kawasan_lapang">
                        @if(isset($MIB->kawasan))
                            @foreach($MIB->kawasan as $key => $kawasan)
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <input type="text" name="kawasan[{{ $key }}][nama]" class="form-control" maxlength="150" value="{{ $kawasan['nama'] ?? '' }}">
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <input type="text" name="kawasan[{{ $key }}][keluasan]" class="form-control decimal" maxlength="20" value="{{ $kawasan['keluasan'] ?? '' }}">
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="vertical-align:middle;">
                                    <input type="text" name="kawasan[0][nama]" class="form-control" maxlength="150" value="">
                                </td>
                                <td style="vertical-align:middle;">
                                    <input type="text" name="kawasan[0][keluasan]" class="form-control decimal" maxlength="20" value="">
                                </td>
                            </tr>
                        @endif
                    </tbody>

                    <tfoot>
                        <tr style="background-color: #e5e5e5;height: 5px;">
                            <td style="padding: 4px 8px; line-height: 1.2;">Jumlah Keluasan</td>
                            <td style="padding: 4px 8px; line-height: 1.2;"><span id="jumlah_keluasan">0</span> ekar</td>
                        </tr>
                    </tfoot>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            // Initialize total area to 0
                            var totalArea = 0;

                            // Loop through each 'keluasan' input field and sum the values
                            $('input[name$="[keluasan]"]').each(function() {
                                var area = parseFloat($(this).val());
                                if (!isNaN(area)) {
                                    totalArea += area;
                                }
                            });

                            // Update the displayed total area in 'Jumlah Keluasan'
                            $('#jumlah_keluasan').text(totalArea.toFixed(2));

                            // Update total area (jumlah_keluasan) when a field changes
                            $(document).on('input', 'input[name$="[keluasan]"]', function() {
                                totalArea = 0; // Reset total area

                                // Loop through each 'keluasan' input field and sum the values again
                                $('input[name$="[keluasan]"]').each(function() {
                                    var area = parseFloat($(this).val());
                                    if (!isNaN(area)) {
                                        totalArea += area;
                                    }
                                });

                                // Update the displayed total area in 'Jumlah Keluasan'
                                $('#jumlah_keluasan').text(totalArea.toFixed(2));
                            });
                        });
                    </script>
                </table>
                <br>
                <p class="showButton">
                    <button type="button" id="addKawasan" class="btn btn-info" style="margin-right:20px;">Tambah</button>
                    * Minimum keluasan bagi kawasan lapang adalah 0.5 ekar
                </p>
            </div>
        </div>

        @if(strpos(request()->url(), 'edit') !== false || strpos(request()->url(), 'create') !== false)
        <div class="row">
            <div class="form-group mb-3 col-md-4">
                <label for="pelan_lokasi_1">Pelan Lokasi 1 <span class="font-red"> * </span></label>
                @if(isset($MIB->fail['pelan_lokasi_1']) && $MIB->fail['pelan_lokasi_1'] != null)
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <div class="center-content">
                        <img src="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['pelan_lokasi_1']) }}" alt="Pelan Lokasi 1" class="img-thumbnail" width="100">
                        <br>
                        <input type="hidden" name="fail[pelan_lokasi_1]" value="{{ $MIB->fail['pelan_lokasi_1'] }}">
                        <a href="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['pelan_lokasi_1']) }}" target="_blank" class="showButton">Lihat Gambar</a>
                    </div>
                @else
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                @endif
            </div>

            <div class="form-group mb-3 col-md-4">
                <label for="pelan_lokasi_2">Pelan Lokasi 2</label>
                @if(isset($MIB->fail['pelan_lokasi_2']) && $MIB->fail['pelan_lokasi_2'] != null)
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <div class="center-content">
                        <img src="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['pelan_lokasi_2']) }}" alt="Pelan Lokasi 2" class="img-thumbnail" width="100">
                        <br>
                        <input type="hidden" name="fail[pelan_lokasi_2]" value="{{ $MIB->fail['pelan_lokasi_2'] }}">
                        <a href="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['pelan_lokasi_2']) }}" target="_blank" class="showButton">Lihat Gambar</a>
                    </div>
                @else
                    <input type="file" name="fail[pelan_lokasi_2]" class="form-control showButton"><br>
                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                @endif
            </div>

            <div class="form-group mb-3 col-md-4">
                <label for="pelan_lokasi_3">Pelan Lokasi 3</label>
                @if(isset($MIB->fail['pelan_lokasi_3']) && $MIB->fail['pelan_lokasi_3'] != null)
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <div class="center-content">
                        <img src="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['pelan_lokasi_3']) }}" alt="Pelan Lokasi 3" class="img-thumbnail" width="100">
                        <br>
                        <input type="hidden" name="fail[pelan_lokasi_3]" value="{{ $MIB->fail['pelan_lokasi_3'] }}">
                        <a href="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['pelan_lokasi_3']) }}" target="_blank" class="showButton">Lihat Gambar</a>
                    </div>
                @else
                    <input type="file" name="fail[pelan_lokasi_3]" class="form-control showButton"><br>
                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group mb-3 col-md-4">
                <label for="gambar_kawasan_lapang_1">Gambar Kawasan Lapang 1 <span class="font-red"> * </span></label>
                @if(isset($MIB->fail['gambar_kawasan_lapang_1']) && $MIB->fail['gambar_kawasan_lapang_1'] != null)
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <div class="center-content">
                        <img src="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['gambar_kawasan_lapang_1']) }}" alt="Gambar Kawasan Lapang 1" class="img-thumbnail" width="100">
                        <br>
                        <input type="hidden" name="fail[gambar_kawasan_lapang_1]" value="{{ $MIB->fail['gambar_kawasan_lapang_1'] }}">
                        <a href="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['gambar_kawasan_lapang_1']) }}" target="_blank" class="showButton">Lihat Gambar</a>
                    </div>
                @else
                    <input type="file" name="fail[gambar_kawasan_lapang_1]" class="form-control showButton"><br>
                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                @endif
            </div>

            <div class="form-group mb-3 col-md-4">
                <label for="gambar_kawasan_lapang_2">Gambar Kawasan Lapang 2</label>
                @if(isset($MIB->fail['gambar_kawasan_lapang_2']) && $MIB->fail['gambar_kawasan_lapang_2'] != null)
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <div class="center-content">
                        <img src="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['gambar_kawasan_lapang_2']) }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                        <br>
                        <input type="hidden" name="fail[gambar_kawasan_lapang_2]" value="{{ $MIB->fail['gambar_kawasan_lapang_2'] }}">
                        <a href="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['gambar_kawasan_lapang_2']) }}" target="_blank" class="showButton">Lihat Gambar</a>
                    </div>
                @else
                    <input type="file" name="fail[gambar_kawasan_lapang_2]" class="form-control showButton"><br>
                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                @endif
            </div>

            <div class="form-group mb-3 col-md-4">
                <label for="gambar_kawasan_lapang_3">Gambar Kawasan Lapang 3</label>
                @if(isset($MIB->fail['gambar_kawasan_lapang_3']) && $MIB->fail['gambar_kawasan_lapang_3'] != null)
                    <input type="file" name="fail[pelan_lokasi_1]" class="form-control showButton"><br>
                    <div class="center-content">
                        <img src="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['gambar_kawasan_lapang_3']) }}" alt="Gambar Kawasan Lapang 3" class="img-thumbnail" width="100">
                        <br>
                        <input type="hidden" name="fail[gambar_kawasan_lapang_3]" value="{{ $MIB->fail['gambar_kawasan_lapang_3'] }}">
                        <a href="{{ asset('storage/uploads/MIB/' . str_replace(' ', '_', $MIB->id.' '.$MIB->taman) . '/' . $MIB->fail['gambar_kawasan_lapang_3']) }}" target="_blank" class="showButton">Lihat Gambar</a>
                    </div>
                @else
                    <input type="file" name="fail[gambar_kawasan_lapang_3]" class="form-control showButton"><br>
                    <img src="{{ asset('storage/uploads/no-photos.png') }}" alt="Gambar Kawasan Lapang 2" class="img-thumbnail" width="100">
                @endif
            </div>
        </div>

        <div class="form-group showButton">
            <div class="col-sm-offset-4 col-sm-8 col-xs-12">
                <p class="help-block font-red"> <i class="fa fa-info-circle"></i> Format yang dibenarkan: pdf, gif, jpg, png, jpeg. Saiz maksimum fail adalah  10MB.</p>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="form-group mb-6 col-md-12">
                {{ Form::label('penduduk', 'Anggaran Penduduk * ') }}
                <input value="{{ isset($MIB->penduduk) ? $MIB->penduduk : '' }}" id="penduduk" type="text" class="form-control" name="penduduk" placeholder="Anggaran Penduduk">
            </div>
        </div>

        <div class="row">
            <?php
                $ajkCount = 0;
                if(isset($MIB->jawatankuasa)){
                    $rakanTaman = ($MIB->jawatankuasa);
                    foreach ($rakanTaman as $key => $value) {
                        foreach ($value as $subKey => $subValue) {
                            if (strpos($subKey, 'ajk') === 0 && strpos($subKey, '_nama') !== false) {
                                $ajkCount++;
                            }
                            break;
                        }
                    }
                    // dd($rakanTaman);
                }else{
                    $rakanTaman = null;
                }
            ?>
            <table class="table table-bordered" style="margin-bottom:0;">
                <thead>
                    <tr style="background-color: #e5e5e5;height: 5px;">
                        <th colspan="4" class="text-center bold" style="padding: 4px 8px; line-height: 1.2;">
                            SENARAI JAWATANKUASA RAKAN TAMAN
                        </th>
                    </tr>
                    <tr style="background-color: #e5e5e5;height: 5px;">
                        <th style="padding: 4px 8px; line-height: 1.2;">Jawatan</th>
                        <th style="padding: 4px 8px; line-height: 1.2;">Nama <span class="font-red"> * </span></th>
                        <th style="padding: 4px 8px; line-height: 1.2;">No. Telefon Bimbit <span class="font-red"> * </span></th>
                        <th style="padding: 4px 8px; line-height: 1.2;">Alamat Emel</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($rakanTaman[0]))
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Pengerusi <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="pengerusi_nama" name="pengerusi_nama" class="form-control" maxlength="150" value="{{ isset($rakanTaman) ? $rakanTaman[0]['pengerusi_nama'] : '' }}"></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="pengerusi_tel_bimbit" name="pengerusi_tel_bimbit" class="form-control" maxlength="20" value="{{ isset($rakanTaman) ? $rakanTaman[0]['pengerusi_tel_bimbit'] : '' }}"></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="pengerusi_email" name="pengerusi_email" class="form-control lowercase" maxlength="100" value="{{ isset($rakanTaman) ? $rakanTaman[0]['pengerusi_email'] : '' }}"></td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Pengerusi <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="pengerusi_nama" name="pengerusi_nama" class="form-control" maxlength="150" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="pengerusi_tel_bimbit" name="pengerusi_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="pengerusi_email" name="pengerusi_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    @endif
                    @if(isset($rakanTaman[1]))
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Timbalan Pengerusi <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="timbalan_pengerusi_nama" name="timbalan_pengerusi_nama" class="form-control" maxlength="150" value="{{ isset($rakanTaman) ? $rakanTaman[1]['timbalan_pengerusi_nama'] : '' }}"></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="timbalan_pengerusi_tel_bimbit" name="timbalan_pengerusi_tel_bimbit" class="form-control" maxlength="20" value="{{ isset($rakanTaman) ? $rakanTaman[1]['timbalan_pengerusi_tel_bimbit'] : '' }}"></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="timbalan_pengerusi_email" name="timbalan_pengerusi_email" class="form-control lowercase" maxlength="100" value="{{ isset($rakanTaman) ? $rakanTaman[1]['timbalan_pengerusi_email'] : '' }}"></td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Timbalan Pengerusi <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="timbalan_pengerusi_nama" name="timbalan_pengerusi_nama" class="form-control" maxlength="150" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="timbalan_pengerusi_tel_bimbit" name="timbalan_pengerusi_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="timbalan_pengerusi_email" name="timbalan_pengerusi_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    @endif
                    @if(isset($rakanTaman[2]))
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Setiausaha <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="setiausaha_nama" name="setiausaha_nama" class="form-control " maxlength="150" value="{{ isset($rakanTaman) ? $rakanTaman[2]['setiausaha_nama'] : '' }}" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="setiausaha_tel_bimbit" name="setiausaha_tel_bimbit" class="form-control" maxlength="20" value="{{ isset($rakanTaman) ? $rakanTaman[2]['setiausaha_tel_bimbit'] : '' }}" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="setiausaha_email" name="setiausaha_email" class="form-control lowercase" maxlength="100" value="{{ isset($rakanTaman) ? $rakanTaman[2]['setiausaha_email'] : '' }}"></td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Setiausaha <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="setiausaha_nama" name="setiausaha_nama" class="form-control " maxlength="150" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="setiausaha_tel_bimbit" name="setiausaha_tel_bimbit" class="form-control" maxlength="20" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="setiausaha_email" name="setiausaha_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    @endif
                    @if(isset($rakanTaman[3]))
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Bendahari <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="bendahari_nama" name="bendahari_nama" class="form-control " maxlength="150" value="{{ isset($rakanTaman) ? $rakanTaman[3]['bendahari_nama'] : '' }}" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="bendahari_tel_bimbit" name="bendahari_tel_bimbit" class="form-control " maxlength="20" value="{{ isset($rakanTaman) ? $rakanTaman[3]['bendahari_tel_bimbit'] : '' }}" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="bendahari_email" name="bendahari_email" class="form-control lowercase" maxlength="100" value="{{ isset($rakanTaman) ? $rakanTaman[3]['bendahari_email'] : '' }}"></td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Bendahari <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="bendahari_nama" name="bendahari_nama" class="form-control " maxlength="150" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="bendahari_tel_bimbit" name="bendahari_tel_bimbit" class="form-control " maxlength="20" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="email" id="bendahari_email" name="bendahari_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    @endif
                    <!-- Repeat for other rows with similar structure -->
                    @for ($i = 1; $i <= 6; $i++)
                        <tr>
                            <td style="padding: 4px 8px; line-height: 1;">AJK {{ $i }}</td>
                            <td style="padding: 4px 8px; line-height: 1;">
                                <input type="text" id="ajk{{ $i }}_nama" name="ajk{{ $i }}_nama" class="form-control" maxlength="150" 
                                    value="{{ isset($rakanTaman[$i+4]) ? $rakanTaman[$i+4]['ajk'.$i.'_nama'] : '' }}">
                            </td>
                            <td style="padding: 4px 8px; line-height: 1;">
                                <input type="text" id="ajk{{ $i }}_tel_bimbit" name="ajk{{ $i }}_tel_bimbit" class="form-control" maxlength="20" 
                                    value="{{ isset($rakanTaman[$i+4]) ? $rakanTaman[$i+4]['ajk'.$i.'_tel_bimbit'] : '' }}">
                            </td>
                            <td style="padding: 4px 8px; line-height: 1;">
                                <input type="email" id="ajk{{ $i }}_email" name="ajk{{ $i }}_email" class="form-control lowercase" maxlength="100" 
                                    value="{{ isset($rakanTaman[$i+4]) ? $rakanTaman[$i+4]['ajk'.$i.'_email'] : '' }}">
                            </td>
                        </tr>
                    @endfor

                    <!-- <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Penyelaras (Pemegang ID) <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="penyelaras_nama" name="penyelaras_nama" class="form-control" maxlength="150" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="penyelaras_tel_bimbit" name="penyelaras_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="penyelaras_email" name="penyelaras_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr> -->
                    
                    @if(isset($rakanTaman[4]))
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Penyelaras <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;">
                            <input required type="text" id="penyelaras_nama" name="penyelaras_nama" class="form-control @error('penyelaras_nama') is-invalid @enderror" maxlength="150" value="{{ isset($rakanTaman) ? $rakanTaman[4]['penyelaras_nama'] : '' }}" >
                            @error('penyelaras_nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="penyelaras_tel_bimbit" name="penyelaras_tel_bimbit" class="form-control " maxlength="20" value="{{ isset($rakanTaman) ? $rakanTaman[4]['penyelaras_tel_bimbit'] : '' }}" ></td>
                        <td style="padding: 4px 8px; line-height: 1;">
                            <input required type="email" id="penyelaras_email" name="penyelaras_email" class="form-control lowercase @error('penyelaras_email') is-invalid @enderror" maxlength="100" value="{{ isset($rakanTaman) ? $rakanTaman[4]['penyelaras_email'] : '' }}">
                            @error('penyelaras_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Penyelaras <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;">
                            <input required type="text" id="penyelaras_nama" name="penyelaras_nama" class="form-control @error('penyelaras_nama') is-invalid @enderror" maxlength="150" value="{{ isset($MIB->name) ? $MIB->name : '' }}" >
                            @error('penyelaras_nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                        <td style="padding: 4px 8px; line-height: 1;"><input required type="text" id="penyelaras_tel_bimbit" name="penyelaras_tel_bimbit" class="form-control " maxlength="20" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;">
                            <input required type="email" id="penyelaras_email" name="penyelaras_email" class="form-control lowercase @error('penyelaras_email') is-invalid @enderror" maxlength="100" value="{{ isset($MIB->email) ? $MIB->email : '' }}">
                            @error('penyelaras_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Alamat Surat Menyurat Penyelaras <span class="font-red"> * </span></td>
                        <td colspan="3" style="padding: 4px 8px; line-height: 1;">
                            <textarea id="alamat" name="alamat" class="form-control" rows="5">{{ $MIB->alamat ?? '' }}</textarea>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Register Button -->
    <!-- <div class="row" style="display: block;" id="daftar">
        <div class="col-12">
            <button type="submit" class="btn bg-olive btn-block btn-flat">Daftar</button>
        </div>
    </div>
    &nbsp;
    <div class="row" style="display: block;" id="daftar">
        <div class="col-12">
            <button type="reset" class="btn bg-gray btn-block btn-flat">Reset</button>
        </div>
    </div> -->

<!-- <div class="form-row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            {{ Form::label('name', 'Nama Pengguna') }}
            {{ Form::text('name',null,['placeholder'=>'Sila masukkan Nama Pemohon','class' => 'form-control '.Html::isInvalid($errors,'name')]) }}
            {!! Html::hasError($errors,'name') !!}
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            {{ Form::label('email', 'E-Mel Pengguna') }}
            {{ Form::email('email',null,['placeholder'=>'Sila masukkan E-Mel Pemohon','class' => 'form-control '.Html::isInvalid($errors,'email')]) }}
            {!! Html::hasError($errors,'email') !!}
        </div>
    </div>
    <div class="col-12 col-md-2">
        <div class="form-group">
            {{ Form::label('phone', 'No. Telefon Pengguna') }}
            {{ Form::text('phone',null,['placeholder'=>'Sila masukkanNo. Telefon','class' => 'form-control '.Html::isInvalid($errors,'phone')]) }}
            {!! Html::hasError($errors,'phone') !!}
        </div>
    </div>
</div>

<div class="form-group">
    {{ Form::label('message', 'Ringkasan Aktiviti') }}
    {{ Form::textarea('message',null,['rows'=>6,'placeholder'=>'Sila masukkan Ringkasan Aktiviti','class' => 'form-control '.Html::isInvalid($errors,'message')]) }}
    {!! Html::hasError($errors,'message') !!}
</div> -->


<script>
    function updatePBT() {
        const negeriId = $('#negeri').val();
        const $datalist = $('#data_pbt');  // Target the datalist element
        
        // Clear previous options in the datalist
        $datalist.empty();
        
        // Show the spinner while loading
        $('#loading-spinner').show(); 

        $.getJSON('/data/pbt/' + negeriId, function(data) {
            // Loop through the data and populate the datalist
            $.each(data, function(index, pbt) {
                // Create a new option element for the datalist
                $datalist.append($('<option>', {
                    value: pbt.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' '),
                    // text: pbt.id,
                    'data-id': pbt.id,
                }));
            });

            // Hide the spinner once the data is loaded
            $('#loading-spinner').hide(); 
        }).fail(function() {
            // Hide the spinner in case of error
            $('#loading-spinner').hide();
            alert('Failed to load data. Sila isi Nama Pihak Berkuasa Tempatan.');
        });
    }

    // Initialize fields based on the default dropdown value
    $(document).ready(function() {
        // $.getJSON('/data/negeri', function(data) {
            
        //     $.each(data, function(index, negeri) {
        //         let pname = negeri.name;
        //         $('#negeri').append($('<option>', {
        //             value: negeri.id,
        //             text: negeri.name.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
        //         }));
        //     });
        //     // Re-enable the negeri dropdown and hide the spinner
        //     $('#negeri').prop('disabled', false);
        //     $('#loading-spinner').hide(); // Hide the spinner

        // }).fail(function() {
        //     // Handle errors if needed
        //     $('#negeri').prop('disabled', false);
        //     $('#loading-spinner').hide(); // Hide the spinner in case of error
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
                    $('#negeri').append('<option value="' + value.kod_negeri + '">' + value.nama_negeri + '</option>');
                });
                var negeriSelected = "{{ isset($MIB->negeri) ? $MIB->negeri : '' }}"; // Assuming you have $ePALM->negeri
                if (negeriSelected) {
                    $('#negeri').val(negeriSelected);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching Negeri data: ", error);
            }
        });

        $('#negeri').change(function() {
            var negeriId = $(this).val();
            var negeriText = $(this).find('option:selected').text();
            $('#data_pbt').empty();
            $.getJSON('/data/pbt/' + negeriText, function(data) {
                $.each(data, function(index, pbt) {
                    $('#data_pbt').append($('<option>', {
                        value: pbt.name,
                        'data-id': pbt.id,
                    }));
                });
            });
        });


        
        let rowIndex = '{{ isset($MIB->kawasan) ? count($MIB->kawasan) : 1 }}';
        // alert(rowIndex);
        // Function to Add New Row
        $('#addKawasan').click(function() {
            var newRow = `
                <tr>
                    <td style="vertical-align:middle;">
                        <input type="text" name="kawasan[${rowIndex}][nama]" class="form-control" maxlength="150" value="">
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="text" name="kawasan[${rowIndex}][keluasan]" class="form-control decimal" maxlength="20" value="">
                    </td>
                </tr>
            `;
            // Append the new row to the table
            $('#senarai_kawasan_lapang').append(newRow);
            
            // Increment the rowIndex for the next row
            rowIndex++;
        });

        // Function to Update the Total Area
        $(document).on('input', 'input[name^="kawasan"][name$="[keluasan]"]', function() {
            var totalArea = 0;
            
            // Loop through each 'keluasan' input field and sum the values
            $('input[name$="[keluasan]"]').each(function() {
                var area = parseFloat($(this).val());
                if (!isNaN(area)) {
                    totalArea += area;
                }
            });
            
            // Update the displayed total area
            $('#jumlah_keluasan').text(totalArea.toFixed(2));
        });
        
    });
</script>