@extends('layouts.website.master')
@section('title','Laman Utama')
@section('insert_style')
    <link rel="stylesheet" href="{{-- asset('web/plugins/owlcarousel/owl.carousel.min.css') --}}">
    <link rel="stylesheet" href="{{-- asset('web/plugins/owlcarousel/owl.theme.default.min.css') --}}">

    <style>
        #ajax-aduan .error {
            color: #343a40
        }
        section {
            /* background-color:rgb(25, 98, 92) !important; */
            background-image: url("{{ asset('storage/img/bg-pattern-leaves.png') }}");
            /* background-image: url("https://www.transparenttextures.com/patterns/flowers.png"); */
        }
        .mib {
            background-color:rgb(25, 98, 92) !important;
            /* background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}"); */
            /* background-image: url("https://www.transparenttextures.com/patterns/flowers.png"); */
            /* color: #343a40 !important; */
        }
        .mib2 {
            background-color:rgb(250, 250, 250) !important;
            color:rgb(0, 0, 0) !important;
        }

        .mib2 a.btn {
            color: rgb(255, 255, 255) !important;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://db.onlinewebfonts.com/c/9292cc35e4f1fd3bee22274764613e63?family=Leadville+W00+Regular" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            color: white;
            text-align: center;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0 1rem;
            background: black; /* fallback */
        }

        #carouselBanner3 {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        #carouselBanner3 .carousel-item img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            filter: brightness(0.75);
            transition: filter 0.5s ease;
        }

        #carouselBanner3 .carousel-item.active img {
            filter: brightness(0.75);
        }

        #particles-js {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.48);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            width: 100%;
            padding: 1rem 2rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.9);
        }

        h1 {
            font-size: clamp(1.5rem, 5vw, 3rem);
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .p {
            font-size: clamp(0.85rem, 2vw, 1.25rem);
            margin-bottom: 2rem;
            line-height: 1.5;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.9);
        }

        .cta-buttons {
            /* display: flex; */
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        .cta-buttons .primary,
        a.btn {
            border-radius: 10px !important;
        }

        .cta-buttons a {
            display: inline-block;
            padding: 0.65rem 1.5rem;
            font-size: 1rem;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            background-color: #31d5c8;
            transition: background-color 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
            user-select: none;
            flex: 0 0 180px; 
            padding: 0.65rem 1rem;
        }

        .cta-buttons a:hover,
        .cta-buttons a:focus {
            background-color:rgb(20, 92, 199);
            outline: none;
        }

        .cta-buttons a.secondary {
            background-color: #005cbf;
        }

        .cta-buttons a.secondary:hover,
        .cta-buttons a.secondary:focus {
            background-color: #00408a;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                height: 100vh;
                padding: 2rem 1rem;
                background-image: url("{{ asset('storage/img/bg-pattern-leaves.png') }}");
                background-position: center;
                background-size: cover;
                color: white;
                text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.9);
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .cta-buttons a {
                flex: 0 0 auto;
                width: 180px;
                margin-bottom: 0.75rem;
            }

            .cta-buttons a:last-child {
                margin-bottom: 0;
            }
            .hero-content {
                top: -10vh; /* move content up by 5% of viewport height */
            }
        }

        @keyframes panImage {
            0% {
                transform: scale(1.1) translateX(0);
            }
            100% {
                transform: scale(1.1) translateX(-5%);
            }
        }
        @keyframes zoomOut {
            0% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes panLeft {
            0% { transform: scale(1.1) translateX(0); }
            100% { transform: scale(1.1) translateX(-5%); }
        }

        @keyframes panRight {
            0% { transform: scale(1.1) translateX(0); }
            100% { transform: scale(1.1) translateX(5%); }
        }

        @keyframes panUp {
            0% { transform: scale(1.1) translateY(0); }
            100% { transform: scale(1.1) translateY(-5%); }
        }

        @keyframes panDown {
            0% { transform: scale(1.1) translateY(0); }
            100% { transform: scale(1.1) translateY(5%); }
        }

        .carousel-item img {
            animation: zoomOut 7s ease-in-out infinite alternate;
        }
        
    </style>
    
@endsection

@section('insert_js')
    <!-- Owl Carousel CSS (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Owl Carousel JS (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,       // animation duration (ms)
            delay: 0,             // delay before animation starts (ms)
            easing: 'ease-in-out',// easing function
            // once: true,           // whether animation happens only once while scrolling down
            mirror: false         // whether elements animate out while scrolling past them
        });
    </script>





    <script src="{{-- asset('web/plugins/jquery-validation/jquery-validation.min.js') --}}"></script>
    <script src="{{-- asset('web/plugins/jquery-validation/jquery-validation-methods.min.js') --}}"></script>
    <script src="{{-- asset('web/plugins/jquery-validation/jquery-validation-additional.js') --}}"></script>
    <script src="{{-- asset('web/plugins/owlcarousel/owl.carousel.min.js') --}}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>



    <script>@php($issetpop = @isset($popup) ? $popup : null); </script>
    <script>
        $(document).ready(function () {
            // alert("Start");
            var issetpop = "{{ $issetpop }}";

            if(issetpop){
                setTimeout(function() {
                    $('#modalPopup').modal('show');
                },3000);
            }


            function getBase64(file) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    // console.log(reader.result);
                };
                reader.onerror = function (error) {
                    // console.log('Error: ', error);
                };
            }
            bsCustomFileInput.init();
            // var url = "{{route('website.feedbacks.simpan')}}";
            // $('#ajaxfeedbacks').validate({ //sets up the validator
            //     submitHandler: function (form) {
            //         //form.submit();
            //         $.ajaxSetup({
            //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //         });

            //         $.ajax({
            //             url: url,
            //             type: 'POST',
            //             data: $('#ajaxfeedbacks').serialize(),
            //             success: function(data) {
            //                 console.log('data',data);
            //                 $('#myModalAjax').modal('show');
            //                 setTimeout(()=>{
            //                     $('#myModalAjax').modal('hide');
            //                 },6000);

            //                 $('#ajaxfeedbacks')[0].reset();
            //             },
            //             error: function(error) {
            //                 console.log('error',error);
            //             }
            //         });

            //         return false;

            //     },
            //     rules: {
            //         'name': 'required',
            //         'email': {
            //             required:true,
            //             email:true
            //         },
            //         'phone': {
            //             required:true,
            //             phone:true
            //         },
            //         'message': 'required'
            //     }
            // });
            var url = "{{route('website.feedbacks.simpan')}}";

            $('#ajaxfeedbacks').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear any previous error messages
                let valid = true;

                // Manually check each field
                var name = $('#name').val().trim();
                var email = $('#email').val().trim();
                var phone = $('#phone').val().trim();
                var message = $('#message').val().trim();

                // Validation
                if (name === '') {
                    valid = false;
                    alert('Name is required.');
                }

                if (email === '') {
                    valid = false;
                    alert('Email is required.');
                } else if (!validateEmail(email)) {
                    valid = false;
                    alert('Please enter a valid email address.');
                }

                if (phone === '') {
                    valid = false;
                    alert('Phone number is required.');
                }

                if (message === '') {
                    valid = false;
                    alert('Message is required.');
                }

                // If validation passes, proceed with AJAX
                if (valid) {
                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    });

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: $('#ajaxfeedbacks').serialize(),
                        success: function(data) {
                            // console.log('data', data);
                            $('#myModalAjax').modal('show');
                            setTimeout(() => {
                                $('#myModalAjax').modal('hide');
                            }, 6000);

                            $('#ajaxfeedbacks')[0].reset();
                        },
                        error: function(error) {
                            // console.log('error', error);
                        }
                    });
                }
            });

            // Email Validation function
            function validateEmail(email) {
                var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return re.test(email);
            }

            $(".owl-carousel").owlCarousel({
                nav: true,
                center: true,
                items: 4,
                loop: true,
                autoplay:true,
                autoplayTimeout:2000,
                responsiveClass: true,
                autoplayHoverPause:true,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: true
                    },
                    1000: {
                        items: 3,
                        nav: true
                    }
                }
            });
            // alert("End");


        });

    </script>
    <!--<meta name="google-site-verification" content="H9AQXvBj0Cnj11LZWLCzYI2lIZ5srIczvWXwKu4Xmig" />-->
    <script src="{{ asset('js/particles.min.js') }}"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 100,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 2,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#256762",
                    "opacity": 0.5,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    </script>
