<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\MaklumatPenggunaPbt;
use App\Model\MaklumatPenggunaPenggiatIndustri;

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
            return redirect()->route('register')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
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
            'password.min' => ':attribute must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.', // Custom message for password confirmation
            'roles.exists' => 'One or more of the selected roles are invalid.',
        ];

        // if (isset($data['roles']) && $data['roles'] === 'Penggiat Industri') {
        //     $rules['no_mof'] = 'required|unique:maklumat_pengguna_penggiat_industri,no_mof';
        //     $messages['no_mof.unique'] = 'The MOF registration number has already been taken. Please choose another one.';
        // }    
        // dump($rules);
        // dd($messages);
        // Create the validator instance with the rules and messages
        return Validator::make($data, $rules, $messages);
    }

    protected function create(array $data)
    {
        // if($data['roles'] == "Penggiat Industri"){
        //     $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_mof', $data['no_mof'])->first();
        //     if ($existingMof) {
        //         return redirect()->back()->withErrors(['no_mof' => 'The MOF registration number has already been taken. Please choose another one.']);
        //     }
        // }
        // Create a new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => 0, // Set to inactive initially
        ]);
        $user->assignRole($data['roles'] );
        $accountType = $data['roles'] ? $data['roles'] : "-" ;

        if($accountType == "Pihak Berkuasa Tempatan"){
            $maklumat = MaklumatPenggunaPbt::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'pbt_name' => $data['pbt'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'postcode' => $data['postcode'],
                'locality' => $data['locality'],
                'state' => $data['state'],
            ]);
        }else if($accountType == "Penggiat Industri"){
            $existingMof = MaklumatPenggunaPenggiatIndustri::where('no_mof', $data['no_mof'])->first();
            if ($existingMof) {
                return redirect()->back()->withErrors(['no_mof' => 'The MOF registration number has already been taken. Please choose another one.']);
            }
            $maklumat = MaklumatPenggunaPenggiatIndustri::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'jenis_industri' => $data['jenis_penggiat'],
                'no_mof' => $data['no_mof'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'postcode' => $data['postcode'],
                'locality' => $data['locality'],
                'state' => $data['state'],
            ]);
            $accountType = $data['roles']." ({$data['jenis_penggiat']})";
        }else{
            return redirect()->route('auth.register')->with('errorMessage', 'Maklumat telah berjaya dihapuskan');
        }

        // Send email notification (if enabled)
        if (config('mail.enabled')) {
            try {
                $emailData = [
                    "email_to_address" => 'admin@example.com',
                    "email_to_name" => 'Admin',
                    "email_cc_address" => 'cc@example.com',
                    "email_cc_name" => 'CC Recipient',
                    "subject" => 'New User Registration Notification',
                    "status" => $user->is_active ? 'Active' : 'Inactive',
                ];

                Mail::send('pengurusan.users.mails.pendaftaran', ['user' => $user, 'accountType' => $accountType], function ($message) use ($emailData) {
                    $message->subject($emailData["subject"])
                            ->to($emailData["email_to_address"], $emailData["email_to_name"])
                            ->cc($emailData["email_cc_address"], $emailData["email_cc_name"]);
                });
            } catch (\Exception $exception) {
                // Handle mail sending error
                // You can log the exception or display an error message
                // \Log::error("Error sending registration email: " . $exception->getMessage());
            }
        }

        return $user;
    }
}
