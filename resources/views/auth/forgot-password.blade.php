@extends('layouts.auth')

@section('title') Forgot Password @endsection

@section('content')
{{-- <div class="brand-logo">
    <img src="{{ asset('assets/images') }}">
</div> --}}
<h4>Forgot Your Password ?</h4>
<form class="pt-3" method="post">
    {!! session('status') !!}
    <div class="form-group">
        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
            placeholder="email@domain.com" name="email">
        @error('email') <span class="invalid-feedback"> {{ $message }} </span> @enderror
    </div>
    <div class="mt-3">
        @csrf
        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SEND</button>
    </div>
    <div class="mt-3 mb-2 d-flex justify-content-between align-items-center">
        <a href="{{ route('login') }}" class="auth-link text-black">Go Back to Login</a>
    </div>
</form>
@endsection
