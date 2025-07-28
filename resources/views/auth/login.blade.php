@extends('layouts.pengurusan.auth')

@section('title', 'Log Masuk')

@section('content')
    <section class="content">
        @include('layouts.pengurusan.notification')
        @yield('content')
    </section>
    <!--EMMET: .card>.card-body -->
    <style>
        /* Hero Section */
        #hero {
        /* background-image: url("{{ asset('img/border2.png') }}"); */
        }
    </style>
    <div class="row">
        <!-- <div class="col-lg-7 col-md-4 col-12 d-none d-lg-block rounded-left bg-gradient-olive p-5" style="min-height: 380px">
            <div class="login-logo h-100 d-flex flex-column justify-content-center align-items-center">
                <img height="96" src="{{ asset('img/logo-jln.png') }}" />
                <div><span class="font-weight-bold text-light">{{config('app.name_short')}}</span> {{config('app.agency_short')}}</div>
            </div>
        </div> -->
        <div class="col-lg-12 col-12 rounded-right bg-white">

            <div class="card-body" style="width: 400px !important" id="hero">
                <div class="login-logo h-100 d-flex flex-column justify-content-center align-items-center">
                    <!-- <img height="25" src="{{ asset('img/logo-jln.png') }}" /> -->
                    <!-- <div> -->
                        {{config('app.name_short')}}
                    <!-- </div> -->
                </div>
                <!-- Login form Input Email; Input Password -->
                {{ Form::open(['route' =>['login'],'class'=>'m-lg-5']) }}
                <h4 class="login-box-msg text-dark">@yield('title')</h4>
                <div class="input-group mb-3">
                    {{ Form::label('email', 'Emel',['class'=>'sr-only']) }}
                    {{ Form::text('email',null,['placeholder'=>'Emel', 'required' => 'required', 'class' => 'form-control '.Html::isInvalid($errors,'email')]) }}
                    <!-- <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div> -->
                    {!! Html::hasError($errors,'email') !!}
                </div>
                <div class="input-group mb-3">
                    {{ Form::label('password', 'Katalaluan',['class'=>'sr-only']) }}
                    {{ Form::password('password', ['placeholder'=>'Katalaluan', 'required' => 'required', 'class' => 'form-control '.Html::isInvalid($errors,'email')]) }}
                    <div class="input-group-append" style="background-color: transparent !important;">
                        <div class="input-group-text" style="background-color: transparent !important;">
                            <span><i id="toggle-password-visibility" class="fas fa-eye" style="cursor: pointer;"></i> </span>
                        </div>
                    </div>
                    <!-- <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div> -->
                    {!! Html::hasError($errors,'email') !!}
                </div>
                <div class="row">
                    <div class="col-12">
                        {{ Form::submit('Log Masuk', ['class'=>'btn bg-olive btn-block btn-flat','type'=>'submit']) }}
                    </div>
                    <!-- /.col -->
                </div>
                {{ Form::close() }}
                <!--hold-->
                @if(config('mail.enabled'))
                <p class="my-1 text-center">
                    {!! Form::button('Lupa Kata Laluan', ['onclick'=>"window.location='".route('password.request')."'",'class'=>'btn btn-link btn-sm']) !!}
                </p>
                @endif
                <p class="my-1 text-center">
                    <a href="{{ route('register') }}" class="btn btn-link btn-sm">Belum ada akaun? Daftar Akaun</a>
                </p>
                <p class="my-1 text-center">
                    <a href="{{ route('welcome') }}" class="btn btn-link btn-sm">Halaman Utama</a>
                </p>
            
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility when the eye icon is clicked
        document.getElementById('toggle-password-visibility').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this;

            // Toggle password field type
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
@endsection
