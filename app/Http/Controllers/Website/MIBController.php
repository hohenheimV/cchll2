<?php

namespace App\Http\Controllers\Website;


use App\Http\Controllers\Controller;
use App\Exports\MIBExport;
use App\Model\MIB;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MIBController extends Controller
{
   

    public function simpan(Request $request)
    {
        // return redirect()->route('website.MIB.register')->with('successMessage', 'Maklumat permohonan telah berjaya disimpan');
        // dd($request->all());
        
        // List of keys you want to check for
        $keysToCheck = [
            'pengerusi_nama', 'pengerusi_tel_bimbit', 'pengerusi_email',
            'timbalan_pengerusi_nama', 'timbalan_pengerusi_tel_bimbit', 'timbalan_pengerusi_email',
            'setiausaha_nama', 'setiausaha_tel_bimbit', 'setiausaha_email',
            'bendahari_nama', 'bendahari_tel_bimbit', 'bendahari_email',
            'ajk1_nama', 'ajk1_tel_bimbit', 'ajk1_email',
            'ajk2_nama', 'ajk2_tel_bimbit', 'ajk2_email',
            'ajk3_nama', 'ajk3_tel_bimbit', 'ajk3_email',
            'ajk4_nama', 'ajk4_tel_bimbit', 'ajk4_email',
            'ajk5_nama', 'ajk5_tel_bimbit', 'ajk5_email',
            'ajk6_nama', 'ajk6_tel_bimbit', 'ajk6_email'
        ];

        // Group the data by 3
        $requestData = $request->all();//$request->only($keysToCheck);
        $groupedData = [];
        for ($i = 0; $i < count($keysToCheck); $i += 3) {
            if(isset($requestData[$keysToCheck[$i]]) || isset($requestData[$keysToCheck[$i + 1]]) || isset($requestData[$keysToCheck[$i + 2]])){    
                $group = [
                    $keysToCheck[$i] => $requestData[$keysToCheck[$i]] ?? null,
                    $keysToCheck[$i + 1] => $requestData[$keysToCheck[$i + 1]] ?? null,
                    $keysToCheck[$i + 2] => $requestData[$keysToCheck[$i + 2]] ?? null,
                ];
                $groupedData[] = $group;
                // dump($keysToCheck[$i]);
                // dump($keysToCheck[$i + 1]);
                // dump($keysToCheck[$i + 2]);
            }
        }
        // $jsonData = json_encode($groupedData, JSON_PRETTY_PRINT);
        $requestData['jawatankuasa'] = $groupedData;
        // $requestData['taman'] = "Taman 2";

        if(isset($requestData['kawasan'])){
            $mergedkawasan = [];
            $kawasanArr = $requestData['kawasan'];
            foreach ($kawasanArr as $key => $value) {
                $kawasan = collect($value ?? [])
                ->map(function($item) {
                    return $item;
                })
                ->toArray();
                if ($kawasan['nama'] !== null) {
                    $mergedkawasan[] = $kawasan;
                }
            }
            $requestData['kawasan'] = ($mergedkawasan);
        }

        if (isset($requestData['fail'])) {
            $mergedfail = [];
            $failArr = $requestData['fail'];
            foreach ($failArr as $key => $value) {
                if ($value->isValid()) {
                    $folderName = str_replace(' ', '_', $requestData['taman']); 
                    $filename = time() . '_' .$value->getClientOriginalName();
                    $path = $value->storeAs('public/uploads/MIB/' . $folderName, $filename);
                    $mergedfail[$key] = $filename;
                }else{
                    $mergedfail[$key] = null;
                }
            }
            $requestData['fail'] = ($mergedfail);
        }  

        // dd($requestData);
        // Mula Rule validation
        $rules = [
            'name'   => 'required',
            'email'   => 'required|email',
            'jawatankuasa'  => 'required',
        ];

        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'  => ':attribute diperlukan.',
            'email'  => ':attribute tidak sah.'
        ];

        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        $validator = Validator::make($requestData, $rules, $messages, $attributes)->validate();

        $ref = Carbon::now()->timestamp;
        $data = $requestData;
        $data['ref_num'] = "MIB$ref";
        $data['registered_at'] = Carbon::now()->format('Y-m-d H:i:s');
        
        $MIB = MIB::create($data);
        // dd($MIB);
		//Hold
        if(config('mail.enabled')){//MAIL ACTIVE, fungsi email enable
            $this->sendmailtopemohon($MIB);
            $this->sendmailtoadmin($MIB);
        }
        // dd($MIB);
        return view('website.MIB.register')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    private function sendmailtopemohon($MIB)
    {

        $data["email"] = $MIB->email;
        $data["client_name"] = $MIB->name;
        $data["subject"] = "Permohonan Pendaftaran Rakan Taman (No Ruj: $MIB->ref_num)";

        try {

            Mail::send('website.MIB.mails.salinan', ['MIB' => $MIB], function ($message) use ($data) {
                $message->to($data["email"], $data["client_name"])
                    //->cc('tpbk@jln.gov.my')
                    ->subject($data["subject"]);
                //->attachData($pdf->output(), $fileName);
            });
        } catch (Error $exception) {
            
             $exception->getMessage();
        }

       
        return true;
        // return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }

    private function sendmailtoadmin($MIB)
    {
        //DEFINE('DS', DIRECTORY_SEPARATOR);

        $data["email"] = config('mail.from.address'); //'kpjln@jln.gov.my';
        $data["client_name"] = config('mail.from.name'); //'KP JLN';
        $data["subject"] = "Permohonan Pendaftaran Rakan Taman (No Ruj: $MIB->ref_num)";

        try {

            Mail::send('website.MIB.mails.permohonan', ['MIB' => $MIB], function ($message) use ($data) {
                $message->to($data["email"], $data["client_name"])
					//->cc('tpbk@jln.gov.my','zahri@jln.gov.my')
					->cc('tpbk@jln.gov.my')
					->bcc('frenemies.888@gmail.com')
                    ->subject($data["subject"]);
            });
        } catch (Error $exception) {
             $exception->getMessage();
        }
        
        return true;
        // return redirect()->route('website.activities.index')->with($this->statuscode, $this->statusdesc);
    }
}

