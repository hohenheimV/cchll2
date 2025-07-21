<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\User;
use App\Model\MaklumatPenggunaPbt;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use App\Model\Negeri;
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
        $this->middleware(['role:Pentadbir Sistem|Pegawai'], ['except' => [
            'profile_show',
            'profile_edit',
            'profile_update',
            'pbt_show',
            'pbt_edit',
            'pbt_update'
        ]]);
    }


    /**
     * Display a listing of the resource.
     *
     * Search with keyword for user.name OR SUBSTRING user.email or roles.name
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->only('keyword'));
        if ($request->filled('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        
            $users = User::whereHas('roles', function ($query) use ($request) {
                $query->where('name', $request->keyword);
            })
            ->orderBy('bahagian_jln', 'asc')
            ->latest()
            ->paginate(User::count());
        } else {
            $users = User::whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['Penggiat Industri', 'Pihak Berkuasa Tempatan']);
            })
            ->orderBy('bahagian_jln', 'asc')
            ->latest()
            ->paginate(User::count());
        }

        // if ($request->only('keyword')) {
        //     $request->validate([
        //         'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
        //     ]);
        // }

        // $users = User::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
        //     $q->where(function ($query) use ($request) {
		// 		$query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);    
        //     })->orWhereHas('roles', function ($query)  use ($request){
        //         $query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);   
        //     });
        // })
        // ->where(function ($query) {
        //     $query->whereHas('roles', function ($query) {
        //         // $query->where('name', 'Penggiat Industri');
        //         // $query->whereRaw('is_active = ? ', ['0']);    
        //             //   ->orWhere('name', 'Perunding');
        //     })->orderBy('roles', 'desc')
        //     ->orWhereDoesntHave('roles');
        // })
        // ->orderBy('bahagian_jln', 'asc')
        // ->latest() 
        // // ->orderBy('created_at', 'desc')
        // ->paginate(20);

        $users->appends($request->only('keyword'));

        foreach ($users as $key => $value) {
            // dump($value->getRoleNames());
            if (in_array('Penggiat Industri', $value->getRoleNames()->toArray()) /* && $value->bahagian_jln != null */) {
                $syarikat = MaklumatPenggunaPenggiatIndustri::select('name', 'jenis_industri')->where('id_elind', $value->bahagian_jln)->first();
                // $value->bahagian = $syarikat->name;
                // $value->jenis = $syarikat->jenis_industri;
                $syarikat ? $value->bahagian = $syarikat->name : $value->bahagian = 'Tiada Maklumat';
                $syarikat ? $value->jenis = $syarikat->jenis_industri : $value->jenis = 'Tiada Maklumat';
            }elseif (in_array('Pihak Berkuasa Tempatan', $value->getRoleNames()->toArray()) && $value->bahagian_jln != null) {
                $syarikat = MaklumatPenggunaPbt::where('id', $value->bahagian_jln)->first();
                $syarikat ? $value->bahagian = $syarikat->pbt_name : $value->bahagian = 'Tiada Maklumat';
            }elseif (in_array('Pegawai', $value->getRoleNames()->toArray())) {
                $bahagian_jln = [
                    '0' => 'Tiada Maklumat',
                    '1' => 'Bahagian Pengurusan Landskap',
                    '2' => 'Bahagian Taman Awam',
                    '3' => 'Bahagian Pembangunan Landskap',
                    '4' => 'Bahagian Khidmat Teknikal',
                    '5' => 'Bahagian Penyelidikan & Pemuliharaan',
                    '6' => 'Bahagian Penilaian & Penyelenggaraan',
                    '7' => 'Bahagian Teknologi Maklumat',
                    '8' => 'Bahagian Promosi & Industri Landskap',
                    '9' => 'Bahagian Dasar & Pengurusan Korporat',
                    '10' => 'Bahagian Kontrak & Ukur Bahan',
                ];
                $value->bahagian = $value->bahagian_jln > 0 ? $bahagian_jln[$value->bahagian_jln] : '';
            }
            // dump($value);
        }
        // dump($users);

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
        if($user->hasRole('Penggiat Industri')){
            $syarikat = $user->bahagian_jln;
            $elind = MaklumatPenggunaPenggiatIndustri::where('id_elind', '=', $syarikat)->first();
            $user->jenis = $elind->jenis_industri ?? null;
        }

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
            'password' => 'nullable|sometimes|min:8|required_with:confirm-password|same:confirm-password', // enforce min and matching if confirm is filled
            'confirm-password' => 'nullable', // confirm-password is optional
            'roles' => 'required|array|min:1', // Ensure roles is an array and has at least one role
            'is_active' => 'required|boolean',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'email.unique' => 'E-mel telah digunakan.',
            'password.required_with' => 'Kata laluan diperlukan apabila pengesahan kata laluan diisi.',
            'password.same' => 'Kata laluan dan pengesahan kata laluan tidak sama.',
            'password.min' => 'Kata laluan mesti mempunyai sekurang-kurangnya 8 aksara.',
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
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
            if (config('mail.enabled')) {
                // $details = [
                //     'title' => 'User Activation Notification',
                //     'body' => 'Your account has been activated.',
                //     'email' => $user->email,
                // ];

                // Mail::raw($details['body'], function ($message) use ($details) {
                //     $message->to($details['email'])  // Replace with your test email address
                //             ->subject($details['title']);
                // });
            }
            if (config('mail.enabled')) {
                Mail::send('pengurusan.users.mails.pengaktifan', [
                    'user' => $user,
                    'accountType' => $user->roles->pluck('name')->first(), // or however you store role
                ], function ($message) use ($user) {
                    $message->to($user->email, $user->name)
                            ->subject('Akaun Anda Telah Diaktifkan');
                });
            }
        }

        // Redirect with success message
        $route = 'pengurusan.users.index';
        $params = [];
        if (in_array('Penggiat Industri', $input['roles'])) {
            $params = ['keyword' => 'Penggiat Industri'];
        }elseif (in_array('Pihak Berkuasa Tempatan', $input['roles'])) {
            $params = ['keyword' => 'Pihak Berkuasa Tempatan'];
        }
        return redirect()->route($route, $params)->with('successMessage', 'Maklumat telah berjaya disimpan' . ((!$previousStatus && $user->is_active) ? ' dan e-mel telah dihantar!' : '!'));
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
        // $user->bahagian_jln = 13;
        if (in_array('Penggiat Industri', $user->getRoleNames()->toArray()) && $user->bahagian_jln != null) {
            $syarikat = MaklumatPenggunaPenggiatIndustri::select('name', 'jenis_industri')->where('id_elind', $user->bahagian_jln)->first();
            // $user->bahagian = $syarikat->name;
            // $user->jenis = $syarikat->jenis_industri;
            $syarikat ? $user->bahagian = $syarikat->name : $user->bahagian = 'Tiada Maklumat';
            $syarikat ? $user->jenis = $syarikat->jenis_industri : $user->jenis = 'Tiada Maklumat';
        }elseif (in_array('Pihak Berkuasa Tempatan', $user->getRoleNames()->toArray()) && $user->bahagian_jln != null) {
            $syarikat = MaklumatPenggunaPbt::where('id', $user->bahagian_jln)->first();
            $syarikat ? $user->bahagian = $syarikat->pbt_name : $user->bahagian = 'Tiada Maklumat';
        }elseif (in_array('Pegawai', $user->getRoleNames()->toArray())) {
            $bahagian_jln = [
                '0' => 'Tiada Maklumat',
                '1' => 'Bahagian Pengurusan Landskap',
                '2' => 'Bahagian Taman Awam',
                '3' => 'Bahagian Pembangunan Landskap',
                '4' => 'Bahagian Khidmat Teknikal',
                '5' => 'Bahagian Penyelidikan & Pemuliharaan',
                '6' => 'Bahagian Penilaian & Penyelenggaraan',
                '7' => 'Bahagian Teknologi Maklumat',
                '8' => 'Bahagian Promosi & Industri Landskap',
                '9' => 'Bahagian Dasar & Pengurusan Korporat',
                '10' => 'Bahagian Kontrak & Ukur Bahan',
            ];
            $user->bahagian = $user->bahagian_jln > 0 ? $bahagian_jln[$user->bahagian_jln] : 'Tiada Maklumat';
        }
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
        // dd($user->id);
        // Mula Rule validation
        $rules = [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'same:confirm-password',
            'confirm-password' => 'same:password',
            // 'roles' => 'required'
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
            'same' => ':attribute tidak sama.',
            'unique' => ':attribute mungkin telah digunakan.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        // $attributes = [];
        $attributes = [
            'name' => 'Nama',
            'email' => 'Emel',
            'password' => 'Kata laluan',
            'confirm-password' => 'Pengesahan kata laluan',
            'roles' => 'Peranan',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($validator->errors());
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


    // public function pbt_show()
    // {
    //     $id = Auth::user()->id;
    //     $user = User::find($id);
    //     // $user->bahagian_jln = 13;
    //     if (in_array('Penggiat Industri', $user->getRoleNames()->toArray()) && $user->bahagian_jln != null) {
    //         $syarikat = MaklumatPenggunaPenggiatIndustri::select('name', 'jenis_industri')->where('id_elind', $user->bahagian_jln)->first();
    //         // $user->bahagian = $syarikat->name;
    //         // $user->jenis = $syarikat->jenis_industri;
    //         $syarikat ? $user->bahagian = $syarikat->name : $user->bahagian = 'Tiada Maklumat';
    //         $syarikat ? $user->jenis = $syarikat->jenis_industri : $user->jenis = 'Tiada Maklumat';
    //     }elseif (in_array('Pihak Berkuasa Tempatan', $user->getRoleNames()->toArray()) && $user->bahagian_jln != null) {
    //         $syarikat = MaklumatPenggunaPbt::where('id', $user->bahagian_jln)->first();
    //         $syarikat ? $user->bahagian = $syarikat->pbt_name : $user->bahagian = 'Tiada Maklumat';
    //     }elseif (in_array('Pegawai', $user->getRoleNames()->toArray())) {
    //         $bahagian_jln = [
    //             '0' => 'Tiada Maklumat',
    //             '1' => 'Bahagian Pengurusan Landskap',
    //             '2' => 'Bahagian Taman Awam',
    //             '3' => 'Bahagian Pembangunan Landskap',
    //             '4' => 'Bahagian Khidmat Teknikal',
    //             '5' => 'Bahagian Penyelidikan & Pemuliharaan',
    //             '6' => 'Bahagian Penilaian & Penyelenggaraan',
    //             '7' => 'Bahagian Teknologi Maklumat',
    //             '8' => 'Bahagian Promosi & Industri Landskap',
    //             '9' => 'Bahagian Dasar & Pengurusan Korporat',
    //             '10' => 'Bahagian Kontrak & Ukur Bahan',
    //         ];
    //         $user->bahagian = $user->bahagian_jln > 0 ? $bahagian_jln[$user->bahagian_jln] : 'Tiada Maklumat';
    //     }
    //     return view('pengurusan.users.pbt.show', ['user' => $user]);
    //     # code...
    // }

    public function pbt_edit()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $syarikat = MaklumatPenggunaPbt::where('id', $user->bahagian_jln)->first();
        // dd($syarikat);
        $user->address1 = strtoupper($syarikat->address1);
        $user->address2 = strtoupper($syarikat->address2);
        $user->postcode = strtoupper($syarikat->postcode);
        $user->locality = ($syarikat->locality);

        $negeri = Negeri::select('nama_negeri')->where('kod_negeri', $syarikat->state)->first();
        $user->state = strtoupper($negeri['nama_negeri']);
        
        $user->pbt = strtoupper($syarikat->pbt_name);
        $user->department = strtoupper($user->department);
        $user->position = strtoupper($user->position);
        $user->sv_name = strtoupper($user->sv_name);
        // dd($user);
        return view('pengurusan.users.pbt.edit', ['user' => $user]);
    }
    public function pbt_update(Request $request, User $user)
    {
        // dd($request->all());
        $syarikat = MaklumatPenggunaPbt::where('id', $user->bahagian_jln)->first();
        if ($syarikat) {
            $syarikat->update([
                'address1' => strtoupper($request->input('address1', $syarikat->address1)),
                'address2' => strtoupper($request->input('address2', $syarikat->address2)),
                'postcode' => strtoupper($request->input('postcode', $syarikat->postcode)),
                'locality' => strtoupper($request->input('locality', $syarikat->locality)),
            ]);
        }
        $user->update([
            'department' => strtoupper($request->input('department', $user->department)),
            'position' => strtoupper($request->input('position', $user->position)),
            'sv_name' => strtoupper($request->input('sv_name', $user->sv_name)),
            'sv_email' => ($request->input('sv_email', $user->sv_email)),
            'phone' => ($request->input('phone', $user->phone)),
        ]);
        return redirect()->route('pengurusan.users.pbt.edit')->with('successMessage', 'Maklumat telah berjaya disimpan');
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
