<ul class="nav justify-content-end nav-pills mr-3">
    <li class="nav-item">
        <a class="nav-link {{ Html::active('pengurusan.softscape.') }} rounded-0"
            href="{{ route('pengurusan.softscape.show',$softscape) }}">
            Landskap Lembut
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Html::active('pengurusan.softscapes.record.') }} rounded-0"
            href="{{ route('pengurusan.softscapes.record.index',$softscape) }}">
            Maklumat Asas
        </a>
    </li>


    <li class="nav-item dropdown">
        @php( $sftActive = Html::active(['pengurusan.softscapes.gambar.','pengurusan.softscapes.silara.',
        'pengurusan.softscapes.bunga.','pengurusan.softscapes.daun.index','pengurusan.softscapes.batang.','pengurusan.softscapes.buah.']) )
        <a class="nav-link rounded-0 dropdown-toggle {{ $sftActive }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Maklumat Tambahan</a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.gambar.index',$softscape) }}">
                Maklumat Gambar
            </a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.silara.index',$softscape) }}">
                Maklumat Silara
            </a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.bunga.index',$softscape) }}">
                Maklumat Bunga
            </a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.daun.index',$softscape) }}">
                Maklumat Daun
            </a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.batang.index',$softscape) }}">
                Maklumat Batang Pokok
            </a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.buah.index',$softscape) }}">
                Maklumat Buah
            </a>
        </div>
    </li>
    <li class="nav-item dropdown">
        @php( $sftActive = Html::active(['pengurusan.softscapes.pemangkasan.','pengurusan.softscapes.pembajaan.',
        'pengurusan.softscapes.perosak.','pengurusan.softscapes.risiko.']) )

        <a class="nav-link rounded-0 dropdown-toggle {{ $sftActive }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false">Penyelenggaraan</a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.pemangkasan.index',$softscape) }}">Pemangkasan</a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.pembajaan.index',$softscape) }}">Pembajaan</a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.perosak.index',$softscape) }}">Perosak</a>
            <a class="dropdown-item" href="{{ route('pengurusan.softscapes.risiko.index',$softscape) }}">Risiko</a>
        </div>
    </li>
</ul>
