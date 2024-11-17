<ul class="nav justify-content-end nav-pills mr-3">
    <li class="nav-item">
        <a class="nav-link {{ Html::active('pengurusan.hardscape.show') }} rounded-0"
            href="{{ route('pengurusan.hardscape.show',$hardscape) }}">
            Landskap Kejur
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Html::active('pengurusan.hardscapes.record.index') }} rounded-0"
            href="{{ route('pengurusan.hardscapes.record.index',$hardscape) }}">
            Sejarah Penyelenggaraan
        </a>
    </li>
</ul>
