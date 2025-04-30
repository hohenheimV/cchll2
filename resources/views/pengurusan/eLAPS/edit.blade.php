@extends('layouts.pengurusan.app')

@section('title', 'Kemaskini eLAPS')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                    <div class="d-flex justify-content-end" role="group" aria-label="First group">
                        {!! Form::button('Informasi&nbsp;&nbsp;&nbsp;<i class="fas fa-info"></i>', [
                            'class'=>'btn btn-success btn-sm',
                            'data-toggle'=>'modal','data-target'=>'#pelanModal',
                        ]) !!}
                        &nbsp;
                    </div>
                </div>
                @php
                    //dd($eLAPS['id']);
                    //(dd($eLAPS->category))
                @endphp
                {!! Form::model($eLAPS, ['route' => ['pengurusan.eLAPS.update', $eLAPS], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body table-hardscape form-hardscape text-sm">

                    @include('pengurusan.eLAPS._form')

                    <!-- @include('pengurusan.eLAPS._upload') -->
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to eLAPS index) -->
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.eLAPS.index')."'", 'class' => 'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', [
                        'class' => 'btn btn-primary', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'update',
                        'id' => 'updateButton'
                    ]) !!}

                    <!-- Submit Button (Hantar Permohonan) -->
                    {!! Form::button('<i class="fas fa-save"></i> Hantar Permohonan', [
                        'class' => 'btn btn-success', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'submit'
                    ]) !!}

                    {!!
                        ((($eLAPS->status_permohonan == 10 || $eLAPS->status_permohonan == 12) && auth()->user()->hasRole('Pentadbir Sistem|Pihak Berkuasa Tempatan')) ?
                            Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini Status Projek', 
                                [
                                    'class' => 'btn btn-primary', 
                                    'type' => 'submit', 
                                    'name' => 'statusProjek', 
                                    'value' => 'siap'
                                ]) 
                        : '')
                    !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
