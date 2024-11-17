<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th class="table-secondary">Kod</th>
        <td colspan="2">{!! $softscape->kod_tag ?? $blank !!}</td>
        <td rowspan="6" class="align-middle text-center">
            <img class="img-thumbnail m-1"
                src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .3, true)->margin(0)->size(120)->errorCorrection('Q')->generate($softscape->softscape_qrcode)) !!}"
                alt="qr">
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Koordinat</th>
        <td colspan="2">
            {{ $softscape->x_coord .', '.$softscape->y_coord }}
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Zon</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('zon', 'Zon',['class'=>'sr-only']) }}
                {{ Form::text('zon',null,['placeholder'=>'Sila masukkan Zon','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'zon')]) }}
                {!! Html::hasError($errors,'zon') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Taman Persekutuan</th>
        <td colspan="2">
            {{ Form::label('taman_pers', 'taman_pers',['class'=>'sr-only']) }}
            {{ Form::text('taman_pers',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'taman_pers')]) }}
            {!! Html::hasError($errors,'taman_pers') !!}
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Jenis/Kategori</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('jenis_kate', 'jenis_kate',['class'=>'sr-only']) }}
                {{ Form::text('jenis_kate',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_kate')]) }}
                {!! Html::hasError($errors,'jenis_kate') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Botani</th>
        <td colspan="2">
            <div class="form-group mb-0">
                {{ Form::label('nama_bot', 'nama_bot',['class'=>'sr-only']) }}
                {{ Form::text('nama_bot',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_bot')]) }}
                {!! Html::hasError($errors,'nama_bot') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Tempatan</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('nama_temp', 'nama_temp',['class'=>'sr-only']) }}
                {{ Form::text('nama_temp',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_temp')]) }}
                {!! Html::hasError($errors,'nama_temp') !!}
            </div>
        </td>
        <th class="table-secondary">Tarikh Ditanam</th>
        <td style="width: 200px">
            <div class="form-group mb-0">
                {{ Form::label('tarikh_tan', 'tarikh_tan',['class'=>'sr-only']) }}
                {{ Form::text('tarikh_tan',null,['placeholder'=>'Sila masukkan maklumat','class' => 'tarikh form-control form-control-sm '.Html::isInvalid($errors,'tarikh_tan')]) }}
                {!! Html::hasError($errors,'tarikh_tan') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Keluarga/Asal</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('nama_kel', 'nama_kel',['class'=>'sr-only']) }}
                {{ Form::text('nama_kel',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_kel')]) }}
                {!! Html::hasError($errors,'nama_kel') !!}
            </div>
        </td>
        <th class="table-secondary">Tahun Ditanam</th>
        <td style="width: 200px">{!! Html::datetime($softscape->tarikh_tan,'Y') !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Negara Asal</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('negara_asa', 'negara_asa',['class'=>'sr-only']) }}
                {{ Form::text('negara_asa',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'negara_asa')]) }}
                {!! Html::hasError($errors,'negara_asa') !!}
            </div>
        </td>
        <th class="table-secondary">Tarikh Daftarkan</th>
        <td style="width: 200px">{!! $softscape->tarikh_mas ? Html::datetime($softscape->tarikh_mas,'d-m-Y') : $blank !!}</td>
    </tr>

    <tr>
        <th class="table-secondary">Kos Perolehan (RM)</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('kos', 'kos',['class'=>'sr-only']) }}
                {{ Form::text('kos',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kos')]) }}
                {!! Html::hasError($errors,'kos') !!}
            </div>
        </td>
        <th class="table-secondary">Tarikh Dikemaskini</th>
        <td style="width: 200px">{!! $softscape->updated_at ? $softscape->updated_at->format('d-m-Y') : $blank !!}</td>
    </tr>
</table>

<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th colspan="6" class="table-secondary">Maklumat Asas</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kategori Tumbuhan</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('kategori_t', 'kategori_t',['class'=>'sr-only']) }}
                {{ Form::text('kategori_t',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'kategori_t')]) }}
                {!! Html::hasError($errors,'kategori_t') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Umur Pokok</th>
        <td>{!! $softscape->umur_pokok  ? $softscape->umur_pokok .' tahun' : $blank !!}</td>
        <th class="font-weigt-bold">Jenis Akar</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('jenis_akar', 'jenis_akar',['class'=>'sr-only']) }}
                {{ Form::text('jenis_akar',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_akar')]) }}
                {!! Html::hasError($errors,'jenis_akar') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Cara Pembiakan</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('cara_biak', 'cara_biak',['class'=>'sr-only']) }}
                {{ Form::text('cara_biak',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'cara_biak')]) }}
                {!! Html::hasError($errors,'cara_biak') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Saiz Kanopi</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('saiz_kanop', 'saiz_kanop',['class'=>'sr-only']) }}
                {{ Form::text('saiz_kanop',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'saiz_kanop')]) }}
                {!! Html::hasError($errors,'saiz_kanop') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Nilai Semasa (RM)</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('nilai_sema', 'nilai_sema',['class'=>'sr-only']) }}
                {{ Form::text('nilai_sema',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nilai_sema')]) }}
                {!! Html::hasError($errors,'nilai_sema') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Keterangan Pokok</th>
        <td colspan="5">
            <div class="form-group mb-0">
                {{ Form::label('keterangan', 'keterangan',['class'=>'sr-only']) }}
                {{ Form::textarea('keterangan',null,['placeholder'=>'Sila masukkan maklumat','rows'=>2,'class' => 'form-control form-control '.Html::isInvalid($errors,'keterangan')]) }}
                {!! Html::hasError($errors,'keterangan') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Fungsi Pokok</th>
        <td colspan="5">
            <div class="form-group mb-0">
                {{ Form::label('fungs_ipok', 'fungs_ipok',['class'=>'sr-only']) }}
                {{ Form::textarea('fungs_ipok',null,['placeholder'=>'Sila masukkan maklumat','rows'=>2,'class' => 'form-control form-control '.Html::isInvalid($errors,'fungs_ipok')]) }}
                {!! Html::hasError($errors,'fungs_ipok') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kegunaan Pokok</th>
        <td colspan="5">
            <div class="form-group mb-0">
                {{ Form::label('kegunaan', 'kegunaan',['class'=>'sr-only']) }}
                {{ Form::textarea('kegunaan',null,['placeholder'=>'Sila masukkan maklumat','rows'=>2,'class' => 'form-control form-control '.Html::isInvalid($errors,'kegunaan')]) }}
                {!! Html::hasError($errors,'kegunaan') !!}
            </div>
        </td>
    </tr>

</table>

<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th colspan="6" class="table-secondary">Maklumat Tambahan</th>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Silara</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kelebaran Silara</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('lebar_sila', 'lebar_sila',['class'=>'sr-only']) }}
                {{ Form::text('lebar_sila',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'lebar_sila')]) }}
                {!! Html::hasError($errors,'lebar_sila') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Bentuk Silara Pokok</th>
        <td colspan="3">
            <div class="form-group mb-0">
                {{ Form::label('bentuk_sil', 'kategori_t',['class'=>'sr-only']) }}
                {{ Form::text('bentuk_sil',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'bentuk_sil')]) }}
                {!! Html::hasError($errors,'bentuk_sil') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Bunga</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Warna Bunga</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('warna_bung', 'warna_bung',['class'=>'sr-only']) }}
                {{ Form::text('warna_bung',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'warna_bung')]) }}
                {!! Html::hasError($errors,'warna_bung') !!}
            </div>
        </td>
        </td>
        <th class="font-weigt-bold">Bentuk Bunga</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('bentuk_bun', 'bentuk_bun',['class'=>'sr-only']) }}
                {{ Form::text('bentuk_bun',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'bentuk_bun')]) }}
                {!! Html::hasError($errors,'bentuk_bun') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Saiz Bunga</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('saiz_bunga', 'saiz_bunga',['class'=>'sr-only']) }}
                {{ Form::text('saiz_bunga',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'saiz_bunga')]) }}
                {!! Html::hasError($errors,'saiz_bunga') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Bilangan Kelopak Bunga</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('bil_kelopa', 'bil_kelopa',['class'=>'sr-only']) }}
                {{ Form::text('bil_kelopa',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'bil_kelopa')]) }}
                {!! Html::hasError($errors,'bil_kelopa') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Wangian Bunga</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('wangian', 'wangian',['class'=>'sr-only']) }}
                {{ Form::text('wangian',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'wangian')]) }}
                {!! Html::hasError($errors,'wangian') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Tempoh Berbunga</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('tempohbg', 'tempohbg',['class'=>'sr-only']) }}
                {{ Form::text('tempohbg',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tempohbg')]) }}
                {!! Html::hasError($errors,'tempohbg') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Musim Berbunga</th>
        <td colspan="5">
            <div class="form-group mb-0">
                {{ Form::label('musimbg', 'musimbg',['class'=>'sr-only']) }}
                {{ Form::text('musimbg',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'musimbg')]) }}
                {!! Html::hasError($errors,'musimbg') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Daun</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Warna Daun</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('warna_daun', 'warna_daun',['class'=>'sr-only']) }}
                {{ Form::text('warna_daun',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'warna_daun')]) }}
                {!! Html::hasError($errors,'warna_daun') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Bentuk Daun</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('bentuk_dau', 'bentuk_dau',['class'=>'sr-only']) }}
                {{ Form::text('bentuk_dau',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'bentuk_dau')]) }}
                {!! Html::hasError($errors,'bentuk_dau') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Jenis Daun</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('jenis_daun', 'jenis_daun',['class'=>'sr-only']) }}
                {{ Form::text('jenis_daun',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis_daun')]) }}
                {!! Html::hasError($errors,'jenis_daun') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Cara Percambahan Daun</th>
        <td colspan="5">
            <div class="form-group mb-0">
                {{ Form::label('percambaha', 'percambaha',['class'=>'sr-only']) }}
                {{ Form::text('percambaha',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'percambaha')]) }}
                {!! Html::hasError($errors,'percambaha') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Batang Pokok</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Ketinggian Batang Pokok</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('tinggi_btg', 'tinggi_btg',['class'=>'sr-only']) }}
                {{ Form::text('tinggi_btg',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tinggi_btg')]) }}
                {!! Html::hasError($errors,'tinggi_btg') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Diameter Batang Pokok</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('diamater_b', 'diamater_b',['class'=>'sr-only']) }}
                {{ Form::text('diamater_b',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'percambaha')]) }}
                {!! Html::hasError($errors,'diamater_b') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Ukur Lilit Batang</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('bentuk_btg', 'bentuk_btg',['class'=>'sr-only']) }}
                {{ Form::text('bentuk_btg',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'bentuk_btg')]) }}
                {!! Html::hasError($errors,'bentuk_btg') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tekstur Batang Pokok</th>
        <td colspan="5">
            <div class="form-group mb-0">
                {{ Form::label('tekstur_bt', 'tekstur_bt',['class'=>'sr-only']) }}
                {{ Form::text('tekstur_bt',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tekstur_bt')]) }}
                {!! Html::hasError($errors,'tekstur_bt') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Buah</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Warna Buah</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('warna_bh', 'warna_bh',['class'=>'sr-only']) }}
                {{ Form::text('warna_bh',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'warna_bh')]) }}
                {!! Html::hasError($errors,'warna_bh') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Bentuk Buah</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('bentuk_bh', 'bentuk_bh',['class'=>'sr-only']) }}
                {{ Form::text('bentuk_bh',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'bentuk_bh')]) }}
                {!! Html::hasError($errors,'bentuk_bh') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Saiz Buah</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('saiz_buah', 'saiz_buah',['class'=>'sr-only']) }}
                {{ Form::text('saiz_buah',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'saiz_buah')]) }}
                {!! Html::hasError($errors,'saiz_buah') !!}
            </div>
        </td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Musim Buah</th>
        <td>
            <div class="form-group mb-0">
                {{ Form::label('musim_buah', 'musim_buah',['class'=>'sr-only']) }}
                {{ Form::text('musim_buah',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'musim_buah')]) }}
                {!! Html::hasError($errors,'musim_buah') !!}
            </div>
        </td>
        <th class="font-weigt-bold">Tempoh Berbuah</th>
        <td colspan="3">
            <div class="form-group mb-0">
                {{ Form::label('tempoh_bua', 'tempoh_bua',['class'=>'sr-only']) }}
                {{ Form::text('tempoh_bua',null,['placeholder'=>'Sila masukkan maklumat','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'tempoh_bua')]) }}
                {!! Html::hasError($errors,'tempoh_bua') !!}
            </div>
        </td>
    </tr>
</table>
