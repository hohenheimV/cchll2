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
            // $count = KTP::where('pbt', $data->pbt_name)->whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)'));
            $count = KTP::whereRaw('LOWER(pbt) = ?', [strtolower($data->pbt_name)])->whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)'));
            return number_format($count);
        }
        return number_format(KTP::whereNotNull('jumlah_pokok')->sum(DB::raw('CAST(jumlah_pokok AS INTEGER)')));
    }
}

if (!function_exists('app_dashboard_eread')) {
    function app_dashboard_eread($keyword = null){
        return number_format(eREAD::with('kategori')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('kate', $keyword);    
            });
        })->count());
    }
}

if (!function_exists('app_dashboard_epact')) {
    function app_dashboard_epact($keyword = null){
        return number_format(ePACT::with('kategori')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('kate', $keyword);    
            });
        })->count());
    }
}

if (!function_exists('app_dashboard_elad')) {
    function app_dashboard_elad($keyword = null){
        return number_format(eLAD::with('kategori')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('kate', $keyword);    
            });
        })->count());
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
            return number_format($count);
        }
        return number_format(eLAPS::where('status_permohonan', '!=', '1')->when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('bahagian_jln', $keyword);    
            });
        })->count());
    }
}

if (!function_exists('app_dashboard_taman')) {
    function app_dashboard_taman($keyword = null) {
        // Original categories excluding the expanded "Taman Awam" group
        $kategoriList = [
            'Taman Awam',          // will cover multiple sub-categories below
            'Taman Botani',
            'Landskap Perbandaran',
            'Persekitaran Kehidupan',
            'Taman Persekutuan',
        ];

        // Sub-categories considered as "Taman Awam"
        $tamanAwamSubCategories = [
            'Taman Wilayah',
            'Taman Bandaran',
            'Taman Tempatan',
            'Padang Kejiranan',
            'Padang Permainan',
            'Lot Permainan',
        ];

        if (Auth::user()->hasRole('Pihak Berkuasa Tempatan')) {
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();

            $count = ePALM::whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)])
                ->where('is_komponen', null)
                ->when($keyword, function ($q) use ($keyword, $kategoriList, $tamanAwamSubCategories) {
                    if ($keyword === 6) {
                        // Exclude all defined categories
                        $q->whereNotIn('kategori_taman', $kategoriList);
                    } else {
                        if ($keyword === 1) {
                            // If keyword is 1 (Taman Awam), include all sub-categories as well
                            $q->where(function($query) use ($tamanAwamSubCategories) {
                                $query->where('kategori_taman', 'Taman Awam')
                                      ->orWhereIn('kategori_taman', $tamanAwamSubCategories);
                            });
                        } else {
                            // Other categories just filter normally
                            $q->where('kategori_taman', $kategoriList[$keyword - 1]);
                        }
                    }
                })->count();

            return number_format($count);
        }

        return number_format(ePALM::where('is_komponen', null)
            ->when($keyword, function ($q) use ($keyword, $kategoriList, $tamanAwamSubCategories) {
                if ($keyword === 6) {
                    $q->whereNotIn('kategori_taman', $kategoriList);
                } else {
                    if ($keyword === 1) {
                        $q->where(function($query) use ($tamanAwamSubCategories) {
                            $query->where('kategori_taman', 'Taman Awam')
                                  ->orWhereIn('kategori_taman', $tamanAwamSubCategories);
                        });
                    } else {
                        $q->where('kategori_taman', $kategoriList[$keyword - 1]);
                    }
                }
            })->count());
    }
}

if (!function_exists('app_dashboard_pelan')) {
    function app_dashboard_pelan(){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            // $count = ePIL::where('nama_pbt', $data->pbt_name)->count();
            $count = ePIL::whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)])->count();
            return number_format($count);
        }
        return number_format(ePIL::count());
    }
}

if (!function_exists('app_dashboard_mib')) {
    function app_dashboard_mib($keyword = null){
        if(Auth::user()->hasRole('Pihak Berkuasa Tempatan')){
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            // $count = MIB::where('pbt', $data->pbt_name)->count();
            $count = MIB::whereRaw('LOWER(pbt) = ?', [strtolower($data->pbt_name)])->count();
            return number_format($count);
        }
        return number_format(MIB::when($keyword, function ($q) use ($keyword) {
            $q->where('status_keahlian', $keyword);
        })->count());
    }
}

if (!function_exists('app_dashboard_industri')) {
    function app_dashboard_industri($keyword = null){
        return number_format(MaklumatPenggunaPenggiatIndustri::when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('jenis_industri', $keyword);    
            });
        })->count());
    }
}

if (!function_exists('app_dashboard_entiti')) {
    function app_dashboard_entiti($keyword = null){
        return number_format(EntitiLandskapUnik::when($keyword, function ($q) use ($keyword) {
            $q->where(function ($query) use ($keyword) {
				$query->where('jenis_entiti', $keyword);    
            });
        })->count());
    }
}

if (!function_exists('app_dashboard_taman_negeri')) {
    function app_dashboard_taman_negeri($kod_negeri = null)
    {
        $query = ePALM::query()
            ->whereNull('is_komponen');

        if ($kod_negeri) {
            $query->where('negeri_taman', $kod_negeri);
        }

        if (Auth::user()->hasRole('Pihak Berkuasa Tempatan')) {
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();

            if ($data && $data->pbt_name) {
                $query->whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)]);
            } else {
                return 0;
            }
        }

        // $total = $query->selectRaw("
        //     SUM(
        //         CASE
        //             WHEN keluasan_taman ~ '^[0-9]+(\\.[0-9]+)?$' THEN CAST(keluasan_taman AS NUMERIC)
        //             ELSE 0
        //         END
        //     ) as total_kel
        // ")->value('total_kel');
        $total = $query->selectRaw("
            SUM(
                CASE
                    WHEN keluasan_taman ~ '^[0-9]+(\\.[0-9]+)?$' THEN
                        CAST(keluasan_taman AS NUMERIC) * 
                        CASE
                            WHEN LOWER(keluasan_unit) = 'ekar' THEN 1
                            WHEN LOWER(keluasan_unit) = 'hektar' THEN 2.47105
                            WHEN LOWER(keluasan_unit) = 'm2' THEN 0.000247105
                            ELSE 0
                        END
                    ELSE 0
                END
            ) as total_kel
        ")->value('total_kel');

        return number_format($total ?? 0)/*  . " Ekar" */;
        // return $total ?? 0;
    }

    function user_in_bahagian(...$allowed) {
        $user = Auth::user();
        return $user->hasRole('Pegawai') && $user->bahagian_jln !== null && in_array($user->bahagian_jln, $allowed);
    }
}

if (!function_exists('app_dashboard_pokok_by_year')) {
    function app_dashboard_pokok_by_year()
    {
        $query = KTP::whereNotNull('jumlah_pokok')
            // only accept values in tajuk that are 4-digit numbers (i.e. years)
            ->whereRaw("tajuk ~ '^[0-9]{4}$'")
            ->select(
                DB::raw('tajuk as tahun'),
                DB::raw('SUM(CAST(jumlah_pokok AS INT)) as total')
            )
            ->groupBy('tajuk')
            ->orderBy('tajuk', 'desc');

        if (Auth::user()->hasRole('Pihak Berkuasa Tempatan')) {
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $query->whereRaw('LOWER(pbt) = ?', [strtolower($data->pbt_name)]);
        }

        return $query->get();
    }
}
