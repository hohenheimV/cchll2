<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eLANDSKAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .certificate {
            border: 5px solid #000;
            padding: 30px;
            margin-top: 25%;
            margin-bottom: 25%;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            background-color: #f9f9f9;
        }

        .title {
            font-size: 36px;
            font-weight: bold;
        }

        .serial-number {
            font-size: 24px;
            margin-top: 30px;
            font-weight: bold;
        }

        .content {
            font-size: 18px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="title">Sijil Rakan Taman</div>
        <div class="content">
            Ini adalah untuk memperakui bahawa taman yang memegang sijil ini ialah Rakan Taman kepada Jabatan Landskap Negara.
        </div>
        <div class="serial-number">
            Nombor Siri: {{ $serial_number }}
        </div>
        <div class="footer">
            Tarikh Kelulusan: {{ $approved_at->format('d-m-Y') }}
        </div>
    </div>
</body>
</html>
