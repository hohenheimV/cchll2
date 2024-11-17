@extends('layouts.pengurusan.blank')

@section('title', 'Landskap Lembut')

@section('page-css-style')

<!-- summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">

<style>
    .product-image-thumb {
        min-height: 115px !important;
    }

    .product-image-thumb img {
        min-height: 112px !important;
        width: 100% !important;
        height: 112px !important;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title') </h5>
                    @include('pengurusan.softscape._pill_nav')
                </div>
                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">Maklumat @yield('title') </h5>
                        <div class="py-1">
                            <div class="btn-group">
                                {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini',
                                ['onclick'=>"window.location='".route('pengurusan.softscape.edit',$softscape)."'",'class'=>'btn
                                btn-warning btn-sm']) !!}
                                {!! Form::button('<i class="fas fa-qrcode"></i>',
                                ['onclick'=>"window.open('".route('pengurusan.softscape.tagging',$softscape)."');",'class'=>'btn
                                btn-secondary btn-sm',
                                Html::tooltip('Tag')]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-8">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="mt-2 mt-sm-0 text-center border border-dark pb-1 px-2">
                                        <p class="font-weight-bold p-0 m-0">{{ $softscape->fullKodTag ?? '-' }}</p>
                                        <img class="img-thumbnail"
                                            src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/logo-jln.png'), .3, true)->margin(0)->size(120)->errorCorrection('Q')->generate($softscape->softscape_qrcode)) !!}"
                                            alt="qr">
                                    </div>
                                </div>
                                <div class="col-sm-10 text-center text-sm-left">
                                    <div class="bg-dark px-3 w-100">
                                        <h2 class="mb-0">Taman Persekutuan</h2>
                                        <h4 class="m-0"><small>{{ $softscape->taman_persekutuan ?? '-' }}</small></h4>
                                    </div>
                                    <div class="bg-gray px-3 w-100">
                                        <dl class="row p-3">
                                            <dt class="col-sm-2">Kod Tag</dt>
                                            <dd class="col-sm-2 mb-0">
                                                <span
                                                    class="badge badge-warning">{{ $softscape->fullKodTag ?? '-' }}</span>
                                            </dd>

                                            <dt class="col-sm-2">Koordinat</dt>
                                            <dd class="col-sm-6 mb-0">{{ $softscape->lat .', '.$softscape->lng }}</dd>

                                            <dt class="col-sm-2">Zon</dt>
                                            <dd class="col-sm-2">
                                                <span
                                                    class="badge badge-warning">{{  $softscape->nama_zon ?? '-' }}</span>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Jenis/Kategori</dt>
                                <dd class='col-sm-9'>{!! $softscape->jenis ?? '<span class="badge badge-light">Tiada
                                        Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Nama Botani</dt>
                                <dd class='col-sm-9'>{!! $softscape->nama_botani ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Nama Tempatan</dt>
                                <dd class='col-sm-9'>{!! $softscape->nama_tempatan ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Nama Keluarga/Asal</dt>
                                <dd class='col-sm-9'>{!! $softscape->nama_keluarga ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Negara Asal</dt>
                                <dd class='col-sm-9'>{!! $softscape->negara_asal ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Sumber Anak Benih</dt>
                                <dd class='col-sm-9'>{!! $softscape->sumber_benih ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Taman Persekutuan</dt>
                                <dd class='col-sm-9'>{!! $softscape->taman_persekutuan ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class="col-sm-3">Kos Perolehan</dt>
                                <dd class='col-sm-9'>{!! $softscape->kos_perolehan ? "RM ".$softscape->kos_perolehan :
                                    '<span class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Kategori Tumbuhan</dt>
                                <dd class='col-sm-9'>{!! $softscape->kategori_tumbuhan ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Umur Pokok</dt>
                                <dd class='col-sm-9'>{{ date('Y') - $softscape->tahun_tanam .' tahun'  ?? '-' }}</dd>

                                <dt class='col-sm-3'>Jenis Akar</dt>
                                <dd class='col-sm-9'>{!! $softscape->jenis_akar ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Cara Pembiakan</dt>
                                <dd class='col-sm-9'>{!! $softscape->cara_pembiakan ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Tarikh Ditanam</dt>
                                <dd class='col-sm-9'>
                                    {{ $softscape->tarikh ? $softscape->tarikh : '-' }}</dd>

                                <dt class='col-sm-3'>Tahun Ditanam</dt>
                                <dd class='col-sm-9'>{{ $softscape->tahun_tanam ?? '-' }}</dd>

                                <dt class='col-sm-3'>Tarikh Daftarkan</dt>
                                <dd class='col-sm-9'>
                                    {{ $softscape->created_at ? $softscape->created_at->format('d/m/Y') : '-' }}</dd>

                                <dt class='col-sm-3'>Tarikh Dikemaskini</dt>
                                <dd class='col-sm-9'>
                                    {{ $softscape->updated_at ? $softscape->updated_at->format('d/m/Y') : '-' }}</dd>

                            </dl>

                            <h4 class="border-bottom">Maklumat Asas</h4>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Saiz Kanopi</dt>
                                <dd class='col-sm-9'>{!! $softscape->record->saiz_kanopi ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Nilai Semasa </dt>
                                <dd class='col-sm-9'>{!! $softscape->record->nilai_semasa ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Keadaan Semasa </dt>
                                <dd class='col-sm-9'>{!! $softscape->record->keadaan_semasa ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>
                            </dl>

                            {{-- Maklumat Silara --}}
                            {{-- <h4 class="border-bottom">Maklumat Silara</h4>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Kelebaran Silara</dt>
                                <dd class='col-sm-9'>{!! $softscape->silara->kelebaran ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Bentuk Silara Pokok</dt>
                                <dd class='col-sm-9'>{!! $softscape->silara->bentuk ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>
                            </dl> --}}

                            {{-- Maklumat Bunga --}}
                            {{-- <h4 class="border-bottom">Maklumat Bunga</h4>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Warna Bunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->warna ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Bentuk Bunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->bentuk ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Saiz Bunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->saiz ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Bilangan Kelopak Bunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->bilangan ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Wangian Bunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->wangian ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Musim Berbunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->musim ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Tempoh Berbunga</dt>
                                <dd class='col-sm-9'>{!! $softscape->bunga->tempoh ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                            </dl> --}}

                            {{-- Maklumat Daun --}}
                            {{-- <h4 class="border-bottom">Maklumat Daun</h4>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Warna Daun</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->warna ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Bentuk Daun</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->bentuk ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Cara Percambahan Daun</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->percambahan ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Jenis Daun</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->jenis ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>
                            </dl> --}}

                            {{-- Maklumat Batang --}}
                            {{-- <h4 class="border-bottom">Maklumat Batang Pokok</h4>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Bentuk Batang Pokok</dt>
                                <dd class='col-sm-9'>{!! $softscape->batang->bentuk ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Ketinggian Batang Pokok</dt>
                                <dd class='col-sm-9'>{!! $softscape->batang->ketinggian ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Diameter Batang Pokok</dt>
                                <dd class='col-sm-9'>{!! $softscape->batang->diameter ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Tekstur Batang Pokok</dt>
                                <dd class='col-sm-9'>{!! $softscape->batang->tekstur ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>
                            </dl> --}}

                            {{-- Maklumat Buah --}}
                            {{-- <h4 class="border-bottom">Maklumat Buah</h4>
                            <dl class="row p-3">
                                <dt class='col-sm-3'>Warna Buah</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->warna ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Bentuk Buah</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->bentuk ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Saiz Buah</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->saiz ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>

                                <dt class='col-sm-3'>Musim Buah</dt>
                                <dd class='col-sm-9'>{!! $softscape->daun->musim ?? '<span
                                        class="badge badge-light">Tiada Maklumat</span>' !!}</dd>
                            </dl> --}}

                            <h4 class="border-bottom">Keterangan Pokok</h4>
                            <div class="bg-light p-2">
                                <p class="text-justify">{{ $softscape->keterangan ?? 'Tiada Maklumat'}}</p>
                            </div>

                            <h4 class="border-bottom">Fungsi Pokok</h4>
                            <div class="bg-light p-2">
                                <p class="text-justify">{{ $softscape->fungsi_pokok ?? 'Tiada Maklumat'}}</p>
                            </div>

                            <h4 class="border-bottom">Kegunaan Pokok</h4>
                            <div class="bg-light p-2">
                                <p class="text-justify">{{ $softscape->kegunaan_pokok ?? 'Tiada Maklumat'}}</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="border pb-1">
                                <div class="col-12">
                                    @isset($softscape->gambar->keseluruhan)
                                    <div class="p-1 text-capitalize">
                                        <a href="{{$softscape->gambar->keseluruhan}}" data-toggle="lightbox" class="text-center"
                                            data-gallery="gallery" data-title="Gambar Keseluruhan" data-max-width="600">
                                            <img src="{{$softscape->gambar->keseluruhan}}" class="product-image"
                                                onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                                                alt="Keseluruhan Image" />
                                                <small class="text-dark">Keseluruhan</small>
                                        </a>
                                    </div>
                                    @endisset
                                </div>
                                <div
                                    class="col-12 product-image-thumbs justify-content-center mt-1 d-flex justify-content-center">
                                    @foreach (['batang','daun','bunga','buah'] as $item)
                                    @isset($softscape->gambar->{$item})
                                    <div class="text-capitalize text-center">
                                        <a href="{{ $softscape->gambar->{$item} }}" data-toggle="lightbox" class="text-center"
                                            data-gallery="gallery" data-title="Gambar {{$item}}" data-max-width="600">
                                            <div class="product-image-thumb p-1 w-100">
                                                <img src="{{$softscape->gambar->{$item} }}"
                                                    onerror="this.onerror=null;this.src='{{asset('img/default-150x150.png')}}';"
                                                    class="img-fluid" alt="Gambar {{$item}}" />
                                            </div>
                                            <small class="text-dark">{{$item}}</small>
                                        </a>
                                    </div>
                                    @endisset
                                    @endforeach
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

<script>
    $(document).ready(function () {


        $('#modalSoftscape').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('[data-tooltip="tooltip"]').tooltip('hide');
            // Load URL from data-href
            $('#modalSoftscape .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

                //Date picker
                $('input[name="tarikh"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: '01-' + moment().subtract(1, 'month').subtract(1, 'year').format('MM-YYYY'), //Tarikh mula 01/01/TahunLepas
                    maxDate: moment().endOf('month').format('DD-MM-YYYY'), //Tarikh mula 01/01/TahunDepan
                    drops: "up",
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                });

                validation();

                //If success load, show modal
                if (statusTxt == "success") {

                    $('#summernote').summernote({
                        toolbar: false,
                        height: 100
                    });

                    $('#modalSoftscape').modal('show'); // Show Modal start
                    // clear modal content if modal closed
                    $('#modalSoftscape').on('hidden.bs.modal', function () {
                        $('[data-tooltip="tooltip"]').tooltip('hide');
                        $(this).find('.modal-content').empty();
                    });
                } else {
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
                }
            });
        });

        //jquery validation
        function validation() {
            $('#modalFormSoftscape').validate({ //sets up the validator
                submitHandler: function (form) {
                    form.submit();
                },
                rules: {
                    'lat' : 'required',
                    'lng' : 'required',
                    'kod_tag' : 'required',
                    'zon' : 'required',
                    'jenis' : 'required',
                    'nama_botani' : 'required',
                    'nama_tempatan' : 'required',
                    'nama_keluarga' : 'required',
                    'negara_asal' : 'required',
                    'sumber_benih' : 'required',
                    'taman_persekutuan' : 'required',
                    'keterangan' : 'required',
                    'tarikh' : 'required',
                    'tahun_tanam' : 'required',
                    'kos_perolehan' : 'required',
                    'kategori_tumbuhan' : 'required',
                    'umur_pokok' : 'required',
                    'fungsi_pokok' : 'required',
                    'kegunaan_pokok' : 'required',
                    'cara_pembiakan' : 'required',
                    'jenis_akar' : 'required',
                    'tarikh_masa' : 'required',
                }
            });
        }
    });

</script>


@endsection
