<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panorama Viewer</title>
    <style>
        #photosphere {
            width: 100%; /* Full width of the iframe */
            height: 100vh; /* Full height of the iframe */
            background-color: #000;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('js/pano/photo-sphere-viewer.css') }}">
    <style>
        .phpdebugbar {
            display: none !important;
        }
    </style>
</head>
<body>
    <div id="photosphere"></div>

    <script src="{{ asset('js/pano/three/build/three.js') }}"></script>
    <script src="{{ asset('js/pano/uevent/browser.js') }}"></script>
    <script src="{{ asset('js/pano/photo-sphere-viewer.js') }}"></script>
    <script src="{{ asset('js/pano/viewer-compat.js') }}"></script>

    <!-- Initialize the panorama viewer -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var PSV = new PhotoSphereViewer.ViewerCompat({
                container: document.getElementById('photosphere'),
                panorama: '{{ $imagePath }}', // Correct image path
                caption: 'ePokok<b>&copy; Panorama</b>',
                loading_img: 'https://tpbk.jln.gov.my/img/photosphere-logo.gif', 
                time_anim: false,
                anim_speed: '-2rpm',
                default_fov: 50,
                fisheye: false,
                move_speed: 1.1
            });
        });
    </script>
</body>
</html>
