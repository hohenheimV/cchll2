@extends('layouts.website.secondary')
@section('title','Peta Inventori')

@section('insert_style')
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
<link rel="stylesheet" href="{{ asset('js/pano/photo-sphere-viewer/dist/photo-sphere-viewer.min.css') }}">
<style>
    #map {
        height: 100%;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #photosphere {
        width: 100%;
        height: 80vh;
    }

    a.rm-link {
        color: #e83e8c !important;
    }
</style>
@endsection

@section('content')

<section id="posts" class="bg-light pt-lg-5">
 
    <div class="row pt-lg-5">
   
           <iframe src="https://emap.jln.gov.my/arcgis/apps/webappviewer/index.html?id=43427736cb1e43a595e0a53af6ef0663"
            title="Peta" width="100%" style="border:none; height: calc(140vh - 250px);"></iframe>
       
     </div>
</section>
<!-- /.section#posts -->
@endsection

@section('modal')
<div class="modal fade" id="modalMap" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modalMapLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection
@if(!empty($data))
@section('insert_js')
<script src="{{ asset('js/readmore/readmore.min.js') }}"></script>
<script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script src="{{ asset('js/pano/three/build/three.js') }}"></script>
<script src="{{ asset('js/pano/uevent/uevent.min.js') }}"></script>
<script src="{{ asset('js/pano/dot/doT.min.js') }}"></script>
<script src="{{ asset('js/pano/photo-sphere-viewer/dist/photo-sphere-viewer.min.js') }}"></script>

