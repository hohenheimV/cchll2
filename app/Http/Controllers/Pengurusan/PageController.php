<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Exports\VisitorsExport;
use App\Model\Category;
use App\Model\Page;
use App\Model\Home;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use CyrildeWit\EloquentViewable\Support\Period;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|page-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|page-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|page-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|page-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //validate
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }

        $pages = Page::with('users', 'category')->when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                 $query->whereRaw('lower(title) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
				
            });
        })->latest()->paginate();

        $pages->appends($request->only('keyword'));

        return view('pengurusan.page.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('pengurusan.page.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Mula Rule validation
        $rules = [
            'title' => 'required',
            'content' => 'required',
            //'slug' => 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'is_status' => 'required',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'    => ':attribute diperlukan.'
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) { //VALIDATION ERROR
            return Redirect::route('pengurusan.page.index')->with('warningMessage', 'Maklumat page gagal dikemaskini');
        }


        //UPDATE
        $data = $request->all();
        $data['page_image'] = $request->features ?? null;
       // $data['category_id'] = 1;
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pages';
        //$data['slug'] = Str::slug($request->title, '-');
        $data['published_at'] = Carbon::parse($request->published_at)->format('Y-m-d h:i:s');

        //define data field of Model
        Page::create($data);

        //redirect to
        return Redirect::route('pengurusan.page.index')->with('successMessage', 'Maklumat page telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('pengurusan.page.show', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $categories = Category::pluck('name', 'id');
        return view('pengurusan.page.edit', ['page' => $page, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {

        // Mula Rule validation
        $rules = [
            'title' => 'required',
            'content' => 'required',
            // 'slug' => 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'is_status' => 'required',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'    => ':attribute diperlukan.'
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        //dump($request);
        //dd($validator->errors());
        if ($validator->fails()) { //VALIDATION ERROR
            return Redirect::route('pengurusan.page.index')->with('warningMessage', 'Maklumat page gagal dikemaskini');
        }


        //UPDATE
        //$data = $request->all();
        //dd($request->all());
        $page->update($request->all());

        return Redirect::route('pengurusan.page.index')->with('successMessage', 'Maklumat page telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
		if ($page->delete()) {
            return redirect()->route('pengurusan.page.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.page.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all(Request $request)
    {


        $visitor = Home::first();

        $visitor['visitor_count_2020'] = views($visitor)->period(Period::subYears(1))->count();
        $visitor['visitor_count_2021'] = views($visitor)->count();

        $start = $month =  1;
        $now = date('n', strtotime('now'));
        $end = 12;

        for ($start; $start <= $end; $start++) {
            $visitor['visitor_count_month_' . $start] = $now > $start ? views($visitor)->period(Period::subMonths($start))->count() : 0;
        }

        $visitor['visitor_count_month_'.$now] = views($visitor)->period(Period::subDays(date('j')))->count();

        $visitor['visitor_count_day'] = views($visitor)->period(Period::subHours(date('G')))->count();

        $visitor['visitor_count_day_1'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-2 day")),date('Y-m-d',strtotime("-1 day"))))->count();
        $visitor['visitor_count_day_2'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-3 day")),date('Y-m-d',strtotime("-2 day"))))->count();
        $visitor['visitor_count_day_3'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-4 day")),date('Y-m-d',strtotime("-3 day"))))->count();
        $visitor['visitor_count_day_4'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-5 day")),date('Y-m-d',strtotime("-4 day"))))->count();
        $visitor['visitor_count_day_5'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-6 day")),date('Y-m-d',strtotime("-5 day"))))->count();
        $visitor['visitor_count_day_6'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-7 day")),date('Y-m-d',strtotime("-6 day"))))->count();
        $visitor['visitor_count_day_7'] = views($visitor)->period(Period::create(date('Y-m-d',strtotime("-8 day")),date('Y-m-d',strtotime("-7 day"))))->count();

        if ($request->isMethod('post')) {
            return (new VisitorsExport($visitor))->download('visitors-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }

        return view('pengurusan.page.export', compact('visitor'));
    }
}
