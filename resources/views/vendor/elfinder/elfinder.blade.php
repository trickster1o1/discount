<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>Media Manager</title>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset($dir . '/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir . '/css/theme.css') }}">

    <!-- elFinder JS (REQUIRED) -->
    <script src="{{ asset($dir . '/js/elfinder.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here

                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url: '{{ route('elfinder.connector') }}', // connector URL
                soundPath: '{{ asset($dir . '/sounds') }}'
            });
        });
    </script>
</head>

<body>


    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center border-bottom">
                <a href="{{ url('') }}" class="navbar-brand brand-logo text-white">PMS</a>
                <a href="{{ url('') }}" class="navbar-brand brand-logo-mini text-white">P</a>
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
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="image">
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">{{ auth()->user()->name }}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm"
                            aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                            <div class="p-3 text-center bg-primary">
                                <img class="img-avatar img-avatar48 img-avatar-thumb"
                                    src="{{ asset('assets/images/avatar.png') }}" alt="">
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                                    href="javascript:void(0)">
                                    <span>Settings</span>
                                    <i class="mdi mdi-settings"></i>
                                </a>
                                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                                    href="#">
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
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('') }}">
                            <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    @foreach (menus('subMenus') as $menu)
                        {{-- Menu Item with No Dropdown --}}
                        @if ($menu->parent == 0 && $menu->subMenus->isEmpty())
                            @authorized($menu->menu_code)
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
                            @endauthorized
                        @endif

                        {{-- Menu Item with Dropdown --}}
                        @if ($menu->parent == 0 && $menu->subMenus->isNotEmpty())
                            @authorized($menu->menu_code)
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
                                        @foreach ($menu->subMenus->sortBy('position') as $subMenu)
                                            @authorized($subMenu->menu_code)
                                            <li class="nav-item"> <a class="nav-link"
                                                    @if (Route::has($subMenu->route)) href="{{ route($subMenu->route) }}" @endif>
                                                    {{ $subMenu->name }}
                                                </a>
                                            </li>
                                            @endauthorized
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endauthorized
                        @endif
                    @endforeach
                </ul>
            </nav>
            <!-- partial -->

            <div class="main-panel">
                {!! Toastr::message() !!}
                <div class="content-wrapper">
                    <!-- Element where elFinder will be created (REQUIRED) -->
                    <div id="elfinder"></div>
                </div>
                <footer class="footer">
                    <div class="footer-inner-wraper">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                                {{ env('APP_NAME') }}, {{ date('Y') }}</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Created by Deft
                                Tree </span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

    </div>
</body>

</html>
