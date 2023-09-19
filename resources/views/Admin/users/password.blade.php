@extends('layouts.app')

@section('title') Edit User @endsection

@section('content')
<div class="page-header">
    <h3 class="page-title"> Update Password </h3>
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
                <form class="forms-sample row" action="{{ route('users.pupd', $user) }}" method="POST">
                    @include('inputs.text', [$data=['oldPwd', 'Old Password', 'Enter Old Password','password'], $md='12'])
                    @include('inputs.text', [$data=['password', 'Password', 'Enter New Password','password'], $md='6'])
                    @include('inputs.text', [$data=['repwd', 'Confirm Password', 'Re-Enter Password','password'], $md='6'])
                    <span id="error" class="col-md-12 text-danger d-none" align='center'>Passwords doesn't match.</span>
                    <input type="hidden" name="table" value="users">
                   
                    <div class="col-md-12">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary mr-2" id="sub" disabled>Submit</button>
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
        function checkMatch() {
            if($('#password').val() !== $('#repwd').val()) {
                $('#error').removeClass('d-none');
                $('#sub').attr('disabled','true');
                
            } else {
                $('#error').addClass('d-none');
                $('#sub').removeAttr('disabled');

            }
        }

        $('#password').on('keyup', checkMatch);
        $('#repwd').on('keyup', checkMatch);
    </script>
@endsection