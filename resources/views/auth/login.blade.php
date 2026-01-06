@extends('layouts.auth')

@section('content')

@include('components.auth-hero')

<form method="POST" action="{{ route('login') }}" class="auth-form">
  @csrf
  <div class="form-header">
    <h3 class="form-title">Welcome Back!</h3>
    <p class="form-desc">Enter your email and password to manage your links.</p>
  </div>

  <div class="form-group-col">
    <label class="form-label" for="email">Email</label>
    <input class="form-control" type="email" name="email" id="email" aria-describedby="email" :value="old('email')"
      placeholder="name@gmail.com" required autofocus>
  </div>

  <div class="form-group-col">
    <label class="form-label" for="password ">Password</label>
    <input class="form-control" type="password" name="password" id="password" aria-describedby="password"
      placeholder="Enter your password" required autocomplete="current-password">
  </div>

  <div class="form-action">
    <div class="form-group-row">
      <input type="checkbox" name="remember" id="remember_me" class="form-control">
      <label class="form-label" for="remember_me">Remember Me</label>
    </div>

    <a href="{{ route('password.request') }}" class="text-red-500">Forgot Password?</a>
  </div>
  <button class="btn btn-primary btn-lg" type="submit">Login</button>

  <div class="form-footer">
    <p class="form-cto-label">Don't have an account yet?</p>
    <a class="form-cto-link" href="{{ route('register') }}">Sign Up</a>
  </div>

  <!-- Session Status -->
  <x-auth-session-status :status="session('status')" />

  <!-- Validation Errors -->
  <x-auth-validation-errors :errors="$errors" />
</form>

@endsection