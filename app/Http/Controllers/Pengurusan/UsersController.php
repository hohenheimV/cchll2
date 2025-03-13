<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

use App\Exports\UsersExport;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(['role:Pentadbir Sistem'], ['except' => ['profile_show','profile_edit','profile_update']]);
    }


    /**
     * Display a listing of the resource.
     *
     * Search with keyword for user.name OR SUBSTRING user.email or roles.name
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }

        $users = User::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
				$query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);    
            })->orWhereHas('roles', function ($query)  use ($request){
                $query->where('name', '=', $request->keyword);
            });
        })
        ->where(function ($query) {
            $query->whereHas('roles', function ($query) {
                // $query->where('name', 'Penggiat Industri');
                // $query->whereRaw('is_active = ? ', ['0']);    
                    //   ->orWhere('name', 'Perunding');
            })
            ->orWhereDoesntHave('roles'); // Include users with no roles
        })
        ->paginate(20);

        $users->appends($request->only('keyword'));

        return view('pengurusan.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('pengurusan.users.create', ['roles' => $roles, 'userRole' => []]);
    }

    public function velind()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('pengurusan.users.velind', ['roles' => $roles, 'userRole' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Mula Rule validation
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
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

        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();


        $input = $request->all();
        // dd($request->all());
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = Arr::except($input, ['password']);
        }

        // define data field of Model
        $user = User::create($input);

        $user->assignRole($request->roles);

        //redirect to
        return redirect()->route('pengurusan.users.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $record
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('pengurusan.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('pengurusan.users.edit', ['user' => $user, 'roles' => $roles, 'userRole' => $userRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());
        // Mula Rule validation
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required|array|min:1', // Ensure roles is an array and has at least one role
            'is_active' => 'required|boolean',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'email.unique' => 'E-mel telah digunakan.',
            'password.same' => 'Kata laluan dan pengesahan kata laluan tidak sama.',
            'roles.required' => 'Sekurang-kurangnya satu peranan mesti dipilih.',
            'roles.array' => 'Peranan mesti dalam bentuk senarai.',
            'roles.min' => 'Sekurang-kurangnya satu peranan mesti dipilih.',
            'boolean' => ':attribute mesti benar atau palsu.',
        ];

        $attributes = [
            'is_active' => 'Status Aktif',
            'roles' => 'Peranan',
        ];
        // Before updating
        $previousStatus = $user->is_active;

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = Arr::except($input, ['password']);
        }


        // define data field of Model
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles'));

        // redirect to
        // return redirect()->route('pengurusan.users.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
        // Send an email if user is active
        if (!$previousStatus && $user->is_active) {
            $details = [
                'title' => 'User Activation Notification',
                'body' => 'Your account has been activated.',
                'email' => $user->email,
            ];

            Mail::raw($details['body'], function ($message) use ($details) {
                $message->to($details['email'])  // Replace with your test email address
                        ->subject($details['title']);
            });
        }

        // Redirect with success message
        return redirect()->route('pengurusan.users.index')->with('successMessage', 'Maklumat telah berjaya disimpan' . ((!$previousStatus && $user->is_active) ? ' dan e-mel telah dihantar!' : '!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->route('pengurusan.users.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.users.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }


    public function profile_show()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('pengurusan.users.profile.show', ['user' => $user]);
        # code...
    }

    public function profile_edit()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('pengurusan.users.profile.edit', ['user' => $user]);
        # code...
    }
    public function profile_update(Request $request, User $user)
    {
        // Mula Rule validation
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
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

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = Arr::except($input, ['password']);
        }


        // define data field of Model
        $user->update($input);

        // redirect to
        return redirect()->route('pengurusan.users.profile.show')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all()
    {

        $users = User::all();
        return (new UsersExport($users))->download('users-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


}
