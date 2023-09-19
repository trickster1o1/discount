@extends('Frontend.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('Frontend/assets/owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/assets/owl/owl.theme.default.min.css') }}">
@endsection
@if ($homeSetting)
    @section('body')
        @if ($banner)
            @include('Frontend.home.components.banner')
        @endif
        @if ($homeSetting->top_title && count($topNotch))
            @include('Frontend.home.components.top')
        @endif
        @include('Frontend.home.components.category')
        @include('Frontend.home.components.cat2')

        @if ($homeSetting->recent_title && count($recents))
            @include('Frontend.home.components.recents')
        @endif

        {{-- @if (count($banners))
            @include('Frontend.home.components.banner')
        @endif
        @if ($homeSetting->top_title && count($topNotch))
            @include('Frontend.home.components.top')
        @endif
        @if ($homeSetting->popular_title && count($popularProd))
            @include('Frontend.home.components.popular')
        @endif
        @if ($homeSetting->eval_title)
            @include('Frontend.home.components.evaluate')
        @endif
        @if ($homeSetting->offer_title && count($discount))
            @include('Frontend.home.components.offer')
        @endif
        @if ($homeSetting->gallery_title)
            @include('Frontend.home.components.gallery')
        @endif
        @if (count($supporters))
            @include('Frontend.home.components.client')
        @endif
        @if ($homeSetting->special_title)
            @include('Frontend.home.components.specialoffer')
        @endif
        @if ($homeSetting->recent_title && count($recents))
            @include('Frontend.home.components.recents')
        @endif
        @if (count($testimonials))
            @include('Frontend.home.components.feedbacks')
        @endif
        @if ($homeSetting->contact_title)
            @include('Frontend.home.components.contact')
        @endif --}}
    @endsection

@endif
@section('script')
    <script src="{{ asset('Frontend/assets/owl/jquery.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/owl/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('Frontend/assets/owlscripts.js') }}"></script>
@endsection
