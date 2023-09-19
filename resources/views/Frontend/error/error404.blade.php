@extends('Frontend.layouts.app')
@section('body')
    <!--Error Page Start-->
    <section>
        <div class="error-page">
            <img src="/uploads/error404.png" alt="Error404">
            <a href="{{url()->previous()}}">Go Back</a>
        </div>
    </section>
    <!--Error Page End-->
@endsection
