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
        <td colspan="2">{{ $softscape->x_coord .', '.$softscape->y_coord }}</td>
    </tr>
    <tr>
        <th class="table-secondary">Zon</th>
        <td colspan="2">{!! $softscape->zon ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Taman Persekutuan</th>
        <td colspan="2">{!! $softscape->taman_pers ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Jenis/Kategori</th>
        <td colspan="2">{!! $softscape->jenis_kate ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Botani</th>
        <td colspan="2">{!! $softscape->nama_bot ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Tempatan</th>
        <td>{!! $softscape->nama_temp ?? $blank !!}</td>
        <th class="table-secondary">Tarikh Ditanam</th>
        <td style="width: 200px">{!! $softscape->tarikh_tan ? Html::datetime($softscape->tarikh_tan,'d-m-Y') : $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Keluarga/Asal</th>
        <td>{!! $softscape->nama_kel ?? $blank !!}</td>
        <th class="table-secondary">Tahun Ditanam</th>
        <td style="width: 200px">{!! $softscape->tarikh_tan ? Html::datetime($softscape->tarikh_tan,'Y') : $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Negara Asal</th>
        <td>{!! Str::length($softscape->negara_asa) > 1 ? $softscape->negara_asa : $blank !!}</td>
        <th class="table-secondary">Tarikh Daftarkan</th>
       <td style="width: 200px">{!! $softscape->tarikh_mas ? Html::datetime($softscape->tarikh_mas,'d-m-Y') : $blank !!}</td>
    </tr>

    <tr>
        <th class="table-secondary">Kos Perolehan (RM)</th>
        <td>{!! Str::length($softscape->kos) > 1 ? $softscape->kos : $blank !!}</td>
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
        <td>{!! Str::length($softscape->kategori_t) > 1 ? $softscape->kategori_t : $blank !!}</td>
        <th class="font-weigt-bold">Umur Pokok</th>
        <td>{!! $softscape->tahun_tana ? date('Y') - $softscape->tahun_tana .' tahun' : $blank !!}</td>
        <th class="font-weigt-bold">Jenis Akar</th>
        <td>{!! Str::length($softscape->jenis_akar) > 1 ? $softscape->jenis_akar : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Cara Pembiakan</th>
        <td>{!! Str::length($softscape->cara_pembi) > 1 ? $softscape->cara_pembi : $blank !!}</td>
        <th class="font-weigt-bold">Saiz Kanopi</th>
        <td>{!! Str::length($softscape->saiz_kanop) > 1 ? $softscape->saiz_kanop : $blank !!}</td>
        <th class="font-weigt-bold">Nilai Semasa (RM)</th>
        <td>{!! Str::length($softscape->nilai_sema) > 1 ? $softscape->nilai_sema : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Keterangan Pokok</th>
        <td colspan="5">{!! Str::length($softscape->keterangan) > 1 ? $softscape->keterangan : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Fungsi Pokok</th>
        <td colspan="5">{!! Str::length($softscape->fungsi) > 1 ? $softscape->fungsi : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kegunaan Pokok</th>
        <td colspan="5">{!! Str::length($softscape->kegunaan) > 1 ? $softscape->kegunaan : $blank !!}</td>
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
        <td>{!! Str::length($softscape->lebar_sila) > 1 ? $softscape->lebar_sila : $blank !!}</td>
        <th class="font-weigt-bold">Bentuk Silara Pokok</th>
        <td colspan="3">{!! Str::length($softscape->bentuk_sil) > 1 ? $softscape->bentuk_sil : $blank !!}</td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Bunga</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Warna Bunga</th>
        <td>{!! Str::length($softscape->warna_bung) > 1 ? $softscape->warna_bung : $blank !!}</td>
        <th class="font-weigt-bold">Bentuk Bunga</th>
        <td>{!! Str::length($softscape->bentuk_bun) > 1 ? $softscape->bentuk_bun : $blank !!}</td>
        <th class="font-weigt-bold">Saiz Bunga</th>
        <td>{!! Str::length($softscape->saiz_bunga) > 1 ? $softscape->saiz_bunga : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Bilangan Kelopak Bunga</th>
        <td>{!! Str::length($softscape->bil_kelopa) > 1 ? $softscape->bil_kelopa : $blank !!}</td>
        <th class="font-weigt-bold">Wangian Bunga</th>
        <td>{!! Str::length($softscape->wangian) > 1 ? $softscape->wangian : $blank !!}</td>
        <th class="font-weigt-bold">Tempoh Berbunga</th>
        <td>{!! Str::length($softscape->tempohbg) > 1 ? $softscape->tempohbg : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Musim Berbunga</th>
        <td colspan="5">{!! Str::length($softscape->musimbg) > 1 ? $softscape->musimbg : $blank !!}</td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Daun</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Warna Daun</th>
        <td>{!! Str::length($softscape->warna_daun) > 1 ? $softscape->warna_daun : $blank !!}</td>
        <th class="font-weigt-bold">Bentuk Daun</th>
        <td>{!! Str::length($softscape->bentuk_dau) > 1 ? $softscape->bentuk_dau : $blank !!}</td>
        <th class="font-weigt-bold">Jenis Daun</th>
        <td>{!! Str::length($softscape->jenis_daun) > 1 ? $softscape->jenis_daun : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Cara Percambahan Daun</th>
        <td colspan="5">{!! Str::length($softscape->cara_pembi) > 1 ? $softscape->cara_pembi : $blank !!}</td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Batang Pokok</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Ketinggian Batang Pokok</th>
        <td>{!! Str::length($softscape->tinggi_btg) > 1 ? $softscape->tinggi_btg : $blank !!}</td>
        <th class="font-weigt-bold">Diameter Batang Pokok</th>
        <td>{!! Str::length($softscape->diamater_b) > 1 ? $softscape->diamater_b : $blank !!}</td>
        <th class="font-weigt-bold">Ukur Lilit Batang</th>
        <td>{!! Str::length($softscape->bentuk_btg) > 1 ? $softscape->bentuk_btg : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tekstur Batang Pokok</th>
        <td colspan="5">{!! Str::length($softscape->tekstur_bt) > 1 ? $softscape->tekstur_bt : $blank !!}</td>
    </tr>
    <tr>
        <th colspan="6" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="6" class="font-weigt-bold text-center table-info">Maklumat Buah</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Warna Buah</th>
        <td>{!! Str::length($softscape->warna_bung) > 1 ? $softscape->warna_bung : $blank !!}</td>
        <th class="font-weigt-bold">Bentuk Buah</th>
        <td>{!! Str::length($softscape->bentuk_bh) > 1 ? $softscape->bentuk_bh : $blank !!}</td>
        <th class="font-weigt-bold">Saiz Buah</th>
        <td>{!! Str::length($softscape->saiz_buah) > 1 ? $softscape->saiz_buah : $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Musim Buah</th>
        <td>{!! Str::length($softscape->musim_buah) > 1 ? $softscape->musim_buah : $blank !!}</td>
        <th class="font-weigt-bold">Tempoh Berbuah</th>
        <td style="width: 200px">{!! Str::length($softscape->tempoh_bua) > 1 ? $softscape->tempoh_bua : $blank !!}</td>
    </tr>
</table>
