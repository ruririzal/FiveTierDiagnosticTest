@extends('layouts.app')

@section('content')
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>{{ trans('panel.site_title') }}</b></a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('global.reset_password') }}</p>

            @if (session('message'))
                <div class="alert alert-info" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

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
                        placeholder="{{ trans('global.login_password') }}" autocomplete="new-password">
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
                <div class="input-group mb-3">
                    <input id="password-confirm" name="password_confirmation" type="password"
                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required
                        placeholder="{{ trans('global.confirm_password') }}" autocomplete="new-password">
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
                    <div class="col-12">
                        <button type="submit"
                            class="btn btn-primary btn-block">{{ trans('global.reset_password') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
