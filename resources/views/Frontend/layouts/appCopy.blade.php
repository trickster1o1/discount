<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--SEO DETAIL BEGINS-->
    <title>{{ isset($meta_title) ? $meta_title : 'Rug Nepal' }}</title>
    <meta name="description" content="{{ isset($meta_description) ? $meta_description : '' }}">
    <meta property="og:site_name" content="{{ $siteSetting->title }}" />
    <meta property="og:image" content="{{ isset($fb_image) ? $fb_image : '' }}" />
    <meta property="og:image:secure_url" content="{{ isset($fb_image) ? $fb_image : '' }}" />
    <meta property="og:title" content="{{ isset($fb_title) ? $fb_title : '' }}" />
    <meta property="og:description" content="{{ isset($fb_description) ? $fb_description : '' }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="{{ url('') }}" />
    <meta name="twitter:description" content="{{ isset($twitter_description) ? $twitter_description : '' }}" />
    <meta property="twitter:image" content="{{ isset($twitter_image) ? $twitter_image : '' }}" />
    <meta property="twitter:title" content="{{ isset($twitter_title) ? $twitter_title : '' }}" />
    <!--SEO DETAIL ENDS-->

    <!-- favicons Icons -->
    {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{asset('Frontend/assets/images/favicons/apple-touch-icon.png')}}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('Frontend/assets/images/favicons/favicon-32x32.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('Frontend/assets/images/favicons/favicon-16x16.png')}}" />
    <link rel="manifest" href="{{asset('Frontend/assets/images/favicons/site.webmanifest')}}" />

    
    @if (isset($is_home) && $is_home)
    <link rel="stylesheet" href="{{asset('Frontend/assets/vendors/bootstrap/css/bootstrap-home.min.css')}}" defer/> 
    @else
    <link rel="stylesheet" href="{{asset('Frontend/assets/vendors/bootstrap/css/bootstrap.min.css')}}" defer/> 
    @endif

    <!-- template styles -->
    <link rel="stylesheet" href="{{asset('Frontend/assets/css/main.css')}}" defer/>
    <link rel="stylesheet" href="{{asset('Frontend/assets/css/main-responsive.css')}}" defer/> --}}

    <!-- favicon -->
    <link rel="icon" type="image/ico" href="{{ asset('Frontend/assets/logo/favicon.ico') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('Frontend/assets/vendors/bootstrap/css/bootstrap.min.css') }}"
        media="all">
    <!-- Fonts Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/vendors/fontawesome/css/all.min.css') }}">
    <!-- jquery-ui css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/vendors/jquery-ui/jquery-ui.min.css') }}">
    <!-- modal video css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('Frontend/assets/vendors/modal-video/modal-video.min.css') }}">
    <!-- light box css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('Frontend/assets/vendors/lightbox/dist/css/lightbox.min.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/vendors/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/vendors/slick/slick-theme.css') }}">
    <!-- google fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/style.css') }}">
    @yield('css')

    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/toaster/toastr.min.css') }}" />
    <script src="{{asset('assets/vendors/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendors/toaster/toastr.min.js')}}"></script>
