<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|category-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|category-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|category-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|category-delete'], ['only' => ['destroy']]);
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

        $categories = Category::withCount('articles')->when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                 $query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
            });
        })->latest()->paginate();

        $categories->appends($request->only('keyword'));

        return view('pengurusan.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.categories.create');
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
            'name' => 'required|min:3|max:255|regex:/(^[A-Za-z ]+$)+/',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        //dump($request);
        //dd($validator->errors());
        if ($validator->fails()) { //VALIDATION ERROR
            return Redirect::route('pengurusan.categories.index')->with('warningMessage', 'Maklumat category gagal dikemaskini');
        }
        //define data field of Model
        Category::create($request->all());

        //redirect to
        return Redirect::route('pengurusan.categories.index')->with('successMessage', 'Maklumat category telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('pengurusan.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|min:3|max:255|regex:/(^[A-Za-z ]+$)+/',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        //$validator($rules, $messages, $attributes);
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        //dump($request);
        //dd($validator->errors());
        if ($validator->fails()) { //VALIDATION ERROR
            return Redirect::route('pengurusan.categories.index')->with('warningMessage', 'Maklumat category gagal dikemaskini');
        }

        //UPDATE
        $category->update($request->all());
        //redirect to
        return Redirect::route('pengurusan.categories.index')->with('successMessage', 'Maklumat category telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
