@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>

                {!! Form::model($eLAPS ?? '', ['route' => ['pengurusan.eLAPS.update', $eLAPS ?? '43'], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.eLAPS._form')

                    @include('pengurusan.eLAPS._upload')
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to eLAPS index) -->
                    {!! Form::button('Batal dan Kembali', ['onclick' => "window.location='".route('pengurusan.eLAPS.index')."'", 'class' => 'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'update'
                    ]) !!}

                    <!-- Submit Button (Hantar Permohonan) -->
                    {!! Form::button('<i class="fas fa-save"></i> Hantar Permohonan', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'submit'
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
