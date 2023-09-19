@extends('Frontend.layouts.app')
@section('body')
    @include('Frontend.page.includes.banner', ['sublink' => 'Product', 'prev' => 'products'])
    <div class="container pt-5">
        <div class="single-tour-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="single-tour-inner">
                            <h2>{{ $product->title }}</h2>
                            <figure class="feature-image">
                                <img style="width: 100%;"
                                    src="{{ !$product->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($product->thumb_image, 'http') ? $product->thumb_image : '/' . $product->thumb_image) }}"
                                    alt="">
                                <div class="package-meta text-center">
                                    <ul>
                                        <li>
                                            <i class="far fa-clock"></i>
                                            Available: 15
                                        </li>
                                        <li>
                                            <i class="fas fa-user-friends"></i>
                                            Size: 4m<sup>2</sup>
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marked-alt"></i>
                                            {{ $product->category($product->category) }}
                                        </li>
                                    </ul>
                                </div>
                            </figure>
                            @if ($product->imga || $product->imgb || $product->imgc || $product->imgd)
                            @endif
                            <div class="single-tour-gallery">
                                {{-- <h3>GALLERY / PHOTOS</h3> --}}
                                <div class="single-tour-slider">
                                    @if ($product->imga)
                                        <div class="single-tour-item">
                                            <figure class="feature-image">
                                                <img src="{{ str_starts_with($product->imga, 'http') ? $product->imga : '/' . $product->imga }}"
                                                    alt="">
                                            </figure>
                                        </div>
                                    @endif
                                    @if ($product->imgb)
                                        <div class="single-tour-item">
                                            <figure class="feature-image">
                                                <img src="{{ str_starts_with($product->imgb, 'http') ? $product->imgb : '/' . $product->imgb }}"
                                                    alt="">
                                            </figure>
                                        </div>
                                    @endif
                                    @if ($product->imgc)
                                        <div class="single-tour-item">
                                            <figure class="feature-image">
                                                <img src="{{ str_starts_with($product->imgc, 'http') ? $product->imgc : '/' . $product->imgc }}"
                                                    alt="">
                                            </figure>
                                        </div>
                                    @endif
                                    @if ($product->imgd)
                                        <div class="single-tour-item">
                                            <figure class="feature-image">
                                                <img src="{{ str_starts_with($product->imgd, 'http') ? $product->imgd : '/' . $product->imgd }}"
                                                    alt="">
                                            </figure>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-container">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview"
                                            role="tab" aria-controls="overview" aria-selected="true">DESCRIPTION</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab"
                                            aria-controls="review" aria-selected="false">REVIEW</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                        aria-labelledby="overview-tab">
                                        <div class="overview-content">
                                            {!! $product->description !!}

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="program" role="tabpanel" aria-labelledby="program-tab">
                                        <div class="itinerary-content">
                                            <h3>Program <span>( 4 days )</span></h3>
                                            <p>Dolores maiores dicta dolore. Natoque placeat libero sunt sagittis debitis?
                                                Egestas non non qui quos, semper aperiam lacinia eum nam! Pede beatae.
                                                Soluta, convallis irure accusamus voluptatum ornare saepe cupidatat.</p>
                                        </div>
                                        <div class="itinerary-timeline-wrap">
                                            <ul>
                                                <li>
                                                    <div class="timeline-content">
                                                        <div class="day-count">Day <span>1</span></div>
                                                        <h4>Ancient Rome Visit</h4>
                                                        <p>Nostra semper ultricies eu leo eros orci porta provident, fugit?
                                                            Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus
                                                            potenti pretium.</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="timeline-content">
                                                        <div class="day-count">Day <span>2</span></div>
                                                        <h4>Classic Rome Sightseeing</h4>
                                                        <p>Nostra semper ultricies eu leo eros orci porta provident, fugit?
                                                            Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus
                                                            potenti pretium.</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="timeline-content">
                                                        <div class="day-count">Day <span>3</span></div>
                                                        <h4>Vatican City Visit</h4>
                                                        <p>Nostra semper ultricies eu leo eros orci porta provident, fugit?
                                                            Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus
                                                            potenti pretium.</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="timeline-content">
                                                        <div class="day-count">Day <span>4</span></div>
                                                        <h4>Italian Food Tour</h4>
                                                        <p>Nostra semper ultricies eu leo eros orci porta provident, fugit?
                                                            Pariatur interdum assumenda, qui aliquip ipsa! Dictum natus
                                                            potenti pretium.</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="review" role="tabpanel" aria-labelledby="review-tab">
                                        {{-- @if (count($product->reviews))
                                            <div class="summary-review">
                                                <div class="review-score">
                                                    <span>4.9</span>
                                                </div>
                                                <div class="review-score-content">
                                                    <h3>
                                                        Excellent
                                                        <span>( Based on 24 reviews )</span>
                                                    </h3>
                                                    <p>Tincidunt iaculis pede mus lobortis hendrerit eveniet impedit aenean
                                                        mauris qui, pharetra rem doloremque laboris euismod deserunt non,
                                                        cupiditate, vestibulum.</p>
                                                </div>
                                            </div>
                                        @endif --}}
                                        <!-- review comment html -->
                                        <div class="comment-area">
                                            @if (count($product->reviews))
                                                <h3 class="comment-title">{{ count($product->reviews) }} Reviews</h3>
                                                <div class="comment-area-inner">
                                                    <ol>
                                                        @foreach ($product->reviews as $review)
                                                            <li>
                                                                <figure class="comment-thumb u-pic">
                                                                    <img class="i-fit"
                                                                        src="{{ !$review->user($review->user)->pic ? '/uploads/defaults/banner.jpg' : (str_starts_with($review->user($review->user)->pic, 'http') ? $review->user($review->user)->pic : '/' . $review->user($review->user)->pic) }}"
                                                                        alt="">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <div class="comment-header">
                                                                        <h5 class="author-name">
                                                                            {{ $review->user($review->user)->name }}</h5>
                                                                        <span
                                                                            class="post-on">{{ \Carbon\Carbon::parse($review->created_at)->format('M d Y') }}</span>
                                                                        <div class="rating-wrap">
                                                                            <div class="rating-start">
                                                                                <span
                                                                                    style="width: {{ ((int) $review->rating / 5) * 100 }}%;"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <p>{{ strip_tags($review->review) }}</p>
                                                                    {{-- <a href="#" class="reply"><i
                                                                    class="fas fa-reply"></i>Reply</a> --}}
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        {{-- <li>
                                                        <ol>
                                                            <li>
                                                                <figure class="comment-thumb">
                                                                    <img src="assets/images/img21.jpg" alt="">
                                                                </figure>
                                                                <div class="comment-content">
                                                                    <div class="comment-header">
                                                                        <h5 class="author-name">John Doe</h5>
                                                                        <span class="post-on">Jana 10 2020</span>
                                                                        <div class="rating-wrap">
                                                                            <div class="rating-start"
                                                                                title="Rated 5 out of 5">
                                                                                <span style="width: 90%"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <p>Officia amet posuere voluptates, mollit montes eaque
                                                                        accusamus laboriosam quisque cupidatat dolor
                                                                        pariatur, pariatur auctor.</p>
                                                                    <a href="#" class="reply"><i
                                                                            class="fas fa-reply"></i>Reply</a>
                                                                </div>
                                                            </li>
                                                        </ol>
                                                    </li> --}}
                                                    </ol>

                                                </div>
                                            @endif

                                            <div class="comment-form-wrap">
                                                <h3 class="comment-title">Leave a Review</h3>
                                                <form class="comment-form" action="javascript:void(0)" method="POST"
                                                    onsubmit="submitReview()">
                                                    <div class="full-width rate-wrap">
                                                        <label>Your rating</label>
                                                        <span id="s1" onclick="setR(1)">
                                                            <i class="far fa-star"></i>
                                                        </span>
                                                        <span id="s2" onclick="setR(2)">
                                                            <i class="far fa-star"></i>
                                                        </span>
                                                        <span id="s3" onclick="setR(3)">
                                                            <i class="far fa-star"></i>
                                                        </span>
                                                        <span id="s4" onclick="setR(4)">
                                                            <i class="far fa-star"></i>
                                                        </span>
                                                        <span id="s5" onclick="setR(5)">
                                                            <i class="far fa-star"></i>
                                                        </span>
                                                        {{-- <i class="far fa-star"></i> --}}
                                                    </div>

                                                    <p>
                                                        <textarea rows="6" placeholder="Your review" style="resize: none;" id="rev"></textarea> <br>
                                                        <small id="revE"></small>
                                                    </p>
                                                    <p>
                                                        <input type="submit" name="submit" value="Submit">
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="package-price special-item">
                                @if ($product->discount)
                                    <div class="badge-dis">
                                        <span>
                                            <strong>{{ $product->discount->type == 'percent' ? $product->discount->value : (int) (((int) $product->discount->value / (int) $product->price) * 100) }}%</strong>
                                            off
                                        </span>
                                    </div>
                                @endif
                                <h5 class="price">
                                    <span>
                                        @if ($product->discount)
                                            <del>Rs.{{ $product->price }}</del>
                                            <ins>Rs.{{ $product->discount->type == 'fixed' ? (int) $product->price - (int) $product->discount->value : (int) $product->price - ((int) $product->discount->value / 100) * $product->price }}</ins>
                                        @else
                                            Rs.{{ $product->price }}
                                        @endif
                                    </span>
                                </h5>
                                <div class="start-wrap">
                                    <div class="rating-start">
                                        <span style="width: {{ ($average / 5) * 100 }}%"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="travel-package-content text-center mb-5" style="background-color:yellow;">
                                <h5>Checkout</h5>
                                <h3>Order Now</h3>
                                <ul class="order-section" id="order">
                                    <li class="order-active" onclick="selectMethod('COD', event)">
                                        <a href="javascript:void(0)"><i class="far fa-arrow-alt-circle-right"></i>Cash On
                                            Delivery</a>
                                    </li>
                                    @foreach ($methods as $method)
                                        <li onclick="selectMethod('{{ $method->code }}', event)">
                                            <a href="javascript:void(0)" {{-- style="color:#34403c;" --}}><i
                                                    class="far fa-arrow-alt-circle-right"></i>{{ $method->method }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                @if (Session::has('user'))
                                    <form action="{{ route('order.check') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value='COD' id="method" name="method">
                                        <input type="hidden" value='{{ $product->id }}' name="product">
                                        <button class="btn btn-warning w-75 mt-4" type="submit">Order</button>
                                        <a class="btn btn-primary mt-4 text-light" href="javascript:void(0)"
                                            style='width:20%;' onclick="addCart()"><i class="fas fa-cart-plus"></i></a>
                                    </form>
                                @else
                                    <button class="btn btn-warning w-75 mt-4" onclick="showLog()">Order</button>
                                    <button class="btn btn-primary mt-4" style='width:20%;' onclick="showLog()"><i
                                            class="fas fa-cart-plus"></i></button>
                                @endif

                            </div>
                            @if (count($similar_prod))
                                <div class="travel-package-content text-center"
                                    style="background-image: url(assets/images/img11.jpg);">
                                    <h5>MORE RUGS</h5>
                                    <h3>SIMILAR RUGS</h3>
                                    <ul>
                                        @foreach ($similar_prod as $p)
                                            <li>
                                                <a href="/product/{{ $p->slug }}"><i
                                                        class="far fa-arrow-alt-circle-right"></i>{{ $p->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-pop-cont" id="log-pop">
        <div class="login-pop">
            <h3>Please Login <span id="exit-log">x</span> </h1>
                <form action="javascript:void(0)">
                    <input type="text" id="unm" placeholder="Username"> <br>
                    <input type="password" id="pwd" placeholder="Password"> <br>
                    <button class="btn btn-primary w-100">Login</button> <br>
                </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let stars = [$('#s1'), $('#s2'), $('#s3'), $('#s4'), $('#s5')];
        let rate = 0;

        function rmvR() {
            rate = 0;
            stars.forEach(element => {
                element.html("<i class='far fa-star'></i>");
            });
        }

        function setR(rt) {
            rmvR();
            stars.forEach(element => {
                if (rate < rt) {
                    element.html("<i class='fa fa-star'></i>");
                }
                rate += 1;
            });

            rate = rt;
        }

        function submitReview() {
            $('#revE').html('');
            let user = '{{ Session::has('user') ? Session::get('user')['unm'] : 0 }}';
            if (user === '0') {
                window.location.replace("/login");
            } else {
                $.ajax({
                    data: {
                        'rating': '' + rate,
                        'product_id': '{{ $product->id }}',
                        'user': user,
                        'review': $('#rev').val(),
                        '_token': '{{ csrf_token() }}'
                    },
                    type: "POST",
                    url: "{{ route('review.store') }}",
                    success: function(response) {
                        if (response.msg == 'success') {
                            toastr['success']('Review Published');
                            $('#rev').val('');
                            rmvR();
                        }
                        if (response.msg === 'error') {
                            $('#revE').html(response.errors.review[0]);
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }

        }
    </script>
    <script>
        function selectMethod(code, event) {
            $.each($('#order li'), function(index, element) {
                element.classList.remove('order-active');
            });
            event.target.classList.add('order-active');
            $('#method').val(code);
        }

        function showLog() {
            $('#log-pop').css('display', 'flex');
        }
        $('#exit-log').click(() => {
            $('#log-pop').css('display', 'none');
        });
        $('#log-pop form').on('submit', () => {
            $('#log-pop button').attr('disabled', true);
            $.ajax({
                data: {
                    'username': $('#unm').val(),
                    'password': $('#pwd').val(),
                    'page': true,
                    '_token': '{{ csrf_token() }}'
                },
                type: "POST",
                url: "{{ route('customer.access', 'fun=login') }}",
                success: function(response) {
                    if (response.msg == 'success') {
                        toastr['success']('Logged In!');
                        document.location.reload();
                    } else {
                        toastr['error'](response.msg);
                    }
                    $('#log-pop button').removeAttr('disabled');
                },
                error: function(e) {
                    console.log(e);
                    $('#log-pop button').removeAttr('disabled');

                }
            });
        });

        let flag = 0;

        function addCart() {
            if (flag === 0) {
                flag = 1;
                $.ajax({
                    data: {
                        'product': '{{ $product->id }}',
                        '_token': '{{ csrf_token() }}'
                    },
                    type: 'POST',
                    url: "{{ route('customer.addCart') }}",
                    success: function(res) {
                        if (res.cart) {
                            $('.cart-ping').html('Cart(' + res.cart + ')');
                        }
                        toastr['success'](res.action);
                        flag = 0;
                    },
                    error: function(e) {
                        console.log(e);
                        flag = 0;
                    }
                });
            }
        }
    </script>
@endsection
