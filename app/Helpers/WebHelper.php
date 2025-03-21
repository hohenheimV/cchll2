<?php

use App\Model\Home;
use App\Model\Article;
use App\Model\Page;
use App\Model\Category;
use App\Model\Faq;
use App\Model\Menu;
use App\Model\Slider;
use App\Model\ePALM;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('human_file_size')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function human_file_size($bytes, $decimals = 2)
    {
        $sz = 'BKMGTPE';
        $factor = (int) floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
    }
}

if (!function_exists('in_arrayi')) {

    /**
     * Checks if a value exists in an array in a case-insensitive manner
     *
     * @param mixed $needle
     * The searched value
     *
     * @param $haystack
     * The array
     *
     * @param bool $strict [optional]
     * If set to true type of needle will also be matched
     *
     * @return bool true if needle is found in the array,
     * false otherwise
     */
    function in_arrayi($needle, $haystack, $strict = false)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack), $strict);
    }

    if (!function_exists('app_name')) {
        /**
         * Checks application name
         *
         * @return string a string in human readable format
         *
         */
        function app_name()
        {
            $menu = Menu::count();
            return "Menu : $menu";
        }
    }

    if (!function_exists('website_sidebar_search')) { //website.search
        function website_sidebar_search()
        {

            $html = '<h5 class="card-header">Carian</h5>';
            $html .= '<div class="card-body">';
            $html .= website_search_form();
            $html .= '</div>';
            return $html;
        }
    }

    if (!function_exists('website_search_form')) {
        function website_search_form($class = null)
        {
            $html = '<form class="' . $class . '" action="' . route('website.search') . '" method="GET" role="search">';
            $html .= '<div class="input-group">';
            $html .= Form::text('keyword', request('keyword'), ['type' => 'search', 'placeholder' => 'Carian...', 'class' => 'form-control']);
            $html .= '<div class="input-group-append">';
            $html .= '<button class="btn bg-olive" type="submit">Cari</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</form>';
            return $html;
        }
    }

    if (!function_exists('website_sidebar_category')) {

        function website_sidebar_category()
        {
            # code...
            $categories = Category::notmeta()
                ->whereHas('articles', function ($query) {
                    $query->where('web_articles.type', 'posts');
                })->get();
            //dd($categories);
            $html = '<ul class="list-unstyled mb-0 d-flex flex-row flex-wrap">';
            foreach ($categories as $category) {
                $html .= '<li class="w-50"><a href="' . route('website.categories', ['slug' => $category->slug]) . '">' . $category->name . '</a></li>';
            }
            return $html;
        }
    }

    if (!function_exists('website_slider')) {

        function website_slider($carouselId)
        {
            $carousel = config('website.carousel');

            $sliders = Slider::active()->get();
            
            /* $ePALM = ePALM::select('nama_taman', 'nama_pbt', 'is_komponen', 'gambar_taman')->where('status', 'approved')->whereNotNull('gambar_taman')->get();
            foreach ($ePALM as $item) {
                if ($item->nama_pbt == "Landskap Perbandaran") {
                    $ePALM_komponen = ePALM::where('id_taman', $item->is_komponen)->first();
                    $item->nama_taman = str_replace(' ', '_', $ePALM_komponen->nama_taman)."/".str_replace(' ', '_', $item->nama_taman);
                    $item->nama_pbt = $ePALM_komponen->nama_pbt;
                    $item->gambar_taman = str_replace('gambar_input_modal_', 'Xgambar_input_modal_', $item->gambar_taman);
                }
            }
            // dd($ePALM);
            $count = count($ePALM);
            $html = '<div class="carousel-inner">';
            foreach ($ePALM as $key => $slider) {
                // dump($slider);
                
                if(isset($slider->gambar_taman)){
                    $folderName = str_replace(' ', '_', $slider->nama_taman);
                    $gambar_tamanData = json_decode($slider->gambar_taman, true);

                    $Xgambar_input_modal_1 = isset($gambar_tamanData['Xgambar_input_modal_1']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_1'] : null;
                    $Xgambar_input_modal_2 = isset($gambar_tamanData['Xgambar_input_modal_2']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_2'] : null;
                    $Xgambar_input_modal_3 = isset($gambar_tamanData['Xgambar_input_modal_3']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_3'] : null;
                    $Xgambar_input_modal_4 = isset($gambar_tamanData['Xgambar_input_modal_4']) ? $folderName.'/'.$gambar_tamanData['Xgambar_input_modal_4'] : null;
                    //dd($gambar_tamanData);
                }

                $active = ($key == 0 ? 'active' : '');
                for ($i = 1; $i <= 4; $i++) {
                    $active = ($i == 1) ? 'active' : ''; // Add the 'active' class to the first item
                    // Dynamically create the variable name
                    $Xgambar_input_modal = 'Xgambar_input_modal_' . $i;

                    // Make sure the variable exists before using it
                    if (isset($$Xgambar_input_modal)) {
                        $imagePath = $$Xgambar_input_modal; // Access the value of the dynamic variable

                        // Construct the full path to the image
                        $filePath = public_path('storage/uploads/ePALM/' . $imagePath);

                        // Check if the file exists before adding to HTML
                        if (file_exists($filePath)) {
                            // Build the HTML structure only if the file exists
                            $html .= '<div class="carousel-item ' . $active . '">';
                            $html .= '<div class="embed-responsive embed-responsive-16by9">';
                            $html .= '<img src="' . asset('storage/uploads/ePALM/' . $imagePath) . '" class="card-img-top embed-responsive-item" alt="Slider">';

                            $html .= '<div class="carousel-caption d-none d-md-block" style="top: 50%;">';
                            $html .= '</div>';

                            $html .= '</div>';
                            $html .= '</div>';
                        } else {
                            // File does not exist, skip this iteration
                            continue;
                        }
                    }
                }
            } */
            
            $count = count($sliders);
            $html = '<div class="carousel-inner">';
            foreach ($sliders as $key => $slider) {
                // $active = ($key == 0 ? 'active' : '');
                // $html .= '<div class="carousel-item ' . $active . '">';
                // $html .= '<div class="embed-responsive embed-responsive-16by9">';
                // // $html .= '<img src="' . url(str_replace('tpbk.jln.gov.my', '127.0.0.1:8000', $slider->slider_image)) . '" class="card-img-top embed-responsive-item" alt="Slider ' . $slider->title . '">';
                // $html .= '<img src="' . url(str_replace('https', 'http', str_replace('tpbk.jln.gov.my', '127.0.0.1:8000', str_replace('//storage', '/storage', $slider->slider_image)))) . '" class="card-img-top embed-responsive-item" alt="Slider ' . $slider->title . '">';
                // // dump(url(str_replace('https', 'http', str_replace('tpbk.jln.gov.my', '127.0.0.1:8000', str_replace('//storage', '/storage', $slider->slider_image)))));

                $active = ($key == 0 ? 'active' : '');
                $html .= '<div class="carousel-item ' . $active . '">';
                $html .= '<div class="embed-responsive embed-responsive-16by9">';
                $html .= '<img src="' . url(str_replace('10.28.203.150', '192.168.0.120', $slider->slider_image)) . '" class="card-img-top embed-responsive-item" alt="Slider ' . $slider->title . '">';

                $html .= '<div class="carousel-caption d-none d-md-block" style="top: 50%;">';

                if ($slider->title) {
                    $html .= '<h1>' . $slider->title . '</h1>';
                }
                if ($slider->subtitle) {
                    $html .= '<h5>' . $slider->subtitle . '</h5>';
                }

                if ($slider->url) {
                    $html .= '<a target="' . $slider->target . '" href="' . $slider->url . '" class="btn bg-olive">Maklumat Lanjut</a>';
                }
                $html .= '</div>';

                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';

            if ($carousel['indicators'] && $count > 1) {

                $html .= '<ol class="carousel-indicators">';
                foreach ($sliders as $slider) {
                    $active = ($slider->id == 1 ? 'active' : '');
                    $html .= '<li data-target="#' . $carouselId . '" data-slide-to="0" class="' . $active . '"></li>';
                }
                $html .= '</ol>';
            }

            if ($carousel['control'] && $count > 1) {
                $html .= '<a class="carousel-control-prev" href="#' . $carouselId . '" role="button" data-slide="prev">';
                $html .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                $html .= '<span class="sr-only">Previous</span>';
                $html .= '</a>';
                $html .= '<a class="carousel-control-next" href="#' . $carouselId . '" role="button" data-slide="next">';
                $html .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                $html .= '<span class="sr-only">Next</span>';
                $html .= '</a>';
            }

            return $html;
        }
    }

    if (!function_exists('website_navbar')) {

        function website_navbar()
        {

            $parentMenus = Menu::with('children.grandchildren', 'pages', 'articles')->whereNull('parent_id')
                ->orderBy(DB::raw('(web_menu.ordering is null),  web_menu.ordering'), 'ASC')->get();

            $html = '<ul class="navbar-nav">';
            $html .= '<li class="nav-item active"><a class="nav-link text-uppercase text-nowrap" href="' . route('welcome') . '">Laman Utama  <span class="sr-only">(current)</span></a></li>';
            foreach ($parentMenus as $menu) :

                if (count($menu->children)) : //SubMenu
                    $html .= '<li class="nav-item dropdown">';
                    $html .= '<a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenu' . $menu->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $menu->title . '</a>';
                    $html .= '<ul class="dropdown-menu rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenu' . $menu->id . '">';
                    foreach ($menu->children as $children) :
                        if (count($children->grandchildren)) : //SubMenu
                            $html .= '<li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" blank="' . $children->target . '" href="' . $children->link . '">' . $children->title . '</a>';
                            $html .= '<ul class="dropdown-menu rounded-0 mt-lg-0">';
                            foreach ($children->grandchildren as $grandchildren) :
                                $html .= '<li class="dropdown-submenu"><a class="dropdown-item text-nowrap" blank="' . $grandchildren->target . '" href="' . $grandchildren->link . '">' . $grandchildren->title . '</a></li>';
                            endforeach;
                            $html .= '</ul>';
                            $html .= '</li>';
                        else :
                            $html .= '<li><a class="dropdown-item text-nowrap" blank="' . $children->target . '" href="' . $children->link . '">' . $children->title . '</a></li>';
                        endif;
                    endforeach;
                    $html .= '</ul>';
                    $html .= '</li>';
                else :
                    $html .= '<li class="nav-item"><a class="nav-link text-uppercase text-nowrap" blank="' . $menu->target . '" href="' . $menu->link . '">' . $menu->title . '</a></li>';
                endif;
            endforeach;
            $html .= '<li class="nav-item dropdown d-none d-lg-block">';

            $html .= '<a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenuSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $html .= '<i class="fas fa-search"></i></a>';
            $html .= '<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-right rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenuSearch">';
            $html .= website_search_form();
            $html .= '</ul>';

            $html .= '</li>';
            $html .= '</ul>';
            $html .= website_search_form('d-lg-none');
            return $html;
        }
    }
    if (!function_exists('website_navbar2')) {

        function website_navbar2()
        {

            $parentMenus = Menu::with('children.grandchildren', 'pages', 'articles')->whereNull('parent_id')
                ->orderBy(DB::raw('(web_menu.ordering is null),  web_menu.ordering'), 'ASC')->get();

            $html = '';
            $html .= '<li><a href="' . route('welcome') . '" >Home</a></li>';
            // dd($parentMenus);
            foreach ($parentMenus as $menu) :

                if (count($menu->children)) : //SubMenu
                    // $html .= '<li class="nav-item dropdown">';
                    // $html .= '<a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenu' . $menu->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $menu->title . '</a>';
                    // $html .= '<ul class="dropdown-menu rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenu' . $menu->id . '">';
                    // foreach ($menu->children as $children) :
                    //     if (count($children->grandchildren)) : //SubMenu
                    //         $html .= '<li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" blank="' . $children->target . '" href="' . $children->link . '">' . $children->title . '</a>';
                    //         $html .= '<ul class="dropdown-menu rounded-0 mt-lg-0">';
                    //         foreach ($children->grandchildren as $grandchildren) :
                    //             $html .= '<li class="dropdown-submenu"><a class="dropdown-item text-nowrap" blank="' . $grandchildren->target . '" href="' . $grandchildren->link . '">' . $grandchildren->title . '</a></li>';
                    //         endforeach;
                    //         $html .= '</ul>';
                    //         $html .= '</li>';
                    //     else :
                    //         $html .= '<li><a class="dropdown-item text-nowrap" blank="' . $children->target . '" href="' . $children->link . '">' . $children->title . '</a></li>';
                    //     endif;
                    // endforeach;
                    // $html .= '</ul>';
                    // $html .= '</li>';
                    
                    $html .= '<li class="dropdown">';
                    $html .= '<a href="#" id="navbarDropdownMenu' . $menu->id . '" ><span>Layer 1</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>';
                    $html .= '<ul aria-labelledby="navbarDropdownMenu' . $menu->id . '">';
                    foreach ($menu->children as $children) :
                        if (count($children->grandchildren)) : //SubMenu
                            $html .= '<li class="dropdown"><a blank="' . $children->target . '" href="' . $children->link . '"><span>Perutusan Ketua</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>';
                            $html .= '<ul>';
                            foreach ($children->grandchildren as $grandchildren) :
                                $html .= '<li><a blank="' . $grandchildren->target . '" href="' . $grandchildren->link . '">' . $grandchildren->title . '</a></li>';
                            endforeach;
                            $html .= '</ul>';
                            $html .= '</li>';
                    //         $html .= '<li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    //     <ul>
                    //     <li><a href="#">Deep Dropdown 1</a></li>
                    //     <li><a href="#">Deep Dropdown 2</a></li>
                    //     <li><a href="#">Deep Dropdown 3</a></li>
                    //     <li><a href="#">Deep Dropdown 4</a></li>
                    //     <li><a href="#">Deep Dropdown 5</a></li>
                    //     </ul>
                    // </li>';
                        else :
                            $html .= '<li><a blank="' . $children->target . '" href="' . $children->link . '">Layer 2</a></li>';
                            // $html .= '<li><a href="#">Deep Dropdown 1</a></li>';
                        endif;
                    endforeach;
                    $html .= '</ul>';
                    $html .= '</li>';
                    // <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    //     <ul>
                    //     <li><a href="#">Dropdown 1</a></li>
                    //     <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    //         <ul>
                    //         <li><a href="#">Deep Dropdown 1</a></li>
                    //         <li><a href="#">Deep Dropdown 2</a></li>
                    //         <li><a href="#">Deep Dropdown 3</a></li>
                    //         <li><a href="#">Deep Dropdown 4</a></li>
                    //         <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    //                 <ul>
                    //                 <li><a href="#">Deep Dropdown 1</a></li>
                    //                 <li><a href="#">Deep Dropdown 2</a></li>
                    //                 <li><a href="#">Deep Dropdown 3</a></li>
                    //                 <li><a href="#">Deep Dropdown 4</a></li>
                    //                 <li><a href="#">Deep Dropdown 5</a></li>
                    //                 </ul>
                    //             </li>
                    //         </ul>
                    //     </li>
                    //     <li><a href="#">Dropdown 2</a></li>
                    //     <li><a href="#">Dropdown 3</a></li>
                    //     <li><a href="#">Dropdown 4</a></li>
                    //     </ul>
                    // </li>
                else :
                    // $html .= '<li class="nav-item"><a class="nav-link text-uppercase text-nowrap" blank="' . $menu->target . '" href="' . $menu->link . '">' . $menu->title . '</a></li>';
                    $html .= '<li><a blank="' . $menu->target . '" href="' . $menu->link . '">' . $menu->title . '</a></li>';
                endif;
            endforeach;
            $html .= '<li class="nav-item dropdown d-none d-lg-block">';

            $html .= '<a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenuSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $html .= '<i class="fas fa-search"></i></a>';
            $html .= '<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-right rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenuSearch">';
            $html .= website_search_form();
            $html .= '</ul>';

            $html .= '</li>';
            // $html .= '</ul>';
            $html .= website_search_form('d-lg-none');
            return $html;
        }
    }
    if (!function_exists('website_navbars')) {

        function website_navbars()
        {

            $parentMenus = Menu::with('children.grandchildren', 'pages', 'articles')->whereNull('parent_id')
                ->orderBy(DB::raw('(web_menu.ordering is null),  web_menu.ordering'), 'ASC')->get();

            $html = '<ul class="navbar-nav">';
            $html .= '<li class="nav-item active"><a class="nav-link text-uppercase text-nowrap" href="' . route('welcome') . '">Laman Utama  <span class="sr-only">(current)</span></a></li>';
            dd($parentMenus);
            foreach ($parentMenus as $menu) :

                if (count($menu->children)) : //SubMenu
                    $html .= '<li class="nav-item dropdown">';
                    $html .= '<a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenu' . $menu->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $menu->title . '</a>';
                    $html .= '<ul class="dropdown-menu rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenu' . $menu->id . '">';
                    foreach ($menu->children as $children) :
                        if (count($children->grandchildren)) : //SubMenu
                            $html .= '<li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" blank="' . $children->target . '" href="' . $children->link . '">' . $children->title . '</a>';
                            $html .= '<ul class="dropdown-menu rounded-0 mt-lg-0">';
                            foreach ($children->grandchildren as $grandchildren) :
                                $html .= '<li class="dropdown-submenu"><a class="dropdown-item text-nowrap" blank="' . $grandchildren->target . '" href="' . $grandchildren->link . '">' . $grandchildren->title . '</a></li>';
                            endforeach;
                            $html .= '</ul>';
                            $html .= '</li>';
                        else :
                            $html .= '<li><a class="dropdown-item text-nowrap" blank="' . $children->target . '" href="' . $children->link . '">' . $children->title . '</a></li>';
                        endif;
                    endforeach;
                    $html .= '</ul>';
                    $html .= '</li>';
                else :
                    $html .= '<li class="nav-item"><a class="nav-link text-uppercase text-nowrap" blank="' . $menu->target . '" href="' . $menu->link . '">' . $menu->title . '</a></li>';
                endif;
            endforeach;
            $html .= '<li class="nav-item dropdown d-none d-lg-block">';

            $html .= '<a class="nav-link dropdown-toggle text-uppercase text-nowrap" href="#" id="navbarDropdownMenuSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $html .= '<i class="fas fa-search"></i></a>';
            $html .= '<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-right rounded-0 mt-lg-0" aria-labelledby="navbarDropdownMenuSearch">';
            $html .= website_search_form();
            $html .= '</ul>';

            $html .= '</li>';
            $html .= '</ul>';
            $html .= website_search_form('d-lg-none');
            return $html;
        }
    }

    if (!function_exists('website_btn_social')) {

        function website_btn_social()
        {
            $socials = config('website.social');
            $html = '<div class="btn-toolbar" role="toolbar" aria-label="website btn social">';
            foreach ($socials as $social) {
                if ($social['link']) {
                    $html .= '<a target="_blank" class="btn bg-olive btn-sm mr-1" href="' . $social['link'] . '"><i class="' . $social['icon'] . '"></i></a>';
                }
            }
            $html .= '</div>';
            return $html;
        }
    }

    if (!function_exists('website_nav_social')) {

        function website_nav_social()
        {
            $socials = config('website.social');
            //dd($socials);
            $html = '<div class="d-none d-lg-block w-100">';
            $html .= '<ul class="nav navbar-nav navbar-right ml-auto d-flex justify-content-lg-end">';
            foreach ($socials as $social) {
                if ($social['link']) {
                    $html .= '<li class="nav-item"><a target="_blank" class="btn bg-olive btn-sm mr-1" href="' . $social['link'] . '"><i class="' . $social['icon'] . '"></i></a>';
                }
            }
            
            $html .= '</ul></div>';
            return $html;
        }
    }

    if (!function_exists('website_faqs')) {

        function website_faqs($accordionId)
        {

            $faqs = Category::with('pages')->faq()->first();

            $html = '<div id="' . $accordionId . '">';
            foreach ($faqs->pages as $key => $faq) :

                $html .= '<div class="card">';
                $html .= '<div class="card-header collapsed" id="heading' . $key . '" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
                $html .= '<h5 class="mb-0 text-dark"><button class="btn btn-link">' . $faq->title . '</button></h5>';
                $html .= '</div>';
                $html .= '<div id="collapse' . $key . '" class="collapse" aria-labelledby="heading' . $key . '" data-parent="#' . $accordionId . '">';
                $html .= '<div class="card-body text-dark">' . $faq->content . '</div>';
                $html .= '</div>';
                $html .= '</div>';
            endforeach;
            $html .= '</div>';
            return $html;
        }
    }

    if (!function_exists('website_carousel_article')) {

        function website_carousel_article()
        {
            // Fetch the latest 15 featured articles with their category
            $articles = Article::with('category')
                ->where('is_features', 1)
                ->latest()
                ->limit(15)
                ->get();

                $html = '<div class="owl-carousel owl-theme">';

                foreach ($articles as $article) {
                    $url = url($article->type . '/' . $article->slug);
                    $imageUrl = str_replace('10.28.203.150', '192.168.0.120', $article->page_image);
                    $title = Str::limit($article->title, 30);
                    $content = Str::limit(strip_tags(htmlspecialchars_decode($article->content)), 50);
                    $date = $article->created_at->format('F d, Y');
                
                    $html .= '<div class="item">';
                    $html .= '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">';
                    $html .= '<div class="card border">';
                    $html .= '<div class="embed-responsive embed-responsive-4by3">';
                    $html .= '<img src="' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') . '" class="card-img-top embed-responsive-item" alt="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '">';
                    $html .= '</div>';
                    $html .= '<div class="card-body" style="height:200px">';
                    $html .= '<h5 class="text-capitalize">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h5>';
                    $html .= '<p class="card-text">' . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . '</p>';
                    $html .= '<p class="card-text"><small class="text-muted">' . htmlspecialchars($date, ENT_QUOTES, 'UTF-8') . '</small></p>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</a>';
                    $html .= '</div>';
                }
                
                $html .= '</div>';

            return $html;
        }
    }

    if (!function_exists('website_contact')) {

        function website_contact()
        {

            $faqs = Category::with('pages')->hubungi()->first();

            $html = '<div class="heading">';
            $html .= '<h2>' . $faqs->pages->first()->title . '</h2>';
            $html .= '<p>' . $faqs->pages->first()->subtitle . '</p>';
            $html .= '</div>';
            $html .= '<div class="contact-info">';
            $html .= $faqs->pages->first()->content;
            $html .= '</div>';

            return $html;
        }
    }

    if (!function_exists('website_contact_form')) {

        function website_contact_form()
        {

            $html = '<div class="contact-form">';
            $html .= '<h3>Aduan, cadangan atau pertanyaan.</h3>';
            $html .= '<form id="ajaxfeedbacks" novalidate="true" enctype="multipart/form-data">';
            $html .= '<div class="form-group">';
            $html .= '<label for="name">Nama Penuh</label>';
            $html .= '<input type="text" class="form-control" id="name" name="name" placeholder="Nama Penuh" required="required" data-error="Nama anda diperlukan.">';
            $html .= '<div class="help-block with-errors"></div>';
            $html .= '</div>';

            $html .= '<div class="form-row">';
            $html .= '<div class="col-12 col-md-8">';
            $html .= '<div class="form-group">';
            $html .= '<label for="email">Alamat E-mel</label>';
            $html .= '<input type="email" class="form-control" id="email" name="email" placeholder="Alamat E-mel" required="required" data-error="Emel yang sah diperlukan.">';
            $html .= '<div class="help-block with-errors"></div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col-12 col-md-4">';
            $html .= '<div class="form-group">';
            $html .= '<label for="phone">No Telefon</label>';
            $html .= '<input type="text" class="form-control" id="phone" name="phone" placeholder="No Telefon" required="required" data-error="No telefon yang sah diperlukan.">';
            $html .= '<div class="help-block with-errors"></div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div class="form-group">';
            $html .= '<label for="message">Mesej</label>';
            $html .= '<textarea class="form-control" id="message" name="message" rows="6" placeholder="Tulis mesej anda" required="required" data-error="Sila tinggalkan mesej/maklumbalas anda disini."></textarea>';
            $html .= '<div class="help-block with-errors"></div>';
            $html .= '</div>';

            // $html .= '<div class="form-group">';
            // $html .= '<label for="file">Dokumen/Lampiran</label>';
            // $html .= '<div class="custom-file">';
            // $html .= '<input class="custom-file-input" id="file" name="file" type="file">';
            // $html .= '<label class="custom-file-label" for="customFile">Choose file</label>';
            // $html .= '</div></div>';

            $html .= '<button type="submit" class="btn btn-light">Hantar</button>';
            $html .= '<div class="messages"></div>';
            $html .= '</form>';
            $html .= '</div>';
            $html .= '<div class="modal fade" id="myModalAjax">';
            $html .= '<div class="modal-dialog modal-sm">';
            $html .= '<div class="modal-content">';

            $html .= '<div class="modal-body">';
            $html .= '<p class="text-dark text-center">Pesanan Berjaya dihantar. Terima kasih.</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';


            return $html;
        }
    }

    if (!function_exists('website_footer')) {

        function website_footer()
        {
            $slug = 'widget:footer';
            $footer = Page::with('category')->where('slug', $slug)
                ->whereHas('category', function ($query) {
                    $query->where('slug', 'meta');
                })
                ->first();
            if ($footer)
                return $footer->content;
        }
    }
    if (!function_exists('website_sidebar_contact')) {

        function website_sidebar_contact()
        {
            $slug = 'widget:jabatan-landskap-negara';
            $footer = Page::with('category')->where('slug', $slug)
                ->whereHas('category', function ($query) {
                    $query->where('slug', 'meta');
                })
                ->first();
            if ($footer)
                return $footer->content;
        }
    }

    if (!function_exists('website_visitor')) {

        function website_visitor()
        {
            $counter = Home::find(1);
            $num = sprintf('%05d', $counter->visited());
            $strs = str_split($num);
            //dump($strss);

            $html = '<div class="visitor-counter">Jumlah Pelawat<br/>';
            foreach ($strs as $str) :
                $html .= "<span>$str</span>";
            endforeach;
            $html .= '</div>';

            return $html;
        }
    }
}
