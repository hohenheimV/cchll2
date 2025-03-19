<?php
use App\Model\KTP;
use App\Model\ePALM;
use App\Model\MaklumatPenggunaPbt;
use App\Model\ePIL;
use App\Model\MIB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

if (!function_exists('app_dashboard_pokok')) {
    function app_dashboard_pokok(){
        return KTP::whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)'));
    }
}

if (!function_exists('app_dashboard_taman')) {
    function app_dashboard_taman(){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = ePALM::where('nama_pbt', $data->pbt_name)->count();
            $ePALM = ePALM::where('nama_pbt', $data->pbt_name)->paginate($count);
            foreach ($ePALM as $instance) {
                $count += ePALM::where('is_komponen', $instance->id_taman)->count();
            }
            return $count;
        }
        return ePALM::count();
    }
}

if (!function_exists('app_dashboard_pelan')) {
    function app_dashboard_pelan(){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = ePIL::where('nama_pbt', $data->pbt_name)->count();
            return $count;
        }
        return ePIL::count();
    }
}

if (!function_exists('app_dashboard_mib')) {
    function app_dashboard_mib(){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = MIB::where('pbt', $data->pbt_name)->count();
            return $count;
        }
        return MIB::count();
    }
}