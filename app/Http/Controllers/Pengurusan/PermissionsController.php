<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role:Pentadbir Sistem');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }

        $permissions = Permission::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(name) regexp lower(?)', [str_replace(" ", "|", filter_var($request->keyword, FILTER_SANITIZE_SPECIAL_CHARS))]);
            });
        })->paginate(36);

        $permissions->appends($request->only('keyword'));

        //groupBy prefix permission name
        $permissionsNew = $permissions->groupBy(function ($item, $key) {
            return preg_replace('/(\s*)([^-]*)(.*)/', '$2', $item['name']);
        });
        $permissionsNew->toArray();

        return view('pengurusan.permissions.index', ['permissions' => $permissions, 'permissionsNew' => $permissionsNew]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pengurusan.permissions.create');
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
            'name' => 'required|unique:permissions,name',
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

        // define data field of Model
        $permission = $request->all();
        $name = Str::slug(strtolower($request->name), '-');


        if (!isset($request->crud)) {
            $permission['name'] = $name;
            $permission = Arr::set($permission, 'guard_name', 'web'); //add guard_name before save

            Permission::create($permission);
        } else {

            foreach ($request->crud as $crud) {
                Permission::create(['name' => $name . '-' . $crud, 'guard_name' => 'web']);
            }
        }



        // redirect to
        return redirect()->route('pengurusan.permissions.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('pengurusan.permissions.show', ['permission' => $permission]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('pengurusan.permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {

        // Mula Rule validation
        $rules = [
            'name' => 'required',
            'permission' => 'required',
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

        // define data field of Model
        $input = $request->all();
        $input['name'] = Str::slug(strtolower($request->name), '-');

        $permission->update($input);

        // redirect to
        return redirect()->route('pengurusan.permissions.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if ($permission->delete()) {
            return redirect()->route('pengurusan.permissions.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.permissions.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }
}
