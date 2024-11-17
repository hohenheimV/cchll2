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
        /* Hero Section */
        #hero {
            height: 100vh;
        position: relative;
        color: #fff;
        overflow: hidden;
        background-image: url("{{ asset('images/banner-bg.png') }}");
        background-size: cover; /* Ensures the container is fully covered by the image */
        background-repeat: no-repeat; /* Prevents repeating the image */
        background-position: center; /* Centers the image within the container */
        }

        #hero .particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }

        #hero .content {
            position: relative;
            z-index: 2;
            text-align: center;
            /* padding-top: 40%; */
            margin-left: auto;
            margin-right: auto;
            width: 80%;
        }

        #hero h1 {
            font-size: 3em;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            animation: fadeIn 2s ease-in-out;
        }

        #hero .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        #hero .btn-container .btn {
            font-size: 1em;
            color: #fff;
            background: #71c55d;
            padding: 10px 20px;
            /* border-radius: 50px; */
            text-decoration: none;
            transition: background 0.3s ease;
            width: 100px;
            height: 50px;
        }

        #hero .btn-container .btn:hover {
            background: #d43f57;
        }
    </style>
    <style>
        /* ---- reset ---- */ canvas{ display: block; vertical-align: bottom; } /* ---- particles.js container ---- */ #particles-js{ position:absolute; width: 100%; height: 100%;  background-repeat: no-repeat; background-size: cover; background-position: 50% 50%; } /* ---- stats.js ---- */ .count-particles{ background: #000022; position: absolute; top: 48px; left: 0; width: 80px; color: #13E8E9; font-size: .8em; text-align: left; text-indent: 4px; line-height: 14px; padding-bottom: 2px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; } .js-count-particles{ font-size: 1.1em; } #stats, .count-particles{ -webkit-user-select: none; margin-top: 5px; margin-left: 5px; } #stats{ border-radius: 3px 3px 0 0; overflow: hidden; } .count-particles{ border-radius: 0 0 3px 3px; }
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
  <section id="hero">
        
        <!-- particles.js container -->
        <br>
        <br>
        <br>
        <br> 
        <!-- <div id="particles-js"></div>  -->
        <!-- stats - count particles -->  
        <!-- particles.js lib - https://github.com/VincentGarreau/particles.js --> 
        <!-- <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>  -->
        <script src="{{ asset('js/particles.min.js') }}"></script>
        <!-- stats.js lib --> 
        <!-- <script src="http://threejs.org/examples/js/libs/stats.min.js"></script> -->
        <script src="{{ asset('js/stats.min.js') }}"></script>
        <script>
            particlesJS("particles-js", {"particles":{"number":{"value":200,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":1,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
        </script>
        <!-- <div id="particles-js" class="particles-js"></div> -->
         <br>
         <br>
         <br>
         <div class="content" >
            <div class="row" >
                <div class="col-lg-7" >
                    <div>
                    <h6 style="text-align: left;">Selamat Datang ke</h6>
                    <h2 style="text-align: left;">PUSAT IDENTITI DATA LANDSKAP!</h2>
                    <p style="text-align: left;">Sistem Pengurusan Maklumat Landskap (eLANDSKAP) yang dibangunkan akan dijadikan sebagai satu sistem pengurusan maklumat landskap yang komprehensif dan mudah dicapai, untuk panduan serta rujukan semua pengguna.<!--  Ianya akan merupakan satu sistem bersepadu berkenaan pengurusan maklumat landskap secara web based, yang merangkumi kesemua modul perancangan, pembangunan dan pengurusan landskap di seluruh negara. --></p>

                    </div>
                    <div class="btn-container">
                        <a href="#taman" class="btn">eLIND</a>
                        <a href="#daftar" class="btn">eMohon</a>
                        <a href="#posts" class="btn">ePALM</a>
                        <a href="#faq-area" class="btn">eLASC</a>
                    </div>
                    <div class="btn-container">
                        <a href="#contact-area" class="btn">ePACT</a>
                        <a href="#taman" class="btn">eLAD</a>
                        <a href="#daftar" class="btn">eLAPS</a>
                        <a href="#posts" class="btn">ePIL</a>
                    </div>
                    <div class="btn-container">
                        <a href="#taman" class="btn" style="width: 210px;height: 50px;border-radius: 5px;">Entiti Landskap</a>
                        <a href="#daftar" class="btn" style="width: 210px;height: 50px;border-radius: 5px;">Kempen Tanam Pokok</a>
                    </div>
                    <div class="btn-container">
                        <a href="#taman" class="btn" style="width: 210px;height: 50px;border-radius: 5px;">MIB</a>
                        <a href="#daftar" class="btn" style="width: 210px;height: 50px;border-radius: 5px;">eKIARA</a>
                    </div>
                </div>
                <div class="col-sm-2">
                    <!-- <img src="{{ asset('images/hero-img.png') }}" alt="" width="200" > -->
                </div>
                <div class="col-sm" >
                    <img src="{{ asset('images/2.jpeg') }}" alt="" style="box-sizing: border-box; vertical-align: middle; overflow: hidden; width: 100%; height: 100%; border-radius: 25px; margin-left: auto;">
                </div>

            </div>
    
        </div>
    </section>
<!-- Hero Section -->


<!-- /.section#banner -->

<section id="taman" class="bg-light"><br>
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
                    <li><i class="icofont-check"></i> Zon Rekreasi Keluarga</li>
                    <li><i class="icofont-check"></i> Zon Tropika Khatulistiwa Asia</li>
                    <li><i class="icofont-check"></i> Zon Arboretum Bernilai Tinggi</li>
                    <li><i class="icofont-check"></i> Zon Riparian / Konservasi Hidrologi</li>
                    <li><i class="icofont-check"></i> Zon Biodiversiti (Forest Restoration)</li>
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

<section id="daftar" class="bg-olive"><br>
         <br>
         <br>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-up">
                <h1>eMohon</h1>
                <p>
                    Permohonan Pelan Induk Landskap boleh dibuat melalui modul eMohon. Daftar sekarang sebagai wakil PBT untuk proses lanjut.
                </p>
                <a class="btn bg-light" href="{{ route('website.activities.index') }}">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</section>

<section id="posts" class="bg-white">
         <br>
         <br>
         <br>
    <div class="container py-5">
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
                                <h5>eMap JLN</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di seluruh taman pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="#">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <section id="posts">
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Penggiat Industri
                                </h5>
                                <p class="card-text">Senarai para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.konsultasi') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </section>
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
                                <h5>eMap JLN</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di seluruh taman pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="#">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <section id="posts">
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Penggiat Industri
                                </h5>
                                <p class="card-text">Senarai para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.konsultasi') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </section>
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
                                <h5>eMap JLN</h5>
                                <p> Peta interaktif beserta maklumat mengenai aset lembut dan kejur yang terdapat di seluruh taman pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="#">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-lg-6 col-12">
                <section id="posts">
                    <div class="row m-3">
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="img w-100">
                                <img src="{{ asset('img/engagement.png') }}" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                        <div class="col-md-9" data-aos="fade-up">
                            <div class="card-body p-0">
                                <h5>Penggiat Industri
                                </h5>
                                <p class="card-text">Senarai para Penggiat Industri yang terlibat secara langsung dan tidak langsung dengan taman-taman dibawah pantauan JLN.</p>
                                <a class="btn bg-olive mb-3" href="{{ route('website.konsultasi') }}">Maklumat Lanjut</a>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</section>
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
