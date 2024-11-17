@extends('layouts.pengurusan.app')

@section('title', 'Landskap Kejur')

@section('page-css-style')

<!-- summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    @include('pengurusan.hardscape._pill_nav')
                </div>
                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('card-title') </h5>
                        <div class="py-1">
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.hardscape.edit',$hardscape)."'",'class'=>'btn btn-warning btn-sm']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-9">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="mt-2 mt-sm-0 text-center">
                                        <img class="img-thumbnail mb-3"
                                            src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .3, true)->margin(0)->size(120)->errorCorrection('Q')->generate($hardscape->hardscapeQrcode)) !!}"
                                            alt="qr">
                                    </div>
                                </div>
                                <div class="col-sm-10 text-center text-sm-left">
                                    <div class="bg-dark px-3 w-100">
                                        <h2 class="mb-0">Taman Persekutuan</h2>
                                        <h4 class="m-0"><small>{{ $hardscape->taman_persekutuan ?? 'Taman Persekutuan Bukit Kiara' }}</small></h4>
                                    </div>
                                    <div class="bg-gray px-3 w-100">
                                        <dl class="row p-3">
                                            <dt class="col-sm-2">Kod Tag</dt>
                                            <dd class="col-sm-2 mb-0">
                                                <span
                                                    class="badge badge-warning">{{ $hardscape->fullKodTag ?? '-' }}</span>
                                            </dd>

                                            <dt class="col-sm-2">Koordinat</dt>
                                            <dd class="col-sm-6 mb-0">{{ $hardscape->lat .', '.$hardscape->lng }}</dd>

                                            <dt class="col-sm-2">Zon</dt>
                                            <dd class="col-sm-2">
                                                <span class="badge badge-warning">{{  $hardscape->nama_zon ?? '-' }}</span>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            {{-- @include('pengurusan.hardscape._details') --}}
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Jenis Komponen / Struktur</dt>
                                <dd class='col-sm-9'>{!! $hardscape->jenis_komponen ?? '<span class="badge badge-light">Tiada
                                        Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Nama Struktur</dt>
                                <dd class='col-sm-9'>{!! $hardscape->nama_struktur ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class="col-sm-3">Kos Pembinaan</dt>
                                <dd class='col-sm-9'>{!! $hardscape->kos_pembinaan ? "RM ".$hardscape->kos_pembinaan :
                                    '<span class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Tarikh Daftarkan</dt>
                                <dd class='col-sm-9'>
                                    {{ $hardscape->created_at ? $hardscape->created_at->format('d/m/Y') : '-' }}</dd>

                                <dt class='col-sm-3'>Tarikh Dikemaskini</dt>
                                <dd class='col-sm-9'>
                                    {{ $hardscape->updated_at ? $hardscape->updated_at->format('d/m/Y') : '-' }}</dd>

                            </dl>

                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="border pb-1">
                                <div class="col-12">
                                    <a href="{{$hardscape->gambar_lengkap}}" data-toggle="lightbox"
                                        data-gallery="gallery" data-title="Keseluruhan Image" data-max-width="600">
                                        <img src="{{$hardscape->gambar_lengkap ?? asset('img/default-150x150.png')}}" class="product-image"
                                            alt="Keseluruhan Image" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modalSoftscape" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalSoftscapeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->

@endsection

@section('page-js-script')

<!-- summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- Ekko Lightbox -->
<script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
</script>

@endsection
