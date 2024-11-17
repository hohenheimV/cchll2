<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntitiLandskapController extends Controller
{
    public function index()
    {
        return view('pengurusan.entitiLandskap.entiti');
    }
}
