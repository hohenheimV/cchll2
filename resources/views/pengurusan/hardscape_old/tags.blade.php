@extends('layouts.pengurusan.tag')

@section('title', 'Tagging')

@section('content-tag')



@php
$i=0;
//dd($hardscapes);
@endphp
@foreach ($hardscapes as $hardscape)
<div class="row">
    @foreach ($hardscape as $item)
    <div class="column" style="text-align: center">
        <div class="card">
            <div class="main">
                <h1>{{$item->fullKodTag}}</h1>
                <div class="qrcode">
                    <img
                        src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .4, true)->margin(0)->size(100)->errorCorrection('H')->generate($item->hardscape_qrcode)) !!} ">
                </div>
                <div class="title">
                    <h3>TAMAN PERSEKUTUAN<br />BUKIT KIARA</h3>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@if($i % 5 == 0)
<div style="width: 100%; margin:1px;"></div>
@endif
@endforeach
@endsection
