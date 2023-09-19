<section class="special-section">
    <div class="container">
        <div class="section-heading text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h5 class="dash-style">{{ $homeSetting->offer_tag_line }}</h5>
                    <h2>{{ $homeSetting->offer_title }}</h2>
                    <p>{{ $homeSetting->offer_desc }}</p>
                </div>
            </div>
        </div>
        <div class="special-inner">
            <div class="row">
                @foreach ($discount as $disc)
                    <div class="col-md-6 col-lg-4">
                        <div class="special-item">
                            <a href="/product/{{ $disc->product->slug }}">
                                <figure class="special-img col-img-size-portrait">
                                    <img class="i-fit"
                                        src="{{ !$disc->product->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($disc->product->thumb_image, 'http') ? $disc->product->thumb_image : '/' . $disc->product->thumb_image) }}"
                                        alt="">
                                </figure>
                            </a>
                            <div class="badge-dis">
                                <span>
                                    <strong>{{ $disc->type == 'percent' ? $disc->value : (int) (((int) $disc->value / (int) $disc->product->price) * 100) }}%</strong>
                                    off
                                </span>
                            </div>
                            <div class="special-content">
                                <div class="meta-cat">
                                    <a
                                        href="/product/{{ $disc->product->slug }}">{{ $disc->product->category($disc->product->category) }}</a>
                                </div>
                                <h3>
                                    <a href="/product/{{ $disc->product->slug }}">{{ $disc->product->title }}</a>
                                </h3>
                                <div class="package-price">
                                    Price:
                                    <del>Rs.{{ $disc->product->price }}</del>
                                    <ins>Rs.{{ $disc->type == 'fixed' ? (int) $disc->product->price - (int) $disc->value : (int) $disc->product->price - ((int) $disc->value / 100) * $disc->product->price }}</ins>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="col-md-6 col-lg-4">
                    <div class="special-item">
                        <figure class="special-img col-img-size-portrait">
                            <img class="i-fit"
                                src="https://cdn.pixelbin.io/v2/black-bread-289bfa/TIw66q/wrkr/t.resize(h:500,w:500)/data/Westelm/10feb2022/8055133_2.jpg"
                                alt="">
                        </figure>
                        <div class="badge-dis">
                            <span>
                                <strong>15%</strong>
                                off
                            </span>
                        </div>
                        <div class="special-content">
                            <div class="meta-cat">
                                <a href="#">NEW ZEALAND</a>
                            </div>
                            <h3>
                                <a href="#">Trekking to the mountain camp site</a>
                            </h3>
                            <div class="package-price">
                                Price:
                                <del>Rs.1300</del>
                                <ins>Rs.1105</ins>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="special-item">
                        <figure class="special-img col-img-size-portrait">
                            <img class="i-fit" class="i-fit"
                                src="https://images.thdstatic.com/productImages/7e026c64-cf32-443a-95b7-ec55aedc07ff/svn/grey-ivory-home-dynamix-area-rugs-10-7069-451-31_600.jpg"
                                alt="">
                        </figure>
                        <div class="badge-dis">
                            <span>
                                <strong>15%</strong>
                                off
                            </span>
                        </div>
                        <div class="special-content">
                            <div class="meta-cat">
                                <a href="#">MALAYSIA</a>
                            </div>
                            <h3>
                                <a href="#">Sunset view of beautiful lakeside city</a>
                            </h3>
                            <div class="package-price">
                                Price:
                                <del>Rs.1800</del>
                                <ins>Rs.1476</ins>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>
