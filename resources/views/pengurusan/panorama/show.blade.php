@extends('layouts.pengurusan.app')

@section('title', 'Butiran Panorama')

@section('content')
<style>
    #photosphere {
        width: 100%;
        height: 400px;
    }
</style>
<link rel="stylesheet" href="{{ asset('js/pano/photo-sphere-viewer.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline ">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>

                    <div class="card-tools">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">

                                {!! Form::button('Kembali',
                                ['onclick'=>"window.location='".route('pengurusan.panorama.index')."'",
                                'class'=>'btn bg-secondary', Html::tooltip('Kembali')
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body table-hardscape form-hardscape text-sm">
                    @php
                    $blank = 'Tiada Maklumat';
                    @endphp

                    <div class="row">
                        <div class="col-md-3">
                            <dl class="row">

                                <dt class="col-12">Tajuk</dt>
                                <dd class="col-12">{{ $panorama->tajuk }}</dd>

                                <dt class="col-12">Keterangan</dt>
                                <dd class="col-12">{{ $panorama->keterangan }}</dd>

                                <dt class="col-12">Koordinat X</dt>
                                <dd class="col-12">{{ $panorama->lat ?? $blank }}</dd>

                                <dt class="col-12">Koordinat Y</dt>
                                <dd class="col-12">{{ $panorama->lng ?? $blank }}</dd>

                                <dt class="col-12">Tarikh Daftar</dt>
                                <dd class="col-12">{{ $panorama->created_at->format('d-m-Y') }}</dd>

                                <dt class="col-12">Tarikh Kemaskini</dt>
                                <dd class="col-12">{{ $panorama->updated_at->format('d-m-Y' ) }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-9">
                            {{-- {!! '<img class="image-thumb p-1 w-100 mx-auto d-block embed-responsive-item" height="120" alt="Gambar panorama"
                                src="'.asset($panorama->gambar_360 ? 'storage/images/shares/panorama/'.$panorama->gambar_360 : 'img/no-photos.png').'">' !!} --}}
                                <div id="photosphere"></div>
                        </div>
                    </div>





                    <!-- AdminLTE App -->
                    <script src="{{ asset('js/pano/three/build/three.js') }}"></script>
                    <script src="{{ asset('js/pano/uevent/browser.js') }}"></script>
                    <script src="{{ asset('js/pano/photo-sphere-viewer.js') }}"></script>
                    <script src="{{ asset('js/pano/viewer-compat.js') }}"></script>

                    <script>
                        var PSV = new PhotoSphereViewer.ViewerCompat({
                            container: 'photosphere',
                            panorama: 'https://tpbk.jln.gov.my/storage/images/shares/panorama/{{$panorama->gambar_360}}',
                            caption: 'Jabatan Landskap Negara <b>&copy; Panorama</b>',
                            loading_img: 'https://tpbk.jln.gov.my/img/photosphere-logo.gif',
                            time_anim: false,
                            anim_speed: '-2rpm',
                            default_fov: 50,
                            fisheye: false,
                            move_speed: 1.1,
                            time_anim: false,
                            });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
