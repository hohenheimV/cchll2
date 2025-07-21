<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit as Audit;

class AuditController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Pentadbir Sistem|Pegawai']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255',
            ]);
        }

        $audits = Audit::with('user')->where('event', '!=', 'Logged In')
            ->when($request->keyword, function ($q) use ($request) {
                $q->whereHasMorph('user', [User::class], function ($query) use ($request) {
                    $name  = $request->keyword;
                    $name  = strtolower($name);
                    $query->whereRaw("lower(users.name) LIKE '%$name%'");
                });

                if (filter_var($request->keyword, FILTER_VALIDATE_IP)) {
                    $q->orWhere('ip_address', $request->keyword);
                }
                if (strtotime($request->keyword) !== false) {
                    $date = date('Y-m-d', strtotime($request->keyword));
                    $q->orWhereDate('created_at', $date);
                }
                $keyword = strtolower($request->keyword);
                $q->orWhere('event', $keyword)
                    ->orWhereRaw("lower(auditable_type) LIKE '%$keyword%'")
                    ->orWhereRaw("lower(new_values) LIKE '%$keyword%'")
                    ->orWhereRaw("lower(old_values) LIKE '%$keyword%'");
            })
            ->latest()->paginate(20);

        $audits->appends($request->only('keyword'));

        // $logged = Audit::with('user')->where('event', '!=', 'Logged In')
        //     ->when($request->keyword, function ($q) use ($request) {
        //         $q->whereHasMorph('user', [User::class], function ($query) use ($request) {
        //             $name  = $request->keyword;
        //             $name  = strtolower($name);
        //             $query->whereRaw("lower(users.name) LIKE '%$name%'");
        //         });

        //         if (filter_var($request->keyword, FILTER_VALIDATE_IP)) {
        //             $q->orWhere('ip_address', $request->keyword);
        //         }
        //         if (strtotime($request->keyword) !== false) {
        //             $date = date('Y-m-d', strtotime($request->keyword));
        //             $q->orWhereDate('created_at', $date);
        //         }

        //         // $keyword = strtolower($request->keyword);
        //         // $q->orWhere('event', $keyword)
        //         //     ->orWhereRaw("lower(auditable_type) LIKE '%$keyword%'")
        //         //     ->orWhereRaw("lower(new_values) LIKE '%$keyword%'")
        //         //     ->orWhereRaw("lower(old_values) LIKE '%$keyword%'");
        //     })
        //     ->latest()->paginate(20);

        // $logged->appends($request->only('keyword'));

        // $audits = Audit::with('user')->where('event', '!=', 'Logged In')->latest()->paginate(100);
        return view('pengurusan.audits.index', ['audits' => $audits]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logged(Request $request)
    {


        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:3|max:255',
            ]);
        }

        $logged = Audit::with('user')->where('event', 'Logged In')
            ->when($request->keyword, function ($q) use ($request) {
                $q->whereHasMorph('user', [User::class], function ($query) use ($request) {
                    $name  = $request->keyword;
                    $name  = strtolower($name);
                    $query->whereRaw("lower(users.name) LIKE '%$name%'");
                });

                if (filter_var($request->keyword, FILTER_VALIDATE_IP)) {
                    $q->orWhere('ip_address', $request->keyword);
                }
                if (strtotime($request->keyword) !== false) {
                    $date = date('Y-m-d', strtotime($request->keyword));
                    $q->orWhereDate('created_at', $date);
                }
            })
            ->latest()->paginate(20);

        $logged->appends($request->only('keyword'));

        return view('pengurusan.audits.logged', ['audits' => $logged]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function show($audit)
    {
        $audit = Audit::find($audit);

        return view('pengurusan.audits.show', compact('audit'));
    }
}
