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
                <form class="forms-sample row" action="{{ route('users.update', $user) }}" method="POST">
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

                    <div class="form-group col-md-12 d-flex">
                        <label for="changePassword">Change Password</label>
                        <input type="checkbox" class="ml-2 @error('changePassword') is-invalid @enderror"
                            id="changePassword" name="changePassword" placeholder="changePassword" @error('password')
                            checked @enderror>
                        @error('changePassword') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6" id="divPassword">
                        <label for="password">New Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                        @error('password') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6" id="divConfirmPassword">
                        <label for="password_confirmation">Confirm Password *</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                            value="{{ old('password_confirmation') }}">
                        @error('password_confirmation')
                        <span class=" invalid-feedback"> {{ $message }} </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="role_id">Role *</label>
                        <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                            <option value="">Select Role</option>
                            @foreach (roles() as $role)
                            <option value="{{ $role->id }}" @if($user->role_id==$role->id) selected @endif>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" @if( old('status',$user->status)=='active' ) selected @endif>Active</option>
                            <option value="inactive" @if( old('status',$user->status)=='inactive' ) selected @endif>Inactive</option>
                        </select>
                        @error('status') <span class="invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

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

@section('script')
<script>
    function togglePassword(){
        if($('#changePassword').prop('checked')){
            $('#divPassword').removeClass('d-none');
            $('#divConfirmPassword').removeClass('d-none');
        } else {
            $('#divPassword').addClass('d-none');
            $('#divConfirmPassword').addClass('d-none');
        }
    }
    togglePassword();
    $('#changePassword').on('click', function(){
        togglePassword();
    });
</script>
@endsection
