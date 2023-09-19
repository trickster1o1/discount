<section class="callback-section">
    <div class="container">
        <div class="row no-gutters align-items-center">
            <div class="col-lg-5">
                <div class="callback-img"
                    style="background-image: url('{{ !$homeSetting->eval_thumb ? '/uploads/defaults/banner.jpg' : (str_starts_with($homeSetting->eval_thumb, 'http') ? $homeSetting->eval_thumb : '/' . $homeSetting->eval_thumb) }}');">
                    @if ($homeSetting->eval_video)
                        <div class="video-button">
                            <a id="video-container" data-video-id="{{$homeSetting->eval_video}}">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="callback-inner">
                    <div class="section-heading section-heading-white">
                        <h5 class="dash-style">{{ $homeSetting->eval_tag_line }}</h5>
                        <h2>{{ $homeSetting->eval_title }}</h2>
                        <p>{{ $homeSetting->eval_desc }}</p>
                    </div>
                    <div class="callback-counter-wrap">
                        <div class="counter-item">
                            <div class="counter-icon">
                                <img src="{{ asset('Frontend/assets/images/icon1.png') }}" alt="">
                            </div>
                            <div class="counter-content">
                                <span class="counter-no">
                                    <span class="counter">500</span>K+
                                </span>
                                <span class="counter-text">
                                    Satisfied Clients
                                </span>
                            </div>
                        </div>
                        <div class="counter-item">
                            <div class="counter-icon">
                                <img src="{{ asset('Frontend/assets/images/icon2.png') }}" alt="">
                            </div>
                            <div class="counter-content">
                                <span class="counter-no">
                                    <span class="counter">250</span>K+
                                </span>
                                <span class="counter-text">
                                    Satisfied Clients
                                </span>
                            </div>
                        </div>
                        <div class="counter-item">
                            <div class="counter-icon">
                                <img src="{{ asset('Frontend/assets/images/icon3.png') }}" alt="">
                            </div>
                            <div class="counter-content">
                                <span class="counter-no">
                                    <span class="counter">15</span>K+
                                </span>
                                <span class="counter-text">
                                    Satisfied Clients
                                </span>
                            </div>
                        </div>
                        <div class="counter-item">
                            <div class="counter-icon">
                                <img src="{{ asset('Frontend/assets/images/icon4.png') }}" alt="">
                            </div>
                            <div class="counter-content">
                                <span class="counter-no">
                                    <span class="counter">10</span>K+
                                </span>
                                <span class="counter-text">
                                    Satisfied Clients
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="support-area">
                        <div class="support-icon">
                            <img src="{{ asset('Frontend/assets/images/icon5.png') }}" alt="">
                        </div>
                        <div class="support-content">
                            <h4>Our 24/7 Emergency Phone Services</h4>
                            <h3>
                                <a href="#">Call: {{$siteSetting->pri_phone}}</a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
