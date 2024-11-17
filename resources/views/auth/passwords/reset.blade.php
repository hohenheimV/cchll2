@extends('layouts.pengurusan.auth')

@section('title', 'Set Semula Kata Laluan')

@section('content')
<div class="row">
    <div class="col-lg-5 col-md-4 col-12 d-none d-lg-block rounded-left bg-gradient-olive p-5" style="min-height: 380px">
        <div class="login-logo h-100 d-flex flex-column justify-content-center align-items-center">
            <img height="96" src="{{ asset('img/logo-jln.png') }}" />
            <div><span class="font-weight-bold text-light">{{config('app.name_short')}}</span> {{config('app.agency_short')}}</div>
        </div>
    </div>
    <div class="col-lg-7 col-12 rounded-right bg-white">
        <div class="card-body" style="width: 400px !important">

            <h4 class="login-box-msg text-dark">@yield('title')</h4>

            <form method="POST" action="{{ route('password.update') }}" class="w-75">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Emel') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Kata Laluan Baru') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Pengesahan Kata Laluan Baru') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Hantar') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
