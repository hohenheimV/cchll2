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

<script>
    $(document).ready(function () {
    bsCustomFileInput.init();

    var autoupdate = false;

    $('input[name="feedback_at"], input[name="response_at"]').daterangepicker({           
           singleDatePicker: true,
            timePicker: true,
            showDropdowns: true,
            minDate: moment().subtract(1, 'month').subtract(1, 'year').format('DD-MM-YYYY'),
            maxDate: moment().add(1, 'week').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
            drops: "down",
            locale: {
                format: 'DD-MM-YYYY h:mm A'
            }
        });


        $('#formFeedbacks').validate({ //sets up the validator

            submitHandler: function (form) {
                form.submit();
            },
            rules: {
                'feedback_at': 'required',
                'name': 'required',
                'email': {
                    required:true,
                    email:true,
                },
                //'phone': 'required',
                'message': 'required',
            }
        });

    });

</script>
@endsection


    <div id="user_details" style="display: block;">
        <div class="row">
            <div class="form-group mb-3 col-md-6">
                {{ Form::label('name', 'Nama') }}
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama"  autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-md-6">
                {{ Form::label('email', 'Emel') }}
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Emel" >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Fields for PBT Account Type -->
    <div id="pbt_fields" style="display: block;">
        <div class="form-group mb-3">
            {{ Form::label('negeri', 'Negeri') }}
            <br>
            <select id="negeri" class="form-control select2" name="negeri" onchange="updatePBT()">
                <option value="">Pilih Negeri</option>
            </select>
        </div>
        <div class="form-group mb-3">
            {{ Form::label('pbt', 'Pihak Berkuasa Tempatan') }}
            <input type="text" name="pbt" id="pbt" list="data_pbt" autocomplete="off" placeholder="Type or select an option" class="form-control" >
            <datalist id="data_pbt">
            </datalist>
        </div>
        <div class="form-group mb-3">
            {{ Form::label('nama_taman', 'Taman Perumahan') }}
            <input id="nama_taman" type="text" class="form-control" name="nama_taman" placeholder="Taman Perumahan (House No./Lot No./Floor and Building Name)" >
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
                    <tbody>
                        <tr>
                            <td style="vertical-align:middle;">
                                <input type="text" name="nama_kawasan[]" class="form-control" maxlength="150" value="">
                            </td>
                            <td style="vertical-align:middle;">
                                <input type="text" name="keluasan[]" class="form-control decimal" maxlength="20" value="">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #e5e5e5;height: 5px;">
                            <td style="padding: 4px 8px; line-height: 1.2;">Jumlah Keluasan</td>
                            <td style="padding: 4px 8px; line-height: 1.2;"><span id="jumlah_keluasan">0</span> ekar</td>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <p>
                    <button type="button" id="addKawasan" class="btn btn-info" style="margin-right:20px;">Tambah</button>
                    * Minimum keluasan bagi kawasan lapang adalah 0.5 ekar
                </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group mb-3 col-md-4">
                <label for="pelan_lokasi_1">Pelan Lokasi 1 <span class="font-red"> * </span></label>
                <input type="file" name="pelan_lokasi[]" class="form-control" >
            </div>
        <!-- </div>
        <div class="row"> -->
            <div class="form-group mb-3 col-md-4">
                <label for="pelan_lokasi_2">Pelan Lokasi 2</label>
                <input type="file" name="pelan_lokasi[]" class="form-control">
            </div>
        <!-- </div>
        <div class="row"> -->
            <div class="form-group mb-3 col-md-4">
                <label for="pelan_lokasi_3">Pelan Lokasi 3</label>
                <input type="file" name="pelan_lokasi[]" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group mb-3 col-md-4">
                <label for="gambar_kawasan_lapang_1">Gambar Kawasan Lapang 1 <span class="font-red"> * </span></label>
                <input type="file" name="gambar_kawasan_lapang[]" class="form-control" >
            </div>
        <!-- </div>
        <div class="row"> -->
            <div class="form-group mb-3 col-md-4">
                <label for="gambar_kawasan_lapang_2">Gambar Kawasan Lapang 2</label>
                <input type="file" name="gambar_kawasan_lapang[]" class="form-control">
            </div>
        <!-- </div>
        <div class="row"> -->
            <div class="form-group mb-3 col-md-4">
                <label for="gambar_kawasan_lapang_3">Gambar Kawasan Lapang 3</label>
                <input type="file" name="gambar_kawasan_lapang[]" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8 col-xs-12">
                <p class="help-block font-red"> <i class="fa fa-info-circle"></i> Format yang dibenarkan: pdf, gif, jpg, png, jpeg. Saiz maksimum fail adalah  10MB.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group mb-6 col-md-12">
                {{ Form::label('anggaran_penduduk', 'Anggaran Penduduk * ') }}
                <input id="anggaran_penduduk" type="text" class="form-control" name="anggaran_penduduk" placeholder="Anggaran Penduduk">
            </div>
        </div>

        <div class="row">
            <table class="table table-bordered" style="margin-bottom:0;">
                <thead>
                    <tr style="background-color: #e5e5e5;height: 5px;">
                        <th colspan="4" class="text-center bold" style="padding: 4px 8px; line-height: 1.2;">
                            SENARAI JAWATANKUASA MiB
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
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Pengerusi <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="pengerusi_nama" name="pengerusi_nama" class="form-control" maxlength="150" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="pengerusi_tel_bimbit" name="pengerusi_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="pengerusi_email" name="pengerusi_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Timbalan Pengerusi <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="timbalan_pengerusi_nama" name="timbalan_pengerusi_nama" class="form-control" maxlength="150" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="timbalan_pengerusi_tel_bimbit" name="timbalan_pengerusi_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="timbalan_pengerusi_email" name="timbalan_pengerusi_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Setiausaha <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="setiausaha_nama" name="setiausaha_nama" class="form-control " maxlength="150" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="setiausaha_tel_bimbit" name="setiausaha_tel_bimbit" class="form-control" maxlength="20" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="setiausaha_email" name="setiausaha_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Bendahari <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="bendahari_nama" name="bendahari_nama" class="form-control " maxlength="150" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="bendahari_tel_bimbit" name="bendahari_tel_bimbit" class="form-control " maxlength="20" value="" ></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="bendahari_email" name="bendahari_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    <!-- Repeat for other rows with similar structure -->
                    @for ($i = 1; $i <= 1; $i++)
                        <tr>
                            <td style="padding: 4px 8px; line-height: 1;">AJK {{ $i }}</td>
                            <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="ajk{{ $i }}_nama" name="ajk{{ $i }}_nama" class="form-control" maxlength="150" value=""></td>
                            <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="ajk{{ $i }}_tel_bimbit" name="ajk{{ $i }}_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                            <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="ajk{{ $i }}_email" name="ajk{{ $i }}_email" class="form-control lowercase" maxlength="100" value=""></td>
                        </tr>
                    @endfor
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Penyelaras (Pemegang ID) <span class="font-red"> * </span></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="penyelaras_nama" name="penyelaras_nama" class="form-control" maxlength="150" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="text" id="penyelaras_tel_bimbit" name="penyelaras_tel_bimbit" class="form-control" maxlength="20" value=""></td>
                        <td style="padding: 4px 8px; line-height: 1;"><input type="email" id="penyelaras_email" name="penyelaras_email" class="form-control lowercase" maxlength="100" value=""></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 8px; line-height: 1;">Alamat Surat Menyurat Penyelaras <span class="font-red"> * </span></td>
                        <td colspan="3" style="padding: 4px 8px; line-height: 1;">
                            <textarea id="alamat_penyelaras" name="alamat_penyelaras" class="form-control" rows="5"></textarea>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="background-color: #e5e5e5;height: 5px;">
                        <td colspan="4" style="padding: 4px 8px; line-height: 1.2;">
                            Jumlah Keluasan
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="form-group mb-6 col-md-12" style="background-color:#fef7f8; border-left: 5px solid #f0868e; padding: 15px;">
                <label for="anggaran_penduduk"><h4>Pengesahan dan pengakuan pemohon:</h4></label>
                <textarea style="background-color: transparent; border: none; outline: none; padding: 10px; width: 100%; resize: none;" rows="3" class="form-control" readonly disabled>Saya mengaku segala maklumat yang saya nyatakan di dalam borang ini adalah benar dan betul. Saya faham sekiranya ada di antara maklumat yang saya nyatakan di atas tidak benar/palsu, permohonan ini akan terbatal dengan sendirinya.</textarea>
            </div>
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
