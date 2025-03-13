@extends('layouts.pengurusan.app')

@php
    $lastSegment = Request::segment(3);
    $capitalizedSegment = ucfirst($lastSegment);
    if ($capitalizedSegment == 'Pendidikan') {
        $capitalizedSegment = 'Institusi Pendidikan';
    }else if ($capitalizedSegment == 'Ngo') {
        $capitalizedSegment = 'NGO / Badan Ikhtisas';
    }else if ($capitalizedSegment == 'Antarabangsa') {
        $capitalizedSegment = 'Pertubuhan Antarabangsa';
    }
@endphp

@section('title', 'Lihat Maklumat ' . $capitalizedSegment)

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {!! Form::model($eLIND, ['route' => ['pengurusan.eLIND.update', 'type' => $lastSegment, 'id' => $eLIND], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    <div class="card-body table-hardscape form-hardscape text-sm">
                    
                        @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                            <div class="row" style="max-height: 40px; display: flex; justify-content: flex-end;">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        {{ Form::label('', 'Paparan Portal&nbsp;:&nbsp;', ['class' => 'col-form-label required-field-create', 'style' => 'font-weight: strong;']) }}
                                    </div>
                                    <div class="col-auto">
                                        <label class="switch">
                                            <input type="checkbox" name="status" {{ isset($status) && $status == 'approved' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <style>
                            .showButton{
                                display: none;
                            }
                            .inertShow {
                                pointer-events: none; /* Ensure no interactions are possible */
                            }

                            .inertShow input,
                            .inertShow span,
                            .inertShow textarea,
                            .inertShow select {
                                background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                                color: rgb(65, 60, 60); /* Light grey text color */
                                cursor: not-allowed; /* Change the cursor to indicate it's not clickable */
                                pointer-events: none; /* Ensure no interactions are possible */
                            }
                            table th:last-child, table td:last-child {
                                display: none;
                            }
                        </style>
                        <div inert class="inertShow">
                            @include('pengurusan.eLIND._form')
                        </div>

                        @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                            {{ Form::label('ulasan_lawatan', 'KEGUNAAN JABATAN :', ['class' => 'col-form-label']) }}
                            <br>
                            <div class="form-group mb-6 col-md-12" style="background-color:#fef7f8; border-left: 5px solid #f0868e; padding: 15px;">
                                @php
                                    if($eLIND->prestasi != null){
                                        $dataprestasi = json_decode($eLIND->prestasi, true);
                                        $prestasiDB = end($dataprestasi)['prestasi'] ?? 0;
                                    }else{
                                        $prestasiDB = 0;
                                    }

                                    if($eLIND->komen != null){
                                        $datakomen = json_decode($eLIND->komen, true);
                                        $komenDB = end($datakomen)['komen'] ?? '';
                                    }else{
                                        $komenDB = '';
                                    }
                                    
                                    if($eLIND->pentaksir != null){
                                        $datapentaksir = json_decode($eLIND->pentaksir, true);
                                        $pentaksirDB = end($datapentaksir)['pentaksir'] ?? '';
                                        $timestamp = ' pada ' . end($datapentaksir)['timestamp'] ?? '';
                                    }else{
                                        $pentaksirDB = '';
                                        $timestamp = '';
                                    }
                                @endphp
                                {!! Form::label('prestasi', 'Prestasi:') !!}
                                {!! Form::select('prestasi', [
                                    '1' => 'Sangat Baik',
                                    '2' => 'Baik',
                                    '3' => 'Sederhana',
                                    '4' => 'Lemah',
                                    '0' => 'Tiada Maklumat'
                                ], $prestasiDB ?? 0, ['class' => 'form-control', 'id' => 'prestasiSelect']) !!}

                                {!! Form::label('komen', 'Komen:') !!}
                                {!! Form::textarea('komen', $komenDB ?? '', ['class' => 'form-control', 'id' => 'komenTextarea', 'rows' => 3, 'placeholder' => 'Masukkan komen di sini...']) !!}

                                @php($dataPentaksir = json_decode($eLIND->pentaksir, true))
                                {!! Form::label('pentaksir', 'Pentaksir:') !!}
                                {!! Form::text('pentaksir', 
                                    auth()->user()->hasRole('Pentadbir Sistem') ? 
                                        ($eLIND->pentaksir ? App\User::find($pentaksirDB)->name . $timestamp : '') : '', 
                                    [
                                        'class' => 'form-control',
                                        'id' => 'pentaksir',
                                        'inert' => 'inert',
                                        'style' => auth()->user()->hasRole('Pentadbir Sistem') ? '' : 'display:none;' // Hide for non-admin users
                                    ]
                                ) !!}
                            </div>
                        @endif

                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.eLIND.index', ['type' => $lastSegment])."'", 'class' => 'btn btn-secondary']) !!}
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.eLIND.edit', ['type' => $lastSegment, 'id' => $eLIND])."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini PIL')]); 
                    !!}

                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        {!! Form::button('<i class="fas fa-save"></i> Pengesahan', [
                            'class' => 'btn btn-primary', 
                            'type' => 'submit', 
                            'name' => 'action', 
                            'value' => 'approve'
                        ]) !!}
                        {!! Form::button('<i class="fas fa-sticky-note"></i> Simpan Prestasi', [
                            'class' => 'btn btn-success', 
                            'type' => 'submit', 
                            'name' => 'action', 
                            'value' => 'prestasi'
                        ]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
