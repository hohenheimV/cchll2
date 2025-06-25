<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Activity;
use App\Model\Article;
use App\Model\Feedback;
use App\Model\Page;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use App\Model\MaklumatPenggunaPbt;
use App\Model\Negeri;
use App\Model\ePALM;
use App\Model\ePIL;
use App\Model\ePIL_dokumen;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * @param $dir
     */
    public function getClassesLists($dir)
    {
        $role = Role::create(['name' => 'super-admin']);
        $permisions = [];

        Permission::create(['name' => 'user-index']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);

        $classes = File::allFiles($dir);
        foreach ($classes as $class) {
            $class->modelname = strtolower(Str::singular($class->getBasename('.php')));
            if (preg_match("/^[a-z]*$/", $class->modelname)) {
                $permisions[] = $class->modelname . '-index';
                $permisions[] = $class->modelname . '-create'; //only 'create','store'
                $permisions[] = $class->modelname . '-edit'; // only 'edit','update'
                $permisions[] = $class->modelname . '-delete'; //only 'destroy'

                Permission::create(['name' => $class->modelname . '-index']);
                Permission::create(['name' => $class->modelname . '-create']);
                Permission::create(['name' => $class->modelname . '-edit']);
                Permission::create(['name' => $class->modelname . '-delete']);
            }
        }
        $role->givePermissionTo(Permission::all());
        return $permisions;
    }

    public function index()
    {
        if(Auth::user()->hasRole(['Pentadbir Sistem', 'Pegawai'])){
            $negeriList = Negeri::all();

            return view('pengurusan.dashboard.index', [
                'negeriList' => $negeriList,
            ]);

        }
        if(Auth::user()->hasRole(['Pihak Berkuasa Tempatan'])){
            // dd(Auth::user()->bahagian_jln);
            $id_pbt = Auth::user()->bahagian_jln;
            $data = MaklumatPenggunaPbt::where('id', $id_pbt)->latest()->first();
            $ePALM = ePALM::whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)])->where('status', 'approved')->paginate(ePALM::whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)])->where('status', 'approved')->count());
            foreach ($ePALM as $instance) {
                    // $ePALM_komponen = ePALM::where('is_komponen', $instance->id_taman)->get();
                    // if($ePALM_komponen){
                    //     foreach ($ePALM_komponen as $item) {
                    //         $item->komponen = str_replace(' ', '_', $instance->nama_taman)."/".str_replace(' ', '_', $item->nama_taman);
                    //         $item->nama_pbt = $instance->nama_pbt;
                    //         $item->gambar_taman = str_replace('gambar_input_modal_', 'Xgambar_input_modal_', $item->gambar_taman);
                    //         $item->kategori_taman = $instance->kategori_taman;
                    //         $item->fasiliti = $instance->fasiliti;
                    //         $item->lat = $instance->lat;
                    //         $item->lng = $instance->lng;
                    //         $item->keluasan_taman = $instance->keluasan_taman;
                    //         $item->keluasan_unit = $instance->keluasan_unit;
                    //         $item->waktuMula_taman = $instance->waktuMula_taman;
                    //         $item->waktuTamat_taman = $instance->waktuTamat_taman;
                    //         $item->negeri_taman = $instance->negeri_taman;
                    //         $item->nama_taman = "Komponen: ".$item->nama_taman;
                    //         $negeris = Negeri::select('nama_negeri')->where('kod_negeri', $instance->negeri_taman)->orderBy('nama_negeri', 'asc')->first();
                    //         $item->negeri = ucwords(strtolower($negeris->nama_negeri)) ?? ''; 
                    //         $ePALM->push($item);
                    //     }
                    // }
                $negeris = Negeri::select('nama_negeri')->where('kod_negeri', $instance->negeri_taman)->orderBy('nama_negeri', 'asc')->first();
                $instance->negeri = ucwords(strtolower($negeris->nama_negeri)) ?? ''; 
                $instance->slug = Crypt::encryptString($instance->id_taman);
            }
            // dd($ePALM);

            $ePIL = ePIL::whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)])->where('status', 'approved')->paginate(ePIL::whereRaw('LOWER(nama_pbt) = ?', [strtolower($data->pbt_name)])->where('status', 'approved')->count());
            foreach ($ePIL as $item) {
                $negeris = Negeri::select('nama_negeri')->where('kod_negeri', $item->negeri_pelan)->orderBy('nama_negeri', 'asc')->first();
                $item->negeri = ucwords(strtolower($negeris->nama_negeri)) ?? ''; 
            }
            $ePIL->getCollection()->transform(function ($PIL) {
                $dokumen = ePIL_dokumen::where('status', 'active')->where('id_pelan', $PIL->id_pelan)->first();
                $PIL->nama_dokumen_pelan = $dokumen ? $dokumen->nama_dokumen_pelan : null;
                $PIL->id_dokumen_pelan = $dokumen ? $dokumen->id_dokumen_pelan : null;
                // dump($dokumen);
        
                return $PIL;
            });
            // dd($ePIL);


            return view('pengurusan.dashboard.index', ['ePALM_all' => $ePALM, 'ePIL' => $ePIL, ]);

        }
        if(Auth::user()->hasRole(['Penggiat Industri'])){
            // dd(Auth::user()->bahagian_jln);
            $id_elind = Auth::user()->bahagian_jln;
            $type = '';
            if($id_elind){
                $data = MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->latest()->paginate(MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->count());
                // MaklumatPenggunaPenggiatIndustri::where('id_elind', $id_elind)->latest()->first();
                foreach ($data as $item) {
                    $type = $item->jenis_industri;
                    $negeris = Negeri::select('nama_negeri')->where('kod_negeri', $item->state)->orderBy('nama_negeri', 'asc')->first();
                    if($negeris){
                        $item->state = ucwords(strtolower($negeris->nama_negeri)) ?? ''; 
                    }else{
                        $item->state = 'Tiada Maklumat';
                    }
                }
            }else{
                $data = []; 
            }
            if(!$type || $data->isEmpty()){
                dump("Akaun Industri anda tidak wujud. Sila hubungi Pentadbir eLANDSKAP");
                Auth::logout();
                return redirect()->route('login');
            }

            return view('pengurusan.dashboard.index', ['eLIND' => $data, 'keyword' => ($type)]);

        }
        // return view('pengurusan.dashboard.index');
        $routeCollection = Route::getRoutes();

        $popularPages = $this->popular_page();
        $popularArticles = $this->popular_articles();
        $latestArticles = $this->latest_articles();
        $latestAduan = $this->latest_aduan();
        $latestAktiviti = $this->latest_aktiviti();

        return view('pengurusan.dashboard.index', [
            'popularPages' => $popularPages, 'popularArticles' => $popularArticles,
            'latestArticles' => $latestArticles,
            'latestAduan' => $latestAduan,
            'latestAktiviti' => $latestAktiviti,
        ]);
    }

    public function peta()
    {

        return view('pengurusan.dashboard.peta');
    }

    private function latest_aktiviti()
    {
        # code...
        return Activity::latest()->whereNotIn('status',['Lulus','Tidak Lulus'])->limit(7)->get(); // descending
    }
    private function latest_aduan()
    {
        # code...
        return Feedback::latest()->whereNotIn('status',['Selesai'])->limit(7)->get(); // descending
    }

    private function latest_articles()
    {
        # code...
        return Article::latest()->limit(7)
            ->whereHas('category', function ($query) {
                $query->notmeta();
            })->get(); // descending
    }

    private function popular_page()
    {
        # code...
        return Page::orderByViews()->limit(7)
            ->whereHas('category', function ($query) {
                $query->notmeta();
            })->get(); // descending
    }

    private function popular_articles()
    {
        # code...
        return Article::orderByViews()->limit(7)
            ->whereHas('category', function ($query) {
                $query->notmeta();
            })->get(); // descending
    }
}