<script>
    //var markerss = "$softscape";

    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

    var minZoomLevel = 15;

    var markers = new Array();
    var customLabel = {
        hardscapes: {
            labelText: 'H',
            labelSize: '12px',
            labelColor: 'white',
            color: "#9b59b6",
            stroke: "#8e44ad",
        },
        softscapes: {
            labelText: 'S',
            labelSize: '12px',
            labelColor: 'white',
            color: "#1abc9c",
            stroke: "#16a085",
        },
        panorama: {
            labelText: '360',
            labelSize: '10px',
            labelColor: 'white',
            color: "#e74c3c",
            stroke: "#c0392b",
        }
    };

    var markers = new Array();
    var center = null;

    function initMap() {

        //var markerlocations = {!!json_encode($data) !!};
        var markerlocations = {!!json_encode($data) !!};
        //console.log(markerlocations);


        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
            center: {
                lat: 3.148118,
                lng: 101.632295
            },
            restriction: {
                latLngBounds: {north: 3.1664, south: 3.14202, west: 101.62422, east: 101.648},
                strictBounds: false,
            },
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            streetViewControl: false,
            fullscreenControl: false,
            zoom: minZoomLevel
        });

        var ctaLayer = new google.maps.KmlLayer({
          url: 'http://tpbk.jln.gov.my/storage/malaysia.kml',
          map: map
        });
        var infoWindow = new google.maps.InfoWindow;
        var bounds = new google.maps.LatLngBounds();

        //Marker Custome
        // var pinSVGFilled = "M 12,2 C 8.1340068,2 5,5.1340068 5,9 c 0,5.25 7,13 7,13 0,0 7,-7.75 7,-13 0,-3.8659932 -3.134007,-7 -7,-7 z";
        // var labelOriginFilled = new google.maps.Point(12, 9);
        var pinSVGFilled = "M-10,0a10,10 0 1,0 20,0a10,10 0 1,0 -20,0";
        var labelOriginFilled = new google.maps.Point(0, 0);

        //Looping data
        $.each(markerlocations, function (i, item) {
            //console.log('item',item);
            var icon = customLabel[item.type] || {};
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(item.lat, item.lng),
                type: item.type,
                label: {
                    text: icon.labelText,
                    color: icon.labelColor,
                    fontSize: icon.labelSize,
                },
                icon: {
                    path: "M-10,0a10,10 0 1,0 20,0a10,10 0 1,0 -20,0",
                    fillColor: icon.color,
                    fillOpacity: 1,
                    anchor: new google.maps.Point(0, 0),
                    strokeWeight: 5,
                    strokeColor: icon.stroke,
                    strokeOpacity: 0.25,
                    scale: .7
                },
                map: map
            });

            markers.push(marker);

            marker.addListener('click', function () {
                modalInfo(i, item);
            });

        });

        //  Create a new viewpoint bound
        //markerFitBounds(map, bounds);

        filterMarkers();

        $("input[name='all']").on('click', function () {
            var $this = $(this);
            $("input[name='categories[]']").prop('checked', $this.is(':checked'));
            filterMarkers();
        });


    }

    /*Bootstrap Modal Pop Up Open Code*/
    function modalInfo(i, item) {
        $('#modalMap').modal('show'); // Show Modal start

        if (item.type === 'softscapes') {
            var href = "{{ route('website.softscape',['id'=>'ids']) }}".replace("ids", item.id);
        } else if (item.type === 'hardscapes') {
            var href = "{{ route('website.hardscape',['id'=>'ids']) }}".replace("ids", item.id);
        } else {
            var href = "{{ route('website.panorama',['id'=>'ids']) }}".replace("ids", item.id);
        }

        $('#modalMap .modal-content').load(href, function (responseTxt, statusTxt, xhr) {

            //If success load, show modal
            if (statusTxt == "success") {
                if (item.type === 'panorama') {
                    //pano(item.img);
                    setTimeout(function () {
                        pano(item.img);
                    }, 500);
                }

                $readMoreJS.init({
                    target: '.more p',
                    numOfWords: 50,
                    moreLink: 'baca selanjutnya...',
                    lessLink: 'tutup',
                    toggle: true,
                });

                //if (item.type !== 'panorama') {
                $('img.thumb').on('click', function () {
                    console.log($(this)[0].src);
                    $('img.product-image').attr("src", $(this)[0].src);
                    $('a.product-image-lightbox').attr("href", $(this)[0].src);

                });
                //}

                //$('#modalMap').modal('show'); // Show Modal start
                // clear modal content if modal closed
                $('#modalMap').on('hidden.bs.modal', function () {
                    $(this).find('.modal-content').empty();
                });
            } else {
                alert("Error: " + xhr.status + ": " + xhr.statusText);
            }
        });

    }

    function pano(img) {
        var PSV = new PhotoSphereViewer({
            container: 'photosphere',
            panorama: 'storage/images/panorama/' + img,
            caption: '<b>&copy; Panorama</b>',
            loading_img: 'img/photosphere-logo.gif',
            anim_speed: '-2rpm',
            default_fov: 90,
            //min_fov: 1,
            fisheye: false,
            move_speed: 1.1,
            time_anim: false,
            // touchmove_two_fingers: true,
            // mousemove_hover: true,
            navbar: [
                'autorotate', 'zoom',
                'caption', 'gyroscope', 'stereo', 'fullscreen'
            ],
        });
    }


    //Create a new viewpoint bound
    function markerFitBounds(map, bounds) {
        //  Go through each...
        for (var i = 0; i < markers.length; i++) {
            bounds.extend(markers[i].position);
        }
        // console.log('bounds', bounds);
        //  Fit these bounds to the map
        map.fitBounds(bounds);
        console.log('bounds',map.getCenter().lat());
        console.log('bounds',map.getCenter().lng());

        fitMaps(map, map.getCenter());
    }

    function fitMaps(map,center) {
        // Bounds for Taman
        var strictBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(3.143555, 101.629011),
        new google.maps.LatLng(3.152982, 101.636468));

        // Listen for the dragend event
        google.maps.event.addListener(map, 'dragend', function () {
            //console.log('getZoom',map.getZoom());
            //if (strictBounds.contains(center) return;
            //if (strictBounds.contains(map.getCenter())) return;

            // We're out of bounds - Move the map back within the bounds

            var c = map.getCenter(),
                x = c.lng(),
                y = c.lat(),
                maxX = strictBounds.getNorthEast().lng(),
                maxY = strictBounds.getNorthEast().lat(),
                minX = strictBounds.getSouthWest().lng(),
                minY = strictBounds.getSouthWest().lat();

            if (x < minX) x = minX;
            if (x > maxX) x = maxX;
            if (y < minY) y = minY;
            if (y > maxY) y = maxY;

            if(map.getZoom() <= 15){
                map.setCenter(new google.maps.LatLng(center.lat(),center.lng()));
            }
        });

        // Limit the zoom level
        google.maps.event.addListener(map, 'zoom_changed', function () {
            if (map.getZoom() < minZoomLevel) map.setZoom(minZoomLevel);
        });
    }



    function filterMarkers() {

        var checked = $("input[name='categories[]']:checked").map(function (_, el) {
            return $(el).val();
        }).get();

        for (i = 0; i < markers.length; i++) {
            marker = markers[i];

            if (checked.indexOf(marker.type) !== -1) {
                marker.setVisible(true);
            } else {
                marker.setVisible(false);
            }
        }
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=xxxxx&callback=initMap">
</script>
@endsection
@endif
