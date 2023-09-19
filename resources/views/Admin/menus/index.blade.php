@extends('layouts.app')

@section('title')
    Menus
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Menus </h3>

        @if (authorize($menucode, 'CREATE', false))
            <a href="{{ route('menus.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
        @endif
    </div>

    @if (session('status'))
    @endif

    @if (session('status'))
        <div class="px-3">{!! session('status') !!}</div>
    @endif

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            @if ($menus->count() > 0)
                <table class="table bg-white mx-3">
                    <thead class="thead bg-primary text-white font-weight-bold">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Code</th>
                            <th scope="col" width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            @if ($menu->parent == 0)
                                <tr>
                                    <th>{{ $menu->name }}</th>
                                    <td>{{ $menu->menu_code }}</td>
                                    <td class="text-right">
                                        @if ($menu->is_module == 'yes')
                                            @authorized('MENU', 'SHOW')
                                            <a href="{{ route('menus.show', $menu) }}" class="btn btn-primary btn-sm"
                                                title="Assign Permission"><i class="fa fa-key"></i></a>
                                            @endauthorized('PERMISSION', 'UPDATE')
                                        @endif
                                        @authorized('MENU', 'UPDATE')
                                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-secondary btn-sm"
                                            title="edit"><i class="fa fa-edit"></i></a>
                                        @endauthorized

                                        @authorized('MENU', 'DESTROY')
                                        <form class="d-inline swal-delete" action="{{ route('menus.destroy', $menu) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        @endauthorized
                                    </td>
                                </tr>
                            @endif

                            {{-- Sub Menu --}}
                            @foreach ($menu->subMenus->where('status','!=','deleted')->sortBy('position') as $subMenu)
                                <tr>
                                    <td> <span class="ml-md-4">- {{ $subMenu->name }}<span> </td>
                                    <td>{{ $subMenu->menu_code }}</td>
                                    <td class="text-right">
                                        @authorized('MENU', 'SHOW')
                                        <a href="{{ route('menus.show', $subMenu) }}" class="btn btn-primary btn-sm"
                                            title="Assign Permission"><i class="fa fa-key"></i></a>
                                        @endauthorized

                                        @authorized('MENU', 'UPDATE')
                                        <a href="{{ route('menus.edit', $subMenu) }}" class="btn btn-secondary btn-sm"
                                            title="Edit"><i class="fa fa-edit"></i></a>
                                        @endauthorized

                                        @authorized('MENU', 'DESTROY')
                                        <form class="d-inline swal-delete" action="{{ route('menus.destroy', $subMenu) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                        @endauthorized
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
@endsection
