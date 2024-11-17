<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/pengurusan/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {dump($data);
        // Create the new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => 0, // Set to 0 initially
        ]);

        // Email configuration
        if (config('mail.enabled') && $user) {
            $data = [
                "email_to_address" => 'admin@example.com', // Replace with the admin email address
                "email_to_name" => 'Admin',
                "email_cc_address" => 'cc@example.com', // Replace with the CC email address
                "email_cc_name" => 'CC Recipient',
                "subject" => 'New User Registration Notification',
                "status" => $user->is_active ? 'Aktif' : 'Tidak Aktif'
            ];

            try {
                Mail::send('pengurusan.users.mails.pendaftaran', ['user' => $user], function ($message) use ($data) {
                    $message->subject($data["subject"])
                            ->to($data["email_to_address"], $data["email_to_name"])
                            ->cc($data["email_cc_address"], $data["email_cc_name"]);
                });
                $this->statusdesc = "Message sent Successfully";
                $this->statuscode = "successMessage";
                return $user;
            } catch (\Exception $exception) {
                $this->statusdesc = "Error sending mail: " . $exception->getMessage();
                $this->statuscode = "warningMessage";
            }
        }
    }

    public function getNegeri()
    {
        $negeri = [
            ['id' => 1, 'name' => 'Johor'],
            ['id' => 2, 'name' => 'Kedah'],
            ['id' => 3, 'name' => 'Kelantan'],
            ['id' => 4, 'name' => 'Melaka'],
            ['id' => 5, 'name' => 'Negeri Sembilan'],
            ['id' => 6, 'name' => 'Pahang'],
            ['id' => 7, 'name' => 'Penang'],
            ['id' => 8, 'name' => 'Perak'],
            ['id' => 9, 'name' => 'Perlis'],
            ['id' => 10, 'name' => 'Sabah'],
            ['id' => 11, 'name' => 'Sarawak'],
            ['id' => 12, 'name' => 'Selangor'],
            ['id' => 13, 'name' => 'Terengganu'],
            ['id' => 14, 'name' => 'Kuala Lumpur'],
            // ['id' => 15, 'name' => 'Labuan'],
            // ['id' => 16, 'name' => 'Putrajaya']
        ];

        return response()->json($negeri);
    }

    // app/Http/Controllers/RegistrationController.php

