@extends('layouts.app')

@section('title')
    Site Menus
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Site Menu </h3>

        @authorized('SITEMENU', 'CREATE')
        <a href="{{ route('site_menus.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
        @endauthorized
    </div>

    @if (session('status'))
    @endif

    @if (session('status'))
        <div class="px-3">{!! session('status') !!}</div>
    @endif

    <div class="row">
        <div class="col-12 grid-margin stretch-card table-responsive">
            <table class="table bg-white">
                <thead class="thead bg-primary text-white font-weight-bold">
                    <tr>
                        <th scope="col">@sortablelink('title', 'Title')</th>
                        <th scope="col">Location</th>
                        <th scope="col" style="text-align: end;">Actions</th>
                    </tr>
                </thead>
                @if ($site_menus->count() > 0)
                    <tbody>
                        @foreach ($site_menus as $site_menu)
                            <tr>
                                @if ($site_menu->parent == 0)
                                    <th>{{ $site_menu->title }}</th>
                                    <td>{{$site_menu->location}}</td>
                                    <td class="text-right">
                                        @authorized('SITEMENU', 'UPDATE')
                                        <a href="{{ route('site_menus.edit', $site_menu) }}"
                                            class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></a>
                                        @endauthorized

                                        @authorized('SITEMENU', 'DESTROY')
                                        <form class="d-inline swal-delete"
                                            action="{{ route('site_menus.destroy', $site_menu) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @endauthorized
                                    </td>
                                @endif
                            </tr>

                            {{-- Sub Menu --}}
                            @foreach ($site_menus as $subMenu)
                                @if ($subMenu->parent == $site_menu->id)
                                    <tr>
                                        <td> <span class="ml-md-4">- {{ $subMenu->title }}<span> </td>
                                        <td>{{$subMenu->location}}</td>
                                        <td class="text-right">
                                            @authorized('SITEMENU', 'UPDATE')
                                            <a href="{{ route('site_menus.edit', $subMenu) }}"
                                                class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></a>
                                            @endauthorized

                                            @authorized('SITEMENU', 'DESTROY')
                                            <form class="d-inline swal-delete"
                                                action="{{ route('site_menus.destroy', $subMenu) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </form>
                                            @endauthorized
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="5" style="text-align: center">No Data Available</td>
                        </tr>
                    </tbody>
            </table>
            @endif
            </table>
        </div>
        <div class="col-12 grid-margin stretch-card">
            {!! $site_menus->appends(\Request::except('page'))->render() !!}
        </div>


    </div>
@endsection
