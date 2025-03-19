<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="noindex, noimageindex, nofollow, noarchive,nocache,nosnippet,noodp,noydir">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Jabatan Landskap Negara') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/percentage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pixel.css') }}">

    <!-- CSS:style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tree.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }
    </style>

</head>

<body class="hold-transition login-page">
    <div class="row align-items-center h-100">
        <div class="col-12">
            @yield('scripts')
            @yield('content')
            
            <strong style="color: #71c55d;">_____________________________________________</strong>
        </div>
    </div>
    <footer class="footer">
        <div class="container text-center mt-4">
            <span class="text-olive font-weight-bold">{{ config('app.name_short') }}</span> | {{ config('app.name') }}<br />
            <strong>Copyright &copy; 2024 - {{ date('Y') }} </strong> {{ config('app.agency') }}
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        console.log(typeof jQuery); // Should return "function"
        console.log(typeof $.fn.select2); // Should return "function"

        // $('#negeri').select2({
        //     placeholder: 'Pilih Negeri',
        //     allowClear: true,
        //     theme: 'bootstrap'
        // });
    });
    </script>

</body>

</html>