@endsection

@section('content')
<section class="hero-section" role="banner" aria-label="Sistem Pengurusan Maklumat Landskap hero section">
    <div id="carouselBanner3" class="carousel slide" data-ride="carousel" data-interval="5000" aria-hidden="true" tabindex="-1">
        <div class="carousel-inner">
            @foreach ($sliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ $slider->url }}" alt="{{ $slider->title ?? 'Slider Image' }}" />
                </div>
            @endforeach
        </div>
    </div>
    <div id="particles-js" aria-hidden="true"></div>
    <div class="hero-content fly-in typewriter">
        <img src="{{ asset('img/logo-jln.png') }}" height="80" alt="">
        <br>
        <h3>eLANDSKAP</h3>
        <h5>{{ ("Pusat Data Landskap Negara") }}</h5>
        {{-- <h6 >Pusat Data Landskap Negara</h6> --}}
        <br>
        <nav class="cta-buttons" aria-label="Call to action buttons">
            {{-- <a href="/epalm" class="primary" role="button">Direktori Taman dan Landskap</a> --}}
            {{-- <a href="#penggiat_industri" class="primary" role="button">Penggiat Industri</a> --}}
            <a href="#menu" class="primary" role="button">MASUK</a>
            {{-- <a href="/epil-pelan" class="primary" role="button">Direktori Pelan Induk Landskap</a> --}}
            {{-- <a href="/entiti-landskap" class="primary" role="button">Direktori Entiti Landskap</a> --}}
            {{-- <a href="#elaps" class="primary" role="button">Permohonan Projek</a> --}}
            {{-- <a href="/emap" class="primary" role="button">eMAP JLN</a> --}}
        </nav>
    </div>
