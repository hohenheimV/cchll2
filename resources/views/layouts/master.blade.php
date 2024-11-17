<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('insert_style')
</head>
<body>
    <main>
        @yield('content')
    </main>
    @yield('insert_js')
</body>
</html>
