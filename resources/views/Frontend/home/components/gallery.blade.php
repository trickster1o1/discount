<section class="best-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="section-heading">
                    <h5 class="dash-style">{{ $homeSetting->gallery_tag_line }}</h5>
                    <h2>{{ $homeSetting->gallery_title }}</h2>
                    <p>{{ $homeSetting->gallery_desc }}</p>
                </div>
                @if ($homeSetting->gallery_imgA)
                    <figure class="gallery-img g-l">
                        <img class="i-fit"
                            src="{{ str_starts_with($homeSetting->gallery_imgA, 'http') ? $homeSetting->gallery_imgA : '/' . $homeSetting->gallery_imgA }}"
                            alt="">
                    </figure>
                @endif

            </div>
            <div class="col-lg-7">
                <div class="row">
                    @if ($homeSetting->gallery_imgB)
                        <div class="{{$homeSetting->gallery_imgC ? 'col-sm-6' : 'col-sm-12'}}">
                            <figure class="gallery-img g-small">
                                <img class="i-fit"
                                    src="https://i5.walmartimages.com/asr/ca908866-9529-4fc7-81ba-32177eff7907_2.fe507a00388d6a355ec3908b3439e337.jpeg?odnHeight=768&odnWidth=768&odnBg=FFFFFF"
                                    alt="">
                            </figure>
                        </div>
                    @endif
                    @if ($homeSetting->gallery_imgC)
                        <div class="{{$homeSetting->gallery_imgB ? 'col-sm-6' : 'col-sm-12'}}">
                            <figure class="gallery-img g-small">
                                <img class="i-fit"
                                    src="https://assets.wfcdn.com/im/76152669/compr-r85/2171/217186901/premium-indoor-outdoor-mat-rubber-backing-non-slip-super-absorbent-resist-dirt-entrance-rug.jpg"
                                    alt="">
                            </figure>
                        </div>
                    @endif

                </div>

                @if ($homeSetting->gallery_imgD)
                    <div class="row">
                        <div class="col-12">
                            <figure class="gallery-img g-xl">
                                <img class="i-fit"
                                    src="https://www.fcainc.com/wp-content/uploads/2022/03/Area-Rug-Main-Image.jpg"
                                    alt="">
                            </figure>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
