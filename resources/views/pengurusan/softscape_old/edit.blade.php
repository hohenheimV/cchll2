@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini Landskap Lembut')


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
                    @include('pengurusan.softscape._pill_nav')
                </div>
                {!! Form::model($softscape, ['route' => ['pengurusan.softscape.update', $softscape], 'method'=>'PUT','id'=>'modalFormSoftscape']) !!}
                <div class="card-body p-0 px-2">
                    <div class="d-flex px-1">
                        <h5 class="flex-grow-1 m-2">@yield('title') </h5>
                        <div class="py-1">
                            {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.softscape.show',$softscape)."'",'class'=>'btn btn-secondary']) !!}
                            {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
                        </div>
                    </div>
                    @include('pengurusan.softscape._form')
                </div>
                <div class="card-footer">
                    {!! Form::button('Batal dan Kembali', ['onclick'=>"window.location='".route('pengurusan.softscape.show',$softscape)."'",'class'=>'btn btn-secondary']) !!}
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', ['class'=>'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection


@section('page-js-script')

<!-- summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>


<script>
    $(document).ready(function () {

        validation();

        //jquery validation
        function validation() {
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
