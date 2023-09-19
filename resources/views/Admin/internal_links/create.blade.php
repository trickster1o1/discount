@extends('layouts.app')
@section('title')
    Add Internal Link
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Internal Link </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('internal_links.index') }}">Internal Links</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Internal Link</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Internal Link
                                Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">SEO Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('internal_links.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="pages" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title">
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
                                        <label for="tagline">Tag Line</label>
                                        <input type="text" class="form-control @error('tagline') is-invalid @enderror"
                                            id="tagline" name="tagline" placeholder="Tag Line">
                                        @error('tagline')
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

                                    @include('inputs.file_input',array('enable_banner_image'=>true,'enable_thumb_image'=>true))

                                    <div class="form-group col-md-6">
                                        <label for="short_descptrion">Short Descprition</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="featured_image"
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
                                </div>

                            </div>
                            <div class="tab-pane fade container" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{-- SEO Details --}}
                                @include('inputs.seo')
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a class="btn btn-light" href="{{route('internal_links.index')}}">Cancel</a>
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
