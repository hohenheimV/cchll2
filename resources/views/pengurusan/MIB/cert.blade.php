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
            background-image: url('{{ public_path('storage/images/ben2.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: contain;
            z-index: 0;
        }

        .certificate {
            border: 5px solid #000;
            padding: 25px;
            margin-top: 1%;
            margin-bottom: 1%;
            width: 90%;
            height: 90%;
            margin-left: auto;
            margin-right: auto;
            background-color: #f9f9f900;
            z-index: 2;
        }

        .title {
            font-size: 66px;
            font-weight: bold;
        }

        .serial-number {
            font-size: 34px;
            margin-top: 40px;
            font-weight: bold;
        }

        .content {
            font-size: 22px;
            margin-top: 150px;
        }

        .footer {
            margin-top: 170px !important;
            font-size: 22px;
            font-weight: bold;
        }
        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.778);
            z-index: 1;
        }
    </style>
</head>
<body>
    @php
        // $imagePath = public_path('storage/images/ben.png');
        // $imageData = base64_encode(file_get_contents($imagePath));
        // $src = 'data:image/png;base64,' . $imageData;
    @endphp

    <div class="background-overlay"></div>
    <div class="certificate">
        {{-- <img src="{{ $src }}" style="width: 350px;" alt="Logo JLN"> --}}
        <div class="title" style="">Sijil Rakan Taman</div>
        <div class="content">
            Ini adalah untuk memperakui bahawa taman yang memegang sijil ini ialah Rakan Taman kepada Jabatan Landskap Negara.
        </div>
        <div class="serial-number">
            {{ $taman }}<br>
            Nombor Siri: {{ $serial_number }}
        </div>
        <div class="footer">
            Tarikh Kelulusan: {{ $approved_at->format('d-m-Y') }}
        </div>
        
        <div style="text-align: left; margin-top: 170px; margin-right: 220px;">
            Diluluskan oleh:<br>
            Bahagian Promosi & Industri Landskap,<br>
            Jabatan Landskap Negara,<br>
            Kompleks Bangunan Kerajaan Parcel F, Presint 1,<br>
            Pusat Pentadbiran Kerajaan Persekutuan, 62000 Putrajaya.
        </div>
    </div>
</body>
</html>
