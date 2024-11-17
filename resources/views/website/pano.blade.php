<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoSphereViewer - equirectangular demo</title>

    <link rel="stylesheet" href="{{ asset('js/pano/photo-sphere-viewer/dist/photo-sphere-viewer.min.css') }}">

    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        #photosphere {
            width: 100%;
            height: 400px;
        }

    </style>
</head>

<body>

    <div id="photosphere"></div>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/pano/three/build/three.js') }}"></script>
    <script src="{{ asset('js/pano/uevent/uevent.min.js') }}"></script>
    <script src="{{ asset('js/pano/dot/doT.min.js') }}"></script>
    <script src="{{ asset('js/pano/photo-sphere-viewer/dist/photo-sphere-viewer.min.js') }}"></script>
    <script>
        var PSV = new PhotoSphereViewer({
            container: 'photosphere',
            panorama: 'storage/images/panorama/panorama_0262.jpg',
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

    </script>
</body>

</html>
