<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\eLAPS;
use App\Model\ePALM;
use App\Model\ePALM_draf;
use App\Model\ePIL;
use App\Model\ePIL_draf;
use App\Model\MaklumatPenggunaPbt;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class eLAPSController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|elaps-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elaps-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|elaps-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|Pegawai|elaps-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        
        $userId = $this->getUserID();
        $user = $this->getUser();//User::whereRaw('id = ?', [$userId])->first();
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $totalCount = eLAPS::where('id_pemohon', $user->bahagian_jln)->count();
            $eLAPS = eLAPS::where('id_pemohon', $user->bahagian_jln)->orderBy('id', 'desc')->paginate($totalCount);
        }elseif($user->hasRole('KP/ TKP JLN|Pentadbir Sistem') || ($user->hasRole('Pegawai') && $user->bahagian_jln == 6)){
            $totalCount = eLAPS::count();
            $eLAPS = eLAPS::orderByRaw('CAST(status_permohonan AS INT) ASC')->orderBy('id', 'desc')->paginate($totalCount);
        }else{
            // $totalCount = eLAPS::where('status_permohonan', '!=', $userId)->count();
            // $eLAPS = eLAPS::where('status_permohonan', '!=', $userId)->orderBy('id', 'desc')->paginate($totalCount);
            $totalCount = eLAPS::where('bahagian_jln', $user->bahagian_jln)->orWhere('id_pemohon', $user->id)->count();
            $eLAPS = eLAPS::where('bahagian_jln', $user->bahagian_jln)->orWhere('id_pemohon', $user->id)->orderByRaw('CAST(status_permohonan AS INT) ASC')->orderBy('id', 'desc')->paginate($totalCount);
        }

        $eLAPS->getCollection()->transform(function ($eLAP) {
            $audits = ($eLAP->audits);
            foreach ($audits as $audit) {
                if ($audit->event === 'created') {  // Check if it's the 'created' event
                    $createdByUserId = $audit->user_id ?? '';  // Get the ID of the user who created the record
                    // dump( "Record was created by user with ID: " . $createdByUserId);
                    break;
                }
            }
            $id_pemohon = $createdByUserId ?? $eLAP->id_pemohon;
            $email = User::find($id_pemohon);
            
            if($email->hasRole('Pihak Berkuasa Tempatan')){
                $pbt = MaklumatPenggunaPbt::where('id', '=', $email->bahagian_jln)->first();
                $eLAP->pbt_name = $pbt ? $pbt->pbt_name : null;
            }else{
                $eLAP->pbt_name = "Jabatan Landskap Negara";
            }
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
            return MaklumatPenggunaPbt::where('id', '=', $user->bahagian_jln)->first();
        }else if($id_pemohon){
            return MaklumatPenggunaPbt::where('id', '=', $id_pemohon)->first();
        }
    }

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

    public function validateData(array $request , $id = null)
    {
        // dd($request);
        if (isset($request['action']) && $request['action'] === 'submit') {
            $validator = Validator::make($request, [
                'projectTitle' => 'required',
                'category' => 'required|array',
                'category.0' => 'required',
                'category.lain-lain' => 'required_if:category.0,Lain-lain (sila nyatakan)',
                'rancangan_pembangunan.jenis' => 'required|array|min:1',
                'rancangan_pembangunan.keterangan' => 'required|array|min:1',
                'rancangan_pembangunan.keterangan.*' => 'required',       
                // 'hakmilik_tanah' => 'required',
                // 'status_tanah' => 'required|array',
                // 'kemudahsampaian' => 'required',
                // 'guna_tanah' => 'required',
                // 'pelan_ukur' => 'required|array',
                // 'masalah' => 'required|array',
                'anggaranKos' => 'required|numeric|gt:0',
                // 'keluasan' => 'required|numeric',
                // 'unit_keluasan' => 'required',
                // 'no_lot' => 'required',
                'negeri' => 'required',
                'daerah' => 'required',
                'mukim' => 'required',
                'parlimen' => 'required',
                'dun' => 'required',
                // 'aktiviti_semasa' => 'required',
                // 'jumlah_penduduk' => 'required|numeric', 
            ]);
        }else{
            $validator = Validator::make($request, [
                'projectTitle' => 'required',
                'category' => 'required|array',
                'category.0' => 'required',
                'category.lain-lain' => 'required_if:category.0,Lain-lain (sila nyatakan)',   
                'anggaranKos' => 'required|numeric|gt:0',
            ]);
        }
        // if ($validator->fails()) {
        //     $errors = $validator->errors();
        //     $formattedErrorMessages = [];
        //     foreach ($errors->messages() as $field => $messages) {
        //         $formattedField = strtoupper(str_replace('_', ' ', $field));
        //         foreach ($messages as $message) {
        //             $formattedMessage = strtoupper(str_replace('validation.', '', $message));
        //             $formattedErrorMessages[] = "The \"$formattedField\" field: $formattedMessage";
        //         }
        //     }
        //     $formattedErrorMessage = implode('<br>', $formattedErrorMessages);
        //     return redirect()->back()->with('errorMessage', $formattedErrorMessage);
        // }
        
        // Handle category input
        $category = $request['category'] ?? null;
        if (is_array($category) && isset($category[0]) && $category[0] == "Lain-lain (sila nyatakan)") {
            $lainLain = $request['category']['lain-lain'] ?? null;
            if($lainLain == null){
                unset($request['category']);
            }else{
                $request['category'] = $lainLain;
            }
        } else {
            $request['category'] = $category[0] ?? null;
        }
        // Handle rancangan_pembangunan input (convert to JSON)
        // $rancangan_pembangunan = collect($request['rancangan_pembangunan'] ?? [])
        //     ->map(function($item) {
        //         return $item;
        //     })
        //     ->toArray();
        // $request['rancangan_pembangunan'] = json_encode($rancangan_pembangunan);
        if (isset($request['rancangan_pembangunan'])) {
            // $request['rancangan_pembangunan'] = json_encode($request['rancangan_pembangunan']);
        }
        if (isset($request['rancangan_pembangunan'])) {
            $validRancanganPembangunan = [
                'jenis' => [],
                'keterangan' => []
            ];
        
            // Loop through the jenis and keterangan arrays
            foreach ($request['rancangan_pembangunan']['jenis'] as $key => $jenisItem) {
                $keteranganItem = $request['rancangan_pembangunan']['keterangan'][$jenisItem] ?? null;
        
                // Check if keterangan is not null
                if ($keteranganItem !== null) {
                    // If keterangan is not null, include this jenis and keterangan
                    $validRancanganPembangunan['jenis'][] = $jenisItem;
                    $validRancanganPembangunan['keterangan'][$jenisItem] = $keteranganItem;
                }
            }
        
            // Encode only the filtered valid rancangan_pembangunan
            $request['rancangan_pembangunan'] = json_encode($validRancanganPembangunan);
        }

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

        // Handle  input
        $guna_tanah = $request['guna_tanah'] ?? null;
        // if (is_array($guna_tanah) && isset($guna_tanah['jenis']) && $guna_tanah['jenis'] == "Lain-lain (nyatakan) :") {
        //     $lainLain = $request['guna_tanah']['keterangan'] ?? null;
        //     $request['guna_tanah'] = $lainLain;
        // } else {
        //     $request['guna_tanah'] = $guna_tanah['jenis'] ?? null;
        // }
        // $request['guna_tanah'] = json_encode($guna_tanah);
        if (isset($request['guna_tanah'])) {
            $request['guna_tanah'] = json_encode($request['guna_tanah']);
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

        if ($validator->fails()) {
            $errors = $validator->errors();
            $formattedErrorMessages = [];
            $errorFields = [];
            foreach ($errors->messages() as $field => $messages) {
                $formattedField = strtoupper(str_replace('_', ' ', $field));
                foreach ($messages as $message) {
                    $formattedMessage = strtoupper(str_replace('validation.', '', $message));
                    $formattedErrorMessages[] = "The \"$formattedField\" field: $formattedMessage";
                    $errorFields[] = $field;
                }
            }
            $formattedErrorMessage = implode('<br>', $formattedErrorMessages);
            if($id){
                $eLAPS = eLAPS::find($id);
                if ($eLAPS) {
                    $validatedData = collect($request)->except($errorFields)->toArray();
                    // dd((in_array('rancangan_pembangunan.keterangan.0',$errorFields)));
                    // dd($request);
                    // dd($errorFields);
                    $eLAPS->update($validatedData);
                }
            }
            return redirect()->back()->with('errorMessage', $formattedErrorMessage)
            ->with('errorFields', $errorFields);
        }
        // dd($request['rancangan_pembangunan']);
        return $request;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $userId = auth()->id();
        $user = User::whereRaw('id = ?', [$userId])->first();
        if($user->hasRole('Pihak Berkuasa Tempatan')){
            $id_pemohon = $user->bahagian_jln;
        }else{
            $id_pemohon = $userId;
        }
        // dd($user->name); // Now you can access the 'name' attribute

        // Get the current year
        $currentYear = Carbon::now()->year;
        $recordCount = eLAPS::whereYear('created_at', $currentYear)->count();
        $referenceNumber = $recordCount + 1;
        $referenceNumber = "JLN/{$currentYear}/{$referenceNumber}";
        $request->merge(['referenceNumber' => $referenceNumber]);

        $request->merge(['id_pemohon' => $id_pemohon ]);
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

            return redirect()->route('pengurusan.eLAPS.edit', [$elaps])->with('successMessage', 'Maklumat permohonan telah berjaya disimpan');
            return redirect()->route('pengurusan.eLAPS.index')
            ->with('successMessage', 'Maklumat permohonan telah berjaya disimpan');
        }else{
            return redirect()->route('pengurusan.eLAPS.index')
            ->with('errorMessage', 'Maklumat permohonan tidak berjaya disimpan');
        }
    }

    public function show($id)
    {
        $eLAPS = eLAPS::findOrFail($id);

        $user = $this->getUser();
        // dd($eLAPS->status_permohonan);
        if($user->hasRole('Pentadbir Sistem|Pegawai|KP/ TKP JLN')){
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

    public function edit($id)
    {
        $user = $this->getUser();
        if($user->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem')){
            $eLAPS = eLAPS::findOrFail($id);
            return view('pengurusan.eLAPS.edit', compact('eLAPS'));
        }else if($user->hasRole('Pegawai')){
            $eLAPS = eLAPS::findOrFail($id);
            if($eLAPS->id_pemohon == $user->id){
                return view('pengurusan.eLAPS.edit', compact('eLAPS'));
            }
            abort(403, 'You are not authorized to access this page.');
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $permohonan = eLAPS::findOrFail($id); 
        // dd($permohonan['file_path']);
        $folderName = str_replace('/', '', $permohonan->referenceNumber);
        $largeFileName = $request->input('large_file_name_new');
        $fileExist = false;
        $currentPath = storage_path('app/public/uploads/eLAPS/'.$folderName.'/'.$permohonan['file_path']);
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
            if (file_exists($currentPath)) {
                // unlink($currentPath);
            }
        }
        
        // dd(($currentPath));
        $user = User::whereRaw('id = ?', [$permohonan->id_pemohon])->first();
        
        $userArr = [];
        $PBTArr = ($this->getPBT($permohonan->id_pemohon)) !== null ? $this->getPBT($permohonan->id_pemohon) : [];
        $PBTid = $PBTArr->id ?? '';
        $PBTuser = User::where('bahagian_jln', '=', $PBTid)->where('is_active', 1)->get();
        $PBTemail = [];
        foreach ($PBTuser as $key => $value) {
            $PBTemail[] = ['address' => $value->email, 'name' => $value->name];
        }
        if ($request->input('action') === 'submit' || $request->input('action') === 'keputusan') {
            $userArr = User::where(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pegawai');
                })
                ->where('bahagian_jln', 6);
            })
            ->orWhere(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'KP/ TKP JLN');
                });
            })//->where('is_active', 1)
            ->get();
        }elseif ($request->input('action') === 'serahan' || $request->input('action') === 'status') {
            $bahagian_jln = $request->input('bahagian_jln') ?? $permohonan->bahagian_jln;
            $userArr = User::where(function ($query) use ($bahagian_jln) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pegawai');
                })
                ->where('bahagian_jln', $bahagian_jln);
            })//->where('is_active', 1)
            ->get();
        }elseif ($request->input('ulasan') === 'hantar') {
            $bahagian_jln = $permohonan->bahagian_jln;
            $userArr = User::where(function ($query) use ($bahagian_jln) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pegawai');
                })
                ->where('bahagian_jln', $bahagian_jln);
            })//->where('is_active', 1)
            ->get();
            $user_emailBhg = [];
            foreach ($userArr as $key => $value) {
                $user_emailBhg[] = ['address' => $value->email, 'name' => $value->name];
            }

            $userArr = User::where(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'Pegawai');
                })
                ->where('bahagian_jln', 6);
            })
            ->orWhere(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'KP/ TKP JLN');
                });
            })//->where('is_active', 1)
            ->get();
        }

        $user_email = [];
        foreach ($userArr as $key => $value) {
            $user_email[] = ['address' => $value->email, 'name' => $value->name];
        }
        $nama_pemohon = isset($PBTArr->pbt_name) ? $PBTArr->pbt_name : 'Jabatan Landskap Negara';

        // dd($user_email);
        $request->merge(['anggaranKos' => str_replace(',', '', $request->input('anggaranKos')) ]);
        if ($fileExist) {
            rename($oldPath, $newPath);
            $request->merge(['file_path' => $largeFileName]);
        }
        if ($request->input('action') === 'update') {
            $validated = $this->validateData($request->all(), $id);
            if ($validated instanceof \Illuminate\Http\RedirectResponse) {
                if ($fileExist) {
                    // unlink($oldPath);                    
                    // unlink($newPath);
                }
                return $validated;
            }
            
            // if ($fileExist) {
            //     rename($oldPath, $newPath);
            //     $validated['file_path'] = $largeFileName;
            // }
            // dd($validated);
            $updatePermohonan = $permohonan->update($validated);
            
            if($updatePermohonan){
                return redirect()->route('pengurusan.eLAPS.edit', [$permohonan])->with('successMessage', 'Maklumat permohonan telah berjaya dikemaskini');
            }else{
                return redirect()->route('pengurusan.eLAPS.edit', [$permohonan])->with('errorMessage', 'Maklumat permohonan tidak berjaya dikemaskini');
            }
        } elseif ($request->input('action') === 'submit') {
            $validated = $this->validateData($request->all(), $id);
            if ($validated instanceof \Illuminate\Http\RedirectResponse) {
                if ($fileExist) {
                    // unlink($oldPath);                    
                    // unlink($newPath);
                }
                !(file_exists($currentPath)) ? session()->push('errorFields', 'supporting_documents') : '';

                // dd(session('errorFields', []));
                return $validated;
            }
            $validated['status_permohonan'] = 2;
            // if ($fileExist) {
            //     rename($oldPath, $newPath);
            //     $validated['file_path'] = $largeFileName;
            // }
            
            $hantarPermohonan = $permohonan->update($validated);
            // dd($permohonan);

            // dd($status);
            if($hantarPermohonan){
                //email
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => $user_email,
                            "email_cc" => $PBTemail,
                            "subject" => 'Permohonan Pembangunan Projek',
                        ];
        
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $permohonan, 'name' => $nama_pemohon], function ($message) use ($emailData) {
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
                        \Log::error("Error sending registration email: " . $exception->getMessage());
                    //    dd("Error sending registration email: " . $exception->getMessage());
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
                            "email_to" => $user_email,
                            "email_cc" => $PBTemail,
                            "subject" => 'Permohonan Pembangunan Projek',
                        ];
        
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $permohonan, 'name' => $nama_pemohon], function ($message) use ($emailData) {
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
                        \Log::error("Error sending registration email: " . $exception->getMessage());
                    //    dd("Error sending registration email: " . $exception->getMessage());
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
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => $user_email,
                            "email_cc" => $user_emailBhg,
                            "subject" => 'Permohonan Pembangunan Projek',
                        ];
                        $permohonan->status_permohonan = $permohonan->status_permohonan + 1;
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $permohonan, 'name' => $nama_pemohon], function ($message) use ($emailData) {
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
                        \Log::error("Error sending registration email: " . $exception->getMessage());
                    //    dd("Error sending registration email: " . $exception->getMessage());
                    }
                }
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
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => $PBTemail,
                            "email_cc" => $user_email,
                            "subject" => 'Permohonan Pembangunan Projek',
                        ];
        
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $permohonan, 'name' => $nama_pemohon], function ($message) use ($emailData) {
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
                        \Log::error("Error sending registration email: " . $exception->getMessage());
                    //    dd("Error sending registration email: " . $exception->getMessage());
                    }
                }
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
                if (config('mail.enabled')) {
                    try {
                        $emailData = [
                            "email_to" => $user_email,
                            "email_cc" => $PBTemail,
                            "subject" => 'Permohonan Pembangunan Projek',
                        ];
        
                        Mail::send('pengurusan.eLAPS.mails.pendaftaran', ['elaps' => $permohonan, 'name' => $nama_pemohon], function ($message) use ($emailData) {
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
                        \Log::error("Error sending registration email: " . $exception->getMessage());
                    //    dd("Error sending registration email: " . $exception->getMessage());
                    }
                }
                if($projekSiap == 14){
                    if (in_array($permohonan->category, ['Taman Awam', 'Taman Botani', 'Landskap Perbandaran', 'Persekitaran Kehidupan', 'Taman Persekutuan'])) {
                        $duplicateData = new ePALM();
                        $duplicateData->nama_taman = $permohonan->projectTitle;
                        $duplicateData->kategori_taman = $permohonan->category;
                        // $duplicateData->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                        //     ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                        //     : 'Jabatan Landskap Negara';

                        $audits = ($permohonan->audits);
                        foreach ($audits as $audit) {
                            // dump($audit->event);
                            if (isset($audit->event)) {  // Check if it's the 'created' event
                                if ($audit->event === 'created') {  // Check if it's the 'created' event
                                    $createdByUserId = $audit->user_id ?? '';
                                    break;
                                }
                            }
                        }
                        $id_pemohon = $createdByUserId ?? $permohonan->id_pemohon;
                        $email = User::find($id_pemohon);
                        if($email->hasRole('Pihak Berkuasa Tempatan')){
                            $pbt = MaklumatPenggunaPbt::where('id', '=', $email->bahagian_jln)->first();
                            $duplicateData->nama_pbt = $pbt ? $pbt->pbt_name : null;
                        }else{
                            $duplicateData->nama_pbt = "Jabatan Landskap Negara";
                        }

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
                            $audits = ($permohonan->audits);
                            foreach ($audits as $audit) {
                                // dump($audit->event);
                                if (isset($audit->event)) {  // Check if it's the 'created' event
                                    if ($audit->event === 'created') {  // Check if it's the 'created' event
                                        $createdByUserId = $audit->user_id ?? '';
                                        break;
                                    }
                                }
                            }
                            $id_pemohon = $createdByUserId ?? $permohonan->id_pemohon;
                            $email = User::find($id_pemohon);
                            if($email->hasRole('Pihak Berkuasa Tempatan')){
                                $pbt = MaklumatPenggunaPbt::where('id', '=', $email->bahagian_jln)->first();
                                $duplicateData_draf->nama_pbt = $pbt ? $pbt->pbt_name : null;
                            }else{
                                $duplicateData_draf->nama_pbt = "Jabatan Landskap Negara";
                            }  

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

                    if ($permohonan->category == "Pelan Induk Landskap") {
                        $duplicateData = new ePIL();
                        $duplicateData->nama_pelan = $permohonan->projectTitle;
                        // $duplicateData->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                        //     ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                        //     : 'Jabatan Landskap Negara';

                        $audits = ($permohonan->audits);
                        foreach ($audits as $audit) {
                            // dump($audit->event);
                            if (isset($audit->event)) {  // Check if it's the 'created' event
                                if ($audit->event === 'created') {  // Check if it's the 'created' event
                                    $createdByUserId = $audit->user_id ?? '';
                                    break;
                                }
                            }
                        }
                        $id_pemohon = $createdByUserId ?? $permohonan->id_pemohon;
                        $email = User::find($id_pemohon);
                        if($email->hasRole('Pihak Berkuasa Tempatan')){
                            $pbt = MaklumatPenggunaPbt::where('id', '=', $email->bahagian_jln)->first();
                            $duplicateData->nama_pbt = $pbt ? $pbt->pbt_name : null;
                        }else{
                            $duplicateData->nama_pbt = "Jabatan Landskap Negara";
                        }

                        $duplicateData->negeri_pelan = $permohonan->negeri;
                        $duplicateData->daerah_pelan = $permohonan->daerah;
                        $duplicateData->mukim_pelan = $permohonan->mukim;
                        $duplicateData->parlimen_pelan = $permohonan->parlimen;
                        $duplicateData->dun_pelan = $permohonan->dun;
                        $duplicateData->id_permohonan = $id;

                        $duplicateDataSaved = $duplicateData->save();

                        $duplicateDataId = $duplicateData->id_pelan;
                        if ($duplicateDataSaved) {
                            $duplicateData_draf = new ePIL_draf();
                            $duplicateData_draf->id_pelan = $duplicateDataId;
                            $duplicateData_draf->nama_pelan = $permohonan->projectTitle;
                            // $duplicateData_draf->nama_pbt = isset($this->getPBT($permohonan->id_pemohon)->pbt_name) 
                            //     ? $this->getPBT($permohonan->id_pemohon)->pbt_name 
                            //     : 'Jabatan Landskap Negara';

                            $audits = ($permohonan->audits);
                            foreach ($audits as $audit) {
                                // dump($audit->event);
                                if (isset($audit->event)) {  // Check if it's the 'created' event
                                    if ($audit->event === 'created') {  // Check if it's the 'created' event
                                        $createdByUserId = $audit->user_id ?? '';
                                        break;
                                    }
                                }
                            }
                            $id_pemohon = $createdByUserId ?? $permohonan->id_pemohon;
                            $email = User::find($id_pemohon);
                            if($email->hasRole('Pihak Berkuasa Tempatan')){
                                $pbt = MaklumatPenggunaPbt::where('id', '=', $email->bahagian_jln)->first();
                                $duplicateData_draf->nama_pbt = $pbt ? $pbt->pbt_name : null;
                            }else{
                                $duplicateData_draf->nama_pbt = "Jabatan Landskap Negara";
                            }

                            $duplicateData_draf->negeri_pelan = $permohonan->negeri;
                            $duplicateData_draf->daerah_pelan = $permohonan->daerah;
                            $duplicateData_draf->mukim_pelan = $permohonan->mukim;
                            $duplicateData_draf->parlimen_pelan = $permohonan->parlimen;
                            $duplicateData_draf->dun_pelan = $permohonan->dun;
                            $duplicateData_draf->id_permohonan = $id;

                            $duplicateData_drafSaved = $duplicateData_draf->save();
                        }
                    }
                }
                return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat Status Projek telah berjaya dikemaskini');
            }else{
                return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat Status Projek tidak berjaya dikemaskini');
            }
        }
    }

    public function destroy($id)
    {
        $user = $this->getUser();
        if($user->hasRole('Pihak Berkuasa Tempatan|Pentadbir Sistem')){
            $permohonan = eLAPS::findOrFail($id);
            $deletePermohonan = $permohonan->delete();
        }else if($user->hasRole('Pegawai')){
            $permohonan = eLAPS::findOrFail($id);
            if($permohonan->id_pemohon == $user->id){
                $deletePermohonan = $permohonan->delete();
            }
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
        // $permohonan = eLAPS::findOrFail($id);
        // $permohonan->delete();
        if($deletePermohonan){
            return redirect()->route('pengurusan.eLAPS.index')->with('successMessage', 'Maklumat permohonan telah dihapuskan');
        }else{
            return redirect()->route('pengurusan.eLAPS.index')->with('errorMessage', 'Maklumat permohonan tidak berjaya dihapuskan');
        }
    }
}
