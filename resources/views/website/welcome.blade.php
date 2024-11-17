@extends('layouts.website.master')
@section('title','Laman Utama')
@section('insert_style')
    <link rel="stylesheet" href="{{ asset('web/plugins/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/plugins/owlcarousel/owl.theme.default.min.css') }}">
    <style>
        .scroll-button {
            /* position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            border: none;
            color: white; */
            background-color: #36458e00;
        /* opacity: 0; Semi-transparent background */
            border-radius: 5px;
            cursor: pointer;
            /* display: none; */
            transition: background-color 0.3s ease; /* Smooth transition for color change */
        }

        .scroll-button.scrolled {
            display: block;
            background-color: rgba(54, 69, 142, 1); /* Solid color when scrolled */
        }
    </style>
    <style>
        #ajax-aduan .error {
            color: #343a40
        }
    </style>

<style>
</style>

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
@endsection

@section('insert_js')
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1200, // Duration of the animations in milliseconds
            });
        });
    </script>
    <script src="{{ asset('web/plugins/jquery-validation/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('web/plugins/jquery-validation/jquery-validation-methods.min.js') }}"></script>
    <script src="{{ asset('web/plugins/jquery-validation/jquery-validation-additional.js') }}"></script>
    <script src="{{ asset('web/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        document.addEventListener('scroll', function() {
            const button = document.querySelector('.scroll-button');
            const scrollPosition = window.scrollY;

            if (scrollPosition > 200) { // Change 100 to the scroll position where you want the color to change
                button.classList.add('scrolled');
            } else {
                button.classList.remove('scrolled');
            }
        });
    </script>


    <script>@php($issetpop = @isset($popup) ? $popup : null); </script>
    <script>
        $(document).ready(function () {

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
            var url = "{{route('website.feedbacks.simpan')}}";
            $('#ajaxfeedbacks').validate({ //sets up the validator
                submitHandler: function (form) {
                    //form.submit();
                    $.ajaxSetup({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    });

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: $('#ajaxfeedbacks').serialize(),
                        success: function(data) {
                            console.log('data',data);
                            $('#myModalAjax').modal('show');
                            setTimeout(()=>{
                                $('#myModalAjax').modal('hide');
                            },6000);

                            $('#ajaxfeedbacks')[0].reset();
                        },
                        error: function(error) {
                            console.log('error',error);
                        }
                    });

                    return false;

                },
                rules: {
                    'name': 'required',
                    'email': {
                        required:true,
                        email:true
                    },
                    'phone': {
                        required:true,
                        phone:true
                    },
                    'message': 'required'
                }
            });
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


        });

    </script>
    <!--<meta name="google-site-verification" content="H9AQXvBj0Cnj11LZWLCzYI2lIZ5srIczvWXwKu4Xmig" />-->
@endsection

