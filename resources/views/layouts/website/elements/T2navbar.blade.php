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
        background-color: rgba(82, 105, 218, 1); /* Solid color when scrolled */
    }
    /* Media query for mobile screens */
    @media (max-width: 768px) {
        .scroll-button {
            background-color: rgba(82, 105, 218, 1); /* Solid color for mobile */
        }
    }
</style>
<div id="main-navbar" class="row align-items-center scroll-button fixeded-top">
   <!--  <div class="col-12 order-lg-1 order-2 d-lg-none d-flex justify-content-center mt-2">
        {!! website_btn_social() !!}
    </div> -->
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
                <ul class="navbar-nav">
                    <li class="nav-item active">
                    <a
                        class="nav-link text-uppercase text-nowrap"
                        href="http://127.0.0.1:8000"
                        >Laman Utama <span class="sr-only">(current)</span></a
                    >
                    </li>
                    <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle text-uppercase text-nowrap"
                        href="#"
                        id="navbarDropdownMenu53"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >Modul eLANDSKAP</a
                    >
                    <ul
                        class="dropdown-menu rounded-0 mt-lg-0"
                        aria-labelledby="navbarDropdownMenu53"
                    >
                        
                        @php
                            $array = ['eLIND', 'eMohon', 'ePALM', 'eREAD', 'ePACT', 'ePIL', 'eKiara', 'MIB', 'MyUjana'];
                        @endphp
                        @foreach ($array as $arrayVal)
                            <li>
                                <a class="dropdown-item text-nowrap" target="_self" href="#">
                                    {{ $arrayVal }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    </li>
                    <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle text-uppercase text-nowrap"
                        href="#"
                        id="navbarDropdownMenu53"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >Pengenalan eLANDSKAP</a
                    >
                    <ul
                        class="dropdown-menu rounded-0 mt-lg-0"
                        aria-labelledby="navbarDropdownMenu53"
                    >
                        <li class="dropdown-submenu">
                        <a
                            class="dropdown-item dropdown-toggle"
                            blank="_self"
                            href="http://127.0.0.1:8000/articles/perutusan-ketua-pengarah"
                            >Perutusan Ketua Pengarah</a
                        >
                        <ul class="dropdown-menu rounded-0 mt-lg-0">
                            <li class="dropdown-submenu">
                            <a
                                class="dropdown-item text-nowrap"
                                blank="_blank"
                                href="http://127.0.0.1:8000/pages/perutusan-ketua-pengarahp"
                                >Latar Belakang</a
                            >
                            </li>
                            <li class="dropdown-submenu">
                            <a class="dropdown-item text-nowrap" blank="_self" href="#"
                                >Info eLANDSKAP</a
                            >
                            </li>
                        </ul>
                        </li>
                        <li>
                        <a class="dropdown-item text-nowrap" blank="_self" href="#"
                            >Penyelidikan eLANDSKAP</a
                        >
                        </li>
                        <li>
                        <a class="dropdown-item text-nowrap" blank="_self" href="#"
                            >Bantuan</a
                        >
                        </li>
                    </ul>
                    </li>
                    <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle text-uppercase text-nowrap"
                        href="#"
                        id="navbarDropdownMenu23"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >Hubungi Kami</a
                    >
                    <ul
                        class="dropdown-menu rounded-0 mt-lg-0"
                        aria-labelledby="navbarDropdownMenu23"
                    >
                        <li>
                        <a
                            class="dropdown-item text-nowrap"
                            blank="_self"
                            href="http://127.0.0.1:8000/pages/hubungi-kami-lokasi"
                            >Taman Persekutuan Bukit Kiara</a
                        >
                        </li>
                        <li>
                        <a
                            class="dropdown-item text-nowrap"
                            blank="_self"
                            href="http://www.jln.gov.my/"
                            >Jabatan Landskap Negara</a
                        >
                        </li>
                    </ul>
                    </li>
                    <li class="nav-item dropdown d-none d-lg-block">
                    <a
                        class="nav-link dropdown-toggle text-uppercase text-nowrap"
                        href="#"
                        id="navbarDropdownMenuSearch"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        ><i class="fas fa-search"></i
                    ></a>
                    <ul
                        class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-right rounded-0 mt-lg-0"
                        aria-labelledby="navbarDropdownMenuSearch"
                    >
                        <form
                        class=""
                        action="http://127.0.0.1:8000/search"
                        method="GET"
                        role="search"
                        >
                        <div class="input-group">
                            <input
                            type="text"
                            placeholder="Carian..."
                            class="form-control"
                            name="keyword"
                            />
                            <div class="input-group-append">
                            <button class="btn bg-olive" type="submit">Cari</button>
                            </div>
                        </div>
                        </form>
                    </ul>
                    </li>
                </ul>
                <form
                    class="d-lg-none"
                    action="http://127.0.0.1:8000/search"
                    method="GET"
                    role="search"
                >
                    <div class="input-group">
                    <input
                        type="text"
                        placeholder="Carian..."
                        class="form-control"
                        name="keyword"
                    />
                    <div class="input-group-append">
                        <button class="btn bg-olive" type="submit">Cari</button>
                    </div>
                    </div>
                </form>
                <div class="d-none d-lg-block w-100">
                    <ul
                    class="nav navbar-nav navbar-right ml-auto d-flex justify-content-lg-end"
                    >
                    <li class="nav-item">
                        <a
                        target="_blank"
                        class="btn bg-olive btn-sm mr-1"
                        href="https://twitter.com/LandskapNegara"
                        ><i class="fab fa-twitter"></i
                        ></a>
                    </li>
                    <li class="nav-item">
                        <a
                        target="_blank"
                        class="btn bg-olive btn-sm mr-1"
                        href="https://www.facebook.com/JabatanLandskapNegara/"
                        ><i class="fab fa-facebook-f"></i
                        ></a>
                    </li>
                    <li class="nav-item">
                        <a
                        target="_blank"
                        class="btn bg-olive btn-sm mr-1"
                        href="https://www.instagram.com/landskapnegara"
                        ><i class="fab fa-instagram"></i
                        ></a>
                    </li>
                    </ul>
                </div>
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