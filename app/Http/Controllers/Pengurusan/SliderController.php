<?php

namespace App\Http\Controllers\Pengurusan;

use App\Http\Controllers\Controller;
use App\Model\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Pentadbir Sistem|slider-list']);
        $this->middleware(['role_or_permission:Pentadbir Sistem|slider-create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|slider-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:Pentadbir Sistem|slider-delete'], ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::paginate();
        return view('pengurusan.sections.sliders.index',['sliders'=>$sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengurusan.sections.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Mula Rule validation
        $rules = [];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        //UPDATE
        $data = $request->all();
        $data['is_active'] = isset($request->is_active) ? $request->is_active : 0;
        $data['popup'] = isset($request->popup) ? $request->popup : 0;
        Slider::create($data);
        //redirect to
        return Redirect::route('pengurusan.sliders.index')->with('successMessage', 'Maklumat Slider telah berjaya disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
        return view('pengurusan.sections.sliders.edit',['slider'=>$slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {

        // Mula Rule validation
        $rules = [];
        //Selaras bentuk mesej yang sama; attributes berbeza
        $messages = [];
        // Rename field ke perkataan boleh difaham (jika perlu/berlainan)
        $attributes = [];

        //UPDATE
        $data = $request->all();
        $data['is_active'] = isset($request->is_active) ? $request->is_active : 0;
        $data['popup'] = isset($request->popup) ? $request->popup : 0;
        $slider->update($data);
        //redirect to
        return Redirect::route('pengurusan.sliders.index')->with('successMessage', 'Maklumat Slider telah berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
        $slider->delete();

        return Redirect::route('pengurusan.sliders.index')->with('successMessage', 'Maklumat Slider telah berjaya dihapuskan');
    }
}
