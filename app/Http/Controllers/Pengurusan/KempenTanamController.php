<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KempenTanamController extends Controller
{
    public function index()
    {
        return view('pengurusan.kempenTanam.entiti');
    }
}
