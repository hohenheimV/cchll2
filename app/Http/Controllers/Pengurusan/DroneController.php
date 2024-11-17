<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Drone;
use Illuminate\Http\Request;

class DroneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|drone-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|drone-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|drone-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|drone-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $drones = Drone::latest()->paginate();

        return view('pengurusan.drone.index', ['drones' => $drones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.drone.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'video' => 'nullable|mimes:mp4,mov,flv,avi,wmv',
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        $time = time();

        //Semak sekiranya wujud input gambar
        if ($request->hasFile('filevideo')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields video
            $filenamevideo = $time . '_drone_video.' . $request->filevideo->extension();
            $filenameMime = $request->filevideo->getClientMimeType();
            $filenameExtension = $request->filevideo->extension();
            $filenameSize = $request->filevideo->getSize();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->filevideo->storeAs('public/images/shares/drone/', $filenamevideo);

            $request->request->add(['video' => $filenamevideo, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
        if ($request->hasFile('filegambar')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields imej
            $filenamethumbs = $time . '_drone_thumbs.' . $request->filegambar->extension();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->filegambar->storeAs('public/images/shares/drone/', $filenamethumbs);

            $request->merge(['gambar' => $filenamethumbs]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

        //define data field of Model
        Drone::create($request->all());

        //redirect to 'user.designations'
        return response()->json(['success'=>'You have successfully upload file.']);
        // return redirect()->route('pengurusan.drone.index')->with('successMessage', 'Maklumat drone telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Drone  $drone
     * @return \Illuminate\Http\Response
     */
    public function show(Drone $drone)
    {
        return view('pengurusan.drone.show', ['drone' => $drone]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Drone  $drone
     * @return \Illuminate\Http\Response
     */
    public function edit(Drone $drone)
    {
        return view('pengurusan.drone.edit', ['drone' => $drone]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Drone  $drone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drone $drone)
    {

        $request->validate([
            'tajuk' => ['required', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'keterangan' => ['nullable', 'min:3', 'regex:/[0-9a-zA-Z @\/\'`]+$/'],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'video' => 'nullable|mimes:mp4,mov,flv,avi,wmv',
            'tarikh' => 'required',
        ], [
            'required' => ':attribute diperlukan.',
            'min' => ':attribute terlalu ringkas, minima 3 aksara.',
            'regex' => ':attribute format tidak sah.',
        ]);

        $time = time();
        //Semak sekiranya wujud input gambar
        if ($request->hasFile('filevideo')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields video
            $filenamevideo = $time . '_drone_video.' . $request->filevideo->extension();
            $filenameMime = $request->filevideo->getClientMimeType();
            $filenameExtension = $request->filevideo->extension();
            $filenameSize = $request->filevideo->getSize();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->filevideo->storeAs('public/images/shares/drone/', $filenamevideo);

            $request->request->add(['video' => $filenamevideo, 'extension' => $filenameExtension, 'mimes' => $filenameMime, 'size' => $filenameSize]);
        }
        if ($request->hasFile('filegambar')) {
            //nama baru bagi fail yg di upload
            //akan disimpan ke dalm fields imej
            $filenamethumbs = $time . '_drone_thumbs.' . $request->filegambar->extension();

            //Store Image in Storage Folder
            //storage/app/images/file.png
            $request->filegambar->storeAs('public/images/shares/drone/', $filenamethumbs);

            $request->merge(['gambar' => $filenamethumbs]);
        }
        $request->merge(['tarikh' => date('Y-m-d', strtotime($request->tarikh))]);

        //define data field of Model
        $statsu = $drone->update($request->all());

        //redirect to 'user.designations'
         return response()->json(['success'=>'You have successfully upload file.',$statsu]);
        //return redirect()->route('pengurusan.drone.index')->with('successMessage', 'Maklumat drone telah berjaya disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Drone  $drone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drone $drone)
    {
        $drone->delete();
        return redirect()->route('pengurusan.drone.index')->with('successMessage', 'Maklumat drone telah dihapuskan');
    }
}
