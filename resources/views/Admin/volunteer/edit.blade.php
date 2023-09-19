@extends('layouts.app')
@section('title')
    Volunteer
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Volunteer </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('volunteer.index') }}">Donner</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Volunteer</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Volunteer
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('volunteer.update', $volunteer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="volunteers" name="table">
                                <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
                                    @include('inputs.text',$data=['fullName','Full Name*','Enter Full Name','text',$volunteer->fullName])
                                    @include('inputs.text',$data=['number','Phone Number*','Enter Phone Number','text',$volunteer->number])
                                    @include('inputs.text',$data=['email','Email*','Enter Email Address','email',$volunteer->email])
                                    @include('inputs.text',$data=['address','Address*','Enter Address','text',$volunteer->address])
                                    @include('inputs.date',$data=['dob','Date Of Birth',$volunteer->dob])
                                    @include('inputs.text',$data=['occupation','Occupation','Enter Occupation','text',$volunteer->occupation])
                                    @include('inputs.mediainput',$data=['image','Picture (370x412px)','Upload Your Image',$volunteer->image])
                                    @include('inputs.mediainput',$data=['attachment','Attachment','Link The File',$volunteer->attachment])

                                    @include('inputs.selects',[$data=['accepted','Accepted'], $option=['Yes','No'], $default=$volunteer->accepted])

                                    @include('inputs.selects',[$data=['status','Status'], $option=['Active','Inactive'], $default=$volunteer->status])
                                    
                                    {{-- @include('inputs.file_input',array('enable_featured_image'=>true,'enable_thumb_image'=>true)) --}}
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('volunteer.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

