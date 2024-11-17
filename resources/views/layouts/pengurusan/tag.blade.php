<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Theme style -->

    <title>@yield('title')</title>
    <style>
        html,
        body {
            height: 100%;
            text-align: center;
            /* font-family: Arial, Helvetica, 'sans-serif'; */
        }


        header {
            top: -30px;
            position: fixed;
            left: 0px;
            right: 0px;
            font-size: small;

            /** Extra personal styles **/

            color: black;
            text-align: left;
            line-height: 1;
        }

        h1 {
            font-size: 8mm;
            padding: 1mm 0 2mm 0;
            margin: 0;
        }

        .h3 {
            margin: 0;
            font-size: .31cm;
            padding: 0.08mm 0 0 0;
            line-height: 0.75;
            font-weight: 200;
        }

        p {
            font-size: .4cm;
            padding: 1px 0 0 0;
            margin: 0;
            line-height: 0.9;
            font-weight: 400;
            text-transform: uppercase;
        }

        .card {
            float: left;
            width: 25%;
            padding: 0;
            height: 51mm;
            max-height: 51mm;
            margin: 2px 0;
        }

        .card>div {
            /* margin: auto; */
            height: 50mm;
            max-width: 40mm;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .main {
            height: 50.5mm;
            max-height: 50.5mm;
            width: 40.5mm;
            width: 100%;
            border: 1px solid black;
            padding: 0px;
            margin: 0;
        }

        .section-one {
            padding: 0px 10px 0px 10px;
            margin: 0;
        }

        .section-two {
            background: black;
            padding: 2px 0;
            margin: 0;
        }

        .qrcode img {
            /* width: 30.5mm; */
            margin-top: 18px;
            margin-bottom: 0;
            padding: 2px;
            width: 98%;
            border: 1px solid black;
        }

        .title {
            color: white;
            text-transform: uppercase;
            width: 100%;
            margin: 0;
            padding: 1px 0 0 0;
        }

        /* Clear floats after the columns */
        .row:after {
            /* content: ""; */
            display: table;
            clear: both;
            padding: 0;
            margin: 0;
        }


    </style>
</head>

<body>
    @yield('content-tag')
</body>

</html>
