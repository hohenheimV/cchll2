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
                    <style>
                        div[inert] {
                            pointer-events: none; /* Ensure no interactions are possible */
                        }

                        div[inert] input,
                        div[inert] span,
                        div[inert] textarea,
                        div[inert] select {
                            background-color:rgb(215, 215, 215); /* Light grey background for input/select */
                            color:rgb(65, 60, 60); /* Light grey text color */
                            cursor: not-allowed; /* Change the cursor to indicate it's not clickable */
                            pointer-events: none; /* Ensure no interactions are possible */
                        }
                        .inertClass {
                            pointer-events: none; /* Ensure no interactions are possible */
                        }

                        .inertClass input,
                        .inertClass span,
                        .inertClass textarea,
                        .inertClass select {
                            background-color: rgb(215, 215, 215); /* Light grey background for input/select */
                            color: rgb(65, 60, 60); /* Light grey text color */
                            cursor: not-allowed; /* Change the cursor to indicate it's not clickable */
                            pointer-events: none; /* Ensure no interactions are possible */
                        }
                    </style>
                    @include('pengurusan.ePIL._form')

                    
                    <script>
                        // Function to add a row when the page loads
                        window.onload = function() {
                            // addRowOnce();
                        };
                    </script>

                    <!-- @include('pengurusan.ePIL._upload') -->
                </div>
                <div class="card-footer">
                    <!-- Cancel Button (redirect to ePIL index) -->
                    {!! Form::button('Batal dan Kembali', ['onclick' => "window.location='".route('pengurusan.ePIL.index')."'", 'class' => 'btn btn-secondary']) !!}

                    <!-- Update Button (Kemaskini) -->
                    {!! Form::button('<i class="fas fa-save"></i> Kemaskini', [
                        'class' => 'btn btn-primary', 
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
