<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="Jabatan Landskap Negara">
    <meta name="description" content="Jabatan Landskap Negara, Jabatan Landskap Negara">
    <meta name="keywords" content="Taman, Pesekutuan, Bukit, Kiara, Jabatan, Landskap, Negara, TPBK, JLN, KPKT, Taman Awam, Rekreasi">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="google-site-verification" content="H9AQXvBj0Cnj11LZWLCzYI2lIZ5srIczvWXwKu4Xmig" />

    <title>@yield('title') | {{ config('app.name', 'Jabatan Landskap Negara') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Catamaran:700|Roboto:300,400,400i,700,900&display=swap" rel="stylesheet">

    <!-- Yield:insert_style -->
    @yield('insert_style')

    <!-- CSS:style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- CSS:percentage -->
    <link rel="stylesheet" href="{{ asset('css/percentage.css') }}">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('layouts.website.elements.navbar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')

            <!-- /.section#sponsors -->
            <section id="footer"></section>
        </div>
        <!-- /.content -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('layouts.website.elements.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
                var $el = $(this);
                $el.toggleClass('active-dropdown');
                var $parent = $(this).offsetParent(".dropdown-menu");
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');

                $(this).parent("li").toggleClass('show');

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
                    $('.dropdown-menu .show').removeClass("show");
                    $el.removeClass('active-dropdown');
                });

                if (!$parent.parent().hasClass('navbar-nav')) {
                    $el.next().css({
                        "top": $el[0].offsetTop,
                        "left": $parent.outerWidth() - 4
                    });
                }

                return false;
            });
        });

    </script>
    <!-- Yield:insert_js -->
    @yield('insert_js')
    @yield('webmodal')
</body>

</html>