public function getPBT($negeriId)
{
    $pbt = [
        // Johor
        1 => [
            ['id' => 1, 'name' => 'Majlis Bandaraya Johor Bahru'],
            ['id' => 2, 'name' => 'Majlis Bandaraya Iskandar Puteri'],
            ['id' => 3, 'name' => 'Majlis Bandaraya Pasir Gudang'],
            ['id' => 4, 'name' => 'Majlis Perbandaran Batu Pahat'],
            ['id' => 5, 'name' => 'Majlis Perbandaran Kluang'],
            ['id' => 6, 'name' => 'Majlis Perbandaran Kulai'],
            ['id' => 7, 'name' => 'Majlis Perbandaran Muar'],
            ['id' => 8, 'name' => 'Majlis Perbandaran Pontian'],
            ['id' => 9, 'name' => 'Majlis Perbandaran Segamat'],
            ['id' => 10, 'name' => 'Majlis Perbandaran Pengerang'],
            ['id' => 11, 'name' => 'Majlis Daerah Kota Tinggi'],
            ['id' => 12, 'name' => 'Majlis Daerah Labis'],
            ['id' => 13, 'name' => 'Majlis Daerah Mersing'],
            ['id' => 14, 'name' => 'Majlis Daerah Simpang Renggam'],
            ['id' => 15, 'name' => 'Majlis Daerah Tangkak'],
            ['id' => 16, 'name' => 'Majlis Daerah Yong Peng'],
        ],
        // Kedah
        2 => [
            ['id' => 17, 'name' => 'Majlis Bandaraya Alor Setar'],
            ['id' => 18, 'name' => 'Majlis Perbandaran Kulim'],
            ['id' => 19, 'name' => 'Majlis Perbandaran Sungai Petani'],
            ['id' => 20, 'name' => 'Majlis Perbandaran Langkawi Bandaraya Pelancongan'],
            ['id' => 21, 'name' => 'Majlis Perbandaran Kubang Pasu'],
            ['id' => 22, 'name' => 'Majlis Daerah Baling'],
            ['id' => 23, 'name' => 'Majlis Daerah Bandar Baharu'],
            ['id' => 24, 'name' => 'Majlis Daerah Padang Terap'],
            ['id' => 25, 'name' => 'Majlis Daerah Pendang'],
            ['id' => 26, 'name' => 'Majlis Daerah Sik'],
            ['id' => 27, 'name' => 'Majlis Daerah Yan'],
        ],
        // Kelantan
        3 => [
            ['id' => 28, 'name' => 'Majlis Perbandaran Kota Bharu Bandaraya Islam'],
            ['id' => 29, 'name' => 'Majlis Daerah Bachok Bandar Pelancongan Islam'],
            ['id' => 30, 'name' => 'Majlis Daerah Gua Musang'],
            ['id' => 31, 'name' => 'Majlis Daerah Ketereh Perbandaran Islam'],
            ['id' => 32, 'name' => 'Majlis Daerah Dabong'],
            ['id' => 33, 'name' => 'Majlis Daerah Kuala Krai'],
            ['id' => 34, 'name' => 'Majlis Daerah Machang'],
            ['id' => 35, 'name' => 'Majlis Daerah Pasir Mas'],
            ['id' => 36, 'name' => 'Majlis Daerah Pasir Puteh'],
            ['id' => 37, 'name' => 'Majlis Daerah Tanah Merah'],
            ['id' => 38, 'name' => 'Majlis Daerah Tumpat'],
            ['id' => 39, 'name' => 'Majlis Daerah Jeli'],
        ],
        // Melaka
        4 => [
            ['id' => 40, 'name' => 'Majlis Bandaraya Melaka Bersejarah'],
            ['id' => 41, 'name' => 'Majlis Perbandaran Alor Gajah'],
            ['id' => 42, 'name' => 'Majlis Perbandaran Jasin'],
            ['id' => 43, 'name' => 'Majlis Perbandaran Hang Tuah Jaya'],
        ],
        // Negeri Sembilan
        5 => [
            ['id' => 44, 'name' => 'Majlis Bandaraya Seremban'],
            ['id' => 45, 'name' => 'Majlis Perbandaran Port Dickson'],
            ['id' => 46, 'name' => 'Majlis Perbandaran Jempol'],
            ['id' => 47, 'name' => 'Majlis Daerah Jelebu'],
            ['id' => 48, 'name' => 'Majlis Daerah Kuala Pilah'],
            ['id' => 49, 'name' => 'Majlis Daerah Rembau'],
            ['id' => 50, 'name' => 'Majlis Daerah Tampin'],
        ],
        // Pahang
        6 => [
            ['id' => 51, 'name' => 'Majlis Bandaraya Kuantan'],
            ['id' => 52, 'name' => 'Majlis Perbandaran Temerloh'],
            ['id' => 53, 'name' => 'Majlis Perbandaran Bentong'],
            ['id' => 54, 'name' => 'Majlis Perbandaran Pekan'],
            ['id' => 55, 'name' => 'Majlis Daerah Cameron Highlands'],
            ['id' => 56, 'name' => 'Majlis Daerah Jerantut'],
            ['id' => 57, 'name' => 'Majlis Daerah Lipis'],
            ['id' => 58, 'name' => 'Majlis Daerah Maran'],
            ['id' => 59, 'name' => 'Majlis Daerah Raub'],
            ['id' => 60, 'name' => 'Majlis Daerah Rompin'],
            ['id' => 61, 'name' => 'Majlis Daerah Bera'],
        ],
        // Penang
        7 => [
            ['id' => 62, 'name' => 'Majlis Bandaraya Pulau Pinang'],
            ['id' => 63, 'name' => 'Majlis Bandaraya Seberang Perai'],
        ],
        // Perak
        8 => [
            ['id' => 64, 'name' => 'Majlis Bandaraya Ipoh'],
            ['id' => 65, 'name' => 'Majlis Perbandaran Manjung'],
            ['id' => 66, 'name' => 'Majlis Perbandaran Kuala Kangsar'],
            ['id' => 67, 'name' => 'Majlis Perbandaran Taiping'],
            ['id' => 68, 'name' => 'Majlis Perbandaran Teluk Intan'],
            ['id' => 69, 'name' => 'Majlis Daerah Kampar'],
            ['id' => 70, 'name' => 'Majlis Daerah Gerik'],
            ['id' => 71, 'name' => 'Majlis Daerah Kerian'],
            ['id' => 72, 'name' => 'Majlis Daerah Batu Gajah'],
            ['id' => 73, 'name' => 'Majlis Daerah Lenggong'],
            ['id' => 74, 'name' => 'Majlis Daerah Pengkalan Hulu'],
            ['id' => 75, 'name' => 'Majlis Daerah Perak Tengah'],
            ['id' => 76, 'name' => 'Majlis Daerah Selama'],
            ['id' => 77, 'name' => 'Majlis Daerah Tanjong Malim'],
            ['id' => 78, 'name' => 'Majlis Daerah Tapah'],
        ],
        // Perlis
        9 => [
            ['id' => 152, 'name' => 'Majlis Perbandaran Kangar'],
        ],
        // Selangor
        10 => [
            ['id' => 79, 'name' => 'Majlis Bandaraya Shah Alam'],
            ['id' => 80, 'name' => 'Majlis Bandaraya Petaling Jaya'],
            ['id' => 81, 'name' => 'Majlis Bandaraya Diraja Klang'],
            ['id' => 82, 'name' => 'Majlis Bandaraya Subang Jaya'],
            ['id' => 83, 'name' => 'Majlis Perbandaran Ampang Jaya'],
            ['id' => 84, 'name' => 'Majlis Perbandaran Kajang'],
            ['id' => 85, 'name' => 'Majlis Perbandaran Selayang'],
            ['id' => 86, 'name' => 'Majlis Perbandaran Sepang'],
            ['id' => 87, 'name' => 'Majlis Perbandaran Hulu Selangor'],
            ['id' => 88, 'name' => 'Majlis Perbandaran Kuala Langat'],
            ['id' => 89, 'name' => 'Majlis Perbandaran Kuala Selangor'],
            ['id' => 90, 'name' => 'Majlis Daerah Sabak Bernam'],
        ],
        // Terengganu
        11 => [
            ['id' => 91, 'name' => 'Majlis Bandaraya Kuala Terengganu'],
            ['id' => 92, 'name' => 'Majlis Perbandaran Kemaman'],
            ['id' => 93, 'name' => 'Majlis Perbandaran Dungun'],
            ['id' => 94, 'name' => 'Majlis Daerah Besut'],
            ['id' => 95, 'name' => 'Majlis Daerah Hulu Terengganu'],
            ['id' => 96, 'name' => 'Majlis Daerah Marang'],
            ['id' => 97, 'name' => 'Majlis Daerah Setiu'],
        ],
        // Sabah
        12 => [
            ['id' => 98, 'name' => 'Dewan Bandaraya Kota Kinabalu'],
            ['id' => 99, 'name' => 'Majlis Perbandaran Sandakan'],
            ['id' => 100, 'name' => 'Majlis Perbandaran Tawau'],
            ['id' => 101, 'name' => 'Majlis Daerah Beaufort'],
            ['id' => 102, 'name' => 'Majlis Daerah Beluran'],
            ['id' => 103, 'name' => 'Majlis Daerah Keningau'],
            ['id' => 104, 'name' => 'Majlis Daerah Kinabatangan'],
            ['id' => 105, 'name' => 'Majlis Daerah Kota Belud'],
            ['id' => 106, 'name' => 'Majlis Daerah Kota Marudu'],
            ['id' => 107, 'name' => 'Majlis Daerah Kuala Penyu'],
            ['id' => 108, 'name' => 'Majlis Daerah Kunak'],
            ['id' => 109, 'name' => 'Majlis Daerah Lahad Datu'],
            ['id' => 110, 'name' => 'Majlis Daerah Nabawan'],
            ['id' => 111, 'name' => 'Majlis Daerah Papar'],
            ['id' => 112, 'name' => 'Majlis Daerah Penampang'],
            ['id' => 113, 'name' => 'Majlis Daerah Ranau'],
            ['id' => 114, 'name' => 'Majlis Daerah Semporna'],
            ['id' => 115, 'name' => 'Majlis Daerah Sipitang'],
            ['id' => 116, 'name' => 'Majlis Daerah Tambunan'],
            ['id' => 117, 'name' => 'Majlis Daerah Tenom'],
            ['id' => 118, 'name' => 'Majlis Daerah Tuaran'],
            ['id' => 119, 'name' => 'Lembaga Bandaran Kudat'],
            ['id' => 120, 'name' => 'Majlis Daerah Pitas'],
            ['id' => 121, 'name' => 'Majlis Daerah Putatan'],
            ['id' => 122, 'name' => 'Majlis Daerah Tongod'],
            ['id' => 123, 'name' => 'Majlis Daerah Telupid'],
        ],
        // Sarawak
        13 => [
            ['id' => 124, 'name' => 'Dewan Bandaraya Kuching Utara'],
            ['id' => 125, 'name' => 'Majlis Bandaraya Kuching Selatan'],
            ['id' => 126, 'name' => 'Majlis Bandaraya Miri'],
            ['id' => 127, 'name' => 'Majlis Perbandaran Padawan'],
            ['id' => 128, 'name' => 'Majlis Perbandaran Sibu'],
            ['id' => 129, 'name' => 'Majlis Perbandaran Kota Samarahan'],
            ['id' => 130, 'name' => 'Lembaga Kemajuan Bintulu (Perbandaran)'],
            ['id' => 131, 'name' => 'Majlis Daerah Bau'],
            ['id' => 132, 'name' => 'Majlis Daerah Betong'],
            ['id' => 133, 'name' => 'Majlis Daerah Dalat & Mukah'],
            ['id' => 134, 'name' => 'Majlis Daerah Kanowit'],
            ['id' => 135, 'name' => 'Majlis Daerah Kapit'],
            ['id' => 136, 'name' => 'Majlis Daerah Lawas'],
            ['id' => 137, 'name' => 'Majlis Daerah Luar Bandar Sibu'],
            ['id' => 138, 'name' => 'Majlis Daerah Lubok Antu'],
            ['id' => 139, 'name' => 'Majlis Daerah Maradong & Julau'],
            ['id' => 140, 'name' => 'Majlis Daerah Lundu'],
            ['id' => 141, 'name' => 'Majlis Daerah Marudi'],
            ['id' => 142, 'name' => 'Majlis Daerah Matu & Daro'],
            ['id' => 143, 'name' => 'Majlis Daerah Saratok'],
            ['id' => 144, 'name' => 'Majlis Daerah Sarikei'],
            ['id' => 145, 'name' => 'Majlis Daerah Serian'],
            ['id' => 146, 'name' => 'Majlis Daerah Simunjan'],
            ['id' => 147, 'name' => 'Majlis Daerah Sri Aman'],
            ['id' => 148, 'name' => 'Majlis Daerah Subis'],
            ['id' => 149, 'name' => 'Majlis Daerah Limbang'],
            ['id' => 150, 'name' => 'Majlis Daerah Gedong'],
        ],
        // Kuala Lumpur
        14 => [
            ['id' => 151, 'name' => 'Dewan Bandaraya Kuala Lumpur'],
        ],
    ];

    return response()->json($pbt[$negeriId] ?? []);
}

}
