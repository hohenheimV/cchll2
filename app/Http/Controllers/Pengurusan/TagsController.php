<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
     
        $this->middleware(['role_or_permission:Pentadbir Sistem|tag-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|tag-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|tag-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|tag-delete'], ['only' => ['destroy']]);
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

        $tags = Tag::withCount('articles')->when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(kategori) regexp lower(?)', [str_replace(" ", "|", filter_var($request->keyword, FILTER_SANITIZE_SPECIAL_CHARS))]);
            });
        })->latest()->paginate();

        $tags->appends($request->only('keyword'));

        return view('pengurusan.tags.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.tags.create');
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
            'label' => 'required|unique:web_tags,label',
            'title' => 'nullable',
            'meta_description' => 'nullable',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'    => ':attribute diperlukan.'
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        //$validator($rules, $messages, $attributes);
        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();

        $request->merge(['title' => '', 'meta_description' => '-']);

        //define data field of Model
        Tag::create($request->all());

        //redirect to
        return Redirect::route('pengurusan.tags.index')->with('successMessage', 'Maklumat tag telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('pengurusan.tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // Mula Rule validation
        $rules = [
            'label' => 'required|unique:web_tags,label,' . $tag->id,
            'title' => 'nullable',
            'meta_description' => 'nullable',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'    => ':attribute diperlukan.'
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        if (!$request->has('title')) {
            $request->merge(['title' => '']);
        }
        if (!$request->has('meta_description')) {
            $request->merge(['meta_description' => '-']);
        }

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) { //VALIDATION ERROR
            return Redirect::route('pengurusan.tags.index')->with('warningMessage', 'Maklumat tag gagal dikemaskini');
        }

        //UPDATE
        $tag->update($request->all());
        //redirect to
        return Redirect::route('pengurusan.tags.index')->with('successMessage', 'Maklumat tag telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
