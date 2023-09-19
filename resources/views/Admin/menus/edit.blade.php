@extends('layouts.app')

@section('title')
    Add Menu
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Menu </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('menus.index') }}">Menus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Menu</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample row" action="{{ route('menus.update', $menu) }}" method="POST">
                        <div class="form-group col-md-6">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Name" value="{{ old('name') ?? $menu->name }}">
                            @error('name')
                                <span class=" invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="route">Route</label>
                            <input type="text" class="form-control @error('route') is-invalid @enderror" id="route"
                                name="route" placeholder="Route" value="{{ old('route') ?? $menu->route }}">
                            @error('route')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="parent">Parent</label>
                            <select class="form-control @error('parent') is-invalid @enderror" id="parent" name="parent">
                                <option value="0" @if ($menu->parent == 0) selected @endif>Self</option>
                                @foreach (parent_menus() as $parent_menu)
                                    <option value="{{ $parent_menu->id }}"
                                        @if ($menu->parent == $parent_menu->id) selected @endif>
                                        {{ $parent_menu->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="menu_code">Menu Code</label>
                            <input type="text" class="form-control @error('menu_code') is-invalid @enderror" id="menu_code"
                                name="menu_code" placeholder="Menu Code"
                                value="{{ old('menu_code') ?? $menu->menu_code }}">
                            @error('menu_code')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="position">Position</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position"
                                name="position" placeholder="Position" value="{{ old('position') ?? $menu->position }}">
                            @error('position')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="icon_class">Icon Class</label>
                            <input type="text" class="form-control @error('icon_class') is-invalid @enderror"
                                id="icon_class" name="icon_class" placeholder="Icon Class"
                                value="{{ old('icon_class') ?? $menu->icon_class }}">
                            @error('icon_class')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="is_module">Is Module</label>
                            <select class="form-control @error('is_module') is-invalid @enderror" id="is_module"
                                name="is_module">
                                <option value="yes" @if (old('is_module', $menu->is_module) == 'yes') selected @endif>Yes</option>
                                <option value="no" @if (old('is_module', $menu->is_module) == 'no') selected @endif>No</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" @if ($menu->status == 'active') selected @endif>Active</option>
                                <option value="inactive" @if ($menu->status == 'inactive') selected @endif>Inactive</option>
                               
                            </select>
                            @error('status')
                                <span class="invalid-feedback"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a href="{{ route('menus.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
