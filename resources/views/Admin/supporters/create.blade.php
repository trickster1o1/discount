@extends('layouts.app')
@section('title')
    Our Supporters
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Supporter </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('supporter.index') }}">Supporter</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Supporter</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Supporter
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('supporter.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="supporters" name="table">
                                    @include('inputs.text',$data=['title','Title*','Enter Title','text'])
                                    @include('inputs.text',$data=['website','Website','Enter Website','text'])
                                    @include('inputs.mediainput',$data=['logo','Logo (115x90px)','Upload Logo',''])
                                    @include('inputs.selects',[$data=['status','Status'], $option=['Active','Inactive'], $default=''])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'description',
                                            'Description',
                                            'Enter Description',
                                            '',
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('supporter.index') }}" class="btn btn-light">Cancel</a>
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
    }
</script>
@endsection
