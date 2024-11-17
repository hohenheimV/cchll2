@extends('layouts.pengurusan.tag')

@section('title', 'Tagging '.request('zon') .' ' .$first.' - '.$last)

@section('titlepdf', '(Zon '.request('zon').' Page '.request('page').')')

@section('content-tag')

@if ($hardscapes)

<header>
    @yield('title') @yield('titlepdf')
</header>

@php
$i=1;
@endphp
@foreach ($hardscapes as $hardscape)
<div class="row">
    @foreach ($hardscape as $item)
    <div class="card">
        <div class="main">
            <div class="section-one">
                <div class="qrcode">
                    <img
                        src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln-qr.png'), .4, true)->margin(0)->size(100)->errorCorrection('H')->generate($item->hardscape_qrcode)) !!} ">
                </div>
                <p>{{$item->kod_tag}}</p>
            </div>
            <div class="section-two">
                <div class="title">
                    <p class="h3">TAMAN PERSEKUTUAN<br />BUKIT KIARA</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@if($i++ % 5 == 0)
<div style="width: 100%; height: 10px"></div>
@endif
@endforeach
<script type="text/php">
    if (isset($pdf)) {
        $x = 250;
        $y = 10;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>

@else
{{ "Tiada Maklumat" }}
@endif
@endsection
