<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// DB::listen(function($events){
//    dump($events->sql);
// });

use App\Model\Article;
use App\Model\Home;
use App\Model\Menu;
use App\Model\Page;
use App\Model\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DataController;
// use App\Http\Controllers\Pengurusan\EntitiLandskapController;
// use App\Http\Controllers\Pengurusan\KempenTanamController;
// use App\Http\Controllers\Pengurusan\eMohonController;

Route::get('/vtour-bukit-kiara', function () {
    return view('website.vtour');
})->name('vtour');

Route::get('/', function () {
    $counter = Home::findOrFail(1);
    views($counter)->cooldown(now()->addHours(1))->record();
    $popup = Slider::where('popup',1)->first();
    $iconBoxes = [
        ['icon' => 'bi bi-house', 'title' => 'Icon Box 1'],
        ['icon' => 'bi bi-gear', 'title' => 'Icon Box 2'],
        // Add more icon boxes here
    ];

    // return view('website.index', compact('iconBoxes'));
    // return view('website.welcome2', compact('popup'));
    return view('website.welcome', compact('popup'));
})->name('welcome');

Route::get('/T1', function () {
    $counter = Home::findOrFail(1);
    views($counter)->cooldown(now()->addHours(1))->record();
    $popup = Slider::where('popup',1)->first();
    return view('website.T1welcome', compact('popup'));
})->name('welcomeT1');

Route::get('/T2', function () {
    $counter = Home::findOrFail(1);
    views($counter)->cooldown(now()->addHours(1))->record();
    $popup = Slider::where('popup',1)->first();
    return view('website.T2welcome', compact('popup'));
})->name('welcomeT2');

Route::get('/T3', function () {
    $counter = Home::findOrFail(1);
    views($counter)->cooldown(now()->addHours(1))->record();
    $popup = Slider::where('popup',1)->first();
    return view('website.T3welcome', compact('popup'));
})->name('welcomeT3');

Route::get('/api/negeri', [RegisterController::class, 'getNegeri']);
// Route::get('/api/daerah/{negeriId}', [RegisterController::class, 'getDaerah']);
Route::get('/api/pbt/{negeriId}', [RegisterController::class, 'getPBT']);

// Route::view('/registration', 'registration');

Route::get('/data', [DataController::class, 'processData']);
Route::get('/data/negeri', [DataController::class, 'getNegeri']);
Route::get('/data/negeri/{shortName}', [DataController::class, 'getNegeri']);
Route::get('/data/pbt/{negeriId}', [DataController::class, 'getPBT']);
Route::get('/data/pbt/{negeriId}/{pbtId}', [DataController::class, 'getPBT']);
Route::get('/data/postcode/{postcode}', [DataController::class, 'getPostcode']);

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('vtour');

Route::get('/pengurusan', function () {
    return redirect()->route('pengurusan.dashboard');
});

Route::get('/read', function () {
    return view('website.read');
})->name('article');

Route::get('/pano', function () {
    return view('website.pano');
})->name('pano');

