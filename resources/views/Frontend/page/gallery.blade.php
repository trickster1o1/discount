@extends('Frontend.layouts.app')
@section('body')
    @include('Frontend.page.includes.banner', ['title' => 'Gallery'])

    @if (!count($galleries))
        <h2>Galleries are currently not available.</h2>
    @else
        <div class="gallery-section pt-5">
            <div class="container">
                <div class="gallery-outer-wrap">
                    <div class="gallery-inner-wrap gallery-container grid">

                        @foreach ($galleries as $gallery)
                            <div class="single-gallery grid-item">
                                    <figure class="gallery-img">
                                        <img src="{{ !$gallery->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($gallery->thumb_image, 'http') ? $gallery->thumb_image : '/' . $gallery->thumb_image) }}"
                                            alt="Error404">
                                        <div class="gallery-title">
                                            <h3>
                                                <a href="{{ !$gallery->thumb_image ? '/uploads/defaults/banner.jpg' : (str_starts_with($gallery->thumb_image, 'http') ? $gallery->thumb_image : '/' . $gallery->thumb_image) }}"
                                                    data-lightbox="lightbox-set">
                                                    {{ $gallery->title }}
                                                </a>
                                            </h3>
                                        </div>
                                    </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('script')
    <script src='{{ asset('Frontend/assets/custom.js') }}'></script>

@endsection