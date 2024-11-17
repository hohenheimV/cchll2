<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Panorama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PanoramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hardscapes = Panorama::latest()->paginate();
        return Response::json($hardscapes, 200);
    }
}
