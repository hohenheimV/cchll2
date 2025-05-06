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
            background-color:rgb(123, 123, 123) !important;
            /* background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}"); */
            /* background-image: url("https://www.transparenttextures.com/patterns/flowers.png"); */
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 0; /* Remove padding to ensure full-height */
            overflow: hidden; /* Prevent content from overflowing */
        }

        #carouselBanner3 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; /* Ensure the carousel fills the section */
            z-index: 0; /* Place carousel below the hero content */
        }

        #particles-js {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Place particles behind both carousel and content */
            background-color: rgba(0, 0, 0, 0.14);
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            z-index: 2; /* Ensure content is on top of carousel and particles */
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.97);
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cta-buttons a {
            text-decoration: none;
            background-color: #00b300;
            color: white;
            padding: 10px 20px; /* Reduced padding for smaller buttons */
            font-size: 0.9rem; /* Smaller font size */
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-buttons a:hover {
            background-color:rgb(20, 92, 199);
        }

        .cta-buttons a.secondary {
            background-color: #005cbf;
        }

        .cta-buttons a.secondary:hover {
            background-color: #00408a;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                background-image: url('https://wikipil.jln.gov.my/elandskap/media/transfer/img/65810b7a4a19a.jpeg');
            }
            .hero-content {
                top: 40%;
                left: 50%;
            }
            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }
            #particles-js {
                display: none;
            }
            #carouselBanner3 {
                display: none;
            }
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
                    console.log(reader.result);
                };
                reader.onerror = function (error) {
                    console.log('Error: ', error);
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
                            console.log('data', data);
                            $('#myModalAjax').modal('show');
                            setTimeout(() => {
                                $('#myModalAjax').modal('hide');
                            }, 6000);

                            $('#ajaxfeedbacks')[0].reset();
                        },
                        error: function(error) {
                            console.log('error', error);
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
<section class="hero-section">
    <!-- <div id="carouselBanner3" class="carousel slide" data-ride="carousel">
        {!! website_slider('carouselBanner3') !!}
    </div> -->
    <div id="carouselBanner3" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
            @foreach ($sliders as $key => $slider)
                <?php
                    $active = ($key == 0 ? 'active' : '');
                ?>
                <div class="carousel-item {{ $active }}">
                    <div class="embed-responsive embed-responsive-16by9">
                        <img src="{{ $slider->url }}" class="card-img-top embed-responsive-item" alt="Slider {{ $slider->title }}">
                        <div class="carousel-caption d-none d-md-block" style="top: 50%;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div id="particles-js" class="particles-js"></div>
    <div class="hero-content">
        <h1>Sistem Pengurusan Maklumat Landskap (eLANDSKAP)</h1>
        <p>Komprehensif dan mudah dicapai untuk panduan serta rujukan.</p>
        <div class="cta-buttons">
            <a href="/epalm" class="primary">Direktori Taman</a>
            <a href="#penggiat_industri" class="primary">Penggiat Industri Landskap</a>
            <a href="/epil-pelan" class="primary">Pelan Induk Landskap</a>
            <!-- <a href="/epalm" class="primary">Entiti Landksap Unik</a>
            <a href="#penggiat_industri" class="primary">Kempen Tanam Pokok</a> -->
        </div>
    </div>
</section>


<!-- <section id="taman" class="mib"><br>
    <div class="mobile-gone">
        <br>
        <br>
    </div>
    <div class="container py-5" style="color: white;">
        <div class="row">
            <div class="col-lg-6 col-12" data-aos="fade-up">
                <h1 class="text-center">Taman Pilihan</h1>
                <p class="text-justify">Taman-taman yang diuruskan oleh PBT dibawah pantauan Jabatan Lanskap Negara. Semak taman-taman menarik berhampiran anda.</p>
                <p>
                    Taman-taman dibahagikan beberapa ZON pembangunan.
                </p>
                <ul>
                    <li><i class="icofont-check"></i> Zon 1</li>
                    <li><i class="icofont-check"></i> Zon 2</li>
                    <li><i class="icofont-check"></i> Zon 3</li>
                    <li><i class="icofont-check"></i> Zon 4</li>
                    <li><i class="icofont-check"></i> Zon 5</li>
                </ul>
            </div>
            <div class="col-lg-6 col-12" data-aos="fade-up">
                <div class="container-fluid p-0">
                    <div id="carouselBanner" class="carousel slide" data-ride="carousel">
                        {!! website_slider('carouselBanner') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-gone">
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Lorem ipsum</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.peta') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Lorem ipsum</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.peta') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section> -->

<!-- <section id="hero" class="mib">
    <div class="mobile-gone">
        <br>
        <br>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Peta Inventori TPBK</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di sekitar Taman Persekutuan Bukit Kiara.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.peta') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Peta Inventori TPBK</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di sekitar Taman Persekutuan Bukit Kiara.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.peta') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Peta Inventori TPBK</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di sekitar Taman Persekutuan Bukit Kiara.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.peta') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <div id="carouselBanner2" class="carousel slide" data-ride="carousel" style="border: 2px solid blue;">
                    {!! website_slider('carouselBanner2') !!}
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- <section id="banner">
    <div class="container-fluid p-0">
        <div id="carouselBanner" class="carousel slide" data-ride="carousel">
            {!! website_slider('carouselBanner') !!}
        </div>
    </div>
</section> -->

