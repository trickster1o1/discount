<div class="testimonial-section" style="background-image: url({{ asset('Frontend/assets/images/img23.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="testimonial-inner testimonial-slider">
                    @foreach ($testimonials as $testi)
                        <div class="testimonial-item text-center">
                            <figure class="testimonial-img">
                                <img class="i-fit"
                                    src="{{ !$testi->image ? '/uploads/defaults/banner.jpg' : (str_starts_with($testi->image, 'http') ? $testi->image : '/' . $testi->image) }}"
                                    alt="">
                            </figure>
                            <div class="testimonial-content">
                                <p>" {{$testi->message}} "</p>
                                <cite>
                                    {{$testi->name}}
                                    <span class="company">{{$testi->title}}</span>
                                </cite>
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="testimonial-item text-center">
                        <figure class="testimonial-img">
                            <img class="i-fit"
                                src="https://c1.wallpaperflare.com/preview/619/340/14/kids-face-smile-child-happy-cute.jpg"
                                alt="">
                        </figure>
                        <div class="testimonial-content">
                            <p>" Dolorum aenean dolorem minima! Voluptatum? Corporis condimentum ac primis fusce, atque!
                                Vivamus. Non cupiditate natus excepturi, quod quo, aute facere? Deserunt aliquip,
                                egestas ipsum, eu.Dolorum aenean dolorem minima!? Corporis condi mentum acpri! "</p>
                            <cite>
                                William Housten
                                <span class="company">Travel Agent</span>
                            </cite>
                        </div>
                    </div>
                    <div class="testimonial-item text-center">
                        <figure class="testimonial-img">
                            <img class="i-fit"
                                src="https://c1.wallpaperflare.com/preview/619/340/14/kids-face-smile-child-happy-cute.jpg"
                                alt="">
                        </figure>
                        <div class="testimonial-content">
                            <p>" Dolorum aenean dolorem minima! Voluptatum? Corporis condimentum ac primis fusce, atque!
                                Vivamus. Non cupiditate natus excepturi, quod quo, aute facere? Deserunt aliquip,
                                egestas ipsum, eu.Dolorum aenean dolorem minima!? Corporis condi mentum acpri! "</p>
                            <cite>
                                Alison Wright
                                <span class="company">Travel Guide</span>
                            </cite>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
