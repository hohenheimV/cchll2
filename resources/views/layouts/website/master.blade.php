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
    <link rel="icon" type="image/png" href="/img/logo-jln-sm.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Catamaran:700|Roboto:300,400,400i,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Yield:insert_style -->
    @yield('insert_style')

    <!-- CSS:style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- CSS:percentage -->
    <link rel="stylesheet" href="{{ asset('css/percentage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tree.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to extract path from URL
        function getPathFromUrl() {
            // Extract path from the URL
            const path = window.location.pathname;
            return path.split('/').pop(); // Get the last segment of the path
        }

        // Map path to color
        function getColorForPath(path) {
            const colorMap = {
                'T1': '#71c55d',
                'T2': '#36458e',
                'T3': '#0171f9',
                // 'T4': 'rgb(59, 25, 98)',
                // Add more mappings as needed
            };

            return colorMap[path] || '#84cd73'; // Default color if no match
        }

        // Get the path and determine color
        const path = getPathFromUrl();
        // alert(path);
        const color = getColorForPath(path);
        
        // Apply the color to the CSS variable
        // document.documentElement.style.setProperty('--themeColor', color);
    </script>
    <style>
        html, body, h1, h2, h3, h4, h5, p, a {
          font-family: 'Poppins', sans-serif !important;
        }
        .mobile-done {
            display: none !important;
        }
        .owl-nav, .owl-dots{
            display: none !important;
        }
        /* Mobile Styles */
        @media only screen and (max-width: 768px) {
            body {
                font-family: 'Poppins', sans-serif;
                padding: 5px;
            }

            header {
                background-color: #4CAF50;
                text-align: center;
                padding: 10px;
            }

            .container {
                width: 100%;
                margin: 0 auto;
            }

            .footer {
                font-size: 12px;
                text-align: center;
                padding: 10px;
                background-color: #333;
                color: white;
            }
            
            .mobile-gone {
                display: none !important;
            }
            .mobile-done {
                display: block !important;
            }
            
        }

        .custom-article-style {
            border: 1px solid white;
            background-color: white !important;
            border-radius: 55px;
        }

        /* Mobile override */
        @media (max-width: 768px) {
            .custom-article-style {
                border: none !important;
                background-color: transparent !important;
                border-radius: 0 !important;
            }
        }

        .tooltip-inner {
            text-align: left !important;
        }

        .owl-nav button.owl-prev,
        .owl-nav button.owl-next {
            background-color: #6c757d !important;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.5rem;
            transition: background-color 0.3s ease;
        }

        @media (min-width: 768px) {
            h5 {
                font-size: 30px !important;
            }
            h3 {
                font-size: 52px !important;
            }
        }
    </style>
    <style>
        .typewriter h3 {
            display: inline-block;
            overflow: hidden;
            border-right: 2px solid #000;
            white-space: nowrap;
            letter-spacing: 1px;
            animation:
                typing 1.5s steps(11, end),
                blink-caret 0.75s step-end infinite;
            /* font-size: 22px; */
            font-family: 'Poppins', sans-serif !important;
            width: 15ch; 
            margin-bottom: 0px;
            margin-top: 5px !important;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 15ch } /* Set to exact width of your text */
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: black }
        }

        .fly-in h5 {
            opacity: 0;
            transform: translateX(-50px);
            animation: flyIn 1s ease-out forwards;
            /* font-size: 35px !important; */
            font-family: 'Poppins', sans-serif !important;
            margin-top: 0px;
        }

        @keyframes flyIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @php
            $requestUri = request()->path(); // Or use request()->getRequestUri() if you need the full URI
        @endphp

        @if (strpos($requestUri, 'T1') !== false)
            @include('layouts.website.elements.T1navbar')
        @elseif (strpos($requestUri, 'T2') !== false)
            @include('layouts.website.elements.T2navbar')
        @elseif (strpos($requestUri, 'T3') !== false)
            @include('layouts.website.elements.T3navbar')
        @elseif (strpos($requestUri, 'T4') !== false)
            @include('layouts.website.elements.T4navbar')
        @else
            @include('layouts.website.elements.navbar')
        @endif
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

            $('[data-toggle="tooltip"]').tooltip({
                html: true
            });
        });

    </script>
    <!-- Yield:insert_js -->
    @yield('insert_js')
    @yield('webmodal')

    
</body>

</html>
