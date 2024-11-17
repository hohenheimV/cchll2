<?php

namespace App\Http\Controllers\Pengurusan;

use App\Exports\HardscapesExport;
use App\Http\Controllers\Controller;
use App\Model\Hardscape;
use App\Model\HardscapeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use PDF;

class HardscapeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|hardscape-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|hardscape-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|hardscape-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|hardscape-delete'], ['only' => ['destroy']]);
        // $this->middleware(['role_or_permission:Pentadbir Sistem|hardscape-histrory']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function peta(Request $request)
    {
        if ($request->only('jenis')) {
            $request->validate([
                'jenis' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }
        if ($request->only('struktur')) {
            $request->validate([
                'struktur' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }

        $query = Hardscape::when($request->jenis, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($qry) use ($request) {
                $qry->whereRaw('lower(jenis_komponen) LIKE ?', ['%' . filter_var(strtolower($request->jenis), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
            });
        })->when($request->struktur, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($qry) use ($request) {
                $qry->whereRaw('lower(nama_struktur) LIKE ?', ['%' . filter_var(strtolower($request->struktur), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
            });
        })->orderBy('gid', 'DESC');
        // })->orderBy('objectid', 'DESC');

        $hardscapes = $query->simplePaginate(500);
        $hardscapes->appends($request->only('jenis', 'struktur'));
        $data = $hardscapes->toArray();
        // $softs = Hardscape::orderBy('objectid')->get();
        // $hardscapes = $softs->toArray();

        return view('pengurusan.hardscape.peta', ['data' => $data, 'hardscapes' => $hardscapes]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Hardscape  $Hardscape
     * @return \Illuminate\Http\Response
     */
    public function marker($id)
    {
        $hardscape = Hardscape::find($id);
        return view('pengurusan.hardscape.marker', ['hardscape' => $hardscape]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //dd($request->all());
        //validate
        if ($request->only('keyword')) {
            $request->validate([
                'keyword' => 'required|min:1|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }

        $hardscapes = Hardscape::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(jenis) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(nama_struk) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('CONCAT(kod_tag) LIKE ? ', $request->keyword);
            });
        })->orderBy('gid')->paginate();
        // })->orderBy('objectid', 'DESC');

        $hardscapes->appends($request->only('keyword'));


        return view('pengurusan.hardscape.index', ['hardscapes' => $hardscapes]);
    }

    private function correctImageOrientation($filename)
    {
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($filename);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                    if ($deg) {
                        $img = imagerotate($img, $deg, 0);
                    }
                    // then rewrite the rotated image back to the disk as $filename
                    imagejpeg($img, $filename, 95);
                } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hardscape = null;
        return view('pengurusan.hardscape.create', compact('hardscape'));
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
            'lat' => 'required',
            'lng' => 'required',
            'kod_tag' => 'required',
            'zon' => 'required',
            'jenis' => 'required',
            'nama_botani' => 'required',
            'nama_tempatan' => 'required',
            'nama_keluarga' => 'required',
            'negara_asal' => 'required',
            'sumber_benih' => 'required',
            'taman_persekutuan' => 'required',
            'keterangan' => 'required',
            'tarikh' => 'required',
            'tahun_tanam' => 'required',
            'kos_perolehan' => 'required',
            'kategori_tumbuhan' => 'required',
            'umur_pokok' => 'required',
            'fungsi_pokok' => 'required',
            'kegunaan_pokok' => 'required',
            'cara_pembiakan' => 'required',
            'jenis_akar' => 'required',
            'tarikh_masa' => 'required',
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
            'lat' => 'Lokasi/Koordinat',
            'lng' => 'Lokasi/Koordinat',
            'kod_tag' => 'Kod Tag',
            'zon' => 'Zon',
            'jenis' => 'Jenis/Kategori',
            'nama_botani' => 'Nama Botani',
            'nama_tempatan' => 'Nama Tempatan',
            'nama_keluarga' => 'Nama Keluarga/Asal',
            'negara_asal' => 'Negara Asal',
            'sumber_benih' => 'Sumber Anak Benih',
            'taman_persekutuan' => 'Taman Persekutuan',
            'keterangan' => 'Keterangan Pokok',
            'tarikh' => 'Tarikh Ditanam',
            'tahun_tanam' => 'Tahun Ditanam',
            'kos_perolehan' => 'Kos Perolehan',
            'kategori_tumbuhan' => 'Kategori Tumbuhan',
            'umur_pokok' => 'Umur Pokok',
            'fungsi_pokok' => 'Fungsi Pokok',
            'kegunaan_pokok' => 'Kegunaan Pokok',
            'cara_pembiakan' => 'Cara Pembiakan',
            'jenis_akar' => 'Jenis Akar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // define data field of Model
        $saved = Hardscape::create($request->all());

        // redirect to
        return redirect()->route('pengurusan.hardscape.show', $saved->gid)->with('successMessage', 'Maklumat telah berjaya disimpan');
        // return redirect()->route('pengurusan.hardscape.show', $saved->objectid)->with('successMessage', 'Maklumat hardscape telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Hardscape  $hardscape
     * @return \Illuminate\Http\Response
     */
    public function show(Hardscape $hardscape, Request $request)
    {
        if ($request->has('tahun') && $request->tahun != date('Y') && $request->tahun <= 2021) {
            $hardscape = HardscapeHistory::where('objectid', $hardscape->objectid)->where('tahun_history', $request->tahun)->first();
        }

        return view('pengurusan.hardscape.show', ['hardscape' => $hardscape]);
    }

    public function petashow(Hardscape $hardscape)
    {
        return view('pengurusan.hardscape.petashow', ['hardscape' => $hardscape]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Hardscape  $hardscape
     * @return \Illuminate\Http\Response
     */
    public function edit(Hardscape $hardscape, $record = null)
    {

        return view('pengurusan.hardscape.edit', ['hardscape' => $hardscape, 'record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Hardscape  $hardscape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hardscape $hardscape)
    {
        // dd($request->all());
        // Mula Rule validation

        // define data field of Model
        $hardscape->update($request->all());

        // redirect to
        return redirect()->route('pengurusan.hardscape.show', $hardscape->gid)->with('successMessage', 'Maklumat telah berjaya disimpan');
        // return redirect()->route('pengurusan.hardscape.show', $hardscape->objectid)->with('successMessage', 'Maklumat hardscape telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Hardscape  $hardscape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hardscape $hardscape)
    {
        //
    }

    public function pdf(Hardscape $hardscape)
    {
        # code...
        $title = $hardscape->kod_tag;
        $hardscape_qrcode = $hardscape->hardscape_qrcode;
        $fileNameToPdf = $title . '.pdf';
        //Arial, Helvetica, sans-serif

        $pdf = PDF::loadView('pengurusan.hardscape.pdf', compact('hardscape', 'title', 'hardscape_qrcode'))
            ->setOptions(['isPhpEnabled' => true, 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true]);
        return $pdf->stream($fileNameToPdf);
    }

    public function tagging(Hardscape $hardscape)
    {
        # code...
        $title = $hardscape->kod_tag;
        $hardscape_qrcode = $hardscape->hardscape_qrcode;
        $fileNameToPdf = $title . '.pdf';
        //Arial, Helvetica, sans-serif

        $pdf = PDF::loadView('pengurusan.hardscape.tag', compact('title', 'hardscape_qrcode'))
            ->setOptions(['isPhpEnabled' => true, 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true]);
        return $pdf->stream($fileNameToPdf);
    }

    public function taggings(Request $request)
    {

        $fileNameToPdf = 'hardscapes_tags_tiada_maklumat.pdf';

        //validate
        if ($request->only('plat')) {
            $request->validate([
                'plat' => 'nullable|regex:/(^[a-z]+$)+/',
            ]);
        }



        $taggings = Hardscape::select('gid', 'objectid', 'zon', 'kod_tag', 'plat')
            ->when($request->plat, function ($q) use ($request) { //Bila ada keyword
                $q->where(function ($query) use ($request) {
                    $query->where('plat', $request->plat);
                });
            })->orderBy('gid')->paginate(400);
        // })->orderBy('objectid')->paginate(400);


        if ($taggings->count() > 0) {

            $first = $taggings->first()->kod_tag;
            $last = $taggings->last()->kod_tag;

            $taggings->appends($request->only('zon', 'plat'));


            $fileNameToPdf = 'hardscapes_tags_' . $first . '_-_' . $last . '.pdf';

            ini_set('max_execution_time', 3000);

            $hardscapes = $taggings->split(100);
        }


        $pdf = PDF::loadView('pengurusan.hardscape.tags', ['hardscapes' => $hardscapes ?? null, 'first' => $first ?? null, 'last' => $last ?? null])
            ->setOptions(['isPhpEnabled' => true, 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true]);
        return $pdf->stream($fileNameToPdf);
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function export_all(Request $request)
    {


        if ($request->isMethod('post')) {


            if ($request->only('zon')) {
                $request->validate([
                    'zon' => 'required',
                ]);
            }
            if ($request->only('jenis')) {
                $request->validate([
                    'struktur' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);
            }
            if ($request->only('struktur')) {
                $request->validate([
                    'struktur' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);
            }


            $hardscapes = Hardscape::when($request->zon, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(zon) LIKE ?', ['%' . strtolower($request->zon) . '%']);
                    });
                })
                ->when($request->jenis, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(jenis) LIKE ?', ['%' . filter_var(strtolower($request->jenis), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })
                ->when($request->struktur, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(nama_struk) LIKE ?', ['%' . filter_var(strtolower($request->struktur), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })
                ->get()->makeHidden(['geom', 'fullKodTag', 'hardscapeQrcode']);

            if (count($hardscapes) > 0) {
                return (new HardscapesExport($hardscapes))->download('hardscapes-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }

            return redirect()->route('pengurusan.exports.hardscape.all')->with('warningMessage', 'Carian tidak dijumpai');
        }

        $zones = [
            'Zon Rekreasi Keluarga',
            'Zon Pentadbiran & Garden Centre',
            'Zon Arboretum Tropika Khatulistiwa',
            'Zon Riparian / Konservasi Hidrologi',
            'Zon Biodiversiti',
            'Zon Arboretum Bernilai Tinggi',
        ];
        $zones = array_combine($zones, $zones);

        return view('pengurusan.hardscape.export', compact('zones'));
    }

    public function gambar(Request $request, Hardscape $hardscape)
    {

        request()->validate([
            'jenis' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ], [
            'image.required' => ':attribute diperlukan.',
            'image.max' => 'Saiz fail :attribute hendaklah kurang dari 5MB.'
        ], ['image' => 'Gambar']);


        if ($request->has('image')) {

            $jenis = $request->jenis;
            $fileName =  $hardscape->kod_tag . '_' . date('ynj-Hi') . '.' . $request->image->getClientOriginalExtension();
            // $request->image->storeAs('/assets/hardscape', $fileName);

            Storage::disk('public')->putFileAs(
                'assets/hardscape',
                $request->file('image'),
                $fileName
            );

            $hardscape->gambar = $fileName;
            $hardscape->save();

            return Response()->json([
                "image" => $hardscape->gambar
            ], Response::HTTP_OK);
        }
    }

    public function history()
    {
        $histories = HardscapeHistory::select('tahun_history')->groupBy('tahun_history')->get();

        return view('pengurusan.hardscape.history', compact('histories'));
    }

    public function history_proses()
    {
        $year = date('Y', strtotime('-1 year'));

        $histories = HardscapeHistory::where('tahun_history', $year)->count();
        if ($histories == 0) {
            DB::connection('pgsqlgis')
                ->statement("INSERT INTO public.kiara_kejur_history(gid, objectid, x, y, kod_tag, zon, jenis, nama_struk, gambar, keadaan, tarikh, kos_bina, baik_pulih, selenggara, catatan, tahun_dibi, created_at, updated_at, deleted_at, plat, geom,tahun_history)
                SELECT gid, objectid, x, y, kod_tag, zon, jenis, nama_struk, gambar, keadaan, tarikh, kos_bina, baik_pulih, selenggara, catatan, tahun_dibi, created_at, updated_at, deleted_at, plat, geom , '$year' FROM public.kiara_kejur;");

            return redirect()->route('pengurusan.hardscape.history')->with('successMessage', 'Jana sejarah landskap kejur bagi tahun ' . $year . ' berjaya');
        }

        return redirect()->route('pengurusan.hardscape.history')->with('warningMessage', 'Jana sejarah landskap kejur bagi tahun ' . $year . ' telah wujud');
    }
}
