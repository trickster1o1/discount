@extends('layouts.app')
@section('title')
    Newsletter
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Newsletter </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('newsletter.index') }}">Newsletter</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Newsletter</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Newsletter
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('newsletter.update', $newsletter->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                                    <input type="hidden" value="newsletters" name="table">
                                    @include('inputs.text',$data=['title','Title*','Enter Title','text',$newsletter->title])
                                    <div class="d-none">@include('inputs.date',$data=['date','Date*',$newsletter->date])</div>
                                    @include('inputs.mediainput',$data=['thumb_image','Thumb Image (370x420 px) *','Enter Thumb Image',$newsletter->thumb_image])
                                    @include('inputs.mediainput',$data=['attachment','Attachment *','Enter Your Attachment',$newsletter->attachment])
                                    @include('inputs.selects',[$data=['status','Status'], $option=['Active','Inactive'], $default=$newsletter->status])
                                    <div class="d-none">@include('inputs.textarea', [
                                        ($data = [
                                            'description',
                                            'Description',
                                            'Enter Description',
                                            $newsletter->description,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])</div> 
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('newsletter.index') }}" class="btn btn-light">Cancel</a>
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
        load_ckeditor('description', false);
        // load_ckeditor('short_description', true);
    }
</script>
@endsection
