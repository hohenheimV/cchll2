<?php

namespace App\Http\Controllers\Website;


use App\Http\Controllers\Controller;
use App\Exports\FeedbacksExport;
use App\Model\Feedback;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FeedbacksController extends Controller
{
   

    public function simpan(Request $request)
    {

        // Mula Rule validation
        $rules = [
            'name'   => 'required',
            'email'   => 'required|email',
            'message'  => 'required',
        ];

        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [
            'required'  => ':attribute diperlukan.',
            'email'  => ':attribute tidak sah.'
        ];

        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes)->validate();

        $ref = Carbon::now()->timestamp;
        $data = $request->all();
        $data['ref_num'] = "F$ref";
        $data['feedback_at'] = Carbon::now()->format('Y-m-d H:i:s');

        // define data field of Model
        $feedback = Feedback::create($data);

		//Hold
        if(config('mail.enabled')){//MAIL ACTIVE, fungsi email enable
            $this->sendmailtopemohon($feedback);
            $this->sendmailtoadmin($feedback);
        }


        # code...
        $response = [
            'status' => true
        ];

        return response()->json($response, 200);
        // redirect to
        return redirect()->route('pengurusan.feedbacks.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    private function sendmailtopemohon($feedback)
    {

        $data["email"] = $feedback->email;
        $data["client_name"] = $feedback->name;
        $data["subject"] = "ADUAN DAN PERTANYAAN JABATAN LANDSKAP NEGARA (No Ruj: $feedback->ref_num)";

        try {

            Mail::send('website.feedbacks.mails.salinan', ['feedback' => $feedback], function ($message) use ($data) {
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

    private function sendmailtoadmin($feedback)
    {
        //DEFINE('DS', DIRECTORY_SEPARATOR);

        $data["email"] = config('mail.from.address'); //'kpjln@jln.gov.my';
        $data["client_name"] = config('mail.from.name'); //'KP JLN';
        $data["subject"] = "ADUAN DAN PERTANYAAN JABATA (No Ruj: $feedback->ref_num)";

        try {

            Mail::send('website.feedbacks.mails.permohonan', ['feedback' => $feedback], function ($message) use ($data) {
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

