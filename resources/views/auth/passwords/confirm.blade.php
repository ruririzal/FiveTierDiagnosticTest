@extends('layouts.app')

@section('content')
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>{{ trans('panel.site_title') }}</b></a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('global.confirm_password') }}</p>
            {{ __('Please confirm your password before continuing.') }}

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
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
                    <div class="col-4 offset-4">
                        <button type="submit"
                            class="btn btn-primary btn-block">{{ trans('global.confirm_password') }}</button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
