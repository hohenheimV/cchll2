@extends('layouts.pengurusan.app')

@section('title', 'Peta Landskap Kejur')

@section('page-css-style')

<style>
    * {
        padding: 0;
        margin: 0;
    }

    #map-hardscape label {
        font-size: smaller;
        margin-bottom: .1rem
    }

    .map-hardscape {
        display: block;
        width: 100%;
        height: calc(100vh - 200px)
    }
</style>
@endsection

@section('content')

<div class="container-fluid" id="map-hardscape">
    <div class="row">
        <div class="col-lg-10">
            <div class="card card-olive card-outline">
                <div class="card-body p-0">
                    <div class="map-hardscape"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            {{ Form::open(['method' => 'get']) }}
            <h4>Carian</h3>
                <div class="form-group mb-2">
                    {{ Form::label('struktur', 'Nama Struktur') }}
                    {{ Form::text('struktur',request('struktur'),['placeholder'=>'Sila masukkan struktur','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'struktur')]) }}
                    {!! Html::hasError($errors,'struktur') !!}
                </div>
                <div class="form-group mb-2">
                    {{ Form::label('jenis', 'Jenis Komponen') }}
                    {{ Form::text('jenis',request('jenis'),['placeholder'=>'Sila masukkan Jenis','class' => 'form-control form-control-sm '.Html::isInvalid($errors,'jenis')]) }}
                    {!! Html::hasError($errors,'jenis') !!}
                </div>
                {!! Form::button('Reset', ['onclick'=>"window.location='".route('pengurusan.hardscape.peta')."'",
                'class'=>'btn btn-secondary']) !!}
                {{ Form::submit('Cari', ['class'=>'btn btn-success','type'=>'submit']) }}
                {{ Form::close() }}

                <div class="my-5"></div>
                {!! Html::pagination_simple($hardscapes) !!}

        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade" id="modalMapLandskapKejur" tabindex="-1" role="dialog" aria-labelledby="modalMapLandskapKejurLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<div class="modal fade" id="modalMapLandskapKejurEdit" data-keyboard="false" role="dialog" aria-labelledby="modalMapLandskapKejurEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@section('page-js-script')

<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.api_map_hardscape')}}"></script>
<script src="{{ asset('js/gmap3/gmap3.min.js') }}"></script>
<script>
    var markerlocations = {!!json_encode($data['data']) !!};
    //var center = [3.148118, 101.632295];
    var markers = [];
    $.each(markerlocations, function (index, item) {
        var data = {
            id: item.id,
            position: [item.lat, item.lng],
            label: {
                text: 'H',
                color: 'white',
                fontSize: '12px',
            },
            icon: {
                path: "M-10,0a10,10 0 1,0 20,0a10,10 0 1,0 -20,0",
                fillColor: "#9b59b6",
                fillOpacity: 1,
                anchor: new google.maps.Point(0, 0),
                strokeWeight: 5,
                strokeColor: '#8e44ad',
                strokeOpacity: 0.25,
                scale: .7
            }
        };
        markers.push(data);
    });

    $('.map-hardscape')
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
        .fit();


    function batalHard(d){
        $('#modalMapLandskapKejurEdit').modal('hide');
        modalInfo(d);
    }
    function editHard(d){
        $('#modalMapLandskapKejur').modal('hide');
        modalEdit(d);
    }


    /*Bootstrap Modal Pop Up Open Code*/
    function modalEdit(d) {
        //console.log(item);
        var item = d.getAttribute("data-id");
        var href = d.getAttribute("data-href");
        $('#modalMapLandskapKejurEdit').modal('show'); // Show Modal start

        $('#modalMapLandskapKejurEdit .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

        });

    }
    function modalInfo(item) {
        //console.log(item);
        $('#modalMapLandskapKejur').modal('show'); // Show Modal start

        var href = "{{ route('pengurusan.hardscape.petashow',['hardscape'=>'ids']) }}".replace("ids", item);

        $('#modalMapLandskapKejur .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

            //If success load, show modal
            if (statusTxt == "success") {

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
</script>
@include('pengurusan.hardscape._ckfinder')
@endsection
