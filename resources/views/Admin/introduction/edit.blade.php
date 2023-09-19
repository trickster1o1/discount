@extends('layouts.app')
@section('title')
    Introduction Setting
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Introduction Setting </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Introduction Setting</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Setting
                                </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="donnation-tab" data-bs-toggle="tab" data-bs-target="#donnation"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Program
                                </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Additional Program
                                </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Content
                                </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="testimonial-tab" data-bs-toggle="tab" data-bs-target="#testimonial"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Testimonial
                                </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="album-tab" data-bs-toggle="tab" data-bs-target="#album"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Album
                                </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="final-tab" data-bs-toggle="tab" data-bs-target="#final"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Final
                                </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="blog-tab" data-bs-toggle="tab" data-bs-target="#blog"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Blog
                                </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-tab" data-bs-toggle="tab" data-bs-target="#tab"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Tab
                                </button>
                        </li> --}}
                    </ul>
                    <form class="forms-sample" action="{{ route('introductionsetting.update',$introduction) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-md-12" id="myTabContent">
                                <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    {{-- Feature Details --}}
                                    <div class="row">
                                        {{-- <input type="hidden" value="introduction_settings" name="table"> --}}
                                        {{-- <h3 class="col-md-12" >Top Banner</h3>
                                            @include('inputs.text',[$data=['banner_title','Banner Title','Enter Banner Title','text',$introduction->banner_title]])
                                            @include('inputs.mediainput',[$data=['banner_image','Banner Image','Enter Banner Image',$introduction->banner_image]]) --}}
                                        
                                        <h3 class="col-md-12" >Content</h3>
                                            @include('inputs.text',[$data=['title','Content Title','Enter Title','text',$introduction->title]])
                                            @include('inputs.text',[$data=['tagline','Content Tagline','Enter Tagline','text',$introduction->tagline]])
                                            @include('inputs.mediainput',[$data=['thumb_image','Content Image (530x491px)','Enter Thumbnail (451x491px)',$introduction->thumb_image]])
                                            
                                            @include('inputs.textarea', [
                                                ($data = [
                                                    'description',
                                                    'Description',
                                                    'Enter Description',$introduction->description,
                                                    'md-6',
                                                    '4',
                                                ]),
                                            ]) 
                                        <h3 class="col-md-12" >Tab Views</h3>
                                            @include('inputs.selectss',[$data=['tabA_content','Content A'], $option=$page, $default=$introduction->tabA_content])                                   
                                            @include('inputs.selectss',[$data=['tabB_content','Content B'], $option=$page, $default=$introduction->tabB_content])                                   
                                            @include('inputs.selectss',[$data=['tabC_content','Content C'], $option=$page, $default=$introduction->tabC_content])                                   

                                        <h3 class="col-md-12" >Second Banner</h3>
                                            @include('inputs.text',[$data=['second_banner_title','Banner Title','Enter Banner Title','text',$introduction->second_banner_title]])
                                            @include('inputs.text',[$data=['second_banner_tagline','Banner Tagline','Enter Banner Tagline','text',$introduction->second_banner_tagline]])
                                            @include('inputs.mediainput',[$data=['second_banner_image','Banner Image (1920x1200px)','Enter Banner Image',$introduction->second_banner_image]])
                                            @include('inputs.text',[$data=['second_banner_button_title','Banner Button Title','Enter Button Title','text',$introduction->second_banner_button_title]])
                                            @include('inputs.text',[$data=['second_banner_button_link','Banner Button Link','Enter Button Link','text',$introduction->second_banner_button_link]])

                                        <h3 class="col-md-12" >Volunteers</h3>
                                            @include('inputs.text',[$data=['volunteer_title','Volunteer Title','Enter Volunteer Title','text',$introduction->volunteer_title]])
                                            @include('inputs.text',[$data=['volunteer_tagline','Volunteer Tagline','Enter Volunteer Tagline','text',$introduction->volunteer_tagline]])
                                        <h3 class="col-md-12" >Testimonial</h3>
                                            @include('inputs.text',[$data=['testimonial_title','Testimonial Title','Enter Testimonial Title','text',$introduction->testimonial_title]])
                                            @include('inputs.text',[$data=['testimonial_tagline','Testimonial Tagline','Enter Testimonial Tagline','text',$introduction->testimonial_tagline]])


                                        <h3 class="col-md-12" >Sections</h3>
                                            <div class="form-group col-md-12">
                                                <label for="service">Supporter Section</label>
                                                <input type="checkbox" id="service" name="supporter" @if($introduction->supporter) checked @endif >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="testimonials">Testimonials Section</label>
                                                <input type="checkbox" id="testimonials" name="testimonials" @if($introduction->testimonials) checked @endif>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="volunteer">Volunteers Section</label>
                                                <input type="checkbox" id="volunteer" name="volunteer" @if($introduction->volunteer) checked @endif>
                                            </div>
                                    </div>

                                </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    window.onload = function() {
        load_ckeditor('description', true);
    }
</script>
@endsection
