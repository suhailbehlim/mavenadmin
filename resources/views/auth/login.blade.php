<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  @isset($title)
  <title>Maven | {{ $title }} Log In</title>
  @endisset
  <title>Maven | Log In</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    @isset($title)

    <a href="{{ route("login.$url") }}">
        <center><img src="{{ asset('/public/dist/img/maven.png') }}"> </a></center>  </a>    
    
    @else


    <a href="{{ route("login") }}"><b>Maven</b>  </a>

    @endisset
   

  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>    
          <strong>{{ $message }}</strong>
      </div>
      @endif
        
      @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>    
          <strong>{{ $message }}</strong>
      </div>
      @endif     


      <p class="login-box-msg">Sign in to start your session</p>

      @isset($url)
        <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
        @else
        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
        @endisset
        @csrf


        <div class="input-group mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="row">
          {{-- <div class="col-8">
            <div class="icheck-primary">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">Remember Me</label>
            </div>
          </div> --}}
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" style="background: #5fb858;border: #5fb858;">Sign In</button>
          </div>







          <!-- /.col -->
        </div>
      </form>
      @isset($url)

      @else

      <!--<div class="social-auth-links text-center mb-3">-->
      <!--  <p>- OR -</p>-->
      <!--  <a href="{{ route('login.facebook') }}" class="btn btn-block btn-primary">-->
      <!--    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook-->
      <!--  </a>-->
      <!--  <a href="{{ route('login.google') }}" class="btn btn-block btn-danger">-->
      <!--    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+-->
      <!--  </a>-->
      <!--</div>-->

      @endisset


      <p class="mb-1">



        @if (Route::has('password.request'))

        @isset($url)

        <a href="{{ route('admin.forgetPassword') }}">
            {{ __('Forgot Your Password?') }}
        </a>

        @else
            <a  href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endisset                                    

        @endif
        

      </p>
      @isset($url)

      @else
      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
      </p>
      @endisset
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/dist/js/adminlte.min.js') }}"></script>

</body>
</html>







<?php /* ?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($url) ? ucwords($url) : ""}} {{ __('Login') }}</div>

                <div class="card-body">

                    @isset($url)
                        <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                    @else
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @endisset


                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))

                                @isset($url)

                                <a class="btn btn-link" href="{{ route('admin.forgetPassword') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>

                                @else
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endisset                                    

                                @endif
                                
                                <br>
                                <a href="{{ route('login.google') }}" class="btn btn-success">Login with Google</a> <br>
                                <a href="{{ route('login.facebook') }}" class="btn btn-success">Login with Facebook</a>
                        
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 */ ?>