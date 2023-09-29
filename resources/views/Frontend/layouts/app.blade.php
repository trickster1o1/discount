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

    {!! Toastr::message() !!}

    <div class="nav-cont custom-cont">
        <div class="nav-top">
            <ul>
                <li>Get The App</li>
                <li>My Whishlist</li>
                <li>Sell on Groupon</li>
                <li>Sign Up</li>
            </ul>
        </div>
        <div class="nav-bot">
            <ul>
                <li class="nav-logo"><img src="{{ $siteSetting ? '/' . $siteSetting->primary_logo : 'empty' }}"
                        alt="DISCOUNT"></li>
                <li><span class="d-box">Categories</span></li>
                <li><span>
                        <span>
                            <input type="text" placeholder="Search Discount">
                        </span>
                        <span>
                            <input type="text" placeholder="Kathmandu">
                        </span>
                    </span></li>
                <li><i class="fa fa-cart"><i class="fas fa-cart-plus"></i></i></li>
                <li><i class="fas fa-bell"></i></li>
                <li><span class="d-box">Sign Up</span></li>
            </ul>
        </div>
    </div>
    @yield('body')

    <div class="footer-cont custom-cont">
        <div>
            <ul>
                <li><b>Customer Suppot</b></li>
                <li><a href="#" class="custom-btn">Help Center</a></li>
                <li>Refund Policies</li>
                <li>Report Infringement</li>
                <li>Merchant Class Statement Notice</li>
            </ul>
        </div>
        <div>
            
            <ul>
                <li><b>Sell on Discount</b></li>
                <li>Join Marketplace</li>
                <li>Run Campaign</li>
                <li>How does Discount work for Merchants</li>
                <li>Sponser for Campaign</li>
                <li>Vendor Code of Conduct</li>
            </ul>
        </div>
        <div>
            
            <ul>
                <li><b>Company</b></li>
                <li>About</li>
                <li>Jobs</li>
                <li>Investor Relations</li>
                <li>Management Team</li>
                <li>In Your Company</li>
            </ul>
        </div>
        <div>
            
            <ul>
                <li><b>Quick Links</b></li>
                <li>Treat Yourself +</li>
                <li>Things to do +</li>
                <li>Coupons +</li>
                <li>Gifts for Occasions +</li>
            </ul>
        </div>
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
    <script src='{{ asset('Frontend/assets/custom.js') }}'></script>
    @yield('script')
</body>

</html>
