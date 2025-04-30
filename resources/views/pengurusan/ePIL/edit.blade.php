@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini ePIL')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {!! Form::model($ePIL, ['route' => ['pengurusan.ePIL.update', $ePIL], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">
                    @if($ePIL->id_permohonan == null)
                        <style>
                            .inertClass input[name="nama_pbt"],
                            .inertClass textarea[name="nama_pelan"] {
                                background-color: rgb(215, 215, 215);
                                color: rgb(65, 60, 60);
                                cursor: not-allowed;
                                pointer-events: none;
                            }
                        </style>
                    @elseif($ePIL->id_permohonan != null || isset($ePIL->nama_pelan))
                        <style>
                            .inertClass {
                                pointer-events: none;
                            }

                            .inertClass input,
                            .inertClass span,
                            .inertClass textarea,
                            .inertClass select {
                                background-color: rgb(215, 215, 215);
                                color: rgb(65, 60, 60);
                                cursor: not-allowed;
                                pointer-events: none;
                            }
                        </style>
                    @endif
                    @include('pengurusan.ePIL._form')

                    <!-- @include('pengurusan.ePIL._upload') -->
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to ePIL index) -->
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.ePIL.index')."'", 'class' => 'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Simpan', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'update'
                    ]) !!}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
