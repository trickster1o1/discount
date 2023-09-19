@extends('layouts.app')

@section('title')
    Assign Menu
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Assign Permissions for {{ $menu->name }} </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('menus.index') }}">Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Assign Menu</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample row" action="{{ route('menus.assign', $menu) }}" method="POST">
                        <div class="form-group col-md-12">
                            <label for="permissions">Permissions</label>
                            <select class="form-control select2 @error('permissions') is-invalid @enderror" id="permissions"
                                name="permissions[]" multiple>
                                @foreach (permissions() as $permission)
                                    <option value="{{ $permission->id }}"
                                        @if ($menu->permissions->contains($permission->id)) selected @endif>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permissions')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('menus.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