<!-- <section id="why-chose-area" class="bg-gray mib2">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 col-12">
                <h1 class="text-center">Taman Persekutuan</h1>
                <h5 class="text-center">Bukit Kiara</h5>
                <p class="text-justify">Taman Persekutuan, Taman Awam Berskala Besar Bukit Kiara adalah merupakan muzium hidup yang menjadikan tempat lokasi pokok utama, pokok renek dan tanaman tutup
                    bumi. Pokok-pokok
                    hutan berkayu dan tanaman sokongan hutan hujan khatulistiwa akan ditanam mengikut rekabentuk senibina landskap berasaskan hutan semulajadi. </p>
                <p>
                    Pembangunan TABB Bukit Kiara dibahagikan beberapa ZON pembangunan.
                </p>
                <ul>
                    <li><i class="icofont-check"></i> Zon Rekreasi Keluarga</li>
                    <li><i class="icofont-check"></i> Zon Tropika Khatulistiwa Asia</li>
                    <li><i class="icofont-check"></i> Zon Arboretum Bernilai Tinggi</li>
                    <li><i class="icofont-check"></i> Zon Riparian / Konservasi Hidrologi</li>
                    <li><i class="icofont-check"></i> Zon Biodiversiti (Forest Restoration)</li>
                </ul>
            </div>
            <div class="col-lg-6 col-12">
                <div class="embed-responsive embed-responsive-16by9 align-middle">
                    <video class="w-100 w-lg-50" controls poster="{{ asset('storage/images/shares/kiara_gambar.png') }}">
                        <source src="{{ asset('storage/videos/kiara_drone.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- <section id="new" class="mib">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Peta Inventori TPBK</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di sekitar Taman Persekutuan Bukit Kiara.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.peta') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <div id="carouselBanner3" class="carousel slide" data-ride="carousel" style="border: 2px solid blue;">
                    {!! website_slider('carouselBanner3') !!}
                </div>
            </div>
        </div>
    </div>
</section> -->


<section id="taman" class="bg-white mib2">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1 style="color: white;">Taman Pilihan</h1>
            </div>
        </div>
        {!! website_carousel_taman() !!}
    </div>
</section>

<section id="activities" class="bg-gray mib">
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Permohonan Projek</h1>
                <div class="mobile-gone">
                    <br>
                    <br>
                </div>
                <p>
                    Wakil PBT boleh mendaftar dan membuat permohonan projek melalui Borang ISO digital.
                </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet sem sed augue pretium gravida.</p>
                <div class="mobile-gone">
                    <br>
                    <br>
                </div>
                <a class="btn bg-light" href="{{ route('register') }}">Maklumat Lanjut</a>
            </div>
        </div>
    </div>
</section>

<section id="penggiat_industri" class="bg-gray mib2">
    <div class="mobile-gone">
        <br>
        <br>
        <br>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Penggiat Industri Landskap</h1>
                <div class="mobile-gone">
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-6">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Kontraktor Landskap</h5>
                                <p class="mobile-gone"> Realisasikan pelan idea anda dengan kepakaran dan komitmen kontraktor landskap. Setiap perincian dilaksanakan dengan sempurna!</p>
                                <a class="btn bg-olive mb-3" href="penggiat-industri/kontraktor">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-6">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Perunding Landskap</h5>
                                <p class="mobile-gone">Visualkan idea impian anda menjadi rancangan nyata dengan cadangan dan reka bentuk daripada Perunding Landskap, disesuaikan mengikut keperluan dan visi anda!</p>
                                <a class="btn bg-olive mb-3" href="penggiat-industri/perunding">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </article>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-6">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Pembekal Landskap</h5>
                                <p class="mobile-gone">Dapatkan segala keperluan landskap anda di satu tempat - dari tumbuhan hingga bahan binaan. Semuanya untuk mewujudkan ruang luar impian anda!</p>
                                <a class="btn bg-olive mb-3" href="penggiat-industri/pembekal">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </article>
            </div>
            <div class="col-lg-6 col-6">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body p-0">
                                <h5>Anda Penggiat Industri?</h5>
                                <p class="mobile-gone"> Penggunaan Taman Persekutuan Bukit Kiara perlu mendapatkan kelulusan daripada Jabatan Landskap Negara sebelum sesuatu program/aktiviti  dijalankan dan perlu mematuhi syarat-syarat yang telah ditetapkan.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('register') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<!-- /.section#posts -->


<section id="artikel" class="bg-white mib">
    <div class="container py-5">
        {!! website_carousel_article() !!}
    </div>
</section>


<style>

</style>
<section id="faq-area" class="bg-gray mib2">
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
</section>

<section id="contact-area" class="bg-gray mib">
    <div class="container py-5">
        <style>
            #ajaxfeedbacks .error {
                color: #dc3545 !important;
                font-weight: normal
            }
        </style>

        <h1 class="text-center">Aduan, Cadangan, Atau Pertanyaan</h1>
        <p class="text-center">Kami sentiasa berusaha untuk meningkatkan mutu perkhidmatan dari semasa ke semasa. Utarakan sebarang cadangan, aduan, atau pertanyaan anda kepada kami. Kami menghargai setiap maklumbalas yang kami terima.</p>
        <hr class="mb-4">
        <div class="row">
            <div class="col-12 col-lg-5 text-center text-lg-left" style="color: white;">
                {!! website_contact() !!}
            </div>
            <!--start contact form-->
            <div class="col-12 col-lg-7">
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


