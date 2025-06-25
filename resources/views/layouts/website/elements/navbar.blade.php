<link rel="stylesheet" href="{{ asset('css/tree.css') }}">
<script>
    // document.documentElement.style.setProperty('--themeColor', '#84cd73');
</script>
<style>
    .navbar-nav li:hover > ul.dropdown-menu {
        display: block;
    }
    .dropdown-submenu {
        position:relative;
    }
    .dropdown-submenu>.dropdown-menu {
        top:0;
        left:100%;
        margin-top:-6px;
    }

    /* rotate caret on hover */
    .dropdown-menu > li > a:hover:after {
        text-decoration: underline;
        transform: rotate(-90deg);
    }
</style>
<style>
    .scroll-button {
        /* position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        border: none;
        color: white; */
        background-color: rgba(13, 50, 47, 0.65);
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition for color change */
        background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}");
        
    }

    .scroll-button.scrolled {
        /* background-color: rgba(82, 105, 218, 1); */
        background-color: rgb(25, 98, 92);
    }
    /* Media query for mobile screens */
    @media (max-width: 768px) {
        .scroll-button {
            background-color: rgb(13, 50, 47);
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        .scroll-button {
            background-color:rgb(13, 50, 47);
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .scroll-button.scrolled {
            background-color: rgb(25, 98, 92);
        }
    }
    .mib {
        background-color:rgb(25, 98, 92) !important;
        background-image: url("{{asset('storage/img/bg-pattern-leaves.png')}}");
        /* background-image: url("https://www.transparenttextures.com/patterns/flowers.png"); */
    }
</style>
<div id="main-navbar" class="row align-items-center scroll-button fixeded-top">
    <div class="col-12 order-lg-1 order-2 d-lg-none d-flex justify-content-center mt-2">
        {{-- {!! website_btn_social() !!} --}}
    </div>
    <div class="col-12 order-lg-2 order-3">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg   p-lg-0">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('images/logo2.png') }}" height="50" alt="">
            </a>
            {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"  style="background-color: #36458e;">
                <span class="navbar-toggler-icon"  style="color: white;"><i class="fas fa-bars"></i></span>
            </button> --}}
            <button id="customNavbarToggler" class="navbar-toggler" type="button" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" style="background-color: #31d5c8;">
                <span class="navbar-toggler-icon" style="color: white;"><i class="fas fa-bars"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <style>
                @media (max-width: 1275px) {
                    .mobile-login {
                        display: inline-block !important;
                    }
                }
                @media (min-width: 1275px) {
                    .mobile-login {
                        display: none !important;
                    }
                }
                </style>
                {!! website_navbar() !!}
                {!! website_nav_social() !!}
            </div>
        </nav>
        <!-- /.navbar -->
    </div>
</div>
<script>
    document.addEventListener('scroll', function() {
        const button = document.querySelector('.scroll-button');
        const scrollPosition = window.scrollY;

        if (scrollPosition > 100) { // Change 100 to the scroll position where you want the color to change
            button.classList.add('scrolled');
        } else {
            button.classList.remove('scrolled');
        }
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggler = document.getElementById('customNavbarToggler');
    const navbarCollapse = document.getElementById('navbarNavDropdown');

    toggler.addEventListener('click', function () {
      navbarCollapse.classList.toggle('show');
      // Optionally update the aria-expanded attribute
      const isExpanded = toggler.getAttribute('aria-expanded') === 'true';
      toggler.setAttribute('aria-expanded', !isExpanded);
    });
  });
</script>