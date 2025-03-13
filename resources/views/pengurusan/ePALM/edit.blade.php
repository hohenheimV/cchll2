@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini ePALM')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {!! Form::model($ePALM, ['route' => ['pengurusan.ePALM.update', $ePALM], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    @if($ePALM->id_permohonan != null || isset($ePALM->nama_taman))
                        <style>
                            .inertClass {
                                pointer-events: none;
                            }

                            .inertClass input,
                            .inertClass span,
                            .inertClass textarea,
                            .inertClass select {
                                background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                                color: rgb(65, 60, 60); /* Light grey text color */
                                cursor: not-allowed;
                                pointer-events: none;
                            }
                        </style>
                    @endif
                    @include('pengurusan.ePALM._form')

                    <!-- @include('pengurusan.ePALM._upload') -->
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to ePALM index) -->
                    {!! Form::button('Batal dan Kembali', ['onclick' => "window.location='".route('pengurusan.ePALM.index')."'", 'class' => 'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', [
                        'class' => 'btn btn-warning', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'update'
                    ]) !!}

                    <!-- Submit Button (Hantar Permohonan) -->
                    <!-- {!! Form::button('<i class="fas fa-save"></i> Hantar Permohonan', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'submit'
                    ]) !!} -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
