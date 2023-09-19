@extends('layouts.app')
@section('title')
    Notice
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Notice </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('notices.index') }}">Notices</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Notice</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Basic
                                Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">SEO Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('notices.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="notices" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="slug">Slug*</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                id="slug" name="slug" placeholder="example: burger-house"
                                                value="{{ old('slug') }}">
                                            <button class="btn btn-primary" type="button" onclick="generateSlug()"
                                                id="generate-slug">Generate
                                                Slug</button>
                                            @error('slug')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="category">Category *</label>

                                        <select class="form-control @error('category') is-invalid @enderror" name="category"
                                            id="category">
                                            <option>Select Category</option>
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
                                    <div class="form-group col-md-6">
                                        <label for="published_date">Published Date *</label>
                                        <input type="text"
                                            class="datepicker form-control @error('published_date') is-invalid @enderror"
                                            id="published_date" name="published_date" placeholder="yyyy/mm/dd"
                                            value="{{ old('published_date') }}">
                                        @error('published_date')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="expiary_date">Expiary Date</label>
                                        <input type="text" class="datepicker form-control @error('expiary_date') is-invalid @enderror"
                                            id="expiary_date" name="expiary_date" placeholder="yyyy/mm/dd"
                                            value="{{ old('expiary_date') }}">
                                        @error('expiary_date')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="publish_time">Publish Time</label>
                                        <input type="text" class="timepicker form-control @error('publish_time') is-invalid @enderror"
                                            id="publish_time" name="publish_time" placeholder="Publish Time"
                                            value="{{ old('publish_time') }}">
                                        @error('publish_time')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="expiary_time">Expiary Time</label>
                                        <input type="text" class="timepicker form-control @error('expiary_time') is-invalid @enderror"
                                            id="expiary_time" name="expiary_time" placeholder="Expiary Time"
                                            value="{{ old('expiary_time') }}">
                                        @error('expiary_time')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    @include('inputs.file_input', ['enable_featured_image' => true, 'enable_thumb_image' => true,'enable_banner_image'=>true])

                                    <div class="form-group col-md-6">
                                        <label for="attached_file_url">Attached File</label>
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('attached_file_url') is-invalid @enderror"
                                                id="attached_file_url" name="attached_file_url"
                                                placeholder="Attached File URL Here"
                                                value="{{ old('attached_file_url') }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="attached_file_url"
                                                type="button">
                                                Select File
                                            </button>
                                            @error('attached_file_url')
                                                <span class=" invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="short_descptrion">Short Descprition</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_descptrion"
                                            name="short_description"
                                            placeholder="Short Description"><?php echo old('short_description'); ?></textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="descprition">Descprition</label>
                                        <textarea class="form-control @error('descptrion') is-invalid @enderror" id="summary-ckeditor" name="description"
                                            placeholder="Descprition"><?php echo old('description'); ?></textarea>
                                        @error('description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 d-none">
                                        <label for="is_featured">Is Featured</label>
                                        <select class="form-control @error('is_featured') is-invalid @enderror"
                                            id="is_featured" name="is_featured">
                                            <option selected value="">--Select--</option>

                                            <option value="yes" {{ old('is_featured') == 'active' ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="no" {{ old('is_featured') == 'inactive' ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>
                                        @error('is_featured')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 d-none">
                                        <label for="publish_as_popup">Publish As Popup</label>
                                        <select class="form-control @error('publish_as_popup') is-invalid @enderror"
                                            id="publish_as_popup" name="publish_as_popup">
                                            <option selected value="">--Select--</option>
                                            <option value="yes" {{ old('is_featured') == 'active' ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="no" {{ old('is_featured') == 'inactive' ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>
                                        @error('publish_as_popup')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    
                                </div>

                            </div>
                            <div class="tab-pane fade container" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{-- SEO Details --}}
                                @include('inputs.seo')
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('notices.index') }}" class="btn btn-light">Cancel</a>
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
    <script>
        $(".datepicker").inputmask("y-m-d", {
            placeholder: "yyyy-mm-dd"
        });
    </script>
@endsection
