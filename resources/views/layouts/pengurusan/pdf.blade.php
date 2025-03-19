<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title') | {{ config('app.name', 'Jabatan Landskap Negara') }}</title>

    <style>
        body {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 10pt;
        }

        .table-pdf {
            border-collapse: collapse;
            width: 100%;
        }

        .table-pdf th {
            padding: 5px;
        }

        .table-pdf td {
            padding: .2rem;
        }

        .table-pdf td,
        .table-pdf th {
            border: 1px solid #ddd;
        }

        .table-pdf th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #f2f2f2;
        }

        .table-borderless tbody+tbody,
        .table-borderless td,
        .table-borderless th,
        .table-borderless thead th {
            border: 0 !important;
        }

        .lajer .table-pdf td,
        .lajer .table-pdf th {
            border: 1px solid #333;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center
        }

        .text-left {
            text-align: left
        }

        .text-right {
            text-align: right
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-lowercase {
            text-transform: lowercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .pr-1 {
            padding-right: .3rem
        }

        .w-100 {
            width: 100% !important;
        }

        .wpx-10 {
            width: 10px !important;
        }

        .wpx-20 {
            width: 20px !important;
        }

        .wpx-30 {
            width: 30px !important;
        }

        .wpx-40 {
            width: 40px !important;
        }

        .wpx-50 {
            width: 50px !important;
        }

        .wpx-60 {
            width: 60px !important;
        }

        .wpx-70 {
            width: 70px !important;
        }

        .wpx-80 {
            width: 80px !important;
        }

        .wpx-90 {
            width: 90px !important;
        }

        .wpx-100 {
            width: 100px !important;
        }

        .wpx-120 {
            width: 120px !important;
        }

        .wpx-130 {
            width: 130px !important;
        }

        .wpx-150 {
            width: 150px !important;
        }

        .wpx-200 {
            width: 200px !important;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
