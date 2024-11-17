<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th colspan="7" class="table-secondary">Maklumat Penyelenggaraan</th>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Pemangkasan</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh Pemangkasan</th>
        <td class="wp-150">{!! $softscape->tarikh_pem ?? $blank !!}</td>
       

    </tr>
    <tr>
        <th class="font-weigt-bold">Jenis Pemangkasan</th>
        <td class="wp-150" colspan="6">{!! $softscape->jenis_pema ?? $blank !!}</td>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Pembajaan</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh Baja</th>
        <td class="wp-150">{!! $softscape->tarikh_baj ?? $blank !!}</td>

    </tr>
    <tr>
        <th class="font-weigt-bold">Jenis Baja</th>
        <td class="wp-150" colspan="6">{!! $softscape->jenis_baja ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Kaedah Pembajaan</th>
        <td class="wp-150" colspan="6">{!! $softscape->kaedah_baj ?? $blank !!}</td>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Kawalan Perosak</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh Rawatan</th>
        <td class="wp-150">{!! $softscape->tarikh_raw ?? $blank !!}</td>

    </tr>
    <tr>
        <th class="font-weigt-bold">Kaedah Rawatan</th>
        <td class="wp-150" colspan="6">{!! $softscape->kaedah_raw ?? $blank !!}</td>
    </tr>
    <tr>
        <th colspan="7" class="p-1"></th>
    </tr>
    <tr>
        <th colspan="7" class="font-weigt-bold text-center table-info">Maklumat Penyelenggaraan Risiko</th>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tarikh</th>
        <td class="wp-150">{!! $softscape->tarikh_ris ?? $blank !!}</td>
        
    </tr>
    <tr>
        <th class="font-weigt-bold">Jenis Risiko</th>
        <td class="wp-150" colspan="6">{!! $softscape->jenis_risi ?? $blank !!}</td>
    </tr>
    <tr>
        <th class="font-weigt-bold">Tahap Risiko</th>
        <td class="wp-150" colspan="6">{!! $softscape->tahap_risi ?? $blank !!}</td>
    </tr>
</table>
