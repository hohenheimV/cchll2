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
<aside class="main-sidebar  elevation-4 collapsed" style="background-color: white;">
    <!-- Brand Logo -->
    <a href="{{ route('pengurusan.dashboard') }}" class="brand-link navbar">
        <img src="{{ asset('img/logo-jln-sm.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold">eLANDSKAP, JLN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="overflow-y: auto;">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
           <!-- <div class="image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>-->
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                {{ Auth::user()->roles->first()->name }}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Dashboard','fas fa-tachometer-alt',
                    ['onclick'=>"window.location='".route('pengurusan.dashboard')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.dashboard')]) !!}
                </li>
                <li class="nav-header text-uppercase">Jabatan Landskap Negara</li>
                @if ((Auth::user()->hasRole('Pentadbir Sistem|TKP/B JLN|Pegawai|Pihak Berkuasa Tempatan')))
                    @foreach(['eLAPS', 'ePALM', 'ePIL'] as $item)
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink($item, 'fas fa-chart-pie', [
                                'onclick' => "window.location='" . route('pengurusan.' . ($item) . '.index') . "'",
                                'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.' . ($item) . '.index')
                            ]) !!}
                        </li>
                    @endforeach
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('Kempen Tanam Pokok', 'fas fa-chart-pie', [
                            'onclick' => "window.location='" . route('pengurusan.ktp.index') . "'",
                            'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.ktp.')
                        ]) !!}
                    </li>
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('Malaysia in Bloom (MiB)', 'fas fa-chart-pie', [
                            'onclick' => "window.location='" . route('pengurusan.MIB.index') . "'",
                            'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.MIB.')
                        ]) !!}
                    </li>
                @endif
                @if ((Auth::user()->hasRole('Pentadbir Sistem|TKP/B JLN|Pegawai|Penggiat Industri')))
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
                        {!! Html::buttonSidebarNavLinkTreeview('eLIND', 'fas fa-chart-pie', ['class' => 'nav-link btn btn-block btn-link text-left']) !!}
                        <ul class="nav nav-treeview">
                            @foreach($types as $type => $data)
                                <li class="nav-item">
                                    {!! Html::buttonSidebarNavLink($data['label'], $data['icon'], [
                                        'onclick' => "window.location='".route('pengurusan.eLIND.index', ['type' => $type])."'",
                                        'class' => 'nav-link btn btn-block btn-link text-left ' . (isset($lastSegment) && $lastSegment === $type ? 'active' : '')
                                    ]) !!}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                @if ((Auth::user()->hasRole('Pentadbir Sistem|TKP/B JLN|Pegawai')))
                    @foreach(['eREAD', 'eLAD', 'ePACT'] as $item)
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink($item, 'fas fa-chart-pie', [
                                'onclick' => "window.location='" . route('pengurusan.' . strt($item) . '.index') . "'",
                                'class' => 'nav-link btn btn-block btn-link text-left ' .  Html::active('pengurusan.' . strt($item) . '.index') 
                            ]) !!}
                        </li>
                    @endforeach
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('Entiti Landskap', 'fas fa-chart-pie', [
                            'onclick' => "window.location='" . route('pengurusan.entiti-landskap-unik.index') . "'",
                            'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.entiti-landskap-unik.')
                        ]) !!}
                    </li>
                    <li class="nav-item">
                        {!! Html::buttonSidebarNavLink('eMAP JLN','fas fa-chart-pie',
                        ['onclick'=>"window.location='#'",
                        'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.peta')]) !!}
                    </li>
                    @if ((Auth::user()->hasRole('Pentadbir Sistem')))
                        <li class="nav-header text-uppercase">Laman Web</li>
                        <li class="nav-item has-treeview {{Html::active(['pengurusan.page.'],'menu-open')}}">
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
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.page.')]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::buttonSidebaNavItemTree('Daftar Page',
                                    ['onclick'=>"window.location='".route('pengurusan.page.create')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left
                                    '.Html::active('pengurusan.page.create')]) !!}
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink('Seksyen','fas fa-boxes',
                            ['onclick'=>"window.location='".route('pengurusan.sections')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active(['pengurusan.sections','pengurusan.menu.','pengurusan.sliders.'])]) !!}
                        </li>
                        <li class="nav-item">
                            {!! Html::buttonSidebarNavLink('Maklumbalas','fas fa-comment-alt',
                            ['onclick'=>"window.location='".route('pengurusan.feedbacks.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.feedbacks.')]) !!}
                        </li>

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
                                <li class="nav-item">
                                    @php
                                        $inactiveUserCount = \App\User::whereRaw('is_active = ? ', ['0'])->count();
                                    @endphp

                                    {!! Html::buttonSidebaNavItemTree('Pengguna <span class="badge badge-danger" style="margin-left: auto;">'.$inactiveUserCount.'</span>',
                                    ['onclick'=>"window.location='".route('pengurusan.users.index')."'",
                                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.users.')])
                                    !!}

                                    <button onclick="window.location='{{ route('pengurusan.users.index') }}'" class="nav-link btn btn-block btn-link text-left">
                                        &nbsp;<span class="badge badge-danger" style="margin-left: auto;">{{ $inactiveUserCount }}</span>
                                        <p>&nbsp;Pengguna</p>
                                    </button>

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
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@endauth
