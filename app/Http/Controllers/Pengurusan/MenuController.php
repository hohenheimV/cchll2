<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Category;
use App\Model\Menu;
use App\Model\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|menu-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|menu-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|menu-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|menu-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $parentMenus = Menu::with('children.grandchildren')->whereNull('parent_id')
        //     ->orderBy(DB::raw('(web_menu.ordering is null)', 'web_menu.ordering'), 'ASC')->get();

            $parentMenus = Menu::with('children.grandchildren')->whereNull('parent_id')
                ->orderBy(DB::raw('(web_menu.ordering is null),  web_menu.ordering'), 'ASC')->get();
        return view('pengurusan.sections.menu.home', ['parentMenus' => $parentMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::pluck('title', 'id');
        $articles = Article::pluck('title', 'id');
        $categories = Category::pluck('name', 'id');
        return view('pengurusan.sections.menu.create', ['menu' => [], 'pages' => $pages, 'articles' => $articles, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        Menu::create($request->all());
        //redirect to
        return Redirect::route('pengurusan.menu.index')->with('successMessage', 'Maklumat menu telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function sortshow()
    {
        $parentMenus = Menu::with('children.childrens')->whereNull('parent_id')
            ->orderBy(DB::raw('(web_menu.ordering is null)', 'web_menu.order'), 'ASC')->get();
        return view('pengurusan.sections.menu.sort', ['parentMenus' => $parentMenus]);
    }
    public function sortsave(Request $request)
    {
        $menus = json_decode($request->output);
        // dd($menus);

        $new = [];
        foreach ($menus as $keym => $menu) {
            $patent1 = $keym + 1;
            if (isset($menu->children)) {
                $flight1 = Menu::updateOrCreate(
                    ['id' => $menu->id],
                    ['ordering' => $patent1, 'parent_id' => null]
                );
                foreach ($menu->children as $keyc => $children) {
                    $patent2 = $flight1->parent + $keyc + 1;
                    $flight2 = Menu::updateOrCreate(
                        ['id' => $children->id],
                        ['ordering' => $patent2, 'parent_id' => $flight1->id]
                    );
                    if (isset($children->children)) {
                        foreach ($children->children as $keyd => $child) {
                            $patent3 =  $keyd + 1;
                            $flight3 = Menu::updateOrCreate(
                                ['id' => $child->id],
                                ['ordering' => $patent3, 'parent_id' => $children->id]
                            );
                        }
                    }
                }
            } else {
                $flight1 = Menu::updateOrCreate(
                    ['id' => $menu->id],
                    ['ordering' => $patent1, 'parent_id' => null]
                );
            }
        }

        //redirect to
        return Redirect::route('pengurusan.menu.index')->with('successMessage', 'Maklumat menu telah berjaya disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $pages = Page::pluck('title', 'id');
        $articles = Article::pluck('title', 'id');
        $categories = Category::pluck('name', 'id');
        return view('pengurusan.sections.menu.edit', ['menu' => $menu, 'pages' => $pages, 'articles' => $articles, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.q
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {

        $menu->update($request->all());
        //redirect to
        return Redirect::route('pengurusan.menu.index')->with('successMessage', 'Maklumat menu telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return Redirect::route('pengurusan.menu.index')->with('successMessage', 'Maklumat menu telah berjaya dihapuskan');
    }
}
