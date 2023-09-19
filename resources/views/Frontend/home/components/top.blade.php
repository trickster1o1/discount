{{-- <section class="destination-section">
    <div class="container">
        <div class="section-heading">
            <div class="row align-items-end">
                <div class="col-lg-7">
                    <h5 class="dash-style">{{ $homeSetting->top_tag_line }}</h5>
                    <h2>{{ $homeSetting->top_title }}</h2>
                </div>
                <div class="col-lg-5">
                    <div class="section-disc">
                        {{ $homeSetting->top_desc }}
                    </div>
                </div>
            </div>
        </div>
        <div class="destination-inner destination-three-column">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="desti-item overlay-desti-item">
                                <a href="/product/{{ $topNotch[0]->slug }}">
                                    <figure class="desti-image i-size-portrait">
                                        <img class="i-fit"
                                            src="{{ !$topNotch[0]->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($topNotch[0]->thumb_image, 'http') ? $topNotch[0]->thumb_image : '/' . $topNotch[0]->thumb_image) }}"
                                            alt="">
                                    </figure>
                                </a>
                                <div class="meta-cat bg-meta-cat">
                                    <a
                                        href="/product/{{ $topNotch[0]->slug }}">{{ $topNotch[0]->category($topNotch[0]->category) }}</a>
                                </div>
                                <div class="desti-content">
                                    <h3>
                                        <a href="/product/{{ $topNotch[0]->slug }}">{{ $topNotch[0]->title }}</a>
                                    </h3>
                                    <div class="rating-start" title="Rated 5 out of 4">
                                        <span style="width: 53%"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($topNotch) > 1)
                            <div class="col-sm-6">
                                <div class="desti-item overlay-desti-item">
                                <a href="/product/{{ $topNotch[1]->slug }}">

                                    <figure class="desti-image i-size-portrait">
                                        <img class="i-fit"
                                            src="{{ !$topNotch[1]->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($topNotch[1]->thumb_image, 'http') ? $topNotch[1]->thumb_image : '/' . $topNotch[1]->thumb_image) }}"
                                            alt="">
                                    </figure>
                                </a>
                                    <div class="meta-cat bg-meta-cat">
                                        <a href="/product/{{ $topNotch[1]->slug }}">{{ $topNotch[1]->category($topNotch[1]->category) }}</a>
                                    </div>
                                    <div class="desti-content">
                                        <h3>
                                            <a href="/product/{{ $topNotch[1]->slug }}">{{ $topNotch[1]->title }}</a>
                                        </h3>
                                        <div class="rating-start" title="Rated 5 out of 5">
                                            <span style="width: 100%"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    @endif

                </div>
                <div class="col-lg-5">
                    <div class="row">
                        @if (count($topNotch) > 2)
                            <div class="col-md-6 col-xl-12">
                                <div class="desti-item overlay-desti-item">
                                <a href="/product/{{ $topNotch[2]->slug }}">

                                    <figure class="desti-image i-size-land">
                                        <img class="i-fit"
                                            src="{{ !$topNotch[2]->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($topNotch[2]->thumb_image, 'http') ? $topNotch[2]->thumb_image : '/' . $topNotch[2]->thumb_image) }}"
                                            alt="">
                                    </figure>
                                </a>
                                    <div class="meta-cat bg-meta-cat">
                                        <a href="/product/{{ $topNotch[2]->slug }}">{{ $topNotch[2]->category($topNotch[2]->category) }}</a>
                                    </div>
                                    <div class="desti-content">
                                        <h3>
                                            <a href="/product/{{ $topNotch[2]->slug }}">{{ $topNotch[2]->title }}</a>
                                        </h3>
                                        <div class="rating-start" title="Rated 5 out of 5">
                                            <span style="width: 100%"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (count($topNotch) > 3)
                            <div class="col-md-6 col-xl-12">
                                <div class="desti-item overlay-desti-item">
                                    <a href="/product/{{ $topNotch[3]->slug }}">
                                    <figure class="desti-image i-size-land">
                                        <img class="i-fit"
                                            src="{{ !$topNotch[3]->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($topNotch[3]->thumb_image, 'http') ? $topNotch[3]->thumb_image : '/' . $topNotch[3]->thumb_image) }}"
                                            alt="">
                                    </figure>
                                </a>
                                    <div class="meta-cat bg-meta-cat">
                                        <a href="/product/{{ $topNotch[3]->slug }}">{{ $topNotch[3]->category($topNotch[3]->category) }}</a>
                                    </div>
                                    <div class="desti-content">
                                        <h3>
                                            <a href="/product/{{ $topNotch[3]->slug }}">{{ $topNotch[3]->title }}</a>
                                        </h3>
                                        <div class="rating-start" title="Rated 5 out of 4">
                                            <span style="width: 60%"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="btn-wrap text-center">
                <a href="/products" class="button-primary">MORE RUGS</a>
            </div>
        </div>
    </div>
</section> --}}
<section class="best-seller container-fluid">
    <h3 class="custom-header">BEST SELLERS</h3>
    <div class="owl-carousel owl-theme slider">
        @foreach ($topNotch as $item)
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
        Shop More Rugs
    </a>
</section>
