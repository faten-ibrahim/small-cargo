@extends('layouts.app')

@section('content')

<div class="container">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Car</b>GO</a>
        </div>
        <div class="card">
            <div class="card-header">{{ __('Login') }}</div>

            <div class="card-body">
                <!-- /.login-logo -->
                <div class="login-box-body">
                    <p class="login-box-msg">Sign in to start your session</p>


                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group has-feedback">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            @error('email')
                            <span class="invalid-feedback">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group has-feedback">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                            @error('password')
                            <span class="invalid-feedback">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="checkbox icheck" style="margin-left: 10px;" >
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

                            </div>
                            <!-- /.col -->
                        </div>
                    </form>



                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

                </div>
                <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->

        </div>
    </div>
</div>
@endsection
