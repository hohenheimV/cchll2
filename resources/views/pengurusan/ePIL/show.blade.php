@extends('layouts.pengurusan.app')

@section('title', 'Lihat ePIL')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header p-0 m-0">
                    <h5 class="card-title p-1 m-1 font-weight-bold">@yield('title')</h5>
                </div>
                {{-- dd($ePIL)--}}
                {!! Form::model($ePIL, ['route' => ['pengurusan.ePIL.update', $ePIL], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
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
                    </style>
                    </style>
                    <div>
                        @include('pengurusan.ePIL._form')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali', ['onclick' => "window.location='".route('pengurusan.ePIL.index')."'", 'class' => 'btn btn-secondary']) !!}
                    {!! 
                        Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.ePIL.edit',$ePIL->id_pelan)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini PIL')]); 
                    !!}

                    @if(auth()->user()->hasRole('Pentadbir Sistem|Pegawai'))
                        {!! Form::button('<i class="fas fa-save"></i> Pengesahan', [
                        'class' => 'btn btn-primary', 
                        'type' => 'submit', 
                        'name' => 'action', 
                        'value' => 'approve'
                    ]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
