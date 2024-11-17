@extends('layouts.pengurusan.app')

@section('title', 'Peta Landskap Lembut')

@section('page-css-style')

<style>
    * {
        padding: 0;
        margin: 0;
    }

    #map-softscape label {
        font-size: smaller;
        margin-bottom: .1rem
    }

    .map-softscape {
        display: block;
        width: 100%;
        height: calc(100vh - 200px)
    }

    a.rm-link {
        color: #e83e8c !important;
    }
</style>
@endsection

@section('content')

<div class="container-fluid" id="map-softscape">
    <div class="row">
        <div class="col-lg-10">
            <div class="card card-olive card-outline">
                <div class="card-body p-0">
                    <div class="map-softscape"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            {{ Form::open(['method' => 'get']) }}
            <h4>Carian</h3>
                <div class="form-group mb-2">
                    {{ Form::label('jenis', 'Jenis/Kategori') }}
                    {{ Form::text('jenis',request('jenis'),['placeholder'=>'Sila masukkan Jenis','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis')]) }}
                    {!! Html::hasError($errors,'jenis') !!}
                </div>
                <div class="form-group mb-2">
                    {{ Form::label('nama_botani', 'Nama Botani') }}
                    {{ Form::text('nama_botani',request('nama_botani'),['placeholder'=>'Sila masukkan Nama Botani','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_botani')]) }}
                    {!! Html::hasError($errors,'nama_botani') !!}
                </div>
                <div class="form-group mb-2">
                    {{ Form::label('nama_tempatan', 'Nama Tempatan') }}
                    {{ Form::text('nama_tempatan',request('nama_tempatan'),['placeholder'=>'Sila masukkan Nama Tempatan','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_tempatan')]) }}
                    {!! Html::hasError($errors,'nama_tempatan') !!}
                </div>
                <div class="form-group mb-2">
                    {{ Form::label('nama_keluarga', 'Nama Keluarga') }}
                    {{ Form::text('nama_keluarga',request('nama_keluarga'),['placeholder'=>'Sila masukkan Nama Keluarga','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'nama_keluarga')]) }}
                    {!! Html::hasError($errors,'nama_keluarga') !!}
                </div>

                {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.softscape.peta')."'",
                'class'=>'btn btn-secondary']) !!}
                {{ Form::submit('Cari', ['class'=>'btn btn-success','type'=>'submit']) }}
                {{ Form::close() }}

                <div class="my-5"></div>
                {!! Html::pagination_simple($softscapes) !!}
        </div>

    </div>
</div>
@endsection

@section('modal')

<div class="modal fade" id="modalLandskapLembut" tabindex="-1" role="dialog" aria-labelledby="modalLandskapLembutLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<div class="modal fade" id="modalLandskapLembutEdit" data-keyboard="false" role="dialog" aria-labelledby="modalLandskapLembutEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-js-script')
<script src="{{ asset('js/readmore/readmore.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.api_map_softscape')}}"></script>
<script src="{{ asset('js/gmap3/gmap3.min.js') }}"></script>
<script>
    var markerlocations = {!!json_encode($data['data']) !!};
    // var markerlocations = {!!json_encode($softscapes) !!};
    // var ruang_hijau = 'http://175.139.199.126:81/tpbk/storage/kml/ruang_hijau.kml';
    // var zon_a = 'http://175.139.199.126:81/tpbk/storage/kml/zon_a.kml';
    // var zon_b = 'http://175.139.199.126:81/tpbk/storage/kml/zon_b.kml';
    // var zon_c = 'http://175.139.199.126:81/tpbk/storage/kml/zon_c.kml';
    // var zon_d = 'http://175.139.199.126:81/tpbk/storage/kml/zon_d.kml';
    // var zon_e = 'http://175.139.199.126:81/tpbk/storage/kml/zon_e.kml';
    // var zon_f = 'http://175.139.199.126:81/tpbk/storage/kml/zon_f.kml';
    var markers = [];
    $.each(markerlocations, function (index, item) {
        var data = {
            id: item.id,
            position: [item.lat, item.lng],
            label: {
                text: 'S',
                color: 'white',
                fontSize: '12px',
            },
            icon: {
                path: "M-10,0a10,10 0 1,0 20,0a10,10 0 1,0 -20,0",
                fillColor: '#1abc9c',
                fillOpacity: 1,
                anchor: new google.maps.Point(0, 0),
                strokeWeight: 5,
                strokeColor: '#16a085',
                strokeOpacity: 0.25,
                scale: .7
            }
        };
        markers.push(data);
    });

    $('.map-softscape')
        .gmap3({
            //center: center,
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            streetViewControl: false,
            fullscreenControl: false,
        })
        .marker(markers)
        .on('click', function (marker) {
            modalInfo(marker.id);
        })
        // .kmllayer({
        //     url: ruang_hijau
        // })
        // .kmllayer({
        //     url: zon_a
        // })
        // .kmllayer({
        //     url: zon_b
        // })
        // .kmllayer({
        //     url: zon_c
        // })
        // .kmllayer({
        //     url: zon_d
        // })
        // .kmllayer({
        //     url: zon_d
        // })
        // .kmllayer({
        //     url: zon_f
        // })
        .fit();


    function batalSoft(d){
        $('#modalLandskapLembutEdit').modal('hide');
        modalInfo(d);
    }
    // function editSoft(d){
    //     $('#modalLandskapLembut').modal('hide');
    //     modalEdit(d);
    // }


    // /*Bootstrap Modal Pop Up Open Code*/
    // function modalEdit(d) {
    //     //console.log(item);
    //     var item = d.getAttribute("data-id");
    //     var href = d.getAttribute("data-href");
    //     $('#modalLandskapLembutEdit').modal('show'); // Show Modal start

    //     $('#modalLandskapLembutEdit .modal-content').load(href, function (responseTxt, statusTxt, xhr) {
    //         //If success load, show modal
    //         if (statusTxt == "success") {
    //             validation();
    //         }

    //     });

    // }
    function modalInfo(item) {
        //console.log(item);
        $('#modalLandskapLembut').modal('show'); // Show Modal start

        var href = "{{ route('pengurusan.softscape.petashow',['softscape'=>'ids']) }}".replace("ids", item);

        $('#modalLandskapLembut .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

            //If success load, show modal
            if (statusTxt == "success") {

                validation();

                $readMoreJS.init({
                    target: '.more p',
                    numOfWords: 50,
                    moreLink: 'baca selanjutnya...',
                    lessLink: 'tutup',
                    toggle: true,
                });

                $('img.thumb').on('click', function () {
                    //console.log($(this)[0].src);
                    $('img.product-image').attr("src", $(this)[0].src);
                    $('a.product-image-lightbox').attr("href", $(this)[0].src);
                });

            } else {
                alert("Error: " + xhr.status + ": " + xhr.statusText);
            }
        });

    }

    $('#modalLandskapLembutEdit').on('show.bs.modal', function (event) {
            //console.log(item);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var href = button.data('href'); // Extract info from data-* attributes
            $('#modalLandskapLembutEdit').modal('show'); // Show Modal start

            $('#modalLandskapLembutEdit .modal-content').load(href, function (responseTxt, statusTxt, xhr) {
                //If success load, show modal
                if (statusTxt == "success") {
                    $('#modalLandskapLembut').modal('hide');
                    validation();
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
                'kod_tag': 'required',
                'kategori': 'required',
                'kos_perolehan': 'required',
                'no_rujukan': 'required',
                'keterangan': 'required',
                'nama_botani': 'required',
                'nama_tempatan': 'required',
                'nama_keluarga': 'required',
                'jenis': 'required',
                'tarikh': 'required',
                'lat': 'required',
                'lng': 'required',
            }
        });
    }
</script>
@include('pengurusan.softscape._ckfinder')
@endsection
