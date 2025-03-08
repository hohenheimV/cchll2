<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLAPS;  // Updated to the new model
use App\Model\ePALM;
use App\Model\ePALM_draf;
use App\Model\MaklumatPenggunaPbt;  // Updated to the new model
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class eLAPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|TKP/B JLN|Pegawai|Pihak Berkuasa Tempatan|eLAPS-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|TKP/B JLN|Pegawai|Pihak Berkuasa Tempatan|eLAPS-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|TKP/B JLN|Pegawai|Pihak Berkuasa Tempatan|eLAPS-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|TKP/B JLN|Pegawai|Pihak Berkuasa Tempatan|eLAPS-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $userId = $this->getUserID();
        $user = $this->getUser();//User::whereRaw('id = ?', [$userId])->first();
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $totalCount = eLAPS::where('id_pemohon', $userId)->count();
            $eLAPS = eLAPS::where('id_pemohon', $userId)->orderBy('id', 'desc')->paginate($totalCount);
        }elseif($user->hasRole('TKP/B JLN|Pentadbir Sistem')){
            $totalCount = eLAPS::count();
            $eLAPS = eLAPS::orderByRaw('CAST(status_permohonan AS INT) ASC')->orderBy('id', 'desc')->paginate($totalCount);
        }else{
            // $totalCount = eLAPS::where('status_permohonan', '!=', $userId)->count();
            // $eLAPS = eLAPS::where('status_permohonan', '!=', $userId)->orderBy('id', 'desc')->paginate($totalCount);
            $totalCount = eLAPS::where('bahagian_jln', $user->bahagian_jln)->count();
            $eLAPS = eLAPS::orderByRaw('CAST(status_permohonan AS INT) ASC')->where('bahagian_jln', $user->bahagian_jln)->orderBy('id', 'desc')->paginate($totalCount);
        }

        $eLAPS->getCollection()->transform(function ($eLAP) {
            // Assuming id_pemohon is a reference to the 'User' model or a similar model
            $email = User::find($eLAP->id_pemohon)->email;
            $pbt = MaklumatPenggunaPbt::where('email', '=', $email)->first();
            // $pbt = MaklumatPenggunaPbt::where('email', '=', '5netsparker@example.com')->first();
            
            // Add the pbt_name to each eLAP record
            $eLAP->pbt_name = $pbt ? $pbt->pbt_name : null;

            // $eLAPSTemp = eLAPS::findOrFail($eLAP->id);
            // $currentYear = Carbon::now()->year;
            // $recordCount = $eLAP->id - 32;
            // $referenceNumber = "JLN/{$currentYear}/{$recordCount}";
            // $eLAPSTemp->update(['referenceNumber' => $referenceNumber]);
    
            return $eLAP;
        });

        return view('pengurusan.eLAPS.index', ['eLAPS' => $eLAPS]);
    }

    public function getUser()
    {
        $userId = $this->getUserID();
        return User::find($userId);
    }

    public function getUserID()
    {
        return auth()->id();
    }

    public function getPBT($id_pemohon = null)
    {
        // dd($id_pemohon);
        if($id_pemohon == null){
            $user = $this->getUser();
            // return MaklumatPenggunaPbt::where('email', '=', $user->email)->first();
            return MaklumatPenggunaPbt::where('email', '=', '5netsparker@example.com')->first();
        }else if($id_pemohon){
            return MaklumatPenggunaPbt::where('id', '=', $id_pemohon)->first();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentYear = Carbon::now()->year;
        $recordCount = eLAPS::whereYear('created_at', $currentYear)->count();
        $referenceNumber = $recordCount + 1;
        $referenceNumber = "JLN/{$currentYear}/{$referenceNumber}";

        $eLAPS = new eLAPS();
        // $eLAPS->referenceNumber = $referenceNumber;
        // dd($eLAPS);
        return view('pengurusan.eLAPS.create'/* , compact('eLAPS') */);
    }

    public function validateData(array $request)
    {
        if (isset($request['action']) && $request['action'] === 'submit') {
            $validator = Validator::make($request, [
                'projectTitle' => 'required',
                'category' => 'required|array',
                'category.0' => 'required',
                'category.lain-lain' => 'required_if:category.0,Lain-lain (sila nyatakan)',   
                'rancangan_pembangunan' => 'required|array',
                'rancangan_pembangunan.jenis' => 'required',
                'rancangan_pembangunan.keterangan' => 'required_if:rancangan_pembangunan.jenis,Lain-Lain Pelan Pembangunan (Nyatakan)',          
                'hakmilik_tanah' => 'required',
                'status_tanah' => 'required|array',
                'kemudahsampaian' => 'required',
                'guna_tanah' => 'required',
                'pelan_ukur' => 'required|array',
                'masalah' => 'required|array',
                'anggaranKos' => 'required|numeric',
                'keluasan' => 'required|numeric',
                'unit_keluasan' => 'required',
                'no_lot' => 'required',
                'negeri' => 'required',
                'daerah' => 'required',
                'mukim' => 'required',
                'parlimen' => 'required',
                'dun' => 'required',
                'aktiviti_semasa' => 'required',
                'jumlah_penduduk' => 'required|numeric', 
            ]);
        }else{
            $validator = Validator::make($request, [
                'projectTitle' => 'required',
                'category' => 'required|array',
                'category.0' => 'required',
                'category.lain-lain' => 'required_if:category.0,Lain-lain (sila nyatakan)',   
                'anggaranKos' => 'required|numeric',
            ]);
        }
        if ($validator->fails()) {
            $errors = $validator->errors();
            $formattedErrorMessages = [];
            foreach ($errors->messages() as $field => $messages) {
                $formattedField = strtoupper(str_replace('_', ' ', $field));
                foreach ($messages as $message) {
                    $formattedMessage = strtoupper(str_replace('validation.', '', $message));
                    $formattedErrorMessages[] = "The \"$formattedField\" field: $formattedMessage";
                }
            }
            $formattedErrorMessage = implode('<br>', $formattedErrorMessages);
            return redirect()->back()->with('errorMessage', $formattedErrorMessage);
        }
        // Handle category input
        $category = $request['category'] ?? null;
        if (is_array($category) && isset($category[0]) && $category[0] == "Lain-lain (sila nyatakan)") {
            $lainLain = $request['category']['lain-lain'] ?? null;
            $request['category'] = $lainLain;
        } else {
            $request['category'] = $category[0] ?? null;
        }

        // Handle rancangan_pembangunan input (convert to JSON)
        $rancangan_pembangunan = collect($request['rancangan_pembangunan'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['rancangan_pembangunan'] = json_encode($rancangan_pembangunan);

        // Handle hakmilik_tanah input
        $hakmilik_tanah = $request['hakmilik_tanah'] ?? null;
        if (is_array($hakmilik_tanah) && isset($hakmilik_tanah['hakmilik']) && $hakmilik_tanah['hakmilik'] == "Agensi lain (Nyatakan)") {
            $lainLain = $request['hakmilik_tanah']['keterangan'] ?? null;
            $request['hakmilik_tanah'] = $lainLain;
        } else {
            $request['hakmilik_tanah'] = $hakmilik_tanah['hakmilik'] ?? null;
        }

        // Handle status_tanah input (convert to JSON)
        $status_tanah = collect($request['status_tanah'] ?? [])
            ->map(function($item) {
                return $item;
            })
            ->toArray();
        $request['status_tanah'] = json_encode($status_tanah);

        // Handle kemudahsampaian input
        $kemudahsampaian = $request['kemudahsampaian'] ?? null;
        if (is_array($kemudahsampaian) && isset($kemudahsampaian[0])) {
            $request['kemudahsampaian'] = $kemudahsampaian[0];
        } else {
            $request['kemudahsampaian'] = null;
        }

        // Handle guna_tanah input
        $guna_tanah = $request['guna_tanah'] ?? null;
        if (is_array($guna_tanah) && isset($guna_tanah['jenis']) && $guna_tanah['jenis'] == "Lain-lain (nyatakan) :") {
            $lainLain = $request['guna_tanah']['keterangan'] ?? null;
            $request['guna_tanah'] = $lainLain;
        } else {
            $request['guna_tanah'] = $guna_tanah['jenis'] ?? null;
        }

        // Handle pelan_ukur input (convert to JSON)
        $pelan_ukur = $request['pelan_ukur'] ?? [];
        if (is_array($pelan_ukur) && isset($pelan_ukur[0]) && $pelan_ukur[0] == "Ya") {
            $pelan_ukurVal = collect($pelan_ukur)
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
            $request['pelan_ukur'] = json_encode($pelan_ukurVal);
        } else {
            $pelan_ukurVal = [
                '0' => $pelan_ukur[0] ?? null,
                'tarikh' => null
            ];
            $request['pelan_ukur'] = json_encode($pelan_ukurVal);
        }

        // Handle masalah input (convert to JSON)
        $masalah = collect($request['masalah'] ?? [])
            ->map(function($item) {
                return $item[0];
            })
            ->toArray();
        $request['masalah'] = json_encode($masalah);

        // Clean anggaranKos and convert to float
        $cleanedValue = str_replace(',', '', $request['anggaranKos'] ?? '');
        $decimalValue = (float)$cleanedValue;
        $request['anggaranKos'] = $decimalValue;

        return $request;
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
        $userId = auth()->id();
        $user = User::whereRaw('id = ?', [$userId])->first();
        // dd($user->name); // Now you can access the 'name' attribute

        // Get the current year
        $currentYear = Carbon::now()->year;
        $recordCount = eLAPS::whereYear('created_at', $currentYear)->count();
        $referenceNumber = $recordCount + 1;
        $referenceNumber = "JLN/{$currentYear}/{$referenceNumber}";
        $request->merge(['referenceNumber' => $referenceNumber]);

        $request->merge(['id_pemohon' => $userId ]);
        $request->merge(['status_permohonan' => 1 ]);
        // // $request->merge(['projectTitle' => trim($request->input('projectTitle'))]);
        // $cleanedValue = str_replace(',', '', $request->input('anggaranKos'));
        // $decimalValue = (float)$cleanedValue;
        $request->merge(['anggaranKos' => str_replace(',', '', $request->input('anggaranKos')) ]);

        // dd($request->all());
        $validated = $this->validateData($request->all());
        if ($validated instanceof \Illuminate\Http\RedirectResponse) {
            return $validated;
        }
        
        $folderName = str_replace('/', '', $referenceNumber);
        // dd($folderName);
        $largeFileName = $request->input('large_file_name_new');
        if (null !== $largeFileName) {
            $oldPath = storage_path('app/public/uploads/eLAPS/temp/'.$largeFileName); // Current file location
            $newPath = storage_path('app/public/uploads/eLAPS/'.$folderName.'/'.$largeFileName); // New location
            
            if (file_exists($oldPath)) {
                $destinationDir = dirname($newPath);
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }
                rename($oldPath, $newPath);
            }
            $validated['file_path'] = $largeFileName;
        }
        // dd($validated);
        // dd($request->all());
        // Insert the main record (eLAPS) into the database
        $elaps = eLAPS::create($validated);
        

        // Redirect back to the list page with a success message
        if($elaps){
            // if (config('mail.enabled')) {
            //     try {
            //         $emailData = [
            //             "email_to" => [
            //                 ['address' => 'admin@jln.com', 'name' => 'Admin'],
            //                 ['address' => 'anotheradmin@jln.com', 'name' => 'Another Admin']
            //             ],
            //             "email_cc" => [
            //                 ['address' => 'cc@pbt.com', 'name' => 'PBT Recipient'],
            //                 ['address' => 'anothercc@pbt.com', 'name' => 'Another CC']
            //             ],
            //             "subject" => 'New User Application Notification',
            //         ];
    
            //         Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $elaps, 'name' => $user->name, 'email' => $user->email], function ($message) use ($emailData) {
            //             $message->subject($emailData["subject"]);
            //             // Loop through to array and add each email
            //             foreach ($emailData['email_to'] as $to) {
            //                 $message->to($to['address'], $to['name']);
            //             }
    
            //             // Loop through cc array and add each email
            //             foreach ($emailData['email_cc'] as $cc) {
            //                 $message->cc($cc['address'], $cc['name']);
            //             }
            //         });
            //     } catch (\Exception $exception) {
            //         // Handle mail sending error
            //         // You can log the exception or display an error message
            //         // \Log::error("Error sending registration email: " . $exception->getMessage());
            //     }
            // }
            return redirect()->route('pengurusan.eLAPS.index')
            ->with('successMessage', 'Maklumat permohonan telah berjaya disimpan');
        }else{
            return redirect()->route('pengurusan.eLAPS.index')
            ->with('errorMessage', 'Maklumat permohonan tidak berjaya disimpan');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eLAPS = eLAPS::findOrFail($id);

        $user = $this->getUser();
        // dd($eLAPS->status_permohonan);
        if($user->hasRole('Pentadbir Sistem|Pegawai|TKP/B JLN')){
            if($eLAPS->status_permohonan == 2){
                $newStat = 3;
            }else if($eLAPS->status_permohonan == 5){
                $newStat = 6;
            }else if($eLAPS->status_permohonan == 8){
                $newStat = 9;
            }
            if(isset($newStat)){
                $serahPermohonan = $eLAPS->update(['status_permohonan' => $newStat]);
            }
        }

        return view('pengurusan.eLAPS.show', compact('eLAPS'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->getUser();
        if($user->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem')){
            $eLAPS = eLAPS::findOrFail($id);
            return view('pengurusan.eLAPS.edit', compact('eLAPS'));
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $permohonan = eLAPS::findOrFail($id); 
        // dd($id);
        $folderName = str_replace('/', '', $permohonan->referenceNumber);
        $largeFileName = $request->input('large_file_name_new');
        $fileExist = false;
        if (null !== $largeFileName) {
            $oldPath = storage_path('app/public/uploads/eLAPS/temp/'.$largeFileName);
            $newPath = storage_path('app/public/uploads/eLAPS/'.$folderName.'/'.$largeFileName);
            if (file_exists($oldPath)) {
                $fileExist = true;
                $destinationDir = dirname($newPath);
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }
            }
        }
        $user = User::whereRaw('id = ?', [$permohonan->id_pemohon])->first();
        if ($request->input('action') === 'update') {
            $validated = $this->validateData($request->all());
            if ($validated instanceof \Illuminate\Http\RedirectResponse) {
                if ($fileExist) {
                    unlink($oldPath);
                }
                return $validated;
            }
            
            if ($fileExist) {
                rename($oldPath, $newPath);
                $validated['file_path'] = $largeFileName;
            }

            $updatePermohonan = $permohonan->update($validated);
            
            if($updatePermohonan){
                return redirect()->route('pengurusan.eLAPS.edit', [$permohonan])->with('successMessage', 'Maklumat permohonan telah berjaya dikemaskini');
            }else{
                return redirect()->route('pengurusan.eLAPS.edit', [$permohonan])->with('errorMessage', 'Maklumat permohonan tidak berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'submit') {
            $validated = $this->validateData($request->all());
            if ($validated instanceof \Illuminate\Http\RedirectResponse) {
                if ($fileExist) {
                    unlink($oldPath);
                }
                return $validated;
            }
            $validated['status_permohonan'] = 2;
            if ($fileExist) {
                rename($oldPath, $newPath);
                $validated['file_path'] = $largeFileName;
            }
            
            $hantarPermohonan = $permohonan->update($validated);
            
            if($hantarPermohonan){
                //email
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => [
                                ['address' => 'admin@jln.com', 'name' => 'Admin'],
                                ['address' => 'anotheradmin@jln.com', 'name' => 'Another Admin']
                            ],
                            "email_cc" => [
                                ['address' => 'cc@pbt.com', 'name' => 'PBT Recipient'],
                                ['address' => 'anothercc@pbt.com', 'name' => 'Another CC']
                            ],
                            "subject" => 'New User Application Notification',
                        ];
        
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $hantarPermohonan, 'name' => $user->name, 'email' => $user->email], function ($message) use ($emailData) {
                            $message->subject($emailData["subject"]);
                            // Loop through to array and add each email
                            foreach ($emailData['email_to'] as $to) {
                                $message->to($to['address'], $to['name']);
                            }
        
                            // Loop through cc array and add each email
                            foreach ($emailData['email_cc'] as $cc) {
                                $message->cc($cc['address'], $cc['name']);
                            }
                        });
                    } catch (\Exception $exception) {
                        // Handle mail sending error
                        // You can log the exception or display an error message
                        // \Log::error("Error sending registration email: " . $exception->getMessage());
                    }
                }
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat permohonan telah berjaya dihantar');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat permohonan tidak berjaya dihantar');
            }
        } elseif ($request->input('action') === 'serahan') {
            // dd($request->all());
            $serahPermohonan = $permohonan->update([
                'status_permohonan' => 5,
                'bahagian_jln' => $request->input('bahagian_jln'),
            ]);
            
            if($serahPermohonan){
                //email
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => [
                                ['address' => 'admin@jln.com', 'name' => 'Admin'],
                                ['address' => 'anotheradmin@jln.com', 'name' => 'Another Admin']
                            ],
                            "email_cc" => [
                                ['address' => 'cc@pbt.com', 'name' => 'PBT Recipient'],
                                ['address' => 'anothercc@pbt.com', 'name' => 'Another CC']
                            ],
                            "subject" => 'New User Application Notification',
                        ];
        
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $serahPermohonan, 'name' => $user->name, 'email' => $user->email], function ($message) use ($emailData) {
                            $message->subject($emailData["subject"]);
                            // Loop through to array and add each email
                            foreach ($emailData['email_to'] as $to) {
                                $message->to($to['address'], $to['name']);
                            }
        
                            // Loop through cc array and add each email
                            foreach ($emailData['email_cc'] as $cc) {
                                $message->cc($cc['address'], $cc['name']);
                            }
                        });
                    } catch (\Exception $exception) {
                        // Handle mail sending error
                        // You can log the exception or display an error message
                        // \Log::error("Error sending registration email: " . $exception->getMessage());
                    }
                }
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat permohonan telah berjaya diserah kepada bahagian');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat permohonan tidak berjaya diserah kepada bahagian');
            }
        } elseif ($request->input('ulasan') === 'draf') {
            $drafUlasan = $permohonan->update(['status_permohonan' => 7, 'ulasan_lawatan' => $request->input('ulasan_lawatan')]);
            // dd($permohonan);
            if($drafUlasan){
                //email
                return redirect()->route('pengurusan.eLAPS.show', [$permohonan])->with('successMessage', 'Maklumat ulasan telah berjaya disimpan');
            }else{
                return redirect()->route('pengurusan.eLAPS.show', [$permohonan])->with('errorMessage', 'Maklumat ulasan tidak berjaya disimpan');
            }
        } elseif ($request->input('ulasan') === 'hantar') {
            $hantarUlasan = $permohonan->update(['status_permohonan' => 8, 'ulasan_lawatan' => $request->input('ulasan_lawatan')]);
            
            if($hantarUlasan){
                //email to ?
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat ulasan telah berjaya dihantar');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat ulasan tidak berjaya dihantar');
            }
        } elseif ($request->input('action') === 'keputusan') {
            $keputusanPermohonan = $permohonan->update([
                'status_permohonan' => $request->input('keputusan'),
            ]);
            
            if($keputusanPermohonan){
                //email
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat keputusan telah berjaya dikemaskini');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat keputusan tidak berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'status') {
            $projekSiap = $request->input('statusProjek');
            $statusProjek = $permohonan->update([
                'status_permohonan' => $projekSiap,
            ]);
            
            if($statusProjek){
                //email to JLN for portal display
                if($projekSiap == 14){
                    $duplicateData = new ePALM();
                    $duplicateData->nama_taman = $permohonan->projectTitle;
                    $duplicateData->kategori_taman = $permohonan->category;
                    $duplicateData->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                        ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                        : 'Jabatan Landskap Negara';
                    $duplicateData->keluasan_taman = $permohonan->keluasan;
                    $duplicateData->keluasan_unit = $permohonan->unit_keluasan;
                    $duplicateData->panjang_taman = $permohonan->panjang;
                    $duplicateData->panjang_unit = $permohonan->unit_panjang;
                    $duplicateData->hakmilik_tanah_taman = $permohonan->hakmilik_tanah;

                    $status_tanahData = json_decode($permohonan->status_tanah, true);
                    $duplicateData->status_tanah_taman = $status_tanahData['status'];
                    $duplicateData->tarikhWarta_tanah_taman = isset($status_tanahData['tarikh']) ? $status_tanahData['tarikh'] : null;

                    $duplicateData->negeri_taman = $permohonan->negeri;
                    $duplicateData->daerah_taman = $permohonan->daerah;
                    $duplicateData->mukim_taman = $permohonan->mukim;
                    $duplicateData->parlimen_taman = $permohonan->parlimen;
                    $duplicateData->dun_taman = $permohonan->dun;
                    $duplicateData->id_permohonan = $id;

                    $duplicateDataSaved = $duplicateData->save();

                    $duplicateDataId = $duplicateData->id_taman;
                    if ($duplicateDataSaved) {
                        $duplicateData_draf = new ePALM_draf();
                        $duplicateData_draf->id_taman = $duplicateDataId;
                        $duplicateData_draf->nama_taman = $permohonan->projectTitle;
                        $duplicateData_draf->kategori_taman = $permohonan->category;
                        $duplicateData_draf->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                            ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                            : 'Jabatan Landskap Negara';
                        $duplicateData_draf->keluasan_taman = $permohonan->keluasan;
                        $duplicateData_draf->keluasan_unit = $permohonan->unit_keluasan;
                        $duplicateData_draf->panjang_taman = $permohonan->panjang;
                        $duplicateData_draf->panjang_unit = $permohonan->unit_panjang;
                        $duplicateData_draf->hakmilik_tanah_taman = $permohonan->hakmilik_tanah;

                        $status_tanahData = json_decode($permohonan->status_tanah, true);
                        $duplicateData_draf->status_tanah_taman = $status_tanahData['status'];
                        $duplicateData_draf->tarikhWarta_tanah_taman = isset($status_tanahData['tarikh']) ? $status_tanahData['tarikh'] : null;

                        $duplicateData_draf->negeri_taman = $permohonan->negeri;
                        $duplicateData_draf->daerah_taman = $permohonan->daerah;
                        $duplicateData_draf->mukim_taman = $permohonan->mukim;
                        $duplicateData_draf->parlimen_taman = $permohonan->parlimen;
                        $duplicateData_draf->dun_taman = $permohonan->dun;
                        $duplicateData_draf->id_permohonan = $id;

                        $duplicateData_drafSaved = $duplicateData_draf->save();
                    }
                }
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat Status Projek telah berjaya dikemaskini');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat Status Projek tidak berjaya dikemaskini');
            }
        } elseif ($request->input('statusProjek') === 'siap') {
            // dd($request->all());
            $siapProjek = $permohonan->update(['status_permohonan' => 14]);
            //if taman awam
            if($siapProjek){
                //email
                $duplicateData = new ePALM();
                $duplicateData->nama_taman = $permohonan->projectTitle;
                $duplicateData->kategori_taman = $permohonan->category;
                $duplicateData->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                    ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                    : 'Jabatan Landskap Negara';
                $duplicateData->keluasan_taman = $permohonan->keluasan;
                $duplicateData->keluasan_unit = $permohonan->unit_keluasan;
                $duplicateData->panjang_taman = $permohonan->panjang;
                $duplicateData->panjang_unit = $permohonan->unit_panjang;
                $duplicateData->hakmilik_tanah_taman = $permohonan->hakmilik_tanah;

                $status_tanahData = json_decode($permohonan->status_tanah, true);
                $duplicateData->status_tanah_taman = $status_tanahData['status'];
                $duplicateData->tarikhWarta_tanah_taman = isset($status_tanahData['tarikh']) ? $status_tanahData['tarikh'] : null;

                $duplicateData->negeri_taman = $permohonan->negeri;
                $duplicateData->daerah_taman = $permohonan->daerah;
                $duplicateData->mukim_taman = $permohonan->mukim;
                $duplicateData->parlimen_taman = $permohonan->parlimen;
                $duplicateData->dun_taman = $permohonan->dun;
                $duplicateData->id_permohonan = $id;

                $duplicateDataSaved = $duplicateData->save();

                $duplicateDataId = $duplicateData->id_taman;
                if ($duplicateDataSaved) {
                    $duplicateData_draf = new ePALM_draf();
                    $duplicateData_draf->id_taman = $duplicateDataId;
                    $duplicateData_draf->nama_taman = $permohonan->projectTitle;
                    $duplicateData_draf->kategori_taman = $permohonan->category;
                    $duplicateData_draf->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                        ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                        : 'Jabatan Landskap Negara';
                    $duplicateData_draf->keluasan_taman = $permohonan->keluasan;
                    $duplicateData_draf->keluasan_unit = $permohonan->unit_keluasan;
                    $duplicateData_draf->panjang_taman = $permohonan->panjang;
                    $duplicateData_draf->panjang_unit = $permohonan->unit_panjang;
                    $duplicateData_draf->hakmilik_tanah_taman = $permohonan->hakmilik_tanah;

                    $status_tanahData = json_decode($permohonan->status_tanah, true);
                    $duplicateData_draf->status_tanah_taman = $status_tanahData['status'];
                    $duplicateData_draf->tarikhWarta_tanah_taman = isset($status_tanahData['tarikh']) ? $status_tanahData['tarikh'] : null;

                    $duplicateData_draf->negeri_taman = $permohonan->negeri;
                    $duplicateData_draf->daerah_taman = $permohonan->daerah;
                    $duplicateData_draf->mukim_taman = $permohonan->mukim;
                    $duplicateData_draf->parlimen_taman = $permohonan->parlimen;
                    $duplicateData_draf->dun_taman = $permohonan->dun;
                    $duplicateData->id_permohonan = $id;

                    $duplicateData_drafSaved = $duplicateData_draf->save();
                }      
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat permohonan telah berjaya diserah kepada bahagian');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat permohonan tidak berjaya diserah kepada bahagian');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\eLAPS  $eLAPS
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permohonan = eLAPS::findOrFail($id);
        $permohonan->delete();
        return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat permohonan telah dihapuskan');
    }
}
