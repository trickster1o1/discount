@extends('layouts.app')
@section('title')
    Donner
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Donner </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('donner.index') }}">Donner</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Donner</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Donner
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('donner.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="donners" name="table">
                                    <input type="hidden" value="none" name="donationProgram">
                                    @include('inputs.text',$data=['fullName','Full Name*','Enter Full Name','text'])
                                    @include('inputs.text',$data=['number','Phone Number*','Enter Phone Number','text'])
                                    @include('inputs.text',$data=['email','Email*','Enter Email Id','email'])
                                    @include('inputs.text',$data=['amount','Donated Amount*','Enter Donated Amount','number'])
                                    @include('inputs.text',$data=['position','Designation','Enter Position','text'])
                                    @include('inputs.mediainput',$data=['image','Picture (370x412px)','Upload Your Image',''])
                                    @include('inputs.selectss',[$data=['paymentMethod','Payment Method'], $option=$payments, $default=''])
                                    @include('inputs.selects',[$data=['status','Status'], $option=['Active','Inactive'], $default=''])
                                    
                                    {{-- @include('inputs.file_input',array('enable_featured_image'=>true,'enable_thumb_image'=>true)) --}}
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('donner.index') }}" class="btn btn-light">Cancel</a>
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
