<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            padding: 20px;
            color: red;
            font-size: 36px;
        }
        .p-0{padding: 0px; margin: 0px}

        .h3{
            font-size: 24px;
        }

        .font-weight-bold{font-weight: bolder;}
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="content">
            <div class="logo-jata"><img src="{{ asset('img/logo-jln-sm.png') }}" alt="Jata" width="auto" height="92"></div>
            <h2><span class="font-weight-bold">{{config('app.name_short')}}</span> {{config('app.dept_short')}}, {{config('app.agency_short')}} | {{config('app.name')}}</span></h2>
            <div class="title">
                @yield('message')
            </div>
            <p class="h3 p-0">Kembali ke <a href="{{ route('welcome') }}" class="btn btn-default">Halaman Utama</a></p>
            <p class="mb-0"><small>{{config('app.address')}}</small></p>
        </div>
    </div>
</body>

</html>
