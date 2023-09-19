@extends('Frontend.layouts.app')
@section('body')
    @include('Frontend.page.includes.banner')
    <div class="container pt-5 pb-5">
        {!! $linkData->description !!}
@endsection
