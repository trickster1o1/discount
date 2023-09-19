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
    <link rel="stylesheet" type="text/css" href="{{ asset('Frontend/assets/custom.css') }}">
    @yield('css')

    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/toaster/toastr.min.css') }}" />
    <script src="{{ asset('assets/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toaster/toastr.min.js') }}"></script>
</head>

<body id="bod">
    <div id="siteLoader" class="site-loader">
        <div class="preloader-content">
            <img src="{{ asset('Frontend/assets/images/loader1.gif') }}" alt="">
        </div>
    </div>
    {!! Toastr::message() !!}
    <section class="header-section" id="head-nav">
        <nav class="header-top">
            <div class="home-search">
                <span>
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search..." autocomplete="off">
                </span>
            </div>
            <div>
                <a href="/"><img src="/{{ $siteSetting->primary_logo }}" alt="LOGO"></a>

            </div>
            <div>
                <div class="social-media">
                    @if ($siteSetting->fb_link)
                        <span><a href="{{ $siteSetting->fb_link }}" target="_blank" rel="noopener noreferrer"><i
                                    class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        </span>
                    @endif
                    @if ($siteSetting->twitter_link)
                        <span><a href="{{ $siteSetting->twitter_link }}" target="_blank" rel="noopener noreferrer"><i
                                    class="fab fa-twitter" aria-hidden="true"></i></a></span>
                    @endif
                    @if ($siteSetting->ig_link)
                        <span><a href="{{ $siteSetting->ig_link }}" target="_blank" rel="noopener noreferrer"><i
                                    class="fab fa-instagram" aria-hidden="true"></i></a>
                        </span>
                    @endif
                    @if ($siteSetting->youtube_link)
                        <span><a href="{{ $siteSetting->youtube_link }}" target="_blank" rel="noopener noreferrer"><i
                                    class="fab fa-youtube" aria-hidden="true"></i></a>
                        </span>
                    @endif
                    @if ($siteSetting->linkedin_link)
                        <span><a href="{{ $siteSetting->linkedin_link }}" target="_blank"
                                rel="noopener noreferrer"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                        </span>
                    @endif
                    {{-- <span><i class="fab fa-twitter" aria-hidden="true"></i></span>
                    <span><i class="fab fa-instagram" aria-hidden="true"></i></span>
                    <span><i class="fab fa-youtube" aria-hidden="true"></i></span> --}}
                </div>
                <div class="log-info">
                    <div class="profile-img""><img class="i-fit"
                            src="{{Session::has('user') ? (!Session::get('user')['pic'] ? 'https://www.freeiconspng.com/thumbs/profile-icon-png/am-a-19-year-old-multimedia-artist-student-from-manila--21.png' : (str_starts_with(Session::get('user')['pic'], 'http') ? Session::get('user')['pic'] : '/' . Session::get('user')['pic'])) : 'https://www.freeiconspng.com/thumbs/profile-icon-png/am-a-19-year-old-multimedia-artist-student-from-manila--21.png'}}"
                            alt="-"></div>
                    @if (!Session::has('user'))
                        <span style="margin-left:10px;margin-right:20px;"><a href="/login">Log In</a></span>
                    @else
                        <span style="margin-left:10px;margin-right:20px;"><a href="{{route('customer.profile')}}">{{Session::get('user')['unm']}}</a></span>
                    @endif
                    <span><a href="{{Session::has('user') ? '/cart' : '/cart'}}"  @if(Session::has('user') && Session::get('user')['cart'] && count(Session::get('user')['cart'])) style="font-weight: bold;color:green;" @endif class="cart-ping" >Cart {{ Session::has('user') && Session::get('user')['cart'] ? (count(Session::get('user')['cart']) ? '('.count(Session::get('user')['cart']).')' : null) : null }}</a></span>
                </div>
            </div>
        </nav>
        <nav class="header-bot">
            @if (count($main_menu))
                <ul>
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
                            <li @if (count($parent->getSubMenus($parent->id))) class='with-child' @endif>
                                <a href="{{ $plink }}">{{ $parent->title }}</a>
                                @if (count($parent->getSubMenus($parent->id)))
                                    <ul class="d-nav">
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
                </ul>
            @endif
            {{-- <ul>
                <li>Home</li>
                <li>Shop All</li>
                <li>Our Story</li>
                <li>Our Craft</li>
                <li>Contact</li>
            </ul> --}}
        </nav>
    </section>
    <section class="mob-nav">
        <div>
            <div class="mobile-media">
                <span><i class="fab fa-facebook-f" aria-hidden="true"></i></span>
                <span><i class="fab fa-twitter" aria-hidden="true"></i></span>
                <span><i class="fab fa-instagram" aria-hidden="true"></i></span>
                <span><i class="fab fa-youtube" aria-hidden="true"></i></span>
            </div>
            <div class="mob-nav-right">
                <span>Cart</span>
                <span class="burger" id="b-bod">
                    <span id="b-top"></span>
                    <span id="b-mid"></span>
                    <span id="b-bot"></span>
                </span>
            </div>
        </div>
        <div class='m-logo'>
            <a href="/"><img src="/{{ $siteSetting->primary_logo }}" alt="LOGO"></a>
        </div>
    </section>
    <div class="mob-nav-pop container-fluid" id="m-nav-p">
        <div style="display: flex;align-items:center;">
            <div class="profile-img"><img style="i-fit"
                    src="https://www.freeiconspng.com/thumbs/profile-icon-png/am-a-19-year-old-multimedia-artist-student-from-manila--21.png"
                    alt="-"></div><span style="margin-left:10px;margin-right:20px;"> Log In</span>
        </div>
        <div class="home-search">
            <span>
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search..." autocomplete="off">
            </span>
        </div>
        @if (count($main_menu))
            <ul>
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
                        <li @if (count($parent->getSubMenus($parent->id))) class='with-child-mob' @endif>
                            <a href="{{ $plink }}">{{ $parent->title }}</a>
                            @if (count($parent->getSubMenus($parent->id)))
                                <ul class="d-nav-mob">
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
            </ul>
        @endif

    </div>
    @yield('body')
    <section class="footer-section container-fluid">
        <span>
            <a href="/"><img src="/{{ $siteSetting->primary_logo }}" alt="LOGO"></a>
        </span>
        @if (count($footer_menu))
            <ul>
                @foreach ($footer_menu as $parent)
                    @if ($parent->parent == 0)
                        @php
                            $plink = 'javascript:void(0)';
                            if ($parent->link_type == 'external_url') {
                                $plink = $parent->external_url;
                            } elseif ($parent->link_type == 'internal_link') {
                                $plink = '/' . $parent->getLink($parent->topic);
                            }
                        @endphp
                        <li>
                            <a href="{{ $plink }}">{{ $parent->title }}</a>

                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
        {{-- <ul>
            <li>Home</li>
            <li>Shop All</li>
            <li>Our Story</li>
            <li>Our Craft</li>
            <li>Contact</li>
        </ul> --}}
        @if (count($f_prod))
            <ul>
                @foreach ($f_prod as $prod)
                    <li><a href="/product/{{ $prod->slug }}">{{ $prod->title }}</a></li>
                @endforeach
                {{-- <li>Product 1</li>
                <li>Product 2</li>
                <li>Product 3</li>
                <li>Product 4</li> --}}
            </ul>
        @endif
        <ul>
            @if ($siteSetting->fb_link)
                <li><a href="{{ $siteSetting->fb_link }}" target="_blank" rel="noopener noreferrer">Facebook</a>
                </li>
            @endif
            @if ($siteSetting->twitter_link)
                <li><a href="{{ $siteSetting->twitter_link }}" target="_blank" rel="noopener noreferrer">Twitter</a>
                </li>
            @endif
            @if ($siteSetting->ig_link)
                <li><a href="{{ $siteSetting->ig_link }}" target="_blank" rel="noopener noreferrer">Instagram</a>
                </li>
            @endif
            @if ($siteSetting->youtube_link)
                <li><a href="{{ $siteSetting->youtube_link }}" target="_blank" rel="noopener noreferrer">Youtube</a>
                </li>
            @endif
            @if ($siteSetting->linkedin_link)
                <li><a href="{{ $siteSetting->linkedin_link }}" target="_blank" rel="noopener noreferrer">Linked
                        In</a>
                </li>
            @endif
        </ul>
    </section>

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
    <script src='{{ asset('Frontend/assets/custom.js') }}'></script>

    <script>
        let nav = 0;
        $('#b-bod').click(() => {
            if (nav == 0) {
                $('#b-top').css("transform", "rotate(240deg) scale(1.2)");
                $('#b-mid').css("transform", "rotate(-45deg) scale(1.2)");
                $('#b-bot').css("background-color", "rgba(0,0,0,0)");
                $('#m-nav-p').css("top", "0");
                $('#m-nav-p').css("opacity", "1");
                $('#bod').css("overflow-y", "hidden");
                nav = 1;
            } else {
                $('#b-top').css("transform", "rotate(0deg) scale(1)");
                $('#b-mid').css("transform", "rotate(0deg) scale(1)");
                $('#b-bot').css("background-color", "rgba(0,0,0,1)");
                $('#m-nav-p').css("top", "-100%");
                $('#m-nav-p').css("opacity", "0");
                $('#bod').css("overflow-y", "auto");
                nav = 0;
            }
        });
    </script>

    @yield('script')
</body>

</html>