Auth::routes(['verify' => false, 'register' => true, 'reset' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::name('website.')
    ->name('website.')
    ->namespace('Website')
    ->group(function () {

        Route::get('/peta', 'MapController@show')->name('peta');
        Route::get('/peta/softscape/{id}', 'MapController@softscape')->name('softscape');
        Route::get('/peta/hardscape/{id}', 'MapController@hardscape')->name('hardscape');
        Route::get('/peta/panorama/{id}', 'MapController@panorama')->name('panorama');


		/* Upgrade 20/04/22*/
       Route::get('/aktiviti', 'ActivitiesController@index')->name('activities.index');
        Route::post('/aktiviti/store', 'ActivitiesController@store')->name('activities.store');
        Route::get('/aktiviti/syarat', 'ActivitiesController@borang')->name('activities.borang');
        Route::get('/aktiviti/imej/{zon}', 'ActivitiesController@imej')->name('activities.imej');
        Route::post('/aktiviti/checkbooking', 'ActivitiesController@checkbooking')->name('activities.checkbooking');

        Route::post('maklumbalas/simpan', 'FeedbacksController@simpan')->name('feedbacks.simpan');

        Route::get('/konsultasi-awam', function () {

            $slug = 'konsultasi';
             $articles = Article::with('users', 'category')
                ->whereHas('category', function ($query) use ($slug) {
                    $query->where('slug', 'like', "%$slug%");
                })->paginate(5);
            //count user hit page
            return view('website.konsultasi', ['articles' => $articles]);

        })->name('konsultasi');

        Route::get('pages/{slug}', function ($slug) {
            $articles = Page::with('users', 'category')->where('slug', $slug)->first();
            //count user hit page
            views($articles)->remember(now()->addDay(1))->record();
            $relateds = $articles->related($articles->id, $articles->category_id);
            return view('website.read', ['articles' => $articles, 'relateds' => $relateds]);
        })->name('pages');

        Route::get('posts/{slug}', function ($slug) {
            $articles = Article::with('users', 'category')->where('slug', $slug)->first();
            //count user hit page
            views($articles)->remember(now()->addDay(1))->record();
            $relateds = $articles->related($articles->id, $articles->category_id);

            return view('website.read', ['articles' => $articles, 'relateds' => $relateds]);
        })->name('posts');

        Route::get('articles/{slug}', function ($slug) {
            $articles = Article::with('users', 'category')->where('slug', $slug)->first();
            //count user hit page
            views($articles)->remember(now()->addDay(1))->record();
            $relateds = $articles->related($articles->id, $articles->category_id);

            return view('website.read', ['articles' => $articles, 'relateds' => $relateds]);
        })->name('articles');

        Route::get('/blogs', function () {
            $articles = Article::with('users', 'category')->paginate(3);

            return view('website.blog', ['articles' => $articles]);
        })->name('blogs');

        Route::get('/category/{slug}', function ($slug) {
            $articles = Article::with('users', 'category')
                ->whereHas('category', function ($query) use ($slug) {
                    $query->where('slug', 'like', "%$slug%");
                })
                ->orderBy('created_at','DESC')
                ->paginate(10);

            return view('website.category', ['articles' => $articles, 'category' => $slug]);
        })->name('categories');

        Route::get('/search', function (Request $request) {
            //validate
            if ($request->only('keyword')) {

                $request->validate([
                    'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);

                $articles = Article::with('users', 'category')->when($request->keyword, function ($q) use ($request) { //Bila ada keyword
                    $q->where(function ($query) use ($request) {
                        $query->whereRaw('lower(title) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
                        $query->orWhereRaw('lower(content) LIKE ?', ['%' . filter_var(strtolower($request->keyword), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })->latest()->get();
                $pages = Page::with('users', 'category')->when($request->keyword, function ($q) use ($request) { //Bila ada keyword
                    $q->where(function ($query) use ($request) {
                        $query->whereRaw('lower(title) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
                        $query->orWhereRaw('lower(content) LIKE ?', ['%' . filter_var(strtolower($request->keyword), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })->latest()->get();
                $results = $articles->merge($pages)->paginate(5);

                $results->appends($request->only('keyword'));


                return view('website.search', ['results' => $results]);
            }

            return view('website.search', ['articles' => []]);
        })->name('search');
    });

Route::middleware(['auth'])
    ->prefix('pengurusan')
    ->name('pengurusan.')
    ->namespace('Pengurusan')
    ->group(function () {

		Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth','XFrame']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        /**
         * Route SectionsController
         */

        Route::get('sections', function () {
            $modules = config('website.sections');
            return view('pengurusan.sections.index', ['modules' => $modules]);
        })->name('sections');

        /**
         * Route DashboardController
         */
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/peta', 'DashboardController@peta')->name('peta');

        /**
         * Route RolesController
         */
        Route::resource('roles', 'RolesController');
        Route::resource('permissions', 'PermissionsController');
        //Route::resource('audits', 'AuditController')->only(['index','auth']);
         Route::get('audits/', 'AuditController@index')->name('audits.index');
         Route::get('audits/logged', 'AuditController@logged')->name('audits.logged');
         Route::get('/audits/{audit}', 'AuditController@show')->name('audits.show');

        /**
         * Route UsersController
         */
        Route::resource('users', 'UsersController');

        Route::name('users.')->group(function () {
            Route::get('profile/', 'UsersController@profile_show')->name('profile.show');
            Route::get('profile/edit', 'UsersController@profile_edit')->name('profile.edit');
            Route::patch('profile/{user}', 'UsersController@profile_update')->name('profile.update');
            // New route for eLIND
            Route::get('velind', 'UsersController@velind')->name('velind');
        });

        /**
         * Route eLINDController
         */
        Route::resource('eLIND', 'UsersController');
        
        Route::get('entiti-lanskap', [EntitiLandskapController::class, 'index'])->name('entitiLandskap.entiti.index');
        Route::get('kempen-tanam', [KempenTanamController::class, 'index'])->name('kempenTanam.entiti.index');
        Route::get('eMohon', [eMohonController::class, 'index'])->name('eMohon.entiti.index');
        Route::get('dashPBT', function () {
            return view('pengurusan.eLIND.dashPBT');
        })->name('dashPBT.entiti.index');
        Route::get('dashPenggiat', function () {
            return view('pengurusan.eLIND.dashPenggiat');
        })->name('dashPenggiat.entiti.index');
        Route::get('dasheLIND', function () {
            return view('pengurusan.eLIND.dasheLIND');
        })->name('dasheLIND.entiti.index');
        
        /**
         * Route HardscapeController
         */
        Route::get('hardscape/history', 'HardscapeController@history')->name('hardscape.history');
        Route::post('hardscape/history', 'HardscapeController@history_proses')->name('hardscape.history.proses');
        Route::get('hardscape/peta', 'HardscapeController@peta')->name('hardscape.peta');
        Route::get('hardscape/petashow/{hardscape}', 'HardscapeController@petashow')->name('hardscape.petashow');
        Route::get('hardscape/tagging/{hardscape}', 'HardscapeController@tagging')->name('hardscape.tagging');
        Route::get('hardscape/taggings', 'HardscapeController@taggings')->name('hardscape.taggings');
        Route::get('hardscape/edit/{hardscape}/{record?}', 'HardscapeController@edit')->name('hardscape.edit');

        Route::post('hardscape/{hardscape}/gambar', 'HardscapeController@gambar')->name('hardscape.gambar');

        Route::resource('hardscape', 'HardscapeController')->except(['edit']);


        Route::name('hardscapes.')->prefix('hardscapes')->group(function () {

            /**
             * Route HardscapeRecordController
             */
            Route::get('records/{hardscape}', 'HardscapeRecordController@index')->name('record.index');
            Route::get('record/create/{hardscape}', 'HardscapeRecordController@create')->name('record.create');
            Route::resource('record', 'HardscapeRecordController')->except(['index', 'create']);
        });

        /**
         * Route SoftscapeController
         */
        Route::get('softscape/history', 'SoftscapeController@history')->name('softscape.history');
        Route::post('softscape/history', 'SoftscapeController@history_proses')->name('softscape.history.proses');
        Route::get('softscape/peta', 'SoftscapeController@peta')->name('softscape.peta');
        Route::get('softscape/petashow/{softscape}', 'SoftscapeController@petashow')->name('softscape.petashow');
        Route::get('softscape/tagging/{softscape}', 'SoftscapeController@tagging')->name('softscape.tagging');
        Route::get('softscape/taggings', 'SoftscapeController@taggings')->name('softscape.taggings');
        //Route::get('softscape/edit/{softscape}/{record}', 'SoftscapeController@edit')->name('softscape.edit');

        Route::post('softscape/{softscape}/gambar', 'SoftscapeController@gambar')->name('softscape.gambar');

        Route::resource('softscape', 'SoftscapeController');

        /**
         * Child group SoftscapeController
         * Route SoftscapesRecordController
         */
        Route::name('softscapes.')->prefix('softscapes')->group(function () {

            /**
             * Route SoftscapesRecordController
             */
            Route::get('records/{softscape}', 'SoftscapesRecordController@index')->name('record.index');
            Route::get('record/create/{softscape}', 'SoftscapesRecordController@create')->name('record.create');
            Route::resource('record', 'SoftscapesRecordController')->except(['index', 'create']);

            /**
             * Route SoftscapesGambarController
             */
            Route::get('rekod_gambar/{softscape}', 'SoftscapesGambarController@index')->name('gambar.index');
            Route::get('gambar/create/{softscape}', 'SoftscapesGambarController@create')->name('gambar.create');
            Route::resource('gambar', 'SoftscapesGambarController')->except(['index', 'create']);

            /**
             * Route SoftscapesBatangController
             */
            Route::get('rekod_batang/{softscape}', 'SoftscapesBatangController@index')->name('batang.index');
            Route::get('batang/create/{softscape}', 'SoftscapesBatangController@create')->name('batang.create');
            Route::resource('batang', 'SoftscapesBatangController')->except(['index', 'create']);

            /**
             * Route SoftscapesBuahController
             */
            Route::get('rekod_buah/{softscape}', 'SoftscapesBuahController@index')->name('buah.index');
            Route::get('buah/create/{softscape}', 'SoftscapesBuahController@create')->name('buah.create');
            Route::resource('buah', 'SoftscapesBuahController')->except(['index', 'create']);

            /**
             * Route SoftscapesBungaController
             */
            Route::get('rekod_bunga/{softscape}', 'SoftscapesBungaController@index')->name('bunga.index');
            Route::get('bunga/create/{softscape}', 'SoftscapesBungaController@create')->name('bunga.create');
            Route::resource('bunga', 'SoftscapesBungaController')->except(['index', 'create']);

            /**
             * Route SoftscapesDaunController
             */
            Route::get('rekod_daun/{softscape}', 'SoftscapesDaunController@index')->name('daun.index');
            Route::get('daun/create/{softscape}', 'SoftscapesDaunController@create')->name('daun.create');
            Route::resource('daun', 'SoftscapesDaunController')->except(['index', 'create']);

            /**
             * Route SoftscapesSilaraController
             */
            Route::get('rekod_silara/{softscape}', 'SoftscapesSilaraController@index')->name('silara.index');
            Route::get('silara/create/{softscape}', 'SoftscapesSilaraController@create')->name('silara.create');
            Route::resource('silara', 'SoftscapesSilaraController')->except(['index', 'create']);
        });


        /**
         * Child group SoftscapeController
         * Route SoftscapesRecordController
         */
        Route::name('softscapes.')->prefix('softscapes')->group(function () {
            Route::prefix('penyelenggaraan')->group(function () {

                /**
                 * Route SoftscapesPemangkasanController
                 */
                Route::get('penyelenggaraan_pemangkasan/{softscape}', 'SoftscapesPemangkasanController@index')->name('pemangkasan.index');
                Route::get('pemangkasan/create/{softscape}', 'SoftscapesPemangkasanController@create')->name('pemangkasan.create');
                Route::resource('pemangkasan', 'SoftscapesPemangkasanController')->except(['index', 'create']);

                /**
                 * Route SoftscapesPembajaanController
                 */
                Route::get('penyelenggaraan_pembajaan/{softscape}', 'SoftscapesPembajaanController@index')->name('pembajaan.index');
                Route::get('pembajaan/create/{softscape}', 'SoftscapesPembajaanController@create')->name('pembajaan.create');
                Route::resource('pembajaan', 'SoftscapesPembajaanController')->except(['index', 'create']);

                /**
                 * Route SoftscapesPerosakController
                 */
                Route::get('penyelenggaraan_perosak/{softscape}', 'SoftscapesPerosakController@index')->name('perosak.index');
                Route::get('perosak/create/{softscape}', 'SoftscapesPerosakController@create')->name('perosak.create');
                Route::resource('perosak', 'SoftscapesPerosakController')->except(['index', 'create']);

                /**
                 * Route SoftscapesRisikoController
                 */
                Route::get('penyelenggaraan_risiko/{softscape}', 'SoftscapesRisikoController@index')->name('risiko.index');
                Route::get('risiko/create/{softscape}', 'SoftscapesRisikoController@create')->name('risiko.create');
                Route::resource('risiko', 'SoftscapesRisikoController')->except(['index', 'create']);
            });
        });


        /**
         * Route PanoramaController
         */
        Route::resource('panorama', 'PanoramaController');

        /**
         * Route KTPController
         */
        Route::resource('ktp', 'KTPController');
        Route::get('ktp/{ktp}/download', 'KTPController@download')->name('ktp.download');

        /**
         * Route EntitiLandskapUnikController
         */
        Route::resource('entiti-landskap-unik', 'EntitiLandskapUnikController');

        /**
         * Route DroneController
         */
        Route::resource('drone', 'DroneController');
        /**
         * Route AnalisaController
         */
        Route::resource('analisa', 'AnalisaController');
        Route::get('analisa/{analisa}/download', 'AnalisaController@download')->name('analisa.download');
        /**
         * Route ZonController
         */
        Route::get('zon/{zon}/download', 'ZonController@download')->name('zon.download');
        Route::get('zon', 'ZonController@index')->name('zon.index');
        Route::resource('zon', 'ZonController');

         Route::post('zon/{zon}/gambar', 'ZonController@gambar')->name('zon.gambar');

           /**
             * Route ZonGambarController
             */
            Route::get('rekod_gambar/{zon}', 'ZonGambarController@index')->name('gambar.index');
            Route::get('gambar/create/{zon}', 'ZonGambarController@create')->name('gambar.create');
            Route::resource('gambar', 'ZonGambarController')->except(['index', 'create']);

        /**
         * Route ManualController
         */
        Route::resource('manual', 'ManualController');
        Route::get('manual/{manual}/download', 'ManualController@download')->name('manual.download');
        /**
         * Route EREADController
         */
        Route::resource('eread', 'EREADController');
        Route::get('eread/{eread}/download', 'EREADController@download')->name('eread.download');

        /**
         * Route ELADController
         */
        Route::resource('elad', 'ELADController');
        Route::get('elad/{elad}/download', 'ELADController@download')->name('elad.download');
        Route::get('/get-subkategori/{kategoriId}', [ELADController::class, 'getSubkategori']);

        // /**
        //  * Route ELADLLController
        //  */
        // Route::resource('eladll', 'ELADLLController');
        // Route::get('eladll/{eladll}/download', 'ELADLLController@download')->name('eladll.download');
        // Route::get('/get-subkategori/{kategoriId}', [ELADLLController::class, 'getSubkategori']);

        //  /**
        //  * Route ELADLKController
        //  */
        // Route::resource('eladlk', 'ELADLKController');
        // Route::get('eladlk/{eladlk}/download', 'ELADLKController@download')->name('eladlk.download');
        // Route::get('/get-subkategori/{kategoriId}', [ELADLKController::class, 'getSubkategori']);


        /**
         * Route EPACTController
         */
        Route::resource('epact', 'EPACTController');
        Route::get('epact/{epact}/download', 'EPACTController@download')->name('epact.download');
        Route::get('/get-subkategori/{kategoriId}', [EPACTController::class, 'getSubkategori']);


        /**
         * Route ArticleController
         */
        Route::resource('article', 'ArticleController');
        /**
         * Route PageController
         */
        Route::resource('page', 'PageController');

        /**
         * Route ActivitiesController
         */
        Route::get('activities/download/{type}/{activity}', 'ActivitiesController@download')->name('activities.download');
        //Route::get('activities/{status?}', 'ActivitiesController@index')->name('activities.index');
        Route::get('activities', 'ActivitiesController@index')->name('activities.index');
        Route::resource('activities', 'ActivitiesController');

        /**
         * Route ActivitiesController
         */
        Route::get('feedbacks/download/{feedback}', 'FeedbacksController@download')->name('feedbacks.download');
        Route::resource('feedbacks', 'FeedbacksController');

        /**
         * Route CategoriesController
         */
        Route::resource('categories', 'CategoriesController')->except(['show']);
        /**
         * Route MenuController
         */
        Route::get('menu/sort/show', 'MenuController@sortshow')->name('menu.sort.show');
        Route::post('menu/sort/save', 'MenuController@sortsave')->name('menu.sort.save');
        Route::resource('menu', 'MenuController')->except(['show']);

        /**
         * Route TagController
         */
        Route::resource('tags', 'TagsController')->except(['show']);

        /**
         * Route SliderController
         */
        Route::resource('sliders', 'SliderController')->except(['show']);


        Route::name('exports.')->group(function () {

            Route::get('exports/activities', 'ActivitiesController@export_all')->name('activities.all');
            Route::post('exports/activities', 'ActivitiesController@export_all')->name('activities.post');

            Route::get('exports/feedbacks', 'FeedbacksController@export_all')->name('feedbacks.all');
            Route::post('exports/feedbacks', 'FeedbacksController@export_all')->name('feedbacks.post');

            Route::get('export/softscape/all', 'SoftscapeController@export_all')->name('softscape.all');
            Route::post('export/softscape/all', 'SoftscapeController@export_all')->name('softscape.post');

            Route::get('export/hardscape/all', 'HardscapeController@export_all')->name('hardscape.all');
            Route::post('export/hardscape/all', 'HardscapeController@export_all')->name('hardscape.post');

            Route::get('exports/visitor/all', 'PageController@export_all')->name('visitor.all');
            Route::post('exports/visitor/all', 'PageController@export_all')->name('visitor.post');
        });
    });

Route::get('/test-email', function () {
    $details = [
        'title' => 'Mail from Laravel App',
        'body' => 'This is a test email sent from Laravel application.'
    ];

    Mail::raw($details['body'], function ($message) use ($details) {
        $message->to('your_test_email@example.com')  // Replace with your test email address
                ->subject($details['title']);
    });

    return 'Email sent!';
});
Route::get('/test-email2', function () {
    $details = [
        'title' => 'Mail from Laravel App',
        'body' => 'This is a test email sent from Laravel application.'
    ];

    \Illuminate\Support\Facades\Mail::raw($details['body'], function ($message) use ($details) {
        $message->to('test@example.com')  // Replace with your test email address
                ->subject($details['title']);
    });

    return 'Email sent!';
});
Route::get('/test-email-html', function () {
    $details = [
        'title' => 'HTML Mail from Laravel App',
        'body' => '<h1>This is a test email sent from Laravel application.</h1>'
    ];

    \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($details) {
        $message->to('test@example.com')
                ->subject($details['title'])
                ->setBody($details['body'], 'text/html');
    });

    return 'HTML email sent!';
});
