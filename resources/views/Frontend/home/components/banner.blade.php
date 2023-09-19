{{-- <section class="home-slider-section">
    <div class="home-slider">
        @foreach ($banners as $banner)
            <div class="home-banner-items">
                <div class="banner-inner-wrap"
                    style="background-image: url('{{str_starts_with($banner->image, "http") ? $banner->image : '/'.$banner->image}}');">
                </div>
                <div class="banner-content-wrap">
                    <div class="container">
                        <div class="banner-content text-center">
                            <h2 class="banner-title">{{$banner->title}}</h2>
                            <p>{{$banner->tag_line}}</p>
                            @if ($banner->primary_button_title)
                                <a href="{{$banner->primary_button_link}}" class="button-primary">{{$banner->primary_button_title}}</a>                            
                            @endif
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
        @endforeach
    </div>
</section>
<div class="trip-search-section shape-search-section">
    <div class="slider-shape"></div>
    <div class="container">
        <div class="trip-search-inner white-bg d-flex">
            <div class="input-group col-md-3">
                <label> Search Theme </label>
                <input type="text" name="s" placeholder="Enter Destination">
            </div>
            <div class="input-group width-col-3 col-md-3">
                <label> Length </label>
                <i class="far fa-calendar"></i>
                <input type="number" name="s" placeholder="Length in meter" autocomplete="off">
            </div>
            <div class="input-group width-col-3 col-md-3">
                <label> Breadth </label>
                <i class="far fa-calendar"></i>
                <input type="number" name="s" placeholder="Bradth in meter" autocomplete="off">
            </div>
            <div class="input-group">
                <label class="screen-reader-text"> Search </label>
                <input type="submit" name="travel-search" value="INQUIRE NOW">
            </div>
        </div>
    </div>
</div> --}}


<section class="banner-section" id="main1"
    style="background-image: url({{ str_starts_with($banner->image, 'http') ? $banner->image : '/' . $banner->image }})">
    <div class="overlay">
        <h1 class="custom-header">{{ $banner->title }}</h1>
        @if ($banner->primary_button_title)
            <a class="banner-btn" href="{{ $banner->primary_button_link }}">{{ $banner->primary_button_title }}</a>
        @endif
    </div>
</section>
