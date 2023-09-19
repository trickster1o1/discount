@extends('layouts.auth')

@section('title') Login @endsection

@section('content')
{{-- <div class="brand-logo">
    <img src="{{ asset('assets/images') }}">
</div> --}}
<h4>Hello! Welcome Back</h4>
<h6 class="font-weight-light">Sign in to continue.</h6>
<form class="pt-3" method="post">
    {!! session('status') !!}
    <div class="form-group">
        <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" id="username"
            placeholder="Username" name="username">
        @error('username') <span class="invalid-feedback"> {{ $message }} </span> @enderror
    </div>
    <div class="form-group">
        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
            id="password" placeholder="Password" name="password">
        @error('password') <span class="invalid-feedback"> {{ $message }} </span> @enderror
    </div>
    <div class="mt-3">
        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
    </div>
    <div class="my-2 d-flex justify-content-between align-items-center">
        @csrf
        <div class="form-check">
            <label class="form-check-label text-muted">
                <input type="checkbox" class="form-check-input"> Keep me signed in </label>
        </div>
        <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot password?</a>
    </div>
</form>
@endsection
