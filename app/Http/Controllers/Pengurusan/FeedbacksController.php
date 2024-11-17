<?php

namespace App\Http\Controllers\Pengurusan;

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
    protected $status;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|feedback-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|feedback-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|feedback-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|feedback-delete'], ['only' => ['destroy']]);
        
        $status = ['Baru', 'Dalam Tindakan', 'Selesai'];
        $this->statusArr = array_combine($status, $status);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
              //validate
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255|regex:/(^[A-Za-z0-9\/\-\_\@ ]+$)+/',
            ]);
        }

        $feedbacks = Feedback::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
				$query->whereRaw('lower(name) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
					->orWhereRaw('lower(status) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(ref_num) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
            });
        })->latest()->paginate();

        $feedbacks->appends($request->only('keyword'));

        return view('pengurusan.feedbacks.index', ['feedbacks' => $feedbacks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.feedbacks.create', ['status' => $this->statusArr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        // redirect to
        return redirect()->route('pengurusan.feedbacks.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        return view('pengurusan.feedbacks.show', ['feedback' => $feedback]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        return view('pengurusan.feedbacks.edit', ['feedback' => $feedback, 'status' => $this->statusArr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        // Mula Rule validation
        $rules = [
            'name'   => 'required|min:3',
            'email'   => 'required|email',
            'message' => 'required|min:3',
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

        $data = $request->all();
		$data['officer'] = Auth::user()->name;

		if (strtolower($request->status) == 'selesai') {
            $data['approved_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }

        //$data['feedback_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['response_at'] = date('Y-m-d H:i:s', strtotime($request->response_at));

        if (isset($request->attachment)) {
            $attachmentName = $feedback->ref_num . '_' . Carbon::now()->format('Ymdhis') . '.' . $request->file('attachment')->extension();
            $data['form_attachment'] = $attachmentName;
        }

        $data = Arr::except($data, ['attachment']);

        // define data field of Model
        $feedback->update($data);

        if (isset($request->attachment)) {
            Storage::disk('public')->putFileAs(
                'files/feedback/' . $feedback->id,
                $request->file('attachment'),
                $attachmentName
            );
        }

        // redirect to
        return redirect()->route('pengurusan.feedbacks.index')->with('successMessage', 'Maklumat telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        if ($feedback->delete()) {
            return redirect()->route('pengurusan.feedbacks.index')->with('successMessage', 'Maklumat telah berjaya dihapuskan');
        }
        return redirect()->route('pengurusan.feedbacks.index')->with('errorMessage', 'Maklumat telah gagal dihapuskan');
    }

    public function download(Feedback $feedback)
    {
        $path = 'files/feedback/' . $feedback->id . '/';

        if(Storage::disk('public')->exists($path . $feedback->form_attachment)){
            return Storage::disk('public')->download($path . $feedback->form_attachment);
        }
        return redirect()->route('pengurusan.feedbacks.index')->with('errorMessage', 'Fail tidak wujud, sila cuba lagi.');

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all(Request $request)
    {

        if ($request->isMethod('post')) {

            $feedbacks = Feedback::limit(110)
                ->when($request->response_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('feedback_at', date('Y-m-d', strtotime($request->feedback_at)));
                    });
                })
                ->when($request->response_at, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('response_at', date('Y-m-d', strtotime($request->response_at)));
                    });
                })
                ->when($request->status, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->where('status', $request->status);
                    });
                })
                ->get();

            if (count($feedbacks) > 0) {
                return (new FeedbacksExport($feedbacks))->download('feedbacks-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }

            return redirect()->route('pengurusan.exports.feedbacks.all')->with('warningMessage', 'Carian tidak dijumpai');
        }

        $status = $this->statusArr;
        $status = array_combine($status, $status);


        return view('pengurusan.feedbacks.export', compact('status'));
    }

}

