@extends('layouts.pengurusan.app')

@section('title', 'Butiran Kempen Tanam Pokok')

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
                                ['onclick' => "window.location='" . route('pengurusan.kempen-tanam-pokok.index') . "'", 
                                 'class' => 'btn bg-secondary', 
                                 Html::tooltip('Kembali') 
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
                                <dd class="col-12">{{ $kempenTanamPokok->tajuk ?? $blank }}</dd>

                                <dt class="col-12">Keterangan</dt>
                                <dd class="col-12">{{ $kempenTanamPokok->keterangan ?? $blank }}</dd>

                                <dt class="col-12">Koordinat X</dt>
                                <dd class="col-12">{{ $kempenTanamPokok->lat ?? $blank }}</dd>

                                <dt class="col-12">Koordinat Y</dt>
                                <dd class="col-12">{{ $kempenTanamPokok->lng ?? $blank }}</dd>

                                <dt class="col-12">Tarikh Daftar</dt>
                                <dd class="col-12">{{ $kempenTanamPokok->created_at->format('d-m-Y') }}</dd>

                                <dt class="col-12">Tarikh Kemaskini</dt>
                                <dd class="col-12">{{ $kempenTanamPokok->updated_at->format('d-m-Y') }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-9">
                            {{-- Here, replace the panorama image viewer with the correct image --}}
                            @if($kempenTanamPokok->gambar) {{-- Check if there is an image for the campaign --}}
                                <div id="photosphere"></div>
                                <script>
                                    var PSV = new PhotoSphereViewer.ViewerCompat({
                                        container: 'photosphere',
                                        panorama: '{{ asset('storage/images/shares/kempen-tanam-pokok/' . $kempenTanamPokok->gambar) }}',
                                        caption: 'Kempen Tanam Pokok <b>&copy; Gambar</b>',
                                        loading_img: 'https://tpbk.jln.gov.my/img/photosphere-logo.gif',
                                        time_anim: false,
                                        anim_speed: '-2rpm',
                                        default_fov: 50,
                                        fisheye: false,
                                        move_speed: 1.1,
                                    });
                                </script>
                            @else
                                <p>Tiada Gambar untuk Kempen Tanam Pokok ini.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