</section>

<section id="taman" class="bg-white mib2">
    <div class="container py-5">
        <div class="row" data-aos="fade-up">
            <div class="col-12 text-center">
                <h1>Taman Pilihan</h1>
            </div>
        </div>
        <div data-aos="fade-up">
            {!! website_carousel_taman() !!}
        </div>
    </div>
</section>



<section id="menu" class="bg-light mib2 py-5">
    {{-- web --}}
    <div class="mobile-gone">
        <br>
        <br>
        <br>
    </div>
    <div class="container mobile-gone" style="max-width: 1200px; font-family: 'Inter', sans-serif;">
        <div class="row justify-content-center g-4">
            {{-- <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" href="/pengurusan/dashboard">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/warga.png') }}" class="img-fluid mb-2 rounded" alt="Warga">
                        <div class="fontnew">Warga </div>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" href="/register">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/warga.png') }}" class="img-fluid mb-2 rounded" alt="PBT">
                        <div class="fontnew">PBT </div>
                    </div>
                </a>
            </div> --}}
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Taman Awam" href="/epalm">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/ePALM.png') }}" class="img-fluid mb-2 rounded" alt="Direktori Taman">
                        <div class="fontnew">ePALM </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Taman Awam </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Pelan Induk Landskap" href="/epil-pelan">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/ePIL.png') }}" class="img-fluid mb-2 rounded" alt="Pelan Induk Landskap">
                        <div class="fontnew">ePIL </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Pelan Induk Landskap </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Penggiat Industri Landskap" href="/penggiat-industri/kontraktor">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eLIND.png') }}" class="img-fluid mb-2 rounded" alt="Kontraktor">
                        <div class="fontnew">eLIND </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Penggiat Industri Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Penyelidikan dan Penerbitan Landskap" href="/eread-dokumen">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eREAD.png') }}" class="img-fluid mb-2 rounded" alt="Penerbitan">
                        <div class="fontnew">eREAD </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Penyelidikan dan Penerbitan Landskap </div>
            </div>

        </div>
        <div class="row justify-content-center g-4">
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Direktori Rekabentuk Landskap" href="/elad-dokumen/kejur">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eLAD.png') }}" class="img-fluid mb-2 rounded" alt="Rekabentuk Landskap">
                        <div class="fontnew">eLAD  </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Rekabentuk Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Direktori Pentadbiran Kontrak dan Polisi Landskap" href="/epact-dokumen">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/ePACT.png') }}" class="img-fluid mb-2 rounded" alt="Pentadbiran Kontrak">
                        <div class="fontnew">ePACT </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Pentadbiran Kontrak dan Polisi Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Direktori Entiti Landskap" href="/entiti-landskap">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eNTITI.png') }}" class="img-fluid mb-2 rounded" alt="Entiti Landskap">
                        <div class="fontnew">eNTITI </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Direktori Entiti Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-4 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Aktiviti Rakan Taman" href="/aktiviti-rakan-taman">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/Rakan Taman.png') }}" class="img-fluid mb-2 rounded" alt="Rakan Taman">
                        <div class="fontnew">Rakan Taman </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 40px 0 !important; font-size: 0.85rem;">Aktiviti Rakan Taman </div>
            </div>

        </div>
    </div>
    <div class="mobile-gone">
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>

    {{-- mobile --}}

    <div class="container mobile-done" style="max-width: 1200px; font-family: 'Inter', sans-serif;">
        <div class="row justify-content-center g-4">
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Taman Awam" href="/epalm">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/ePALM.png') }}" class="img-fluid mb-2 rounded" alt="Direktori Taman">
                        <div class="fontnew">ePALM </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Taman Awam </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Pelan Induk Landskap" href="/epil-pelan">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/ePIL.png') }}" class="img-fluid mb-2 rounded" alt="Pelan Induk Landskap">
                        <div class="fontnew">ePIL </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Pelan Induk Landskap </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Penggiat Industri Landskap" href="/penggiat-industri/kontraktor">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eLIND.png') }}" class="img-fluid mb-2 rounded" alt="Kontraktor">
                        <div class="fontnew">eLIND </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Penggiat Industri Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="top" title="Direktori Penyelidikan dan Penerbitan Landskap" href="/eread-dokumen">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eREAD.png') }}" class="img-fluid mb-2 rounded" alt="Penerbitan">
                        <div class="fontnew">eREAD </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Penyelidikan dan Penerbitan Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Direktori Rekabentuk Landskap" href="/elad-dokumen/kejur">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eLAD.png') }}" class="img-fluid mb-2 rounded" alt="Rekabentuk Landskap">
                        <div class="fontnew">eLAD  </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Rekabentuk Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Direktori Pentadbiran Kontrak dan Polisi Landskap" href="/epact-dokumen">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/ePACT.png') }}" class="img-fluid mb-2 rounded" alt="Pentadbiran Kontrak">
                        <div class="fontnew">ePACT </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Pentadbiran Kontrak dan Polisi Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Direktori Entiti Landskap" href="/entiti-landskap">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/eNTITI.png') }}" class="img-fluid mb-2 rounded" alt="Entiti Landskap">
                        <div class="fontnew">eNTITI </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Direktori Entiti Landskap </div>
            </div>
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 justify-content-center">
                <a target="_blank" style="color: black;" data-toggle="tooltipx" data-placement="bottom" title="Aktiviti Rakan Taman" href="/aktiviti-rakan-taman">
                    <div class="card menu-button text-center p-3 shadow-sm">
                        <img src="{{ asset('/images/Rakan Taman.png') }}" class="img-fluid mb-2 rounded" alt="Rakan Taman">
                        <div class="fontnew">Rakan Taman </div>
                    </div>
                </a>
                <div style="text-align: center; margin: 0  0 18px 0 !important; font-size: 0.6rem;">Aktiviti Rakan Taman </div>
            </div>

        </div>
    </div>

    <style>
        .menu-button {
            background: #fff;
            border-radius: 1.5rem;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            width: 100%;
            height: 200px;
            min-height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            text-align: center;
        }

        .menu-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        .menu-button img {
            max-height: 100px;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
            margin-bottom: 0.5rem;
        }

        .fontnew{
            font-family: 'Poppins' !important; 
            font-size: 25px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            text-align: center;
            min-height: 2.5em;
            line-height: 1.2;
            font-weight: 800;
            color: #2e99b2;

        }

        @media only screen and (max-width: 768px) {
            .menu-button {
                height: 90px;
            }
            .menu-button img {
                max-height: 40px;
                max-width: 100%;
            }
            .fontnew{
                font-size: 16px;
                min-height: 1em;
                font-weight: normal;
            }
        }
    </style>
