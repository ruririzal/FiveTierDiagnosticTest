@extends('layouts.app')

@section('content')
    <div class="login-logo">
        <b>{{ trans('panel.site_title') }}</b>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('global.login') }}</p>

            @if (session('message'))
                <div class="alert alert-info" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <passport-personal-access-tokens></passport-personal-access-tokens>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" name="email" type="text"
                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email"
                        autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input id="password" name="password" type="password"
                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required
                        placeholder="{{ trans('global.login_password') }}" autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ trans('global.login') }}</button>
                    </div>
                </div>
            </form>

            {{-- <div class="social-login-links text-center mb-3">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div> --}}
            @if (Route::has('password.request'))
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">{{ trans('global.forgot_password') }}</a>
                </p>
            @endif
            <p class="mb-0">
                <a href="{{ route('register') }}" class="text-center">{{ trans('global.register') }}</a>
            </p>
        </div>
    </div>
@endsection
