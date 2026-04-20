<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Model\Negeri;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\MaklumatPenggunaPbt;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use App\Model\MaklumatPenggunaPenggiatIndustri_draf;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/pengurusan/dashboard';

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // return redirect()->route('register')->with('errorMessage', 'Maklumat telah berjaya dihapuskan');
        // dd($request->all());
        // Validate the request
        $validated = $this->validator($request->all())->validate();
        if ($validated) {
            // Create the user
            $user = $this->create($request->all());

            // dd($user);
            // Log the user in
            // Auth::loginUsingId($user->id);

            // Fire the registered event
            // event(new Registered($user));

            // Redirect to the dashboard
            // return redirect($this->redirectTo);
            if($user){
                return redirect()->route('register')->with('successMessage', 'Maklumat telah berjaya disimpan.<br> Sila tunggu emel pengaktifan sebelum mula<br> log masuk.<br> Proses pengesahan dalam 5 hari bekerja.');
            }
        } else {
            // return redirect()->route('auth.register')->withInput($request->all())->with('roles', $request->input('roles'));
        }
    }

    protected function validator(array $data)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Unique email validation rule
            'password' => 'required|string|min:8|confirmed', // Password confirmation rule
            'roles.*' => 'exists:roles,name', // Ensure the roles exist in the database
        ];

        // Define custom error messages
        $messages = [
            'required' => ':attribute is required.',
            'email' => ':attribute must be a valid email address.',
            'email.unique' => 'This email address is already in use. Please choose another one.', // Custom message for unique email
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.', // Custom message for password confirmation
            'roles.exists' => 'One or more of the selected roles are invalid.',
        ];

        // if (isset($data['roles']) && $data['roles'] === 'Penggiat Industri') {
        //     $rules['no_ssm'] = 'required|unique:maklumat_pengguna_penggiat_industri,no_ssm';
        //     $messages['no_ssm.unique'] = 'The MOF registration number has already been taken. Please choose another one.';
        // }    
        // dump($rules);
        // dd($messages);
        // Create the validator instance with the rules and messages
        return Validator::make($data, $rules, $messages);
    }

    protected function create(array $data)
    {
        // if($data['roles'] == "Penggiat Industri"){
        //     $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_ssm', $data['no_ssm'])->first();
        //     if ($existingMof) {
        //         return redirect()->back()->withErrors(['no_ssm' => 'The MOF registration number has already been taken. Please choose another one.']);
        //     }
        // }
        // Create a new user
        // $user = User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'is_active' => 0, // Set to inactive initially
        // ]);
        // $user->assignRole($data['roles'] );
        $accountType = $data['roles'] ? $data['roles'] : "-" ;
        if($accountType == "Pihak Berkuasa Tempatan"){
            $negeri = Negeri::select('kod_negeri')->where('nama_negeri', $data['state'])->first();
            $data['state'] = ($negeri['kod_negeri']);

            // $existingPbt = MaklumatPenggunaPbt::where('pbt_name', $data['pbt'])->first();
            $existingPbt = MaklumatPenggunaPbt::whereRaw('LOWER(pbt_name) = ?', [strtolower($data['pbt'])])->first();
            if ($existingPbt) {
                $maklumat = $existingPbt;
                $id = $existingPbt->id;
                $name = $existingPbt->pbt_name;
                $existingPbt->update([
                    // 'name' => $data['namaYDP'],
                    // 'email' => $data['emailYDP'],
                    // 'pbt_name' => $data['pbt'],
                    'address1' => $data['address1'],
                    'address2' => $data['address2'],
                    'postcode' => $data['postcode'],
                    'locality' => $data['locality'],
                    'state' => $data['state'],
                ]);
                //proceed without creating new row
            }else{
                $maklumat = MaklumatPenggunaPbt::create([
                    'name' => $data['pbt'],
                    'email' => $data['sv_email'],
                    'pbt_name' => $data['pbt'],
                    'address1' => $data['address1'],
                    'address2' => $data['address2'],
                    'postcode' => $data['postcode'],
                    'locality' => $data['locality'],
                    'state' => $data['state'],
                ]);
                $id = $maklumat->id;
                $name = $maklumat->pbt_name;
            }
        }else if($accountType == "Penggiat Industri"){
            $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_ssm', $data['no_ssm'])->first();
            if ($existingMof) {
                $maklumat = $existingMof;
                $id = $existingMof->id_elind;
                $name = $existingMof->name;
                //proceed without creating new row
            }else{
                $data['no_cidb'] = $data['no_cidb'] ?? null;
                $existing_cidb = MaklumatPenggunaPenggiatIndustri::where('no_cidb', $data['no_cidb'])->first();
                
                if ($existing_cidb && !empty($data['no_cidb'])) {
                    $maklumat = $existing_cidb;
                    $id = $existing_cidb->id_elind;
                    $name = $existing_cidb->name;
                    if($existing_cidb->no_ssm == null){
                        $existing_cidb_draf = MaklumatPenggunaPenggiatIndustri_draf::where('no_cidb', $data['no_cidb'])->first();
                        $existing_cidb_draf->update([
                            'no_ssm' => $data['no_ssm'],
                        ]);
                    }
                    //proceed without creating new row
                } else {
                    $maklumat = MaklumatPenggunaPenggiatIndustri::create([
                        'name' => $data['nama_syarikat'],
                        // 'email' => $data['email'],
                        'jenis_industri' => $data['jenis_penggiat'],
                        'no_ssm' => $data['no_ssm'],
                        'address1' => $data['address1'],
                        'address2' => $data['address2'],
                        'postcode' => $data['postcode'],
                        'locality' => $data['locality'],
                        'state' => $data['state'],
                    ]);
                    $id = $maklumat->id_elind;
                    $name = $maklumat->name;
                    $maklumat_draf = MaklumatPenggunaPenggiatIndustri_draf::create([
                        'name' => $data['nama_syarikat'],
                        'id_elind' => $id,
                        'jenis_industri' => $data['jenis_penggiat'],
                        'no_ssm' => $data['no_ssm'],
                        'address1' => $data['address1'],
                        'address2' => $data['address2'],
                        'postcode' => $data['postcode'],
                        'locality' => $data['locality'],
                        'state' => $data['state'],
                    ]);
                }
            }
            $accountType = $data['roles']." ({$data['jenis_penggiat']})";
        }else{
            return redirect()->route('auth.register')->with('errorMessage', 'Maklumat tidak berjaya disimpan');
        }

        if($maklumat){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => 0,
                'bahagian_jln' => $id,
            ]);
            $user->assignRole($data['roles'] );
        }
        if($accountType == "Pihak Berkuasa Tempatan"){
            $user->update([
                'department' => $data['department'] ?? null,
                'phone' => $data['phone'] ?? null,
                'position' => $data['position'] ?? null,
                'sv_name' => $data['sv_name'] ?? null,
                'sv_email' => $data['sv_email'] ?? null,
            ]);
        }
        
        // Send email notification (if enabled)
        if (config('mail.enabled')) {
            $bahagian_jln = 7;  //BTM
            $user_email = [];

            $emailArr = User::where(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pentadbir Sistem');
                });
            })->where('is_active', 1)
            ->orWhere(function ($query) use ($bahagian_jln) {
                $query->where(function ($q) use ($bahagian_jln) {
                    $q->whereHas('roles', function ($q) {
                        $q->where('name', 'Pegawai');
                    })->where('bahagian_jln', $bahagian_jln);
                });
            })->where('is_active', 1)
            ->get();

            foreach ($emailArr as $value) {
                if (filter_var($value->email, FILTER_VALIDATE_EMAIL)) {
                    $user_email[] = ['address' => $value->email, 'name' => $value->name];
                } else {
                    \Log::warning("Invalid user email skipped: {$value->email}");
                }
            }
            $ccEmail = $bccEmail = null;
            $bccEmail = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? $data['email'] : null;
            if($accountType == "Pihak Berkuasa Tempatan"){
                $ccEmail = filter_var($data['sv_email'], FILTER_VALIDATE_EMAIL) ? $data['sv_email'] : null;
            }
            // dump($user_email);
            // dump($ccEmail);
            // dump($bccEmail);
            // 3. Send if valid users found
            if (!empty($user_email)) {
                try {
                    Mail::send('pengurusan.users.mails.pendaftaran', [
                        'user' => $user,
                        'accountType' => $accountType,
                        'name' => $name,
                    ], function ($message) use ($user_email, $bccEmail, $ccEmail, $data) {
                        // Convert to array of "email => name"
                        $toList = collect($user_email)
                            ->pluck('name', 'address') // [email => name]
                            ->toArray();

                        $message->to($toList)
                                ->cc($data['email'], $data['name'] ?? '')
                                ->subject('Pendaftaran Pengguna Baru');

                        if ($ccEmail) {
                            $message->cc($ccEmail, $data['sv_name'] ?? '');
                        }

                        if ($bccEmail) {
                            $message->bcc($bccEmail, $data['name'] ?? '');
                        }
                        $message->bcc("frenemies.888@gmail.com", "frenemies.888@gmail.com");
                    });
                } catch (\Exception $e) {
                    \Log::error("Email sending failed: " . $e->getMessage());
                    // dd($e->getMessage());
                }
            } else {
                \Log::info("No valid user emails to send.");
            }
        }
        // dd($user);  
        return $user;
    }

    /**
     * A function used to insert PBT Users from a .csv file.
     */
    /*
    public function testCsv(Request $request)
    {

        if (!$request->hasFile('file_csv')) {
            dd('No file uploaded');
        }

        $file = $request->file('file_csv');

        if (!$file->isValid()) {
            dd('Invalid file');
        }

        $path = $file->getRealPath();

        $rows = array_map('str_getcsv', file($path));

        // remove header
        $header = array_shift($rows);

        $success = 0;
        $failed = 0;
        $errors = [];

        foreach ($rows as $i => $row) {

            if (count($row) < 13) continue;

            try {

                $postcode = str_replace("'", "", $row[4]);
                $state = trim($row[6]);

                // ✅ fix state (01, 02, etc.)
                if (is_numeric($state) && strlen($state) == 1) {
                    $state = '0' . $state;
                }

                $data = [
                    'pbt'       => strtoupper(trim($row[1])),
                    'address1'  => strtoupper(trim($row[2])),
                    'address2'  => strtoupper(trim($row[3])),
                    'postcode'  => trim($postcode),
                    'locality'  => strtoupper(trim($row[5])),
                    'state'     => $state,

                    'sv_name'   => strtoupper(trim($row[7])),
                    'sv_email'  => trim($row[8]),

                    'name'      => strtoupper(trim($row[9])),
                    'position'  => strtoupper(trim($row[10])),
                    'email'     => trim($row[11]),
                    'phone'     => trim($row[12]),

                    'roles'     => 'Pihak Berkuasa Tempatan',
                    'password'  => 'elandskapv2'
                ];

                // ✅ skip if no email (important for User table)
                if (empty($data['email'])) {
                    $failed++;
                    $errors[] = "Row $i: Missing email";
                    continue;
                }

                // ✅ skip duplicate user email
                if (\App\User::where('email', $data['email'])->exists()) {
                    $failed++;
                    $errors[] = "Row $i: Email exists - " . $data['email'];
                    continue;
                }
                // dd($data);  
                $accountType = $data['roles'] ? $data['roles'] : "-" ;
                if($accountType == "Pihak Berkuasa Tempatan"){
                    $existingPbt = MaklumatPenggunaPbt::whereRaw('LOWER(pbt_name) = ?', [strtolower($data['pbt'])])->first();
                    if ($existingPbt) {
                        $maklumat = $existingPbt;
                        $id = $existingPbt->id;
                        $name = $existingPbt->pbt_name;
                        $existingPbt->update([
                            'name' => $data['pbt'],
                            'email' => $data['sv_email'],
                            'address1' => $data['address1'],
                            'address2' => $data['address2'],
                            'postcode' => $data['postcode'],
                            'locality' => $data['locality'],
                            'state' => $data['state'],
                        ]);
                        //proceed without creating new row
                    }else{
                        $maklumat = MaklumatPenggunaPbt::create([
                            'name' => $data['pbt'],
                            'email' => $data['sv_email'],
                            'pbt_name' => $data['pbt'],
                            'address1' => $data['address1'],
                            'address2' => $data['address2'],
                            'postcode' => $data['postcode'],
                            'locality' => $data['locality'],
                            'state' => $data['state'],
                        ]);
                        $id = $maklumat->id;
                        $name = $maklumat->pbt_name;
                    }
                }


                $user = null;

                if ($maklumat) {

                    try {

                        // ✅ skip if email already exists
                        if (\App\User::where('email', $data['email'])->exists()) {
                            // optional: log it
                            \Log::info("Skipped existing email: " . $data['email']);
                        } else {

                            $user = User::create([
                                'name' => $data['name'],
                                'email' => $data['email'],
                                'password' => Hash::make($data['password']),
                                'is_active' => 1,
                                'bahagian_jln' => $id,
                            ]);

                            $user->assignRole($data['roles']);
                        }

                    } catch (\Exception $e) {
                        // ✅ skip error, don't break import
                        \Log::error("User create failed: " . $data['email'] . " | " . $e->getMessage());
                    }
                }

                if ($accountType == "Pihak Berkuasa Tempatan" && $user) {
                    try {
                        $user->update([
                            'department' => isset($data['pbt']) ? $data['pbt'] : null,
                            'phone' => isset($data['phone']) ? $data['phone'] : null,
                            'position' => isset($data['position']) ? $data['position'] : null,
                            'sv_name' => isset($data['sv_name']) ? $data['sv_name'] : null,
                            'sv_email' => isset($data['sv_email']) ? $data['sv_email'] : null,
                        ]);
                    } catch (\Exception $e) {
                        \Log::error("User update failed: " . $data['email'] . " | " . $e->getMessage());
                    }
                }
                
                // dd($user);  
                // return $user;

                $success++;

            } catch (\Exception $e) {
                $failed++;
                $errors[] = "Row $i: " . $e->getMessage();
            }
        }

        // ✅ RESULT SUMMARY
        dd([
            'success' => $success,
            'failed' => $failed,
            'errors' => $errors
        ]);
    }
    */
}
