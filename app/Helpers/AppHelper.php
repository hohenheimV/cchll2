<?php
use App\Model\KTP;
use App\Model\eLAPS;
use App\Model\ePALM;
use App\Model\MaklumatPenggunaPbt;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use App\Model\EntitiLandskapUnik;
use App\Model\ePIL;
use App\Model\MIB;
use App\Model\eREAD;
use App\Model\ePACT;
use App\Model\eLAD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

if (!function_exists('app_dashboard_pokok')) {
    function app_dashboard_pokok(){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = KTP::where('pbt', $data->pbt_name)->whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)'));
            return $count;
        }
        return KTP::whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)'));
    }
}

if (!function_exists('app_dashboard_eread')) {
    function app_dashboard_eread($keyword = null){
        return eREAD::with('kategori')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('kate', $keyword);    
            });
        })->count();
    }
}

if (!function_exists('app_dashboard_epact')) {
    function app_dashboard_epact($keyword = null){
        return ePACT::with('kategori')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('kate', $keyword);    
            });
        })->count();
    }
}

if (!function_exists('app_dashboard_elad')) {
    function app_dashboard_elad($keyword = null){
        return eLAD::with('kategori')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('kate', $keyword);    
            });
        })->count();
    }
}

if (!function_exists('app_dashboard_permohonan')) {
    function app_dashboard_permohonan($keyword = null){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = eLAPS::where('id_pemohon', $data->id)/* ->where('status_permohonan', '!=', '1') */->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($query) use ($keyword) {
                    $query->where('bahagian_jln', $keyword);    
                });
            })->count();
            return $count;
        }
        return eLAPS::where('status_permohonan', '!=', '1')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('bahagian_jln', $keyword);    
            });
        })->count();
    }
}

if (!function_exists('app_dashboard_taman')) {
    function app_dashboard_taman($keyword = null){
        $kategoriList = [
            'Taman Awam',
            'Taman Botani',
            'Landskap Perbandaran',
            'Persekitaran Kehidupan',
            'Taman Persekutuan',
        ];
        // return $keyword;
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = ePALM::where('nama_pbt', $data->pbt_name)
            ->where('is_komponen', null)
            ->when($keyword, function ($q) use ($keyword, $kategoriList) {
                if ($keyword === 6) {
                    $q->whereNotIn('kategori_taman', $kategoriList);
                } else {
                    $q->where('kategori_taman', $kategoriList[$keyword-1]);
                }
            })->count();
            // $ePALM = ePALM::where('nama_pbt', $data->pbt_name)->paginate($count);
            return $count;
        }
        return ePALM::where('is_komponen', null)
        ->when($keyword, function ($q) use ($keyword, $kategoriList) {
            if ($keyword === 6) {
                $q->whereNotIn('kategori_taman', $kategoriList);
            } else {
                $q->where('kategori_taman', $kategoriList[$keyword-1]);
            }
        })->count();
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
    function app_dashboard_mib($keyword = null){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $count = MIB::where('pbt', $data->pbt_name)->count();
            return $count;
        }
        return MIB::when($keyword, function ($q) use ($keyword) {
            $q->where('status_keahlian', $keyword);
        })->count();
    }
}

if (!function_exists('app_dashboard_industri')) {
    function app_dashboard_industri($keyword = null){
        return MaklumatPenggunaPenggiatIndustri::when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('jenis_industri', $keyword);    
            });
        })->count();
    }
}

if (!function_exists('app_dashboard_entiti')) {
    function app_dashboard_entiti($keyword = null){
        return EntitiLandskapUnik::when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('jenis_entiti', $keyword);    
            });
        })->count();
    }
}