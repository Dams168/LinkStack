@extends('layouts.auth')

@section('content')

@include('components.auth-hero')

<form method="POST" action="{{ route('register') }}" class="auth-form">
  @csrf
  @if ($errors->any())
  <div class="form-error">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
  </div>
  @endif
  <div class="form-header">
    <h3 class="form-title">Create Your Account</h3>
    <p class="form-desc">Join thousands of users and get your bio link ready in seconds.</p>
  </div>

  <div class="form-group-col">
    <label class="form-label" for="name">Display Name</label>
    <input class="form-control" type="text" name="name" id="name" placeholder="Fill your name" aria-describedby="name"
      :value="old('name')" required autofocus>
  </div>

  <div class="form-group-col">
    <label class="form-label" for="littlelink_name">Page Url</label>
    <div class="input-group">
      <span class="input-group-text">{{str_replace(['http://', 'https://'], '', url(''))}}/@</span>
      <input class="input-group-field form-control" type="text" name="littlelink_name" id="littlelink_name"
        placeholder="Create a unique name" aria-describedby="littlelink_name" :value="old('littlelink_name')" required
        autofocus>
    </div>
  </div>

  @include('auth.url-validation')

  <div class="form-group-col">
    <label class="form-label" for="email">Email</label>
    <input class="form-control" type="email" name="email" id="email" placeholder="name@gmail.com" required
      aria-describedby="email" :value="old('email')" required autofocus>
  </div>

  <div class="form-group-col">
    <label class="form-label" for="password ">Password</label>
    <input class="form-control" type="password" name="password" id="password" placeholder="Create a strong password"
      aria-describedby="password" name="password" required autocomplete="new-password" required>
    <p class="form-info"><i class="bi bi-info-circle-fill"></i> <span>Use at leat 8
        characters.</span></p>
  </div>

  <div class="form-action">
    <div class="form-group-row">
      <input type="checkbox" name="remember" id="remember_me" class="form-control">
      <label class="form-label" for="remember_me">Remember Me</label>
    </div>
  </div>

  <button class="btn btn-primary btn-lg" type="submit">Signup</button>

  <div class="form-footer">
    <p class="form-cto-label">Already have an account</p>
    <a class="form-cto-link" href="{{ route('login') }}">Log In</a>
  </div>

  <!-- Session Status -->
  <x-auth-session-status :status="session('status')" />

  <!-- Validation Errors -->
  <x-auth-validation-errors :errors="$errors" />
</form>
@endsection