@extends('layouts.app')

@section('title')
    Media Manager
@endsection

@section('css')
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset($dir . '/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir . '/css/theme.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Media Manager </h3>
    </div>


    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div id="elfinder"></div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="{{ asset($dir . '/js/elfinder.min.js') }}"></script>
    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $(document).ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here

                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url: '{{ route('elfinder.connector') }}', // connector URL
                soundPath: '{{ asset($dir . '/sounds') }}'
            });
        });
    </script>
@endsection
