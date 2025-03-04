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
        background-color: #36458e00;; /* Semi-transparent background */
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition for color change */
    }

    .scroll-button.scrolled {
        background-color: #71c55d; /* Solid color when scrolled */
    }
    /* Media query for mobile screens */
    @media (max-width: 768px) {
        .scroll-button {
            background-color: rgba(132, 205, 115, 1); /* Solid color for mobile */
        }
    }
</style>
<div id="main-navbar" class="row align-items-center scroll-button fixeded-top">
    <div class="col-12 order-lg-1 order-2 d-lg-none d-flex justify-content-center mt-2">
        {!! website_btn_social() !!}
    </div>
    <div class="col-12 order-lg-2 order-3">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg   p-lg-0">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('images/logo2.png') }}" height="70" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"  style="background-color: #36458e;">
                <span class="navbar-toggler-icon"  style="color: white;"><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
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