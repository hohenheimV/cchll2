<?php

namespace App\Http\Controllers;

use App\Model\Negeri;
use App\Model\Daerah;
use App\Model\Mukim;
use App\Model\Parlimen;
use App\Model\Dun;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Method to display form with Negeri options
    public function create()
    {
        $negeris = Negeri::orderBy('nama_negeri', 'asc')->get();  // Fetch all Negeri data
        return response()->json($negeris); // Return as JSON response
    }
    // Method to get Daerah based on selected Negeri
    public function getDaerah($kod_negeri)
    {
        $daerahs = Daerah::where('kod_negeri', $kod_negeri)
        ->orderBy('nama_daerah', 'asc')->get();
        return response()->json($daerahs);
    }

    // Method to get Mukim based on selected Daerah
    public function getMukim($kod_negeri, $kod_daerah)
    {
        // Fetch mukim based on both kod_negeri and kod_daerah
        $mukims = Mukim::where('kod_daerah', $kod_daerah)
                    ->where('kod_negeri', $kod_negeri)
                    ->orderBy('nama_mukim', 'asc')
                    ->get();

        return response()->json($mukims);
    }
    // Method to get Parlimen based on selected Negeri
    public function getParlimen($kod_negeri)
    {
        $Parlimens = Parlimen::where('kod_negeri', $kod_negeri)
        ->orderBy('nama_parlimen', 'asc')->get();
        return response()->json($Parlimens);
    }
    // Method to get Dun based on selected Negeri
    public function getDun($kod_parlimen)
    {
        $Duns = Dun::where('kod_parlimen', $kod_parlimen)
        ->orderBy('nama_dun', 'asc')->get();
        return response()->json($Duns);
    }

}
