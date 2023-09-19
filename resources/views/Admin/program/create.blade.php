@extends('layouts.app')
@section('title')
    Program
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Program </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('program.index') }}">Program</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Program</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Program
                                Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                type="button" role="tab" aria-controls="home" aria-selected="true">SEO
                                </button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('program.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="events" name="table">
                                    @include('inputs.text',$data=['title','Title*','Enter Title','text'])
                                    @include('inputs.slug', [($data = '')])
                                    <div class="form-group col-md-6">
                                        <label for="category">Category *</label>
                                        <select class="form-control @error('category') is-invalid @enderror" name="category"
                                            id="category">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sub_category">Sub Category *</label>
                                        <input type="hidden" id="old_subcategory" value="{{ old('sub_category') }}">
                                        <select class="form-control @error('sub_category') is-invalid @enderror"
                                            name="sub_category" id="sub_category">
                                            <option>Select Sub-category</option>
                                        </select>
                                        @error('sub_category')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    

                                    @include('inputs.mediainput',$data=['thumb_image','Thumb Image (370x306 px)','Upload Thumb Image',''])
                                    @include('inputs.mediainput',$data=['banner_image','Banner Image (1894x328 px)','Upload Banner Image',''])

                                    @include('inputs.mediainput',$data=['featured_image','Featured Image (770x430 px)','Upload Featured Image',''])

                                    @include('inputs.mediainput',$data=['attached_file_url','Attach File','Upload Attachment',''])
                                    @include('inputs.selects',[$data=['is_featured','Is Featured'], $option=['Yes','No'], $default='No'])
                                    
                                    
                                    @include('inputs.selectss',[$data=['gallery_id','Gallery'], $option=$galleries, $default=''])
                                    @include('inputs.date',$data=['start_date','Start Date'])
                                    @include('inputs.time',$data=['start_time','Start Time'])
                                    @include('inputs.date',$data=['end_date','End Date'])
                                    @include('inputs.time',$data=['end_time','End Time'])

                                    @include('inputs.text',$data=['organizer','Organizer','Enter Organizer','text'])

                                    @include('inputs.text',$data=['location','Location','Enter Location','text'])
                                    @include('inputs.text',$data=['target_amount','Target Amount','Enter Target Amount','text'])
                                    @include('inputs.text',$data=['donation_amount','Donated Amount','Enter Donated Amount','text'])
                                    
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
                                     @include('inputs.textarea', [
                                        ($data = [
                                            'short_description',
                                            'Short Description',
                                            'Enter Description',
                                            '',
                                            'md-6',
                                            '4',
                                        ]),
                                    ]) 
                                    
                                    @include('inputs.selects',[$data=['status','Status'], $option=['Active','Inactive'], $default=''])
                                </div>

                            </div>
                            <div class="tab-pane fade show container" id="seo" role="tabpanel"
                                aria-labelledby="home-tab">
                                @include('inputs.seo')
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('program.index') }}" class="btn btn-light">Cancel</a>
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
        load_ckeditor('short_description', true);
    }
</script>
@endsection
