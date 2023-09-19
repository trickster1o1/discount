@extends('layouts.auth')

@section('title') Reset Password @endsection

@section('content')
{{-- <div class="brand-logo">
    <img src="{{ asset('assets/images') }}">
</div> --}}
<h4>Reset Password</h4>
<form class="pt-3" action="{{ route('password.update') }}" method="post">
    {!! session('status') !!}
    <div class="form-group">
        <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
            id="email" placeholder="Email" value="{{ $email }}">
        @error('email') <span class="invalid-feedback"> {{ $message }} </span> @enderror
    </div>
    <div class="form-group">
        <input type="password" name="password"
            class="form-control form-control-lg @error('password') is-invalid @enderror" id="password"
            placeholder="New Password">
        @error('password') <span class="invalid-feedback"> {{ $message }} </span> @enderror
    </div>
    <div class="form-group">
        <input type="password" name="password_confirmation"
            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
            id="password_confirmation" placeholder="Confirm Password">
        @error('password_confirmation') <span class="invalid-feedback"> {{ $message }} </span> @enderror
    </div>
    <div class="mt-3">
        @csrf
        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">RESET</button>
    </div>
    <div class="mt-3 mb-2 d-flex justify-content-between align-items-center">
        <input type="hidden" name="token" value="{{ $token }}">
        <a href="{{ route('login') }}" class="auth-link text-black">Go Back to Login</a>
    </div>
</form>
@endsection
