@extends('layouts.pengurusan.tag')

@section('title', $title)

@section('content-tag')

<div class="card">
    <div class="main">
        <div class="section-one">
            <div class="qrcode">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln-qr.png'), .4, true)->margin(0)->size(100)->errorCorrection('H')->generate($softscape_qrcode)) !!} ">
            </div>
            <p>{{$title}}</p>
        </div>
        <div class="section-two">
            <div class="title">
                <p class="h3">TAMAN PERSEKUTUAN<br />BUKIT KIARA</p>
            </div>
        </div>
    </div>
</div>
@endsection
