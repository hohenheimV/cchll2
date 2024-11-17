<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Exports\ArticlesExport;
use App\Model\Article;
use App\Model\Category;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|article-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|article-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|article-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|article-delete'], ['only' => ['destroy']]);
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

        $articles = Article::with('users', 'category')->when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(title) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
            });	
        })->latest()->paginate();

        $articles->appends($request->only('keyword'));

        return view('pengurusan.article.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('label', 'id');
        return view('pengurusan.article.create', ['tags' => $tags, 'categories' => $categories]);
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
            return Redirect::route('pengurusan.article.index')->with('warningMessage', 'Maklumat artikel gagal dikemaskini');
        }

        //SAVE

        $article = Article::create($request->all());

        //SYNC TAGS
        $article->tag()->sync($request->tags);

        //redirect to
        return Redirect::route('pengurusan.article.index')->with('successMessage', 'Maklumat artikel telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('pengurusan.article.show', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('label', 'id');
        return view('pengurusan.article.edit', ['article' => $article, 'tags' => $tags, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {

        // Mula Rule validation
        $rules = [
            'title' => 'required',
            'content' => 'required',
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
            return Redirect::route('pengurusan.article.index')->with('warningMessage', 'Maklumat artikel gagal dikemaskini');
        }

        //UPDATE
        $data = $request->all();
        $article->update($data);

        //SYNC TAGS
        $article->tag()->sync($request->tags);


        //redirect to
        return Redirect::route('pengurusan.article.index')->with('successMessage', 'Maklumat artikel telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
       if ($article->delete()) {
            return redirect()->route('pengurusan.article.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.article.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }

        /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all()
    {

        $articles = Article::all();

        foreach($articles as $article) {
            $article->visited_views_count = views($article)->count();
            $article->unique_views_count = views($article)->unique()->count();
        }

        return (new ArticlesExport($articles))->download('activities-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
