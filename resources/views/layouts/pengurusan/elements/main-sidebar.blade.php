@auth
<style>
    .sidebar {
        overflow-y: scroll; /* Allows vertical scrolling */
    }

    /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
    .sidebar::-webkit-scrollbar {
        display: none; /* Hide scrollbar */
    }

    /* Hide scrollbar for Firefox */
    .sidebar {
        scrollbar-width: none; /* Hide scrollbar for Firefox */
    }
</style>
<aside class="main-sidebar  elevation-4 collapsed" style="background-color:rgb(200, 200, 200) !important;">
    <!-- Brand Logo -->
    <a href="{{ route('pengurusan.dashboard') }}" class="brand-link navbar">
        <img src="{{ asset('img/logo-jln-sm.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold">eLANDSKAP, JLN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="overflow-y: auto;">
        <!-- Sidebar user (optional) -->
        <div class="user-panel">
           <!-- <div class="image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>-->
            <div class="info" style="white-space: normal;">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                {{-- $user_bahagian --}}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Dashboard','fas fa-tachometer-alt',
                    ['onclick'=>"window.location='".route('pengurusan.dashboard')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.dashboard'), Html::tooltip('Dashboard')]) !!}
                </li>
                <?php
                    $bahagian_jln = [
                        '0' => 'Jabatan Landskap Negara',
                        '1' => 'B. Pengurusan Landskap',
                        '2' => 'B. Taman Awam',
                        '3' => 'B. Pembangunan Landskap',
                        '4' => 'B. Khidmat Teknikal',
                        '5' => 'B. Penyelidikan & Pemulihan',
                        '6' => 'B. Penilaian & Penyelenggaraan',
                        '7' => 'B. Teknologi Maklumat',
                        '8' => 'B. Promosi & Industri Landskap',
                        '9' => 'B. Dasar & Pengurusan Korporat',
                        '10' => 'B. Kontrak & Ukur Bahan',
                    ];
                    $icon = [
                        'eLAPS' => 'fas fa-paper-plane',
                        'ePALM' => 'fas fa-leaf',
                        'ePIL' => 'fas fa-drafting-compass',
                        'ktp' => 'fas fa-tree',
                        'MIB' => 'fas fa-users',
                        'eREAD' => 'fas fa-book',
                        'ePACT' => 'fas fa-scroll',
                        'eLAD' => 'fas fa-paint-brush',
                        'eNTITI' => 'fas fa-dna',
                        'eMAP' => 'fas fa-map'
                    ];
                    $hoverText = [
                        'eLAPS' => 'Modul Pengurusan Projek Landskap',
                        'ePALM' => 'Modul Pengurusan Taman & Landskap ',
                        'ePIL' => 'Modul Pelan Induk Landskap ',
                        'ktp' => 'Modul Pelaporan Kempen Tanam Pokok',
                        'MIB' => 'Modul Rakan Taman',
                        'eREAD' => 'Modul Penyelidikan dan Penerbitan Landskap',
                        'ePACT' => 'Modul Pentadbiran Kontrak dan Polisi Landskap',
                        'eLAD' => 'Modul Rekabentuk Landskap',
                        'eNTITI' => 'Modul Entiti Landskap dan Pokok Berkarakter Unik',
                        'eMAP' => 'Taburan Pembangunan Projek Landskap di Malaysia'
                    ];
                    
                ?>
                @if ((Auth::user()->hasRole('Pentadbir Sistem|KP/ TKP JLN|Pegawai')))
                    <!-- <li class="nav-header text-uppercase">{{ $bahagian_jln[Auth::user()->bahagian_jln ? Auth::user()->bahagian_jln : 0] }}</li> -->
                    <li class="nav-header text-uppercase" style="white-space: normal;">Modul (Info Landskap)</li>
                @elseif ((Auth::user()->hasRole('Pihak Berkuasa Tempatan')))
                    <li class="nav-header text-uppercase" style="white-space: normal;">Pihak Berkuasa Tempatan</li>
                @elseif ((Auth::user()->hasRole('Penggiat Industri')))
                    <li class="nav-header text-uppercase" style="white-space: normal;">Penggiat Industri</li>
                @endif
                @if ((Auth::user()->hasRole('Pentadbir Sistem|KP/ TKP JLN|Pegawai|Pihak Berkuasa Tempatan')))
                    @foreach(['eLAPS', 'ePALM', 'ePIL'] as $item)
                        @if(
                            (Auth::user()->hasRole('Pentadbir Sistem')) ||
                            (!(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [1, 2, 3, 4, 5, 6, 7])) && $item == 'eLAPS') ||
                            (!(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [2, 3, 4, 5, 7])) && $item == 'ePALM') ||
                            (!(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [3, 7])) && $item == 'ePIL')
                        )
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink($item, $icon[$item], [
                                'onclick' => "window.location='" . route('pengurusan.' . ($item) . '.index') . "'",
                                'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.' . ($item)), Html::tooltip($hoverText[$item])
                            ]) !!}
                        </li>
                        @endif
                    @endforeach
                    @if((Auth::user()->hasRole('Pentadbir Sistem')) || !(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [8, 7])))
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('Kempen Tanam Pokok', $icon['ktp'], [
                            'onclick' => "window.location='" . route('pengurusan.ktp.index') . "'",
                            'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.ktp.'), Html::tooltip($hoverText['ktp'])
                        ]) !!}
                    </li>
                    @endif
                    @if((Auth::user()->hasRole('Pentadbir Sistem')) || !(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [8, 7])))
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('Rakan Taman', $icon['MIB'], [
                            'onclick' => "window.location='" . route('pengurusan.MIB.index') . "'",
                            'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.MIB.'), Html::tooltip($hoverText['MIB'])
                        ]) !!}
                    </li>
                    @endif
                    <!-- <li class="nav-item">
                        <button onclick="window.location='http://127.0.0.1:8000/pengurusan/MIB'" class="nav-link btn btn-block btn-link text-left {{ Html::active('pengurusan.MIB.') }}">
                            <img src="{{ asset('storage/images/logo.png') }}" alt="" style="height:30px;">
                            &nbsp;
                            <p>Malaysia in Bloom (MiB)</p>
                        </button>
                    </li> -->
                @endif
                @if ((Auth::user()->hasRole('Pentadbir Sistem|KP/ TKP JLN|Pegawai')))
                    @php
                        $types = [
                            'kontraktor' => ['label' => 'Kontraktor', 'icon' => 'fas fa-user-tie'],
                            'perunding' => ['label' => 'Perunding', 'icon' => 'fas fa-briefcase'],
                            'pembekal' => ['label' => 'Pembekal', 'icon' => 'fas fa-truck'],
                            'antarabangsa' => ['label' => 'Pertubuhan Antarabangsa', 'icon' => 'fas fa-globe'],
                            'ngo' => ['label' => 'NGO & Badan Ikhtisas', 'icon' => 'fas fa-hands-helping'],
                            'pendidikan' => ['label' => 'Institusi Pendidikan', 'icon' => 'fas fa-university']
                        ];
                    @endphp
                    @if((Auth::user()->hasRole('Pentadbir Sistem|Pegawai')) || !(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [10, 8, 7])))
                    <li class="nav-item has-treeview {{ Html::active(['pengurusan.eLIND.*'], 'menu-open') }}">
                        {!! Html::buttonSidebarNavLinkTreeview('eLIND', 'fas fa-seedling', ['class' => 'nav-link btn btn-block btn-link text-left']) !!}
                        <ul class="nav nav-treeview">
                            @foreach($types as $type => $data)
                                <li class="nav-item">
                                    {!! Html::buttonSidebarNavLink($data['label'], $data['icon'], [
                                        'onclick' => "window.location='".route('pengurusan.eLIND.index', ['type' => $type])."'",
                                        'class' => 'nav-link btn btn-block btn-link text-left ' . (isset($lastSegment) && $lastSegment === $type ? 'active' : ''), Html::tooltip('Modul Pengurusan Maklumat Industri Landskap ')
                                    ]) !!}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                @endif
                @if ((Auth::user()->hasRole('Penggiat Industri')))
                    @php
                        $user = Auth::user();
                        $id_elind = $user->bahagian_jln;
                        $userDetails = \App\Model\MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->first();
                        $jenis = $userDetails->jenis_industri;
                        //dd($jenis);
                    @endphp
                    @php
                        $types = [
                            'kontraktor' => ['label' => 'Kontraktor', 'icon' => 'fas fa-user-tie'],
                            'perunding' => ['label' => 'Perunding', 'icon' => 'fas fa-briefcase'],
                            'pembekal' => ['label' => 'Pembekal', 'icon' => 'fas fa-truck'],
                            'antarabangsa' => ['label' => 'Pertubuhan Antarabangsa', 'icon' => 'fas fa-globe'],
                            'ngo' => ['label' => 'NGO & Badan Ikhtisas', 'icon' => 'fas fa-hands-helping'],
                            'pendidikan' => ['label' => 'Institusi Pendidikan', 'icon' => 'fas fa-university']
                        ];
                    @endphp

                    <li class="nav-item has-treeview {{ Html::active(['pengurusan.eLIND.*'], 'menu-open') }}">
                        {!! Html::buttonSidebarNavLinkTreeview('eLIND', 'fas fa-seedling', ['class' => 'nav-link btn btn-block btn-link text-left']) !!}
                        <ul class="nav nav-treeview">
                            @foreach($types as $type => $data)
                            <?php if($data['label'] == $jenis){ ?>
                                <li class="nav-item">
                                    {!! Html::buttonSidebarNavLink($data['label'], $data['icon'], [
                                        'onclick' => "window.location='".route('pengurusan.eLIND.index', ['type' => $type])."'",
                                        'class' => 'nav-link btn btn-block btn-link text-left ' . (isset($lastSegment) && $lastSegment === $type ? 'active' : ''), Html::tooltip('Modul Pengurusan Maklumat Industri Landskap ')
                                    ]) !!}
                                </li>
                            <?php } ?>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @if ((Auth::user()->hasRole('Pentadbir Sistem|KP/ TKP JLN|Pegawai')))
                    @foreach(['eREAD', 'eLAD', 'ePACT'] as $item)
                        @if(
                            (Auth::user()->hasRole('Pentadbir Sistem')) || 
                            (!(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [1, 5, 7])) && $item == 'eREAD') ||
                            (!(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [1, 4, 7])) && $item == 'eLAD') ||
                            (!(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [9, 10, 7])) && $item == 'ePACT')
                        )
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink($item, $icon[$item], [
                                'onclick' => "window.location='" . route('pengurusan.' . strtolower($item) . '.index') . "'",
                                'class' => 'nav-link btn btn-block btn-link text-left ' .  Html::active('pengurusan.' . strtolower($item)), Html::tooltip($hoverText[$item]) 
                            ]) !!}
                        </li>
                        @endif
                    @endforeach
                    @if((Auth::user()->hasRole('Pentadbir Sistem')) || !(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [5, 7])))
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('eNTITI', $icon['eNTITI'], [
                            'onclick' => "window.location='" . route('pengurusan.entiti-landskap-unik.index') . "'",
                            'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.entiti-landskap-unik.'), Html::tooltip($hoverText['eNTITI']) 
                        ]) !!}
                    </li>
                    @endif
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('eMAP JLN',$icon['eMAP'],
                        ['onclick'=>"window.location='#'",
                        'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.peta'), Html::tooltip($hoverText['eMAP'])])  !!}
                    </li>
                    @if ((Auth::user()->hasRole('Pentadbir Sistem|Pegawai')))
                        <li class="nav-header text-uppercase">Laman Web</li>
                        <li class="nav-item has-treeview {{Html::active(['pengurusan.article.'],'menu-open')}}">
                            {!! Html::buttonSidebarNavLinkTreeview('Artikel','fas fa-copy', ['class'=>'nav-link btn btn-block
                            btn-link text-left']) !!}
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Senarai Artikel',
                                    ['onclick'=>"window.location='".route('pengurusan.article.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.article.index')])
                                    !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Daftar Artikel',
                                    ['onclick'=>"window.location='".route('pengurusan.article.create')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left
                                    '.Html::active('pengurusan.article.create')]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Kategori',
                                    ['onclick'=>"window.location='".route('pengurusan.categories.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.categories.')]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Tag',
                                    ['onclick'=>"window.location='".route('pengurusan.tags.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.tags.')]) !!}
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{Html::active(['pengurusan.page.'],'menu-open')}}">
                            {!! Html::buttonSidebarNavLinkTreeview('Page','fas fa-thumbtack', ['class'=>'nav-link btn btn-block
                            btn-link text-left']) !!}
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Senarai Page',
                                    ['onclick'=>"window.location='".route('pengurusan.page.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.page.index')]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Daftar Page',
                                    ['onclick'=>"window.location='".route('pengurusan.page.create')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left
                                    '.Html::active('pengurusan.page.create')]) !!}
                                </li>
                            </ul>
                        </li>
                        @if ((Auth::user()->hasRole('Pentadbir Sistem')) || !(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [7])))
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink('Seksyen','fas fa-boxes',
                            ['onclick'=>"window.location='".route('pengurusan.sections')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active(['pengurusan.sections','pengurusan.menu.','pengurusan.sliders.'])]) !!}
                        </li>
                        @endif
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink('Maklumbalas','fas fa-comment-alt',
                            ['onclick'=>"window.location='".route('pengurusan.feedbacks.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.feedbacks.')]) !!}
                        </li>
                        @if ((Auth::user()->hasRole('Pentadbir Sistem')) || !(Auth::user()->hasRole('Pegawai') && !in_array(Auth::user()->bahagian_jln, [7])))
                        <li class="nav-header text-uppercase">Pentadbiran</li>
                        <li class="nav-item has-treeview {{Html::active(['pengurusan.users.','pengurusan.roles.','pengurusan.permissions.'],'menu-open')}}">
                            {!! Html::buttonSidebarNavLinkTreeview('Akses Sistem','fas fa-user-shield', ['class'=>'nav-link btn
                            btn-block btn-link text-left']) !!}
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Peranan',
                                    ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                                    !!}
                                </li>
                                {{-- <li class="nav-item">
                                    @php
                                        $inactiveUserCount = \App\User::where('is_active', 0)->where('bahagian_jln', null)->count();
                                    @endphp

                                    {!! Html::buttonSidebaNavItemTree('Pengguna <span class="badge badge-danger" style="margin-left: auto;">'.$inactiveUserCount.'</span>',
                                    ['onclick'=>"window.location='".route('pengurusan.users.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.users.')])
                                    !!}

                                    <!-- <button onclick="window.location='{{ route('pengurusan.users.index') }}'" class="nav-link btn btn-block btn-link text-left">
                                        &nbsp;<span class="badge badge-danger" style="margin-left: auto;">{{ $inactiveUserCount }}</span>
                                        <p>&nbsp;Pengguna</p>
                                    </button> -->

                                </li> --}}
                                <li class="nav-item has-treeview {{ Html::active(['pengurusan.users.'], 'menu-open') }}">
                                    @php
                                        //$inactiveUserCount = \App\User::whereRaw('is_active = ? ', ['0'])->count();
                                        $inactiveUserCount = \App\User::where('is_active', 0)
                                            ->whereDoesntHave('roles', function ($q) {
                                                $q->whereIn('name', ['Penggiat Industri', 'Pihak Berkuasa Tempatan']);
                                            })
                                            ->count();
                                        //use App\User;
                                        $inactiveUserCountPI = \App\User::where('is_active', 0)
                                            ->where(function ($query) {
                                                $query->whereHas('roles', function ($q) {
                                                    $q->where('name', 'Penggiat Industri');
                                                });
                                            })
                                            ->count();
                                        $inactiveUserCountPBT = \App\User::where('is_active', 0)
                                            ->where(function ($query) {
                                                $query->whereHas('roles', function ($q) {
                                                    $q->where('name', 'Pihak Berkuasa Tempatan');
                                                });
                                            })
                                            ->count();
                                    @endphp
                                    {!! Html::buttonSidebarNavLinkTreeview('Pengguna', 'fas fa-user', ['class' => 'nav-link btn btn-block btn-link text-left']) !!}
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <button onclick="window.location='{{ route('pengurusan.users.index') }}'" class="nav-link btn btn-block btn-link text-left ">
                                                &nbsp;<span class="badge badge-danger" style="margin-left: auto;">{{ $inactiveUserCount }}</span>
                                                <p>&nbsp;Jabatan Landskap Negara</p>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button onclick="window.location='{{ route('pengurusan.users.index', ['keyword' => 'Pihak Berkuasa Tempatan']) }}'" 
                                                    class="nav-link btn btn-block btn-link text-left ">
                                                &nbsp;<span class="badge badge-danger" style="margin-left: auto;">{{ $inactiveUserCountPBT }}</span>
                                                <p>&nbsp;Pihak Berkuasa Tempatan</p>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button onclick="window.location='{{ route('pengurusan.users.index', ['keyword' => 'Penggiat Industri']) }}'" 
                                                class="nav-link btn btn-block btn-link text-left ">
                                            &nbsp;<span class="badge badge-danger" style="margin-left: auto;">{{ $inactiveUserCountPI }}</span>
                                            <p>&nbsp;Penggiat Industri Landskap</p>
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Kawalan Capaian',
                                    ['onclick'=>"window.location='".route('pengurusan.permissions.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left
                                    '.Html::active('pengurusan.permissions.')]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Audit Log',
                                    ['onclick'=>"window.location='".route('pengurusan.audits.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left
                                    '.Html::active('pengurusan.audits.index')]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Rekod Log Masuk',
                                    ['onclick'=>"window.location='".route('pengurusan.audits.logged')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left
                                    '.Html::active('pengurusan.audits.logged')]) !!}
                                </li>
                            </ul>
                        </li>
                        @endif
                        
                    @endif
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@endauth
