@extends('Frontend.layouts.app')
@section('body')
    @include('Frontend.page.includes.banner', ['title' => isset($cTitle) ? $cTitle : 'Products'])
    <div class="container">
        @if (count($products))
            <div class="guide-page-section">
                <div class="container pt-5">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <a href="/product/{{ $product->slug }}">
                                    <div class="guide-content-wrap text-center">
                                        <figure class="guide-image prod-thumb">
                                            <img class="i-fit"
                                                src="{{ !$product->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($product->thumb_image, 'http') ? $product->thumb_image : '/' . $product->thumb_image) }}"
                                                alt="xaina">
                                        </figure>
                                        <div class="guide-content">
                                            <h3>{{ strtoupper($product->title) }}</h3>
                                            <h5>
                                                @if ($product->discount)
                                                    <del>Rs.{{ $product->price }}</del>
                                                    <ins>Rs.{{ $product->discount->type == 'fixed' ? (int) $product->price - (int) $product->discount->value : (int) $product->price - ((int) $product->discount->value / 100) * $product->price }}</ins>
                                                @else
                                                    Rs.{{ $product->price }}
                                                @endif
                                            </h5>
                                            @if ($product->short_description)
                                                <p>
                                                    {{ substr(strip_tags($product->short_description), 0, 90) . '...' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @else
            <h2 class="text-center pt-5 pb-5">No Rugs Available Currently.</h2>
        @endif
    </div>
@endsection
