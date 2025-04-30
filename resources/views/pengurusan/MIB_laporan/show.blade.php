@extends('layouts.pengurusan.app')

@section('title', 'Butiran Aktiviti Rakan Taman')

@section('content')


    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
            <div class="card card-olive card-outline">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold my-1">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                {!! Form::model($MIB_laporan, ['route' => ['pengurusan.MIB_laporan.update', $MIB_laporan],
                'method'=>'PUT','id'=>'formFeedbacks','files' => true]) !!}
                <div class="card-body">
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
                        .inertShow input[type="file"],
                        .inertShow select {
                            background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                            color: rgb(65, 60, 60); /* Light grey text color */
                            cursor: not-allowed; /* Change the cursor to indicate it's not clickable */
                            pointer-events: none; /* Ensure no interactions are possible */
                        }
                    </style>
                    <div >
                        @include('pengurusan.MIB_laporan._form')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::button('Kembali',
                    ['onclick'=>"window.location='".route('pengurusan.MIB.show',$MIB_laporan->id_rakan)."'",
                    'class'=>'btn btn-secondary']) !!}
                    {{--
                        {!! 
                            Form::button('<i class="fas fa-pencil-alt"></i> Kemaskini', ['onclick'=>"window.location='".route('pengurusan.MIB_laporan.edit',$MIB_laporan)."'", 'class'=>'btn bg-warning', Html::tooltip('Kemaskini PIL')]); 
                        !!}
                        {!! Form::button('<i class="fas fa-save"></i> Pengesahan', [
                            'class' => 'btn btn-primary', 
                            'type' => 'submit', 
                            'name' => 'action', 
                            'value' => 'approve'
                        ]) !!}
                    --}}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
