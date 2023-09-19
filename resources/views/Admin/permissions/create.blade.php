@extends('layouts.app')

@section('title') Add Permissions @endsection

@section('content')
<div class="page-header">
    <h3 class="page-title"> Add Permission </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample row" action="{{ route('permissions.store') }}" method="POST">
                    <div class="form-group col-md-6">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Name" value="{{ old('name') }}">
                        @error('name') <span class=" invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="permission_code">Permission Code *</label>
                        <input type="text" class="form-control @error('permission_code') is-invalid @enderror"
                            id="permission_code" name="permission_code" placeholder="Permission Code"
                            value="{{ old('permission_code') }}">
                        @error('permission_code') <span class="invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" @if( old('status')=='active' ) selected @endif>Active</option>
                            <option value="inactive" @if( old('status')=='inactive' ) selected @endif>Inactive</option>
                        </select>
                        @error('status') <span class="invalid-feedback"> {{ $message }} </span> @enderror
                    </div>

                    <div class="col-md-12">
                        @csrf
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
