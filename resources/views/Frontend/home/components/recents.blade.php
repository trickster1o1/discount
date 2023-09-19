{{-- <section class="blog-section">
    <div class="container">
        <div class="section-heading text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h5 class="dash-style">{{ $homeSetting->recent_tag_line }}</h5>
                    <h2>{{ $homeSetting->recent_title }}</h2>
                    <p>{{ $homeSetting->recent_desc }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($recents as $prod)
                <div class="col-md-6 col-lg-4">
                    <article class="post">
                        <figure class="feature-image col-img-size">
                            <a href="/product/{{ $prod->slug }}">
                                <img class="i-fit"
                                    src="{{ !$prod->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($prod->thumb_image, 'http') ? $prod->thumb_image : '/' . $prod->thumb_image) }}"
                                    alt="">
                            </a>
                        </figure>
                        <div class="entry-content">
                            <h3>
                                <a href="/product/{{ $prod->slug }}">{{$prod->title}}</a>
                            </h3>
                            <div class="entry-meta">
                                <span class="byline">
                                    <a href="/product/{{ $prod->slug }}">{{$prod->category($prod->category)}}</a>
                                </span>
                                <span class="posted-on">
                                    <a href="/product/{{ $prod->slug }}">{{\Carbon\Carbon::parse($prod->created_at)->format('M D, Y')}}</a>
                                </span>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}

<section class="recent-section container-fluid">
    <h3 class="custom-header">Our Recent Products</h3>
    <div class="owl-carousel owl-theme slider" style="padding-right:70px;padding-left:70px;">
        @foreach ($recents as $item)
            <div>
                <div class="slider-img-cont">
                    <a href="/product/{{$item->slug}}">
                        <img class="owl-lazy i-fit"
                            data-src="{{ !$item->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($item->thumb_image, 'http') ? $item->thumb_image : '/' . $item->thumb_image) }}"
                            alt="">
                    </a>
                </div>
                <span class="slider-text">{{ $item->title }}</span>
                <span class="slider-text font-italic text-danger">Rs.{{ $item->price }}</span>
            </div>
        @endforeach
    </div>
    <a class="custom-btn" href="/products">
        View All
    </a>
</section>
