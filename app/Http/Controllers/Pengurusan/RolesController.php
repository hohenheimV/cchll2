<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
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

        $roles = Role::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(name) regexp lower(?)', [str_replace(" ", "|", filter_var($request->keyword, FILTER_SANITIZE_SPECIAL_CHARS))]);
            });
        })->paginate(10);

        $roles->appends($request->only('keyword'));

        return view('pengurusan.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $collection = Permission::get();
        //dd($collection);
        //groupBy prefix permission name
        $permissions = $collection->groupBy(function ($item, $key) {
            return preg_replace('/(\s*)([^-]*)(.*)/', '$2', $item['name']);
        });
        $permissions->toArray();

        return view('pengurusan.roles.create', ['permissions' => $permissions, 'rolePermissions' => []]);
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
            'name' => 'required|unique:roles,name',
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
        $role = $request->all();
        //$role['name'] = Str::slug(strtolower($request->name), '-');

        // $role = Arr::set($permission, 'guard_name', 'web'); //add guard_name before save
        // $role = Arr::except($role, ['permission']); //remove permission before save

        $request->merge(['guard_name' => 'web']);
        $request->except(['permission']);

       $role =  Role::create($request->all());
        if ($request->permission)
            $role->syncPermissions($request->permission);

        // redirect to
        return redirect()->route('pengurusan.roles.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $collection = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();
        $permissions = $collection->groupBy(function ($item, $key) {
            return preg_replace('/(\s*)([^-]*)(.*)/', '$2', $item['name']);
        });
        $permissions->toArray();

        return view('pengurusan.roles.show', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        $collection = Permission::get();
        //groupBy prefix permission name
        $permissions = $collection->groupBy(function ($item, $key) {
            return preg_replace('/(\s*)([^-]*)(.*)/', '$2', $item['name']);
        });
        $permissions->toArray();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('pengurusan.roles.edit', ['role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
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
        //$input['name'] = Str::slug(strtolower($request->name), '-');
        $input = Arr::set($input, 'guard_name', 'web'); //add guard_name before save
        $input = Arr::except($input, ['permission']); //remove permission before save
        // define data field of Model
        $role->update($input);

        $role->syncPermissions($request->permission);

        // redirect to
        return redirect()->route('pengurusan.roles.show', $role)->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return redirect()->route('pengurusan.roles.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.roles.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }
}
