<!DOCTYPE html>
<html lang="en">
<head>
<!-- Design by kaaka-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Login</title>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
 <link rel="shortcut icon" href="{{asset('assets/pngegg.png')}}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{asset('assets/pngegg.png')}}">
  <link rel="icon" href="{{asset('assets/pngegg.png')}}" type="image/png" sizes="206x16">
  
<!--Stylesheet-->
<link rel="stylesheet" href="{{asset('assets/assets/login/login.css')}}"> 
</head>
<body>
<div class="background">
<div class="shape"></div>
<div class="shape"></div>
</div>
<form method="POST" action="{{ route('login') }}">
@csrf
	@include('layouts.temp.partials.alerts')

<h3>Login Here</h3>
<div class="row mb-3">
<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
<div class="col-md-6">
<input id="email" type="email" class="form-control @error('email') is-invalid @enderror masuk" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
@error('email')
<span class="invalid-feedback sss" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="row mb-3">
<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
<div class="col-md-6">
<input id="password" type="password" class="masuk form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
@error('password')
<span class="invalid-feedback sss" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
</div>
<div class="row mb-3">
<div class="col-md-6 offset-md-4">
<div class="form-check">
<input class="cek" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
<label class="form-check-label labs" for="remember">
{{ __('Remember Me') }}
</label>
</div>
</div>
</div>
<div class="row mb-0">
<button type="submit" class="btn btn-primary">
{{ __('Login') }}
</button>

@if (Route::has('password.request'))
<a class="btn" href="{{ route('password.request') }}">
{{ __('Forgot Your Password? ') }}
</a>
@endif
<a class="btn" href="{{ url('/') }}">
{{ __(' Beranda') }}
</a> 
</div>
</form>
</body>
</html>