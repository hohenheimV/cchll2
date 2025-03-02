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
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @if (!(Auth::user()->hasRole('Penggiat Industri')))
                @hasanyrole('Perunding')
                 <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Dashboard','fas fa-tachometer-alt',
                    ['onclick'=>"window.location='".route('pengurusan.dashboard')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.dashboard')]) !!}
                </li>
                <li class="nav-header text-uppercase">Aset</li>
                <!-- Pengurusan  -->
                @can(['hardscape-list','softscape-list'])
                 <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Peta','fas fa-map',
                    ['onclick'=>"window.location='".route('pengurusan.peta')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.peta')]) !!}
                </li>
                @endcanany
                @can('softscape-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Landskap Lembut','fas fa-tree',
                    ['onclick'=>"window.location='".route('pengurusan.softscape.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.softscape.')]) !!}
                </li>
                @endcan
                @can('hardscape-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Landskap Kejur','fas fa-shapes',
                    ['onclick'=>"window.location='".route('pengurusan.hardscape.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.hardscape.')]) !!}
                </li>
                @endcan

                <li class="nav-header text-uppercase">Pentadbiran</li>
                <!-- Pentadbiran  -->
                <li class="nav-item has-treeview {{Html::active(['pengurusan.exports.'],'menu-open')}}">
                    {!! Html::buttonSidebarNavLinkTreeview('Pelaporan','fas fa-download', ['class'=>'nav-link btn
                    btn-block btn-link text-left']) !!}
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Landskap Lembut',
                            ['onclick'=>"window.location='".route('pengurusan.exports.softscape.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.softscape.')])
                            !!}
                        </li>

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Landskap Kejur',
                            ['onclick'=>"window.location='".route('pengurusan.exports.hardscape.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.hardscape.')])
                            !!}
                        </li>

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Manual',
                            ['onclick'=>"window.location='".route('pengurusan.manual.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.manual.')])
                            !!}
                        </li>
                    </ul>
                </li>

                @else

                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Dashboard','fas fa-tachometer-alt',
                    ['onclick'=>"window.location='".route('pengurusan.dashboard')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.dashboard')]) !!}
                </li>
                <!-- <li class="nav-header text-uppercase">Aset</li> -->
                <!-- Pengurusan  -->
                @can(['hardscape-list','softscape-list'])
                 <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eMAP JLN','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.peta')]) !!}
                </li>
                @endcanany
                @can('softscape-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eLAPS','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.softscape.')]) !!}
                </li>
                @endcan
                @can('hardscape-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('ePALM','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.hardscape.')]) !!}
                </li>
                @endcan
                @can('panorama-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('ePIL','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.panorama.')]) !!}
                </li>
                @endcan
                {{-- @can('drone-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('ePACT','fas fa-chart-pie',
                    ['onclick'=>"window.location='".route('pengurusan.epact.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.epact.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eREAD','fas fa-chart-pie',
                            ['onclick'=>"window.location='".route('pengurusan.eread.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.eread.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eLAMP','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eLIND','fas fa-chart-pie',
                    ['onclick'=>"window.location='".route('pengurusan.eLIND.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.eLIND.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eLASC','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eLAD','fas fa-chart-pie',
                                ['onclick'=>"window.location='".route('pengurusan.elad.index')."'",
                                'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.elad.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eORIM','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eLIMAR','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Entiti Landskap', 'fas fa-chart-pie', [
                        'onclick' => "window.location='" . route('pengurusan.entiti-landskap-unik.index') . "'",
                        'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.entiti-landskap-unik.')
                    ]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Kempen Tanam Pokok', 'fas fa-chart-pie', [
                        'onclick' => "window.location='" . route('pengurusan.ktp.index') . "'",
                        'class' => 'nav-link btn btn-block btn-link text-left ' . Html::active('pengurusan.ktp.')
                    ]) !!}
                </li>

                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Kursus Latihan','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Perpustakaan JLN','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                {{-- @can('analisa-list') --}}
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Rujukan Atas Talian','fas fa-chart-pie',
                    ['onclick'=>"window.location='#'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.analisa.')]) !!}
                </li>
                {{-- @endcan --}}
                <!-- /.Pengurusan -->

                <!-- Website  -->
                <!-- <li class="nav-header text-uppercase">Laman Web</li>
                <li class="nav-item has-treeview {{Html::active(['pengurusan.page.'],'menu-open')}}">
                    {!! Html::buttonSidebarNavLinkTreeview('Artikel','fas fa-copy', ['class'=>'nav-link btn btn-block
                    btn-link text-left']) !!}
                    <ul class="nav nav-treeview">

                        @can('article-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Senarai Artikel',
                            ['onclick'=>"window.location='".route('pengurusan.article.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.article')])
                            !!}
                        </li>
                        @endcan
                        @can('article-create')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Daftar Artikel',
                            ['onclick'=>"window.location='".route('pengurusan.article.create')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active('pengurusan.article.create')]) !!}
                        </li>
                        @endcan
                        @can('category-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Kategori',
                            ['onclick'=>"window.location='".route('pengurusan.categories.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.categories.')]) !!}
                        </li>
                        @endcan
                        @can('tag-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Tag',
                            ['onclick'=>"window.location='".route('pengurusan.tags.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.tags.')]) !!}
                        </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-item has-treeview {{Html::active(['pengurusan.page.'],'menu-open')}}">
                    {!! Html::buttonSidebarNavLinkTreeview('Page','fas fa-thumbtack', ['class'=>'nav-link btn btn-block
                    btn-link text-left']) !!}
                    <ul class="nav nav-treeview">
                        @can('page-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Senarai Page',
                            ['onclick'=>"window.location='".route('pengurusan.page.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.page.')]) !!}
                        </li>
                        @endcan
                        @can('page-create')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Daftar Page',
                            ['onclick'=>"window.location='".route('pengurusan.page.create')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active('pengurusan.page.create')]) !!}
                        </li>
                        @endcan
                    </ul>
                </li>

                @can('slider-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Seksyen','fas fa-boxes',
                    ['onclick'=>"window.location='".route('pengurusan.sections')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left
                    '.Html::active(['pengurusan.sections','pengurusan.menu.','pengurusan.sliders.'])]) !!}
                </li>
                @endcan
                @can('activity-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('eMohon','fas fa-indent',
                    ['onclick'=>"window.location='".route('pengurusan.activities.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.activities.')]) !!}
                </li>
                @endcan
                @can('feedback-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Maklumbalas','fas fa-comment-alt',
                    ['onclick'=>"window.location='".route('pengurusan.feedbacks.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.feedbacks.')]) !!}
                </li>
                @endcan -->
                <!-- /.Website -->


                <li class="nav-header text-uppercase">Pentadbiran</li>
                <!-- Pentadbiran  -->
                <li class="nav-item has-treeview {{Html::active(['pengurusan.exports.'],'menu-open')}}">
                    {!! Html::buttonSidebarNavLinkTreeview('Pelaporan','fas fa-download', ['class'=>'nav-link btn
                    btn-block btn-link text-left']) !!}
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Landskap Lembut',
                            ['onclick'=>"window.location='".route('pengurusan.exports.softscape.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.softscape.')])
                            !!}
                        </li>

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Landskap Kejur',
                            ['onclick'=>"window.location='".route('pengurusan.exports.hardscape.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.hardscape.')])
                            !!}
                        </li>

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Aktiviti Taman',
                            ['onclick'=>"window.location='".route('pengurusan.exports.activities.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.activities.')])
                            !!}
                        </li>

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Maklumbalas',
                            ['onclick'=>"window.location='".route('pengurusan.exports.feedbacks.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.feedbacks.')])
                            !!}
                        </li>

                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Statistik Pengunjung',
                            ['onclick'=>"window.location='".route('pengurusan.exports.visitor.all')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.exports.visitor.')])
                            !!}
                        </li>
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Manual',
                            ['onclick'=>"window.location='".route('pengurusan.manual.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.manual.')])
                            !!}
                        </li>
                    </ul>
                </li>
                @endhasanyrole
            @endif
                @hasrole('Pentadbir Sistem')

                <!-- Pentadbiran  -->
                <li class="nav-item has-treeview {{Html::active(['pengurusan.users.','pengurusan.roles.','pengurusan.permissions.'],'menu-open')}}">
                    {!! Html::buttonSidebarNavLinkTreeview('Akses Sistem','fas fa-user-shield', ['class'=>'nav-link btn
                    btn-block btn-link text-left']) !!}
                    <ul class="nav nav-treeview">
                        @can('roles-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Peranan',
                            ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                            !!}
                        </li>
                        @endcan
                        @can('users-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Pengguna',
                            ['onclick'=>"window.location='".route('pengurusan.users.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.users.')])
                            !!}
                        </li>
                        <li class="nav-item" style="display: flex; align-items: center;">
                            <?php
                            // Count inactive users
                            $inactiveUserCount = \App\User::whereColumn('created_at', 'updated_at')->count();
                            // $button = Html::buttonSidebaNavItemTree('Pengguna',
                            // ['onclick'=>"window.location='".route('pengurusan.users.index')."'",
                            // 'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.users.'),
                            // 'style' => 'display: flex; align-items: center; justify-content: space-between; width: 100%;']);
                            // $button = str_replace('</button>', '<span>My Span Content</span></button>', $button);
                            // echo $button;
                            ?>
                            {{-- Generate the button HTML --}}
                            @php
                                $button = Html::buttonSidebaNavItemTree(
                                    'Pengguna',
                                    [
                                        'onclick' => "window.location='".route('pengurusan.users.index')."'",
                                        'class' => 'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.users.'),
                                        'style' => 'display: flex; align-items: center; justify-content: space-between; width: 100%;'
                                    ]
                                );
                                
                                
                            @endphp

                            @if ($inactiveUserCount > 0)
                                @php
                                    // Add the <span> content before the closing </button> tag
                                    $button = str_replace('</button>', '<span class="badge badge-danger" style="margin-left: auto;">'.$inactiveUserCount.'</span></button>', $button);
                                @endphp
                            @endif
                            {{-- Output the final HTML --}}
                            {!! $button !!}
                        </li>
                        <li class="nav-item" style="display: flex; align-items: center;">
                            <?php
                                // Count inactive users
                                $inactiveUserCount = \App\User::whereColumn('created_at', 'updated_at')->count();
                            ?>
                            <a href="{{ route('pengurusan.users.index') }}" class="nav-link btn btn-block btn-link text-left {{ Html::active('pengurusan.users.') }}"
                            style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <i class="far fa-circle nav-icon"></i>
                                <span>Pengguna</span>
                                @if ($inactiveUserCount > 0)
                                    <span class="badge badge-danger" style="margin-left: auto;">{{ $inactiveUserCount }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan
                        @can('permissions-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Kawalan Capaian',
                            ['onclick'=>"window.location='".route('pengurusan.permissions.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active('pengurusan.permissions.')]) !!}
                        </li>
                        @endcan
						 @can('audit-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Audit Log',
                            ['onclick'=>"window.location='".route('pengurusan.audits.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active('pengurusan.audits.index')]) !!}
                        </li>
                        @endcan
						 @can('log-list')
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Rekod Log Masuk',
                            ['onclick'=>"window.location='".route('pengurusan.audits.logged')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left
                            '.Html::active('pengurusan.audits.logged')]) !!}
                        </li>
                        @endcan
                    </ul>
                </li>
                <!-- /.Pentadbiran -->
                @endrole


                @hasrole('Penggiat Industri')
                <!-- Pentadbiran  -->
                <li class="nav-header text-uppercase">Aset</li>
                @can('activity-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Aktiviti Taman','fas fa-indent',
                    ['onclick'=>"window.location='".route('pengurusan.activities.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.activities.')]) !!}
                </li>
                @endcan
                @can('feedback-list')
                <li class="nav-item">
                    {!! Html::buttonSidebarNavLink('Maklumbalas','fas fa-comment-alt',
                    ['onclick'=>"window.location='".route('pengurusan.feedbacks.index')."'",
                    'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.feedbacks.')]) !!}
                </li>
                @endcan
                <li class="nav-header text-uppercase">Pentadbiran</li>
                <li class="nav-item has-treeview {{Html::active(['pengurusan.users.','pengurusan.roles.','pengurusan.permissions.'],'menu-open')}}">
                    {!! Html::buttonSidebarNavLinkTreeview('Akses Sistem','fas fa-user-shield', ['class'=>'nav-link btn
                    btn-block btn-link text-left']) !!}
                    <ul class="nav nav-treeview">
                        {{--@can('roles-list')--}}
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Peranan',
                            ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                            !!}
                        </li>
                        {{--@endcan--}}
                        {{--@can('roles-list')--}}
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Peranan',
                            ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                            !!}
                        </li>
                        {{--@endcan--}}
                        {{--@can('roles-list')--}}
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Peranan',
                            ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                            !!}
                        </li>
                        {{--@endcan--}}
                        {{--@can('roles-list')--}}
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Peranan',
                            ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                            !!}
                        </li>
                        {{--@endcan--}}
                        {{--@can('roles-list')--}}
                        <li class="nav-item">
                            {!! Html::buttonSidebaNavItemTree('Peranan',
                            ['onclick'=>"window.location='".route('pengurusan.roles.index')."'",
                            'class'=>'nav-link btn btn-block btn-link text-left '.Html::active('pengurusan.roles.')])
                            !!}
                        </li>
                        {{--@endcan--}}
                    </ul>
                </li>
                <!-- /.Pentadbiran -->
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@endauth
