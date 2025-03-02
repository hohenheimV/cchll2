<?php
use App\Model\KTP;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('app_dashboard_pokok')) {

    function app_dashboard_pokok(){
        return KTP::whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)'));
    }
}

