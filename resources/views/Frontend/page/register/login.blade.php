@extends('Frontend.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/admin.css') }}">
@endsection
@section('body')
    <div class="login-page"
        style="background-image: url(/{{ 'uploads/defaults/bg.jpg' }}); @if (isset($_GET['user'])) height:170vh; @else padding-top:9em; @endif ">
        <div class="login-from-wrap">
            <form class="login-from"
                action="{{ route('customer.access', isset($_GET['user']) ? 'fun=register' : 'fun=login') }}" method="POST">
                @csrf
                <h1 class="site-title">
                    <a href="#">
                        <img src="/{{ $siteSetting->primary_logo }}" alt="">
                    </a>
                </h1>
                @if (isset($_GET['user']))
                    <div class="form-group">
                        <label for="full_name">Full Name*</label>
                        <input type="text" class="validate  @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback"> {{ $message }} </span>
                        @enderror
                    </div>
                @endif
                <div class="form-group">
                    <label for="first_name1">Username*</label>
                    <input type="text" class="validate  @error('username') is-invalid @enderror" name="username"
                        value="{{ old('username') }}">
                    <small class="text-danger">{{ Session::has('ers') ? Session::get('ers')['unmE'] : null }}</small>
                    @error('username')
                        <span class="invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
                @if (isset($_GET['user']))
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" class="validate  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                        <small class="text-danger">{{ Session::has('ers') ? Session::get('ers')['emailE'] : null }}</small>
                        @error('email')
                            <span class="invalid-feedback"> {{ $message }} </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number*</label>
                        <input type="text" class="validate  @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <span class="invalid-feedback"> {{ $message }} </span>
                        @enderror
                    </div>
                @endif
                <div class="form-group">
                    <label for="password">Password*</label>
                    <input id="password" type="password" name="password" class="validate  @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
                @if (isset($_GET['user']))
                    <div class="form-group">
                        <label for="confirm">Confirm Password</label>
                        <input id="confirm" type="password" name="cpwd" class="validate">
                        <small class="text-danger">{{ Session::has('ers') ? Session::get('ers')['cpwd'] : null }}</small>

                    </div>
                @endif
                <div class="form-group">
                    <button class="button-primary w-100"
                        type="submit">{{ isset($_GET['user']) ? 'Register' : 'Login' }}</a>
                </div>
                @if (Session::get('msg'))
                    <small>{{ Session::get('msg') }}</small><br>
                @endif
                @if (isset($_GET['user']))
                    <a href="/login">Already have an account? Login.</a>
                @else
                    <a href="/login?user=0">Dont have an account? Register.</a>
                @endif
                <a href="#" class="for-pass">Forgot Password?</a>
            </form>
        </div>
    </div>
    {{-- <h1>login</h1>
    <form action="{{Route('customer.access')}}" method="POST">
        @csrf
        <input type="text" placeholder="Username" name="username" value="{{old('username')}}">
        <input type="password" placeholder="Password" name="password">
        <button>Submit</button>
        
    </form> --}}
@endsection
