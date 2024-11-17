<?php

namespace App\Http\Controllers\Pengurusan;

use App\Exports\SoftscapesExport;
use PDF;
use App\Http\Controllers\Controller;
use App\Model\Softscape;
use App\Model\SoftscapeHistory;
use App\Model\SoftscapeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class SoftscapeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|softscape-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|softscape-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|softscape-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|softscape-delete'], ['only' => ['destroy']]);
        // $this->middleware(['role_or_permission:Pentadbir Sistem|softscape-histrory']);
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
        if ($request->only('nama_botani')) {
            $request->validate([
                'nama_botani' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }
        if ($request->only('nama_tempatan')) {
            $request->validate([
                'nama_tempatan' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }
        if ($request->only('nama_keluarga')) {
            $request->validate([
                'nama_keluarga' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
            ]);
        }

        $query = Softscape::when($request->jenis, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($qry) use ($request) {
                $qry->whereRaw('lower(jenis) LIKE ?', ['%' . filter_var(strtolower($request->jenis), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
            });
        })->when($request->nama_botani, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($qry) use ($request) {
                $qry->whereRaw('lower(nama_botani) LIKE ?', ['%' . filter_var(strtolower($request->nama_botani), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
            });
        })->when($request->nama_tempatan, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($qry) use ($request) {
                $qry->whereRaw('lower(nama_tempatan) LIKE ?', ['%' . filter_var(strtolower($request->nama_tempatan), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
            });
        })->when($request->nama_keluarga, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($qry) use ($request) {
                $qry->whereRaw('lower(nama_keluarga) LIKE ?', ['%' . filter_var(strtolower($request->nama_keluarga), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
            });
        })->orderBy('gid', 'DESC');
        // })->orderBy('objectid', 'DESC');

        $softscapes = $query->simplePaginate(500);
        $softscapes->appends($request->only('jenis', 'nama_botani', 'nama_tempatan', 'nama_keluarga'));
        $data = $softscapes->toArray();

        return view('pengurusan.softscape.peta', ['data' => $data, 'softscapes' => $softscapes]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Softscape  $softscape
     * @return \Illuminate\Http\Response
     */
    public function marker($id)
    {
        $softscape = Softscape::find($id);
        return view('pengurusan.softscape.marker', ['softscape' => $softscape]);
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

        $softscapes = Softscape::when($request->keyword, function ($q) use ($request) { //Bila ada keyword
            $q->where(function ($query) use ($request) {
                $query->whereRaw('lower(jenis_kate) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(nama_bot) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('lower(nama_kel) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%'])
                    ->orWhereRaw('kod_tag LIKE ? ', $request->keyword)
                    ->orWhereRaw('lower(nama_temp) LIKE ? ', ['%' . trim(strtolower($request->keyword)) . '%']);
            });
        })->orderBy('gid')->paginate();
        // })->orderBy('objectid')->paginate();

        $softscapes->appends($request->only('keyword'));


        return view('pengurusan.softscape.index', ['softscapes' => $softscapes]);
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
        return view('pengurusan.softscape.create');
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
        $saved = Softscape::create($request->all());

        // redirect to
        return redirect()->route('pengurusan.softscape.show', $saved->gid)->with('successMessage', 'Maklumat telah berjaya disimpan');
        // return redirect()->route('pengurusan.softscape.show', $saved->objectid)->with('successMessage', 'Maklumat hardscape telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Softscape  $softscape
     * @return \Illuminate\Http\Response
     */
    public function show(Softscape $softscape, Request $request)
    {
        if ($request->has('tahun') && $request->tahun != date('Y') && $request->tahun <= 2021) {
            $softscape = SoftscapeHistory::where('objectid', $softscape->objectid)->where('tahun_history', $request->tahun)->first();
        }

        return view('pengurusan.softscape.show', ['softscape' => $softscape]);
    }
    public function petashow(Softscape $softscape)
    {
        return view('pengurusan.softscape.petashow', ['softscape' => $softscape]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Softscape  $softscape
     * @return \Illuminate\Http\Response
     */
    public function edit(Softscape $softscape, $record = null)
    {

        return view('pengurusan.softscape.edit', ['softscape' => $softscape, 'record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Softscape  $softscape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Softscape $softscape)
    {
        // dd($request->all());
        // Mula Rule validation

        if ($request->tarikh_tan) {
            $tahun = date('Y', strtotime($request->tarikh_tan));
            $request->merge([
                'tahun_tana' => $tahun,
                'umur_pokok' => date('Y') - $tahun
            ]);
        }
        // define data field of Model
        $softscape->update($request->all());

        // redirect to
        return redirect()->route('pengurusan.softscape.show', $softscape->gid)->with('successMessage', 'Maklumat telah berjaya disimpan');
        // return redirect()->route('pengurusan.softscape.show', $softscape->objectid)->with('successMessage', 'Maklumat hardscape telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Softscape  $softscape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Softscape $softscape)
    {
        //
    }

    public function pdf(Softscape $softscape)
    {
        # code...
        $title = $softscape->kod_tag;
        $softscape_qrcode = $softscape->softscape_qrcode;
        $fileNameToPdf = $title . '.pdf';
        //Arial, Helvetica, sans-serif

        $pdf = PDF::loadView('pengurusan.softscape.pdf', compact('softscape', 'title', 'softscape_qrcode'))
            ->setOptions(['isPhpEnabled' => true, 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true]);
        return $pdf->stream($fileNameToPdf);
    }

    public function tagging(Softscape $softscape)
    {
        # code...
        $title = $softscape->kod_tag;
        $softscape_qrcode = $softscape->softscape_qrcode;
        $fileNameToPdf = $title . '.pdf';
        //Arial, Helvetica, sans-serif

        $pdf = PDF::loadView('pengurusan.softscape.tag', compact('title', 'softscape_qrcode'))
            ->setOptions(['isPhpEnabled' => true, 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isJavascriptEnabled' => true]);
        return $pdf->stream($fileNameToPdf);
    }

    public function taggings(Request $request)
    {

        $fileNameToPdf = 'softscapes_tags_tada_maklumat.pdf';

        //validate
        if ($request->only('zon')) {
            $request->validate([
                'zon' => 'required|regex:/(^[A-Za-z]+$)+/',
            ]);
        }
        if ($request->only('plat')) {
            $request->validate([
                'plat' => 'nullable|regex:/(^[a-z]+$)+/',
            ]);
        }



        $taggings = Softscape::select('gid', 'objectid', 'zon', 'kod_tag', 'plat')
            ->when($request->plat, function ($q) use ($request) { //Bila ada keyword
                $q->where(function ($query) use ($request) {
                    $query->where('plat', $request->plat);
                });
            })->where('zon', 'like', strtoupper($request->zon) . '%')
            ->orderBy('gid')->paginate(400);
        // ->orderBy('objectid')->paginate(400);

        if ($taggings->count() > 0) {

            $first = $taggings->first()->kod_tag;
            $last = $taggings->last()->kod_tag;

            $taggings->appends($request->only('zon', 'plat'));


            $fileNameToPdf = 'softscapes_tags_' . $first . '_-_' . $last . '.pdf';

            ini_set('max_execution_time', 3000);

            $softscapes = $taggings->split(100);
        }


        $pdf = PDF::loadView('pengurusan.softscape.tags', ['softscapes' => $softscapes ?? null, 'first' => $first ?? null, 'last' => $last ?? null])
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
                    'jenis' => 'nullable',
                ]);
            }
            if ($request->only('botani')) {
                $request->validate([
                    'botani' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);
            }
            if ($request->only('tempatan')) {
                $request->validate([
                    'tempatan' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);
            }
            if ($request->only('keluarga')) {
                $request->validate([
                    'keluarga' => 'nullable|min:3|max:255|regex:/(^[A-Za-z0-9\/\- ]+$)+/',
                ]);
            }
            //'zon','jenis_kate', 'nama_bot', 'nama_temp', 'nama_kel',
            $softscapes = Softscape::when($request->jenis, function ($q) use ($request) {
                $q->where(function ($qry) use ($request) {
                    // $qry->whereRaw('lower(jenis) LIKE ?', ['%' . filter_var(strtolower($request->jenis), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    $qry->where('jenis_kate', $request->jenis);
                });
            })
                ->when($request->zon, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(zon) LIKE ?', ['%' . strtolower($request->zon) . '%']);
                    });
                })
                ->when($request->botani, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(nama_bot) LIKE ?', ['%' . filter_var(strtolower($request->botani), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })
                ->when($request->tempatan, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(nama_temp) LIKE ?', ['%' . filter_var(strtolower($request->tempatan), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })
                ->when($request->keluarga, function ($q) use ($request) {
                    $q->where(function ($qry) use ($request) {
                        $qry->whereRaw('lower(nama_kel) LIKE ?', ['%' . filter_var(strtolower($request->keluarga), FILTER_SANITIZE_SPECIAL_CHARS) . '%']);
                    });
                })
                ->get()->makeHidden(['geom', 'fullKodTag', 'softscapeQrcode']);

            if (count($softscapes) > 0) {

                return (new SoftscapesExport($softscapes))->download('softscapes-collection-' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            }

            return redirect()->route('pengurusan.exports.softscape.all')->with('warningMessage', 'Carian tidak dijumpai');
        }

        $jenis = [
            'Ameniti',
            'Buluh',
            'Renek',
            'Palma'
        ];
        $jenis = array_combine($jenis, $jenis);
        $zones = [
            'Zon Rekreasi Keluarga',
            'Zon Pentadbiran & Garden Centre',
            'Zon Arboretum Tropika Khatulistiwa',
            'Zon Riparian / Konservasi Hidrologi 1',
            'Zon Biodiversiti',
            'Zon Arboretum Bernilai Tinggi',
        ];
        $zones = array_combine($zones, $zones);

        return view('pengurusan.softscape.export', compact('zones', 'jenis'));
    }

    public function gambar(Request $request, Softscape $softscape)
    {

        request()->validate([
            'jenis' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ], [
            'image.required' => ':attribute diperlukan.',
            'image.max' => 'Saiz fail :attribute hendaklah kurang dari 5MB.'
        ], ['image' => 'Gambar']);


        if ($request->has('image')) {

            $fileNameGambar = [
                'gambar_p' => $softscape->kod_tag . '_P_' . date('ynj-Hi'),
                'gambar_b' => $softscape->kod_tag . '_B_' . date('ynj-Hi'),
                'gambar_d' => $softscape->kod_tag . '_D_' . date('ynj-Hi'),
                'gambar_bg' => $softscape->kod_tag . '_BG_' . date('ynj-Hi'),
                'gambar_bh' => $softscape->kod_tag . '_BH_' . date('ynj-Hi'),
            ];

            $files = $request->file('image');

            $jenis = $request->jenis;
            $fileName =  $fileNameGambar[$jenis] . '.' . $request->image->getClientOriginalExtension();
            // $request->image->storeAs('image', $fileName);

            Storage::disk('public')->putFileAs(
                'assets/softscape',
                $request->file('image'),
                $fileName
            );

            $softscape->{$jenis} = $fileName;
            $softscape->save();

            return Response()->json([
                "image" => $softscape->{$jenis}
            ], Response::HTTP_OK);
        }
    }


    public function history()
    {
        $histories = SoftscapeHistory::select('tahun_history')->groupBy('tahun_history')->get();
        return view('pengurusan.softscape.history', compact('histories'));
    }

    public function history_proses()
    {
        $year = date('Y', strtotime('-1 year'));

        $histories = SoftscapeHistory::where('tahun_history', $year)->count();
        if ($histories == 0) {
            DB::connection('pgsqlgis')
                ->statement("INSERT INTO public.kiara_lembut_history(gid, objectid, x_coord, y_coord, kod_tag, zon, jenis_kate, nama_bot, nama_temp, nama_kel, negara_asa, sumber_ana, taman_pers, keterangan, gambar_p, gambar_b, gambar_d, gambar_bg, gambar_bh, saiz_kanop, keadaan, tarikh_mas, tarikh_tan, tahun_tana, kos, nilai_sema, status, rawatan, kategori_t, umur_pokok, fungs_ipok, kegunaan, cara_biak, jenis_akar, lebar_sila, bentuk_sil, bentuk_btg, tinggi_btg, diamater_b, tekstur_bt, warna_daun, bentuk_dau, percambaha, jenis_daun, warna_bung, bentuk_bun, saiz_bunga, bil_kelopa, wangian, musimbg, tempohbg, warna_bh, bentuk_bh, saiz_buah, musim_buah, tempoh_bua, jenis_baja, kaedah_baj, tarikh_baj, jenis_pema, tarikh_pem, kaedah_raw, tarikh_raw, jenis_risi, tahap_risi, tarikh_ris, created_at, updated_at, deleted_at, plat, catatan, geom, tahun_history) SELECT gid, objectid, x_coord, y_coord, kod_tag, zon, jenis_kate, nama_bot, nama_temp, nama_kel, negara_asa, sumber_ana, taman_pers, keterangan, gambar_p, gambar_b, gambar_d, gambar_bg, gambar_bh, saiz_kanop, keadaan, tarikh_mas, tarikh_tan, tahun_tana, kos, nilai_sema, status, rawatan, kategori_t, umur_pokok, fungs_ipok, kegunaan, cara_biak, jenis_akar, lebar_sila, bentuk_sil, bentuk_btg, tinggi_btg, diamater_b, tekstur_bt, warna_daun, bentuk_dau, percambaha, jenis_daun, warna_bung, bentuk_bun, saiz_bunga, bil_kelopa, wangian, musimbg, tempohbg, warna_bh, bentuk_bh, saiz_buah, musim_buah, tempoh_bua, jenis_baja, kaedah_baj, tarikh_baj, jenis_pema, tarikh_pem, kaedah_raw, tarikh_raw, jenis_risi, tahap_risi, tarikh_ris, created_at, updated_at, deleted_at, plat, catatan, geom, '$year' FROM public.kiara_lembut;");

            return redirect()->route('pengurusan.softscape.history')->with('successMessage', 'Jana sejarah landskap lembut bagi tahun ' . $year . ' berjaya');
        }

        return redirect()->route('pengurusan.softscape.history')->with('warningMessage', 'Jana sejarah landskap lembut bagi tahun ' . $year . ' telah wujud');
    }
}