</head>
<body>
    <div id="siteLoader" class="site-loader">
        <div class="preloader-content">
            <img src="{{ asset('Frontend/assets/images/loader1.gif') }}" alt="">
        </div>
    </div>
    {!! Toastr::message() !!}

    <div id="page" class="full-page">
        <header id="masthead" class="site-header header-primary">
            <!-- header html start -->
            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 d-none d-lg-block">
                            <div class="header-contact-info">
                                <ul>
                                    <li>
                                        <a href="tel:{{ $siteSetting->pri_phone }}"><i class="fas fa-phone-alt"></i>
                                            {{ $siteSetting->pri_phone }}</a>
                                    </li>
                                    <li>
                                        <a href="mailto:info@Travel.com" target="_blank" rel="noopener noreferrer"><i
                                                class="fas fa-envelope"></i>
                                            {{ $siteSetting->pri_email }}</a>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ strip_tags($siteSetting->pri_address) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex justify-content-lg-end justify-content-between">
                            <div class="header-social social-links">
                                <ul>
                                    @if ($siteSetting->fb_link)
                                        <li><a href="{{ $siteSetting->fb_link }}" target="_blank"
                                                rel="noopener noreferrer"><i class="fab fa-facebook-f"
                                                    aria-hidden="true"></i></a>
                                        </li>
                                    @endif
                                    @if ($siteSetting->twitter_link)
                                        <li><a href="{{ $siteSetting->twitter_link }}" target="_blank"
                                                rel="noopener noreferrer"><i class="fab fa-twitter"
                                                    aria-hidden="true"></i></a></li>
                                    @endif
                                    @if ($siteSetting->ig_link)
                                        <li><a href="{{ $siteSetting->ig_link }}" target="_blank"
                                                rel="noopener noreferrer"><i class="fab fa-instagram"
                                                    aria-hidden="true"></i></a>
                                        </li>
                                    @endif
                                    @if ($siteSetting->youtube_link)
                                        <li><a href="{{ $siteSetting->youtube_link }}" target="_blank"
                                                rel="noopener noreferrer"><i class="fab fa-youtube"
                                                    aria-hidden="true"></i></a>
                                        </li>
                                    @endif
                                    @if ($siteSetting->linkedin_link)
                                        <li><a href="{{ $siteSetting->linkedin_link }}" target="_blank"
                                                rel="noopener noreferrer"><i class="fab fa-linkedin"
                                                    aria-hidden="true"></i></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="header-search-icon">
                                <button class="search-icon">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-header">
                <div class="container d-flex justify-content-between align-items-center">
                    <div class="site-identity">
                        <h1 class="site-title">
                            <a href="/">
                                <img src="/{{ $siteSetting->primary_logo }}" alt="logo here">
                            </a>
                        </h1>
                    </div>
                    <div class="main-navigation d-none d-lg-block">
                        <nav id="navigation" class="navigation">
                            <ul>
                                @if (count($main_menu))
                                    @foreach ($main_menu as $parent)
                                        @if ($parent->parent == 0)
                                            @php
                                                $plink = 'javascript:void(0)';
                                                if ($parent->link_type == 'external_url') {
                                                    $plink = $parent->external_url;
                                                } elseif ($parent->link_type == 'internal_link') {
                                                    $plink = '/' . $parent->getLink($parent->topic);
                                                }
                                            @endphp
                                            <li
                                                class="{{ count($parent->getSubMenus($parent->id)) ? 'menu-item-has-children' : 'menu-item' }}">
                                                <a href="{{ $plink }}">{{ $parent->title }}</a>
                                                @if (count($parent->getSubMenus($parent->id)))
                                                    <ul>
                                                        @foreach ($parent->getSubMenus($parent->id) as $child)
                                                            @php
                                                                $clink = 'javascript:void(0)';
                                                                if ($child->link_type == 'external_url') {
                                                                    $clink = $child->external_url;
                                                                } elseif ($child->link_type == 'internal_link') {
                                                                    $clink = '/' . $child->getLink($child->topic);
                                                                }
                                                            @endphp
                                                            <li>
                                                                <a href="{{ $clink }}">{{ $child->title }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @if (Session::has('user'))
                        <div class="main-navigation d-none d-lg-block">
                            <nav id="nav" class="navigation">
                                <ul>
                                    <li class="menu-item-has-children">
                                        <div class="header-btn">

                                            <a href="javascript:void(0)" class="button-primary p-3">
                                                {{ strtoupper(Session::get('user')['unm']) }}
                                            </a>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="{{ route('customer.logout') }}">logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @else
                        <div class="header-btn">
                            <a href="{{ route('customer.register') }}" class="button-primary">Login</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mobile-menu-container"></div>
        </header>
        <main /id="content" class="site-main">
            @yield('body')
        </main>
        <footer id="colophon" class="site-footer footer-primary">
            <div class="top-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <aside class="widget widget_text">
                                <h3 class="widget-title">
                                    About Rugs
                                </h3>
                                <div class="textwidget widget-text">
                                    @if ($f_about)
                                        {!! $f_about !!}
                                    @else
                                        <p>

                                            Tenzing Sherpa founded N.P. Rugs Industries in year 1991 immediate after
                                            completing his graduation in Civil Engineering from Mysore University,
                                            Karnataka, India. He started his business on principles of dignity.
                                        </p>
                                    @endif
                                </div>
                                {{-- <div class="award-img">
                                    <a href="#"><img src="{{ asset('Frontend/assets/images/logo6.png') }}"
                                            alt=""></a>
                                    <a href="#"><img src="{{ asset('Frontend/assets/images/logo2.png') }}"
                                            alt=""></a>
                                </div> --}}
                            </aside>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <aside class="widget widget_text">
                                <h3 class="widget-title">CONTACT INFORMATION</h3>
                                <div class="textwidget widget-text">
                                    <ul>
                                        <li>
                                            <a href="tel:{{ $siteSetting->pri_phone }}">
                                                <i class="fas fa-phone-alt"></i>
                                                {{ $siteSetting->pri_phone }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="mailto:{{ $siteSetting->pri_email }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="fas fa-envelope"></i>
                                                {{ $siteSetting->pri_email }}
                                            </a>
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ strip_tags($siteSetting->pri_address) }}
                                        </li>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                        @if (count($f_prod))
                            <div class="col-lg-4 col-md-6">
                                <aside class="widget widget_recent_post">
                                    <h3 class="widget-title">Latest Products</h3>
                                    <ul>
                                        @foreach ($f_prod as $prod)
                                            <li>
                                                <h5>
                                                    <a href="/product/{{ $prod->slug }}">{{ $prod->title }}</a>
                                                </h5>
                                                <div class="entry-meta">
                                                    <span class="post-on">
                                                        <a href="/product/{{ $prod->slug }}">Published Date:
                                                            {{ \Carbon\Carbon::parse($prod->created_at)->format('M D, Y') }}</a>
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="buttom-footer">
                <div class="container">
                    <div class="row align-items-center">
                        {{-- <div class="col-md-5">
                       <div class="footer-menu">
                          <ul>
                             <li>
                                <a href="#">Privacy Policy</a>
                             </li>
                             <li>
                                <a href="#">Term & Condition</a>
                             </li>
                             <li>
                                <a href="#">FAQ</a>
                             </li>
                          </ul>
                       </div>
                    </div> --}}
                        <div class="col-md-5">
                            <div class="footer-logo">
                                <a href="/"><img src="/{{ $siteSetting->primary_logo }}" alt="LOGO"></a>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="copy-right text-right">Copyright © 2023 Bisava Technology.</div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a id="backTotop" href="#" class="to-top-icon">
            <i class="fas fa-chevron-up"></i>
        </a>
        <!-- custom search field html -->
        <div class="header-search-form">
            <div class="container">
                <div class="header-search-container">
                    <form class="search-form" role="search" method="get">
                        <input type="text" name="s" placeholder="Enter your text...">
                    </form>
                    <a href="#" class="search-close">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- header html end -->
    </div>

    <!-- JavaScript -->
    <script src='{{ asset('Frontend/assets/js/jquery.js') }}'></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src='{{ asset('Frontend/assets/vendors/bootstrap/js/bootstrap.min.js') }}'></script>
    <script src='{{ asset('Frontend/assets/vendors/jquery-ui/jquery-ui.min.js') }}'></script>
    <script src='{{ asset('Frontend/assets/vendors/countdown-date-loop-counter/loopcounter.js') }}'></script>
    <script src='{{ asset('Frontend/assets/js/jquery.counterup.js') }}'></script>
    <script src='{{ asset('Frontend/assets/vendors/modal-video/jquery-modal-video.min.js') }}'></script>
    <script src='{{ asset('Frontend/assets/vendors/masonry/masonry.pkgd.min.js') }}'></script>
    <script src='{{ asset('Frontend/assets/vendors/lightbox/dist/js/lightbox.min.js') }}'></script>
    <script src='{{ asset('Frontend/assets/vendors/slick/slick.min.js') }}'></script>
    <script src='{{ asset('Frontend/assets/js/jquery.slicknav.js') }}'></script>
    <script src='{{ asset('Frontend/assets/js/custom.min.js') }}'></script>

    @yield('script')
</body>

</html>
