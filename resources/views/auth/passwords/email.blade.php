@extends('layouts.pengurusan.auth')

@section('title', 'Lupa Kata Laluan')

@section('content')
<div class="row">
    <!-- <div class="col-lg-5 col-md-4 col-12 d-none d-lg-block rounded-left bg-gradient-olive p-5" style="min-height: 380px">
        <div class="login-logo h-100 d-flex flex-column justify-content-center align-items-center">
            <img height="96" src="{{ asset('img/logo-jln.png') }}" />
            <div><span class="font-weight-bold text-light">{{config('app.name_short')}}</span> {{config('app.agency_short')}}</div>
        </div>
    </div> -->
    <div class="col-lg-12 col-12 rounded-right bg-white">
        <div class="card-body h-100 d-flex flex-column justify-content-center align-items-center"  style="width: 400px !important">

            <h4 class="login-box-msg text-dark">@yield('title')</h4>

            {{--@if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif--}}
            @if (session('status') == 'passwords.sent')
                <div class="alert alert-success" role="alert">
                    Kami telah menghantar pautan untuk menetapkan semula kata laluan anda!
                </div>
            @elseif (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="text-center w-75">
                @csrf
                <div class="form-group">
                    <label for="email">E-mel Berdaftar</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Hantar') }}
                    </button>
                </div>
            </form>
            <p class="my-3 text-center">
                {!! Form::button('Log Masuk', ['onclick'=>"window.location='".route('login')."'",'class'=>'btn btn-link btn-sm']) !!}
            </p>
        </div>

    </div>

</div>
@endsection
