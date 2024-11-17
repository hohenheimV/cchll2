<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Banner carousel options
    |--------------------------------------------------------------------------
    |
    |
    */

    'carousel' => [
        'indicators' => false,
        'control' => true,
    ],
    /*
    |--------------------------------------------------------------------------
    | Link Media Social

    |--------------------------------------------------------------------------
    |
    |'web' => [
            'icon' => 'fas fa-globe',
            'link' => 'http://www.jln.gov.my/',
        ],
    */

    'social' => [

        'twitter' => [
            'icon' => 'fab fa-twitter',
            'link' => 'https://twitter.com/LandskapNegara',
        ],
        'facebook' => [
            'icon' => 'fab fa-facebook-f',
            'link' => 'https://www.facebook.com/JabatanLandskapNegara/',
        ],
        'instagram' => [
            'icon' => 'fab fa-instagram',
            'link' => 'https://www.instagram.com/landskapnegara',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Modul Web
    |--------------------------------------------------------------------------
    |
    | Global','Menu','Banner','Video','Features','News','Faq','Contact
    */
    'sections' => [
        [
            'title'=>'Menu','route'=>'pengurusan.menu.index','icon'=>'fa fa-cube',
            'subtitle'=>'Senarai menu pada bahagian bar navigasi (navbar).'
        ],
        [
            'title'=>'Slider','route'=>'pengurusan.sliders.index','icon'=>'fa fa-cube',
            'subtitle'=>'Senarai slider dan notifikasi di laman utama.'
        ],
        [
            'title'=>'Sejarah Lembut','route'=>'pengurusan.softscape.history','icon'=>'fa fa-cube',
            'subtitle'=>'Fungsi salin sejarah rekod landskap lembut bagi tahun lalu.'
        ],
        [
            'title'=>'Sejarah Kejur','route'=>'pengurusan.hardscape.history','icon'=>'fa fa-cube',
            'subtitle'=>'Fungsi salin sejarah rekod landskap kejur bagi tahun lalu.'
        ],
    ],


];