</section>

<section id="elaps" class="bg-gray mib">
    <div class="mobile-gone">
        <br>
        <br>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-up">
                <h1>Permohonan Projek PBT</h1>
                <div class="mobile-gone">
                    <br>
                    <br>
                </div>
                <p>
                    Wakil PBT boleh mendaftar dan membuat permohonan projek melalui Borang ISO digital.
                </p>
                {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p> --}}
                <div class="mobile-gone">
                    <br>
                    <br>
                </div>
                <a class="btn bg-light" href="{{ route('register') }}">Maklumat Lanjut</a>
            </div>
        </div>
    </div>
</section>

{{-- <section id="penggiat_industri" class="bg-gray mib2">
    <div class="mobile-gone">
        <br>
        <br>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-up">
                <h1>Penggiat Industri Landskap</h1>
                <div class="mobile-gone">
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-6">
                <article class="custom-article-style">
                    <div class="row m-3 align-items-stretch" data-aos="fade-up">
                        <div class="col-md-2">
                            <div class="img w-100 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-between">
                            <div class="card-body p-0 flex-grow-1">
                                <h5>Kontraktor Landskap</h5>
                                <p class="d-none d-md-block" style="text-align: justify;"> Realisasikan pelan idea anda dengan kepakaran dan komitmen kontraktor landskap. Setiap perincian dilaksanakan dengan sempurna!</p>
                                <a class="btn bg-olive mb-3" href="penggiat-industri/kontraktor">Maklumat Lanjut</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </article>
                <br>
            </div>
            <div class="col-lg-12 col-6">
                <article class="custom-article-style">
                    <div class="row m-3 align-items-stretch" data-aos="fade-up">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-2 d-block d-md-none">
                            <div class="img w-100 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-between">
                            <div class="card-body p-0 flex-grow-1">
                                <h5>Perunding Landskap</h5>
                                <p class="d-none d-md-block" style="text-align: justify;">Visualkan idea impian anda menjadi rancangan nyata dengan cadangan dan reka bentuk daripada Perunding Landskap, disesuaikan mengikut keperluan dan visi anda!</p>
                                <a class="btn bg-olive mb-3" href="penggiat-industri/perunding">Maklumat Lanjut</a>
                            </div>
                        </div>
                        <div class="col-md-2  d-none d-md-block">
                            <div class="img w-100 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>
                </article>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-6">
                <article class="custom-article-style">
                    <div class="row m-3 align-items-stretch" data-aos="fade-up">
                        <div class="col-md-2">
                            <div class="img w-100 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-between">
                            <div class="card-body p-0 flex-grow-1">
                                <h5>Pembekal Landskap</h5>
                                <p class="d-none d-md-block" style="text-align: justify;">Dapatkan segala keperluan landskap anda di satu tempat - dari tumbuhan hingga bahan binaan. Semuanya untuk mewujudkan ruang luar impian anda!</p>
                                <a class="btn bg-olive mb-3" href="penggiat-industri/pembekal">Maklumat Lanjut</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                </article>
                <br>
            </div>
            <div class="col-lg-12 col-6">
                <article class="custom-article-style">
                    <div class="row m-3 align-items-stretch" data-aos="fade-up">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-2 d-block d-md-none">
                            <div class="img w-100 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-between">
                            <div class="card-body p-0 flex-grow-1">
                                <h5>Anda Penggiat Industri?</h5>
                                <p class="d-none d-md-block"  style="text-align: justify;"> Daftar akaun untuk mempromosikan syarikat anda di Sistem eLANDSKAP.<br></p>
                                <a class="btn bg-olive mb-3" href="{{ route('register') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                        <div class="col-md-2 d-none d-md-block">
                            <div class="img w-100 h-100 d-flex align-items-center">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                    </div>
                </article>
                <br>
            </div>
        </div>
    </div>
</section> --}}

