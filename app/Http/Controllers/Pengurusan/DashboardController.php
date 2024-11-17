<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Activity;
use App\Model\Article;
use App\Model\Feedback;
use App\Model\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
                // Get a collection of all the routes
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
