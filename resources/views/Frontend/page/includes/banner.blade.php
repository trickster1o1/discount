{{-- <section class="home-slider-section">
    <div class="home-slider">
        <div class="home-banner-items" style="height: 100vh;">
            <div class="banner-inner-wrap"
                style="background-image: url('{{ !isset($linkData) ? '/uploads/defaults/banner.webp' : (!$linkData->banner_image ? '/uploads/defaults/banner.webp' : (str_starts_with($linkData->banner_image, 'http') ? $linkData->banner_image : '/' . $linkData->banner_image)) }}');">
            </div>

            <div class="overlay">
                <div class="banner-content-wrap">
                    <div class="container">
                        <div class="banner-content text-center" style="padding-top:5em">
                            <h2 class="banner-title" style="border: 1px solid black;min-width:50vw; !important">
                                {{ isset($linkData) ? $linkData->title : (isset($title) ? $title : 'Title') }}</h2>
                            <p> <a href="/" style="color:white;">Home</a> &nbsp; / &nbsp; @if (isset($sublink))
                                    <a href="/{{ $prev }}" style="color:white;"> {{ $sublink }} </a> &nbsp;
                                    / &nbsp;
                                @endif
                                {{ isset($linkData) ? $linkData->title : (isset($title) ? $title : 'Title') }}</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}


<section class="banner-section" id="main1"
    style="@if(isset($style)) {{$style}} @endif background-image: url({{ !isset($linkData) ? '/uploads/defaults/banner.webp' : (!$linkData->banner_image ? '/uploads/defaults/banner.webp' : (str_starts_with($linkData->banner_image, 'http') ? $linkData->banner_image : '/' . $linkData->banner_image)) }})">
    <div class="overlay">
        <h1 class="custom-header">{{ isset($linkData) ? $linkData->title : (isset($title) ? $title : 'Title') }}</h1>
        <p> <a href="/" style="color:white;">Home</a> &nbsp; / &nbsp; @if (isset($sublink))
                <a href="/{{ $prev }}" style="color:white;"> {{ $sublink }} </a> &nbsp;
                / &nbsp;
            @endif
            {{ isset($linkData) ? $linkData->title : (isset($title) ? $title : 'Title') }}</p>
    </div>
</section>
