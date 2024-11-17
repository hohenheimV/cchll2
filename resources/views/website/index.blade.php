
@section('title','Laman Utama')
@section('insert_style')
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming Shop HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-lugx-gaming.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <!--

    TemplateMo 589 lugx gaming

    https://templatemo.com/tm-589-lugx-gaming

    -->
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{ url('/') }}" class="logo">
                            <img src="{{ asset('images/logo.png') }}" alt="" style="width: 158px;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="{{ url('/') }}" class="active">Home</a></li>
                            <li><a href="{{ url('shop') }}">Our Shop</a></li>
                            <li><a href="{{ url('product-details') }}">Product Details</a></li>
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                            <li><a href="{{ url('shop') }}">Our Shop</a></li>
                            <li><a href="{{ url('product-details') }}">Product Details</a></li>
                            <li><a href="{{ url('contact') }}">Contact Us</a></li>
                            <li><a href="#">Sign In</a></li>
                        </ul>   
                        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light p-lg-0">
                        <a class="navbar-brand" href="http://127.0.0.1:8000">
                            <img src="http://127.0.0.1:8000/images/logo.png" height="70" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav"><li class="nav-item active"><a class="nav-link text-uppercase text-nowrap" href="http://127.0.0.1:8000">Laman Utama  <span class="sr-only">(current)</span></a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenu53" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pengenalan eLANDSKAP</a><ul class="dropdown-menu rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenu53"><li><a class="dropdown-item text-nowrap" blank="_self" href="http://127.0.0.1:8000/articles/perutusan-ketua-pengarah">Perutusan Ketua Pengarah</a></li><li><a class="dropdown-item text-nowrap" blank="_blank" href="http://127.0.0.1:8000/pages/perutusan-ketua-pengarahp">Latar Belakang</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="#">Info eLANDSKAP</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="#">Penyelidikan eLANDSKAP</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="#">Bantuan</a></li></ul></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenu23" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hubungi Kami</a><ul class="dropdown-menu rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenu23"><li><a class="dropdown-item text-nowrap" blank="_self" href="http://127.0.0.1:8000/pages/hubungi-kami-lokasi">Taman Persekutuan Bukit Kiara</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="http://www.jln.gov.my/">Jabatan Landskap Negara</a></li></ul></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">TPBK</a><ul class="dropdown-menu rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenu1"><li><a class="dropdown-item text-nowrap" blank="_self" href="http://127.0.0.1:8000/pages/pengenalan-taman-persekutuan-bukit-kiara-kuala-lumpur">Pengenalan</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="http://127.0.0.1:8000/pages/konsep-pembangunan">Konsep Pembangunan</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="http://127.0.0.1:8000/pages/evolusi-kiara">Evolusi Kiara</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="http://127.0.0.1:8000/pages/pelan-konsep">Pelan Konsep</a></li><li><a class="dropdown-item text-nowrap" blank="_self" href="https://tpbk.jln.gov.my/vtour-bukit-kiara">V-TOUR Park</a></li></ul></li><li class="nav-item"><a class="nav-link text-uppercase text-nowrap" blank="_self" href="../peta/">Peta</a></li><li class="nav-item dropdown d-none d-lg-block"><a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenuSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-search"></i></a><ul class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-right rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenuSearch"><form class="" action="http://127.0.0.1:8000/search" method="GET" role="search"><div class="input-group"><input type="text" placeholder="Carian..." class="form-control" name="keyword"><div class="input-group-append"><button class="btn bg-olive" type="submit">Cari</button></div></div></form></ul></li></ul><form class="d-lg-none" action="http://127.0.0.1:8000/search" method="GET" role="search"><div class="input-group"><input type="text" placeholder="Carian..." class="form-control" name="keyword"><div class="input-group-append"><button class="btn bg-olive" type="submit">Cari</button></div></div></form>
                            <div class="d-none d-lg-block w-100"><ul class="nav navbar-nav navbar-right ml-auto d-flex justify-content-lg-end"><li class="nav-item"><a target="_blank" class="btn bg-olive btn-sm mr-1" href="https://twitter.com/LandskapNegara"><i class="fab fa-twitter"></i></a></li><li class="nav-item"><a target="_blank" class="btn bg-olive btn-sm mr-1" href="https://www.facebook.com/JabatanLandskapNegara/"><i class="fab fa-facebook-f"></i></a></li><li class="nav-item"><a target="_blank" class="btn bg-olive btn-sm mr-1" href="https://www.instagram.com/landskapnegara"><i class="fab fa-instagram"></i></a></li></ul></div>
                        </div>
                    </nav> -->
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>Welcome to lugx</h6>
                        <h2>BEST GAMING SITE EVER!</h2>
                        <p>LUGX Gaming is free Bootstrap 5 HTML CSS website template for your gaming websites. You can download and use this layout for commercial purposes. Please tell your friends about TemplateMo.</p>
                        <div class="search-input">
                            <form id="search" action="#">
                                <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                                <button role="button">Search Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="right-image">
                        <img src="{{ asset('images/banner-image.jpg') }}" alt="">
                        <span class="price">$22</span>
                        <span class="offer">-40%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('images/featured-01.png') }}" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Free Storage</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('images/featured-02.png') }}" alt="" style="max-width: 44px;">
                            </div>
                            <h4>User More</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('images/featured-03.png') }}" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Reply Ready</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('images/featured-04.png') }}" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Easy Layout</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section trending">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>Trending</h6>
                        <h2>Trending Games</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="{{ url('shop') }}">View All</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/trending-01.jpg') }}" alt=""></a>
                            <span class="price"><em>$28</em>$20</span>
                        </div>
                        <div class="down-content">
                            <span class="category">Action</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/trending-02.jpg') }}" alt=""></a>
                            <span class="price">$44</span>
                        </div>
                        <div class="down-content">
                            <span class="category">Action</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/trending-03.jpg') }}" alt=""></a>
                            <span class="price"><em>$64</em>$44</span>
                        </div>
                        <div class="down-content">
                            <span class="category">Action</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/trending-04.jpg') }}" alt=""></a>
                            <span class="price">$32</span>
                        </div>
                        <div class="down-content">
                            <span class="category">Action</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section most-played">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>TOP GAMES</h6>
                        <h2>Most Played</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="{{ url('shop') }}">View All</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/top-game-01.jpg') }}" alt=""></a>
                        </div>
                        <div class="down-content">
                            <span class="category">Adventure</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/top-game-02.jpg') }}" alt=""></a>
                        </div>
                        <div class="down-content">
                            <span class="category">Adventure</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/top-game-03.jpg') }}" alt=""></a>
                        </div>
                        <div class="down-content">
                            <span class="category">Adventure</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/top-game-04.jpg') }}" alt=""></a>
                        </div>
                        <div class="down-content">
                            <span class="category">Adventure</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/top-game-05.jpg') }}" alt=""></a>
                        </div>
                        <div class="down-content">
                            <span class="category">Adventure</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/top-game-06.jpg') }}" alt=""></a>
                        </div>
                        <div class="down-content">
                            <span class="category">Adventure</span>
                            <h4>Assasin Creed</h4>
                            <a href="{{ url('product-details') }}">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Categories</h6>
                        <h2>Top Categories</h2>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/categories-01.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/categories-05.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/categories-03.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/categories-04.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-sm-6 col-xs-12">
                    <div class="item">
                        <h4>Action</h4>
                        <div class="thumb">
                            <a href="{{ url('product-details') }}"><img src="{{ asset('images/categories-05.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <div class="section cta">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="shop">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>Our Shop</h6>
                                    <h2>Go Pre-Order Buy & Get Best <em>Prices</em> For You!</h2>
                                </div>
                                <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
                                <div class="main-button">
                                    <a href="{{ url('shop') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-2 align-self-end">
                    <div class="subscribe">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>NEWSLETTER</h6>
                                    <h2>Get Up To $100 Off Just Buy <em>Subscribe</em> Newsletter!</h2>
                                </div>
                                <div class="search-input">
                                    <form id="subscribe" action="#">
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your email...">
                                        <button type="submit">Subscribe Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="col-lg-12">
                <p>Copyright © 2048 LUGX Gaming Company. All rights reserved. &nbsp;&nbsp; <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: TemplateMo</a></p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/isotope.min.js') }}"></script>
    <script src="{{ asset('js/owl-carousel.js') }}"></script>
    <script src="{{ asset('js/counter.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>
</html>