@section('content')

  <!-- Hero Section -->
  <section id="hero" class="container-fluid p-0 position-relative">
    
    
    <div class="hero-bg" style="">
        <div id="particles-js" class="particles-js" ></div>
        <!-- <img height="96" src="{{ asset('img/logo-jln.png') }}" alt="Logo" /> -->
        <h1  style=""class="display-4 text-center">eLANDSKAP</h1>
        <p  style=""class="lead text-center">Sistem Pengurusan Maklumat Landskap (eLANDSKAP) yang dibangunkan akan dijadikan sebagai satu sistem pengurusan maklumat landskap yang komprehensif dan mudah dicapai, untuk panduan serta rujukan semua pengguna.</p>
        <p  style=""class="hide text-center">Sistem Pengurusan Maklumat Landskap (eLANDSKAP)</p>
        
        <div class="btn-container d-flex flex-wrap justify-content-center mt-4" style="position: relative; z-index: 3; ">
            <div class="m-1 position-relative">
                <a target="_blank" href="#posts" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;eLIND
                    <span class="tooltip">Modul Pengurusan Maklumat Industri Landskap</span>
                </a>
                
            </div>
            <div class="m-1 position-relative">
                <a target="_blank" href="../register" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;eMohon
                    <span class="tooltip">Permohonan projek boleh dibuat melalui modul eMohon. Daftar sekarang sebagai wakil PBT untuk proses lanjut.</span>
                </a>
            </div>
            <div class="m-1 position-relative">
                <a target="_blank" href="#taman" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;ePALM
                    <span class="tooltip">Modul Pengurusan Taman & Landskap</span>
                </a>
            </div>
            <div class="m-1 position-relative">
                <a target="_blank" href="https://elandskap.jln.gov.my/portal/info/penyelidikan-rekabentuk-teknologi" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;eREAD<span class="tooltip">Modul  Maklumat R&D Landskap</span></a>
            </div>
            <div class="m-1 position-relative">
                <a target="_blank" href="https://elandskap.jln.gov.my/portal/info/dasar" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;ePACT<span class="tooltip">Modul Maklumat Polisi Landskap</span></a>
            </div>
            <div class="m-1 position-relative">
                <a target="_blank" href="https://elandskap.jln.gov.my/portal/info/pelan-induk-landskap/" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;ePIL
                    <span class="tooltip">Modul Pelan Induk Landskap</span>
                </a>
            </div>
            <div class="m-1 position-relative">
                <a href="#" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;eKiara
                </a>
            </div>
            <div class="m-1 position-relative">
                <a href="#" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;MIB
                </a>
            </div>
            <div class="m-1 position-relative">
                <a href="#" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;eKiara App</a>
            </div>
            <div class="m-1 position-relative">
                <a href="#" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;MyUjana</a>
            </div>
            <div class="m-1 position-relative">
                <a href="#faq-area" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;FAQ</a>
            </div>
            <div class="m-1 position-relative">
                <a href="#contact-area" class="btn"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;Aduan</a>
            </div>
            <div class="m-1 position-relative">
                <a href="#" class="btn" id="myUjanaButton"><i class="fas fa-arrow-circle-right"></i>&nbsp;&nbsp;eLIND: Kontraktor</a>
            </div>

            <script>
                document.getElementById('myUjanaButton').addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default anchor behavior

                    // Define the parameters
                    const specialization = "42";
                    const sessionId = "t5aq3ff0d32jdbqpng004zjq"; // Replace with actual session ID if needed

                    // Create the URL with query parameters
                    const url = `https://mcp.cidb.gov.my/MCP/ContractorSearch?Specialization=${specialization}&sessionId=${sessionId}`;

                    // Open the URL in a new tab
                    window.open(url, '_blank');
                });
            </script>


        </div>
    </div>

    <script src="{{ asset('js/particles.min.js') }}"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 250,
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
                    "color": "#31D5C8",
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
    
    <style>
        #hero .hero-bg {
            background-image: url("{{ asset('images/bglug2.png') }}"); 
            overflow: hidden;
            background-size: cover; /* Ensures the container is fully covered by the image */
            background-repeat: no-repeat; /* Prevents repeating the image */
            background-position: center; /* Centers the image within the container */
            height: 100vh; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            color: white; 
            position: relative; 
            z-index: 1; /* Set z-index to 1 */
        }

        #particles-js {
            position: absolute; /* Make it absolute to layer correctly */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3; /* Set z-index to 3 */
        }
        #hero .hide {
            display: none;
        }
        #hero .btn-container, .lead {
            max-width: 1100px; /* Set a maximum width */
            width: 100%; /* Allow it to shrink */
            margin: 0 auto; /* Center the container */
        }
        #hero .btn {
            color: #fff;
            background: #31D5C8;
            padding: 2em 5em; /* Use relative units for responsive padding */
            border-radius: 5px;
            text-decoration: none;
            position: relative; /* For tooltip positioning */
            transition: background 0.3s; /* Smooth transition for background */
            font-family: 'Arial Black', sans-serif; /* Add your desired font */
            font-size: 1rem; /* Use a relative font size */
            display: inline-block; /* Ensure button takes only necessary space */
            min-width: 150px; /* Set a minimum width for consistency */
            text-align: center; /* Center text within the button */
        }

        /* Optional: Adjust button size for smaller screens */
        @media (max-width: 768px) {
            #hero .hero-bg {
                justify-content: center; /* Align items at the top */
                align-items: center; /* Align items to the left */
            }
            #hero .btn-container {
                margin: 0; /* Remove centering margin */
                padding: 10px 0; /* Add some vertical padding if needed */
                /* height: 70vh; */
            }
            #hero .btn {
                padding: 1.5em 1.5em; /* Adjust padding for smaller screens */
                font-size: 0.9rem; /* Slightly smaller font size */
            }
            #hero h1, .lead {
                display: none; /* Hide h1 and p elements on smaller screens */
            }
            #hero .hide {
                display: block;
                font-family: 'Arial Black', sans-serif;
                padding: 10px 0;
            }
            #hero .btn-container .btn:last-child {
                margin-bottom: 0; 
            }
        }

        #hero .btn:hover {
            background: #007cf8; /* Change to your desired hover color */
        }

        #hero .tooltip {
            visibility: hidden; /* Hide tooltip by default */
            width: 300px; /* Width of the tooltip */
            background-color: #333; /* Background color */
            color: #fff; /* Text color */
            text-align: center; /* Centered text */
            border-radius: 5px; /* Rounded corners */
            padding: 5px; /* Padding around text */
            position: absolute; /* Positioning */
            z-index: 1; /* Ensure the tooltip appears on top */
            bottom: 100%; /* Position above the button */
            left: 50%; /* Center the tooltip */
            transform: translateX(-50%); /* Center the tooltip horizontally */
            margin-bottom: 10px; /* Space between tooltip and button */
            opacity: 0; /* Make it invisible */
            transition: opacity 0.3s; /* Fade in effect */
        }

        #hero .btn:hover .tooltip {
            visibility: visible; /* Show tooltip on hover */
            opacity: 1; /* Make it visible */
        }

    </style>
