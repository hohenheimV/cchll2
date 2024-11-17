@extends('layouts.pengurusan.tag')

@section('title', 'Tagging')

@section('content-tag')

<div class="card">
    <div class="main">
        <h1>{{$title}}</h1>
        <div class="qrcode">
            <img
                src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .4, true)->margin(0)->size(100)->errorCorrection('H')->generate($softscape_qrcode)) !!} ">
        </div>
        <div class="title">
            <h3>TAMAN PERSEKUTUAN<br />BUKIT KIARA</h3>
        </div>
    </div>
</div>
@endsection
