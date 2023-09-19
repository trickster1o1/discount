@extends('layouts.app')

@section('title') Assign Permission to {{ $role->name }} @endsection

@section('content')
<form action="{{ route('roles.assign', $role) }}" method="POST">
    <div class="page-header">
        <h3 class="page-title"> Assign Permission to {{ $role->name }} </h3>
        <div>
            @csrf
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>

    @if(session('status'))
    <div class="px-3">{!! session('status') !!}</div>
    @endif

    @if($errors->any())
    <div class="px-3">{!! alert('An Error Occurred!', 'danger') !!}</div>
    @endif

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            @if($menus->count() > 0)
            <table class="table bg-white mx-3">
                <thead class="thead bg-primary text-white font-weight-bold">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Permission</th>
                        <th scope="col" width="5%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($menus as $menu)
                    <tr>
                        @if($menu->parent == 0)
                        @php
                            $assigned_permission = check_permission($menu->id,1,$role_id);
                            $checked_id = $menu->id.'_1';
                        @endphp
                        <th>{{ $menu->name }}</th>
                        @if($menu->is_module == 'yes')
                        <td>
                            <div class="d-flex">
                                @foreach ($menu->permissions as $permission)
                                <div class="form-group mb-0">
                                    <label class="mr-1" for="{{ $menu->id . '-' . $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                    <input class="form-select mr-2" type="checkbox"
                                        name="permissions[{{ $menu->id }}][]" value="{{ $permission->id }}"
                                        id="{{ $menu->id . '-' . $permission->id }}" @foreach($role->menuPermissionRoles
                                    as $menuPermissionRole)
                                    @if($menuPermissionRole->menu_id == $menu->id &&
                                    $menuPermissionRole->permission_id == $permission->id)
                                    checked
                                    @endif
                                    @endforeach>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        @else
                        <td>
                           <div class="d-flex">
                                <div class="form-group mb-0">
                                    <label class="mr-1" for="menu_{{$checked_id}}">
                                        Access
                                    </label>
                                    <input class="form-select mr-2" type="checkbox"
                                        name="permissions[{{ $menu->id }}][]" value="1"
                                        id="menu_{{$checked_id}}" {{($assigned_permission)?'checked':''}}>
                                </div>
                            </div>
                           </div> 
                        </td>
                        @endif
                        <td class="text-right">
                            <a href="#">All</a>
                            <span>|</span>
                            <a href="#">None</a>
                        </td>
                        @endif
                    </tr>

                    {{-- Sub Menu --}}
                    @foreach ($menu->subMenus->sortBy('position') as $subMenu)
                    <tr>
                        <td> <span class="ml-md-4">- {{ $subMenu->name }}<span> </td>
                        <td>
                            <div class="d-flex">
                                @foreach ($subMenu->permissions as $permission)
                                <div class="form-group mb-0">
                                    <label class="mr-1" for="{{ $subMenu->id . '-' . $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                    <input class="form-select mr-2" type="checkbox"
                                        name="permissions[{{ $subMenu->id }}][]" value="{{ $permission->id }}"
                                        id="{{ $subMenu->id . '-' . $permission->id }}"
                                        @foreach($role->menuPermissionRoles as $menuPermissionRole)
                                    @if($menuPermissionRole->menu_id == $subMenu->id &&
                                    $menuPermissionRole->permission_id == $permission->id)
                                    checked
                                    @endif
                                    @endforeach
                                    >
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-right">
                            <a href="#">All</a>
                            <span>|</span>
                            <a href="#">None</a>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="col-12">
                <h4 class="page-title text-center">No Menus Yet</h4>
                <br>
                <div class="text-center">
                    <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm ml-auto">Add New Menu</a>
                </div>
            </div>
            @endif

        </div>
    </div>
</form>
@endsection
