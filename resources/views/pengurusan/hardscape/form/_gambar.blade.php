
<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th colspan="3" class="table-secondary">Maklumat Gambar</th>
    </tr>

    <tr>
        <td class="align-middle" rowspan="2">
            <div class="text-left">
                @if ($hardscape && $hardscape->gambar && Storage::disk('public')->exists('assets/hardscape/'.$hardscape->gambar))
                <img width="20%" src="{{ asset('storage/assets/hardscape/'.$hardscape->gambar) }}" class="rounded gambar" alt="Gambar Aset">
                @else
                <img width="20%" src="{{ asset('img/no-photos.png') }}" class="rounded gambar" alt="Gambar Aset">
                @endif
            </div>
            <div class="text-left"><small>{{ 'Gambar Aset' }}</small></div>
        </td>

    </tr>
</table>
