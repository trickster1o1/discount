@extends('layouts.app')

@section('title') Edit User @endsection

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Users </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample row" action="{{ route('users.profile', $user) }}" method="POST">
                    <div class="form-group col-md-6">
                        <label for="name">Fullname *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Name" value="{{ old('name',$user->name) }}">
                        @error('name') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email Address" value="{{ old('email',$user->email) }}">
                        @error('email') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone *</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" placeholder="Phone Number" value="{{ old('phone',$user->phone)  }}">
                        @error('phone') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Username *</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" placeholder="Username" value="{{ old('username',$user->username) }}">
                        @error('username') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="role_id">Role</label>
                        <span id='role_id' class="form-control">{{$user->getRole()->role_code}}</span>    
                    </div>
                    <input type="hidden" name="table" value="users">
                   
                    <div class="col-md-12">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
