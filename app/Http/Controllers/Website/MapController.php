<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Model\Hardscape;
use App\Model\Panorama;
use App\Model\Softscape;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {

        return view('website.peta.show');
    }

    public function softscape($id)
    {
        $softscape = Softscape::find($id);
        //dd($softscape);
        return view('website.peta.softscape', ['softscape' => $softscape]);
    }

    public function hardscape($id)
    {
        $hardscape = Hardscape::find($id);
        return view('website.peta.hardscape', ['hardscape' => $hardscape]);
    }

    public function panorama($id)
    {
        $panorama = Panorama::find($id);
        return view('website.peta.panorama', ['panorama' => $panorama]);
    }
}
