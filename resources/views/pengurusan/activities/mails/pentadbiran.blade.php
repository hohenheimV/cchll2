@extends('layouts.pengurusan.email')
@section('title', 'TINDAKAN PERMOHONAN AKTIVITI TAMAN PERSEKUTUAN BUKIT KIARA')


@section('body')
<p>Tuan / Puan</p>

<p>Terdapat satu (1) permohonan aktiviti penggunaan Taman Persekutuan Bukit Kiara yang memerlukan <strong>{{ $status }}</strong> dan butiran permohonan seperti di pautan berikut:</p>

<a style="line-height: 1.5;box-sizing: inherit;border: none;display: inline-block;vertical-align: middle;overflow: hidden;text-decoration: none;text-align: center;cursor: pointer;white-space: nowrap;user-select: none;background-color: #04AA6D!important;border-radius: 5px;font-size: 17px;font-family: 'Source Sans Pro', sans-serif;padding: 6px 18px;color: #FFFFFF;"
    href="{{ route('pengurusan.activities.show',$activity) }}">Klik butiran permohonan</a>

<p>Sekian, terima kasih</p>
@endsection
