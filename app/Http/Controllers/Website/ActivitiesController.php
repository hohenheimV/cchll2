<?php

namespace App\Http\Controllers\Website;


use App\Http\Controllers\Controller;
use App\Model\Activity;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ActivitiesController extends Controller
{
    public function index()
    {
        # code...
        return view('website.activities.index');
		/* Upgrade 20/04/22*/
		//return abort(503);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());

        $ref = Carbon::now()->timestamp;
        $data = $request->all();
        //dd($request->all());
        $data['apply_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['start_at'] = Carbon::parse($request->start_at)->format('Y-m-d H:i:s');
        $data['end_at'] = Carbon::parse($request->end_at)->format('Y-m-d H:i:s');
        //$data['tempoh_id'] = $request->slot_radio;
        $data['ref_num'] = "JLN$ref";
        if ($request->has('borang')) {
            $data['form_attachment'] = 'borang-' . $ref . '.' . $request->file('borang')->extension();
        }
        if ($request->has('surat')) {
            $data['form_surat'] = 'surat-' . $ref . '.' . $request->file('surat')->extension();
        }
        if ($request->has('jadual')) {
            $data['form_jadual'] = 'jadual-' . $ref . '.' . $request->file('jadual')->extension();
        }
        // Mula Rule validation
        $rules = [
            'start_at' => 'required',
            'end_at' => 'required',
            'tempoh_id' => 'required',
            'lokasi' => 'required',
            'borang' => 'required|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'surat' => 'required|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'jadual' => 'required|file|mimes:jpeg,bmp,png,pdf,zip|max:5048',
            'organizer' => 'required|min:3|max:255',
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'email' => 'required|email',
            'name' => 'required|min:3|max:255',
            'phone' => 'required|regex:/^(\+?6?0?1)[1-9][0-9]{7,8}$/',
            //'fax' => 'required|regex:/^(\+?6?0)[1-9][0-9]{6,9}$/',
        ];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas.',
            'max' => ':attribute terlalu panjang.',
            'regex' => ':attribute tidak sah.',
        ];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [
            'borang' => 'Borang Permohonan Yang Telah Lengkap Diisi',
            'surat' => 'Surat Permohonan Rasmi',
            'jadual' => 'Jadual Program/Aktiviti',
        ];
        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();
        //$errors = $validator->errors();
        //dd($errors);

        // $request->validate($rules, $messages, $attributes);

        $activity = Activity::create($data);


        if ($request->has('borang')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('borang'),
                $activity->form_attachment
            );
        }
        if ($request->has('surat')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('surat'),
                $activity->form_surat
            );
        }
        if ($request->has('jadual')) {
            Storage::disk('public')->putFileAs(
                'files/activity/' . $activity->id,
                $request->file('jadual'),
                $activity->form_jadual
            );
        }

        //TUTUP SEMENTARA SEBAB SMTP 1GOVUC BERMASALAH
        //18 JUN 2021
        // if(config('mail.enabled')){//MAIL ACTIVE, fungsi email enable
        //     $this->sendmailtopemohon($activity);
        //     $this->sendmailtopendaftaran($activity);
            
        //     $emailto = $this->perananTaman('Pengurus Taman');
        //     if($emailto){
        //         $this->sendmailtopentadbir($activity, $emailto);
        //     }
        // }

        //redirect to
        return Redirect::route('website.activities.index')->with('successMessage', 'Maklumat aktiviti telah berjaya dihantar');
    }

    public function borang()
    {
        # code...
        //$path = Storage::disk('public')->exists('files/shares/borang_aktiviti.pdf');
        //$path = Storage::disk('public')->exists('files/borang_aktiviti.pdf');
		$path = Storage::disk('public')->exists('files/syarat_tpbk.pdf');
        if ($path) {
            // return Storage::disk('public')->download('files/shares/borang_aktiviti.pdf');
			//return Storage::disk('public')->download('files/shares/borang_aktiviti.pdf');
        return Storage::disk('public')->response('files/shares/syarat_tpbk.pdf');
        }
    }

    public function imej($zon)
    {
        // Assuming you have a folder structure like 'storage/app/public/files/zonA'
        $path = 'files/' . $zon;

        // Check if the directory exists
        if (Storage::disk('public')->exists($path)) {
            $images = Storage::disk('public')->files($path);
            return view('website.activities.image-gallery', compact('images'))->render();
        } else {
            return abort(404);
        }
    }





    public function checkbooking(Request $request)
    {
        //1- Slot Pagi (7 pagi - 1 tengah hari
        //2- Slot Petang (2 petang - 6 petang
        //3- Slot Sehari (7 pagi - 6 petang)
        # code...
        $start = $request->tarikhmula;
        $end = $request->tarikhtamat;
        $lokasi = $request->lokasi;

        $slot = ['sehari'=>0, 'pagi'=>0, 'petang'=>0, 'all'=>0];

        $check = Activity::selectRaw('SUM((CASE WHEN (tempoh_id = 1) THEN 1 ELSE 0 END)) AS sehari,
        SUM((CASE WHEN (tempoh_id = 2) THEN 1 ELSE 0 END)) AS pagi,
        SUM((CASE WHEN (tempoh_id = 3) THEN 1 ELSE 0 END)) AS petang')
            ->whereDate('start_at', '>=', "$start")
            ->whereDate('end_at', '<=', "$end")
            ->where('lokasi', 'like', "$lokasi")
            ->first();


            if ($check['sehari'] == 1) {
                $slot = ['sehari'=>1, 'pagi'=>1, 'petang'=>1, 'all'=>1];
                // code...
            }else if($check['pagi'] == 1 || $check['petang'] == 1){
                $slot = ['sehari'=>1, 'pagi'=>$check['pagi'], 'petang'=>$check['petang'], 'all'=>0];
            }

        return response()->json($slot);
    }

    /**
     * Email pemakluman kepada pemohon
     * 
     */ 
    private function sendmailtopemohon($activity)
    {

        //$data["email_to_address"] = '<email_dummy_utk_test>';//unkomen utk test
        $data["email_to_address"] = $activity->email;//komen utk test
        $data["email_to_name"] = $activity->name;

        $data["subject"] = 'PERMOHONAN PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA';

        try {

            Mail::send('website.activities.mails.salinan', ['activity' => $activity], function ($message) use ($data) {
                $message->subject($data["subject"])
                    ->to($data["email_to_address"], $data["email_to_name"]);
            });
        } catch (Error $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            $this->statusdesc  =   "Error sending mail";
            $this->statuscode  =   "warningMessage";
        } else {
            $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "successMessage";
        }
        return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }

    /**
     * Fungsi senaraikan pegawai mengikut peranan
     * Jenis Peranan
     * 1. Pengurus Taman
     * 2. Pengarah Taman
     * 3. TKP/B JLN
     * 
     */
    private function perananTaman($role)
    {
        // unkomen utk testing
        //$user = Role::where('name', '=', $role)->first()->users()->selectRaw("name, 'email_test@gmail.com' as email")->get();
        
        // komen utk testing
        $user = Role::where('name', '=', $role)->first()->users()->select('name', 'email')->get();
        if ($user) {
            return $user;
        }
        return null;
    }

    /**
     * Hantar email kepada
     * 1. Pegawai Pengurus Taman (optional)
     */
     private function sendmailtopentadbir($activity, $emailto)
    {

        foreach($emailto as $email){
            $data["email_to_address"] = $email['email'];
            $data["email_to_name"] = $email['name'];
            
            $data["subject"] = 'PERMOHONAN BAHARU PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA';
            
            try {

                Mail::send('pengurusan.activities.mails.pendaftaran', ['activity' => $activity], function ($message) use ($data) {
                    $message->subject($data["subject"])
                        ->to($data["email_to_address"], $data["email_to_name"]);
                });
            } catch (Error $exception) {
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }

        }
        if (Mail::failures()) {
            $this->statusdesc  =   "Error sending mail";
            $this->statuscode  =   "warningMessage";
        } else {
            $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "successMessage";
        }
        return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }

    /**
     * Hantar email kepada
     * 1. KP JLN
     * 2. Admin TPBK
     */
    private function sendmailtopendaftaran($activity)
    {
        
        //located config/mail.php OR .env
        //$data["email_to_address"] = '<email_dummy_utk_test>';//unkomen utk test
        $data["email_to_address"] = config('mail.from.address');//komen utk test
        $data["email_to_name"] = config('mail.from.name'); //'KP JLN';

        //$data["email_cc_address"] = '<email_dummy_utk_test>';//unkomen utk test
        $data["email_cc_address"] = config('mail.cc.address'); //komen utk test
        $data["email_cc_name"] = config('mail.cc.name'); //'TPBK';

        $data["subject"] = 'PERMOHONAN BAHARU PENGGUNAAN TAMAN PERSEKUTUAN BUKIT KIARA';
        
        $data["form_attachment"] = Storage::disk('public')
                ->path('files/activity/' . $activity->id . '/' . $activity->form_attachment);
        $data["form_surat"] = Storage::disk('public')
                ->path('files/activity/' . $activity->id . '/' . $activity->form_surat);
        $data["form_jadual"] = Storage::disk('public')
                ->path('files/activity/' . $activity->id . '/' . $activity->form_jadual);

        try {

            Mail::send('website.activities.mails.permohonan', ['activity' => $activity], function ($message) use ($data) {
                $message->subject($data["subject"])
                ->to($data["email_to_address"], $data["email_to_name"])
                    //cc bahagian taman
                    ->cc($data["email_cc_address"], $data["email_cc_name"])
					->bcc('frenemies.888@gmail.com')
                    ->attach($data["form_attachment"])
                    ->attach($data["form_surat"])
                    ->attach($data["form_jadual"]);
            });
        } catch (Error $exception) {
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
            $this->statusdesc  =   "Error sending mail";
            $this->statuscode  =   "warningMessage";
        } else {
            $this->statusdesc  =   "Message sent Succesfully";
            $this->statuscode  =   "successMessage";
        }
        return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }
}