@if(article_exist())
<section id="artikel" class="bg-white mib">
    <div class="container py-5" data-aos="fade-up">
        {!! website_carousel_article() !!}
    </div>
</section>
@endif

{{-- <section id="faq-area" class="bg-gray mib2">
    <div class="container py-5">

        <h1 class="text-center">Soalan Lazim</h1>
        <p class="text-center">
        </p>
        <hr class="mb-4">

        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                {!! website_faqs('faqaccordion') !!}
            </div>
        </div>
    </div>
</section> --}}

<section id="contact-area" class="bg-gray mib">
    <div class="container py-5">
        <style>
            #ajaxfeedbacks .error {
                color: #dc3545 !important;
                font-weight: normal
            }
        </style>

        <h1 class="text-center d-none d-md-block" data-aos="fade-up">Aduan, Cadangan, Atau Pertanyaan</h1>
        <p class="text-center d-none d-md-block" data-aos="fade-up">Kami sentiasa berusaha untuk meningkatkan mutu perkhidmatan dari semasa ke semasa. Utarakan sebarang cadangan, aduan, atau pertanyaan anda kepada kami. Kami menghargai setiap maklumbalas yang kami terima.</p>
        <hr class="mb-4 d-none d-md-block">
        <div class="row">
            <div class="col-12 col-lg-5 text-center text-lg-left d-none d-md-block" style="color: #ffffff !important;" data-aos="fade-up">
                {!! website_contact() !!}
            </div>
            <!--start contact form-->
            <div class="col-12 col-lg-7" data-aos="fade-up">
                {!! website_contact_form() !!}
            </div>
            <!--end contact form-->
        </div>
    </div>
</section>

@endsection

@if ($popup)
@section('webmodal')


<div class="modal fade" id="modalPopup" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                @if(isset($popup->url))
                    <div class="modal-body p-0">
                        <a href="{{ $popup->url }}" href="{{ $popup->target }}">
                            <img src="{{ $popup->slider_image }}" width="100%" alt="popup">
                        </a>
                    </div>
                    <!--<div class="modal-footer p-1">
                        <p class="h3 my-2">Maklumat Lanjut</p>
                        <a href='{{ $popup->url }}' href="{{ $popup->target }}" class="btn btn-primary">Klik Disini</a>
                    </div>-->
                @else
                <div class="modal-body p-0">
                    <img src="{{ $popup->slider_image }}" width="100%" alt="popup">
                </div>        
                @endif
            </div>
    </div>
</div>

<!-- /.modal -->
@endsection
@endif


