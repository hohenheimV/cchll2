<?php

namespace App\Providers;

use App\Model\MaklumatPenggunaPbt;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use OwenIt\Auditing\Models\Audit as Audit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Carbon::now()->settings([
            'locale' => config('app.locale'),
            'timezone' => config('app.timezone'),
        ]);

        Audit::creating(function (Audit $model) {
            if (empty($model->old_values) && empty($model->new_values)) {
                return false;
            }
        });

        // 🔄 Share user bahagian info with all views
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user) {
                $user->bahagian = 'eLANDSKAP, JLN';
                $user->jenis = null;

                if (in_array('Penggiat Industri', $user->getRoleNames()->toArray()) && $user->bahagian_jln) {
                    $syarikat = MaklumatPenggunaPenggiatIndustri::select('name', 'jenis_industri')
                        ->where('id_elind', $user->bahagian_jln)
                        ->first();

                    $user->bahagian = $syarikat->name ?? 'eLANDSKAP, JLN';
                    $user->jenis = $syarikat->jenis_industri ?? 'eLANDSKAP, JLN';

                } elseif (in_array('Pihak Berkuasa Tempatan', $user->getRoleNames()->toArray()) && $user->bahagian_jln) {
                    $syarikat = MaklumatPenggunaPbt::where('id', $user->bahagian_jln)->first();
                    $user->bahagian = $syarikat->pbt_name ?? 'eLANDSKAP, JLN';

                } elseif (in_array('Pegawai', $user->getRoleNames()->toArray())) {
                    $bahagian_jln = [
                        '0' => 'eLANDSKAP, JLN',
                        '1' => 'Bahagian Pengurusan Landskap',
                        '2' => 'Bahagian Taman Awam',
                        '3' => 'Bahagian Pembangunan Landskap',
                        '4' => 'Bahagian Khidmat Teknikal',
                        '5' => 'Bahagian Penyelidikan & Pemulihan',
                        '6' => 'Bahagian Penilaian & Penyelenggaraan',
                        '7' => 'Bahagian Teknologi Maklumat',
                        '8' => 'Bahagian Promosi & Industri Landskap',
                        '9' => 'Bahagian Dasar & Pengurusan Korporat',
                        '10' => 'Bahagian Kontrak & Ukur Bahan',
                    ];
                    $user->bahagian = $bahagian_jln[$user->bahagian_jln] ?? null;
                }

                View::share('user_bahagian', $user->bahagian);
            }
        });
    }
}