</section>






<!-- /.section#banner -->
<section id="posts" class="bg-white">
         <br>
         <br>
         <!-- <br> -->
    <div class="container py-5">
    <h1 class="text-center" data-aos="fade-up">Penggiat Industri</h1>
        <div class="row">
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>NGO & Badan Ikhtisas</h5>
                                <p> Maklumat para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="#">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Institusi Pendidikan
                                </h5>
                                <p class="card-text">Maklumat para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.konsultasi') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </article>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Pembekal Landskap
                                </h5>
                                <p class="card-text">Maklumat para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.konsultasi') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </article>
            </div>
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Pertubuhan Antarabangsa</h5>
                                <p> Maklumat para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="#">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/maps-image.png') }}" class="img-fluid img-thumnail" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Perunding</h5>
                                <p> Maklumat para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="#">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <article>
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Kontraktor
                                </h5>
                                <p class="card-text">Maklumat para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.konsultasi') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </article>
            </div>
        </div>
    </div>
</section>
<section id="taman" class="bg-olive"><br>
         <br>
         <br>
    <div class="container py-5">
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
    </div>
</section>

<!-- <section id="daftar" class="bg-olive"><br>
         <br>
         <br>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-up">
                <h1>eMohon</h1>
                <p>
                    Permohonan projek boleh dibuat melalui modul eMohon. Daftar sekarang sebagai wakil PBT untuk proses lanjut.
                </p>
                <a class="btn bg-light" href="{{ route('website.activities.index') }}">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</section> -->


<!-- /.section#posts -->

<!-- <section id="page">
    <div class="container py-5">
        {!! website_carousel_article() !!}
    </div>
</section> -->

<style>

</style>
<section id="faq-area" class="bg-gray">
         <br>
         <br>
         <br>
    <div class="container py-5">

        <h1 class="text-center" data-aos="fade-up">Soalan Lazim</h1>
        <p class="text-center">
        </p>
        <hr class="mb-4">

        <div class="row" data-aos="fade-up" data-aos-delay="200">
            <div class="col-12 col-lg-10 offset-lg-1">
                {!! website_faqs('faqaccordion') !!}
            </div>
        </div>
    </div>
</section>

<section id="contact-area" class="bg-olive">
         <br>
         <br>
         <br>
    <div class="container py-5">
        <style>
            #ajaxfeedbacks .error {
                color: #dc3545 !important;
                font-weight: normal
            }
        </style>

        <h1 class="text-center" data-aos="fade-up">Aduan, Cadangan, Atau Pertanyaan</h1>
        <p class="text-center" data-aos="fade-up">Kami sentiasa berusaha untuk meningkatkan mutu perkhidmatan dari semasa ke semasa. Utarakan sebarang cadangan, aduan, atau pertanyaan anda kepada kami. Kami menghargai setiap maklumbalas yang kami terima.</p>
        <hr class="mb-4">
        <div class="row">
            <div class="col-12 col-lg-5 text-center text-lg-left" data-aos="fade-up">
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
