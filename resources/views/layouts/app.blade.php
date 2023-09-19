<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Deft Tree">
    <meta name="keywords" content="Project Management System, Project Management, PMS">
    <meta name="_token" content="{{ csrf_token() }}">
    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>Admin Pannel</title>
    @endif

    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/timepicker/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables/datatables.min.css') }}" />
    <link rel="icon" type="image/ico" href="{{ asset('Frontend/assets/logo/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('css')
    <style type="text/css">
        .sidebar .nav.sub-menu .nav-item.sub-active .nav-link {
            color: #fff;
        }

        .sidebar .nav.sub-menu .nav-item.sub-active .nav-link:before {
            color: #fff;
        }
    </style>
    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/toaster/toastr.min.css') }}" />
    <script src="{{ asset('assets/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toaster/toastr.min.js') }}"></script>
</head>

<body>
    <input type="hidden" id="base_url" value="{{ url('') }}">
    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div
                class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center border-bottom">
                <a href="{{ url('/admin') }}" class="navbar-brand brand-logo text-white">Admin Pannel</a>
                <a href="{{ url('/admin') }}" class="navbar-brand brand-logo-mini text-white">P</a>
            </div>

            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                {!! session('script') !!}
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="{{auth()->user()->pic ? (str_starts_with(auth()->user()->pic,'http') ? auth()->user()->pic : '/'.auth()->user()->pic) : asset('assets/images/avatar.png') }}" alt="image" style="width:100%;height:100%;object-fit:cover;">
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">{{ auth()->user()->name }}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm"
                            aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                            <div class="p-2">
                                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                                    href={{ '/admin/users/' . Auth()->user()->id . '/profile/edit' }}>
                                    <span>Profile</span>
                                    <i class="fa fa-user"></i>
                                </a>
                                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                                    href={{ route('users.pwd', auth()->user()->id) }}>
                                    <span>Change Password</span>
                                    <i class="mdi mdi-lock ml-1"></i>
                                </a>
                                <form class="d-inline" action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button
                                        class="btn dropdown-item py-2 d-flex align-items-center justify-content-between"
                                        href="#">
                                        <span>Log Out</span>
                                        <i class="mdi mdi-logout ml-1"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>


        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin') }}">
                            <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    @foreach (menus('subMenus') as $menu)
                        {{-- Menu Item with No Dropdown --}}
                        @if ($menu->parent == 0 && $menu->subMenus->isEmpty())
                            @if (menu_authorize($menu->id))
                                <li class="nav-item">
                                    <a class="nav-link"
                                        @if (Route::has($menu->route)) href="{{ route($menu->route) }}" @endif>
                                        @if ($menu->icon_class != null)
                                            <span class="icon-bg">
                                                <i class="{{ $menu->icon_class }} menu-icon"></i>
                                            </span>
                                        @endif
                                        <span class="menu-title">{{ $menu->name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif

                        {{-- Menu Item with Dropdown --}}

                        @if ($menu->parent == 0 && $menu->subMenus->isNotEmpty())
                            @if (menu_authorize($menu->id))
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="collapse"
                                        href="#{{ Str::slug($menu->name . $menu->id) }}" aria-expanded="false"
                                        aria-controls="auth">
                                        @if ($menu->icon_class != null)
                                            <span class="icon-bg">
                                                <i class="{{ $menu->icon_class }} menu-icon"></i>
                                            </span>
                                        @endif
                                        <span class="menu-title">{{ $menu->name }}</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="collapse" id="{{ Str::slug($menu->name . $menu->id) }}">
                                        <ul class="nav flex-column sub-menu">
                                            {{-- Sub Menu --}}
                                            @foreach ($menu->subMenus->where('status', 'active')->sortBy('position') as $subMenu)
                                                @if (menu_authorize($subMenu->id))
                                                    <li
                                                        class="nav-item {{ isset($menucode) && $menucode == $subMenu->menu_code ? 'sub-active' : '' }}">
                                                        <a class="nav-link"
                                                            @if (Route::has($subMenu->route)) href="{{ route($subMenu->route) }}" @endif>
                                                            {{ $subMenu->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        @endif
                    @endforeach

                </ul>
            </nav>
            <!-- partial -->

            <div class="main-panel">
                {!! Toastr::message() !!}
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="footer-inner-wraper">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                                <a href={{ url('/') }} target="_blank"
                                    rel="noopener noreferrer">{{ env('APP_NAME') }}</a>
                                , {{ date('Y') }}</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Developed by <a
                                    href="https://tricksterweb.netlify.app" target="_blank"
                                    rel="noopener noreferrer">Nischal Tuladhar </a></span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

    </div>



    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
    <!--elfinder popup setup plugins begin-->
    <link rel="stylesheet" href="{{ asset('assets/css/colorbox.css') }}">
    <script src="{{ asset('/packages/barryvdh/elfinder/js/standalonepopup.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.colorbox-min.js') }}"></script>
    <!--elfinder popup setup plugins ends-->
    <script src="{{ asset('assets/js/common.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables/custom.datatable.js') }}"></script>
    {!! session('script') !!}
    @yield('script')
</body>

</html>
