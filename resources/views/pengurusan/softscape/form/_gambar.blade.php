@php
$collection = collect([
['item'=>'gambar_p','label'=>'Gambar Pokok'],
['item'=>'gambar_b','label'=>'Gambar Bunga'],
['item'=>'gambar_d','label'=>'Gambar Daun'],
['item'=>'gambar_bg','label'=>'Gambar Batang'],
['item'=>'gambar_bh','label'=>'Gambar Buah'],
]);
@endphp
<table id="example" class="responsive table table-bordered table-sm mb-3">
    <tr>
        <th colspan="3" class="table-secondary">Maklumat Gambar Tumbuhan</th>
    </tr>

    <tr>
        <td style="width: 33.33%" class="align-middle" rowspan="2">
            <div class="text-center">
                <img width="40%" src="{{ asset('img/no-photos.png') }}" class="rounded gambar" alt="Gambar Pokok">
                {{-- <img width="40%" src="http://tpbk.jln.gov.my/storage/assets/softscape/9/2020/D9_P.jpg" class="rounded gambar" alt="Gambar Pokok"> --}}
            </div>
            <div class="text-center"><small>{{ 'Gambar Pokok' }}</small></div>
        </td>
        <td style="width: 33.33%" class="align-middle">
            <div class="text-center">
                <img width="40%" src="{{ asset('img/no-photos.png') }}" class="rounded gambar" alt="Gambar Bunga">
            </div>
            <div class="text-center"><small>{{ 'Gambar Bunga' }}</small></div>
        </td>
        <td style="width: 33.33%" class="align-middle">
            <div class="text-center">
                <img width="40%" src="{{ asset('img/no-photos.png') }}" class="rounded gambar" alt="Gambar Daun">
                {{-- <img width="40%" src="http://tpbk.jln.gov.my/storage/assets/softscape/9/2020/D9_D.jpg" class="rounded gambar" alt="Gambar Daun"> --}}
            </div>
            <div class="text-center"><small>{{ 'Gambar Daun' }}</small></div>
        </td>
    </tr>
    <tr>
        <td class="align-middle">
            <div class="text-center">
                <img width="40%" src="{{ asset('img/no-photos.png') }}" class="rounded gambar" alt="Gambar Batang">
                {{-- <img width="40%" src="http://tpbk.jln.gov.my/storage/assets/softscape/9/2020/D9_B.jpg" class="rounded gambar" alt="Gambar Batang"> --}}
            </div>
            <div class="text-center"><small>{{ 'Gambar Batang' }}</small></div>
        </td>
        <td class="align-middle">
            <div class="text-center">
                <img width="40%" src="{{ asset('img/no-photos.png') }}" class="rounded gambar" alt="Gambar Buah">
            </div>
            <div class="text-center"><small>{{ 'Gambar Buah' }}</small></div>
        </td>
    </tr>
</table>
