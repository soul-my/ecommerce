@extends('layouts.admin.master')

@section('content')

<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">{{env('STORE_NAME')}}</a>
        <small>build : {{env('APP_BUILD')}} | version : {{env('APP_VERSION')}}</small>
    </div>
    <div class="card">
        <div class="body">
                <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="msg">Sign in to start your session</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" id="remember" class="filled-in chk-col-pink" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                    </div>
                </div>
                {{-- <div class="row m-t-15 m-b--20">

                    <div class="col-xs-12 align-right">
                        <a href="forgot-password.html">Forgot Password?</a>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <script>
        $(function(){
            $("body").addClass('login-page');
        });
    </script>
@endsection