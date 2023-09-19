@extends('layouts.app')
@section('title')
    Testimonial
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Testimonial </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">Testimonials</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Testimonial</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('testimonial.update',$testimonial->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
                                    <input type="hidden" value="testimonials" name="table">
                                    @include('inputs.text',$data=['name','Name*','Enter Name','text',$testimonial->name])
                                    @include('inputs.mediainput',$data=['image','Image (73x73px)','Upload Image',$testimonial->image])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'message',
                                            'Message*',
                                            'Enter Message',$testimonial->message,
                                            'md-6',
                                            '4',
                                        ]),
                                    ]) 
                                    @include('inputs.selects',[$data=['status','Status*'],$option=['Active','Inactive'],$default=$testimonial->status])
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('testimonial.index') }}" class="btn btn-light">Cancel</a>
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
    // window.onload = function() {
    //     load_ckeditor('description', false);
    //     load_ckeditor('short_description', true);
    // }
</script>
@endsection
