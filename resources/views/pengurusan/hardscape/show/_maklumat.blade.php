

<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th class="table-secondary">Kod</th>
        <td colspan="2">{!! $hardscape->kod_tag ?? $blank !!}</td>
        <td rowspan="5" class="align-middle text-center">
            <img class="img-thumbnail m-1"
                src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .3, true)->margin(0)->size(120)->errorCorrection('Q')->generate($hardscape->hardscape_qrcode)) !!}"
                alt="qr">
        </td>
    </tr>
    <tr>
        <th class="table-secondary">Koordinat</th>
        <td colspan="2">{{ $hardscape->x .', '.$hardscape->y }}</td>
    </tr>
    <tr>
        <th class="table-secondary">Zon</th>
        <td colspan="2">{!! $hardscape->zon ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Jenis/Kategori</th>
        <td colspan="2">{!! $hardscape->jenis ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Nama Struktur</th>
        <td colspan="2">{!! $hardscape->nama_struk ?? $blank !!}</td>
    </tr>

    <tr>
        <th class="table-secondary">Keadaan </th>
        <td>{!! $hardscape->keadaan ?? $blank !!}</td>
        <th class="table-secondary">Tarikh Dibina</th>
        <td style="width: 200px">{!! Html::datetime($hardscape->tarikh,'d-m-Y') !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Selenggara </th>
        <td>{!! $hardscape->selenggara ?? $blank !!}</td>
        <th class="table-secondary">Tahun Dibina</th>
        <td style="width: 200px">{!! Html::datetime($hardscape->tarikh,'Y') !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Baik Pulih</th>
        <td>{!! $hardscape->baik_pulih ?? $blank !!}</td>
        <th class="table-secondary">Tarikh Daftarkan</th>
        <td style="width: 200px">{!! Html::datetime($hardscape->tarikh,'d-m-Y') !!}</td>
    </tr>

    <tr>
        <th class="table-secondary">Kos Bina (RM)</th>
        <td>{!! Str::length($hardscape->kos_bina) > 1 ? $hardscape->kos_bina : $blank !!}</td>
        <th class="table-secondary">Tarikh Dikemaskini</th>
        <td style="width: 200px">{!! $hardscape->updated_at ? $hardscape->updated_at->format('d-m-Y') : $blank !!}</td>
    </tr>
    <tr>
        <th class="table-secondary">Catatan</th>
        <td colspan="3">{!! $hardscape->catatan ?? $blank !!}</td>
    </tr>
</table>
