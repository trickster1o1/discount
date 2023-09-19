@extends('layouts.app')
@section('title')
    Edit Internal Link
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Internal Link </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('internal_links.index') }}">Internal Links</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Internal Link</li>
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
                    <form class="forms-sample" action="{{ route('internal_links.update', $internal_link) }}"
                        method="POST">
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="pages" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title"
                                            value="{{ old('title', $internal_link->title) }}">
                                        @error('title')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="slug">Slug*</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                id="slug" name="slug" placeholder="example: burger-house"
                                                value="{{ old('slug',$internal_link->slug) }}">
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
                                            id="tagline" name="tagline" placeholder="Tag Line"
                                            value="{{ old('tagline', $internal_link->tagline) }}">
                                        @error('tagline')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="active"
                                                {{ old('status', $internal_link->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $internal_link->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    @include('inputs.file_input', [
                                        'enable_banner_image' => true,
                                        'enable_thumb_image' => true,
                                        'image_data' => $internal_link,
                                    ])

                                    <div class="form-group col-md-6">
                                        <label for="short_descptrion">Short Descprition</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="featured_image"
                                            name="short_description"
                                            placeholder="Short Description"><?php echo old('short_description', $internal_link->short_description); ?></textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="descprition">Descprition</label>
                                        <textarea class="form-control @error('descptrion') is-invalid @enderror" id="summary-ckeditor" name="description"
                                            placeholder="Descprition"><?php echo old('description', $internal_link->description); ?></textarea>
                                        @error('description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade container" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{-- SEO Details --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="meta_key">Meta Key</label>
                                        <input type="text" class="form-control @error('meta_key') is-invalid @enderror"
                                            id="meta_key" name="meta_key" placeholder="Meta Key"
                                            value="{{ old('meta_key', $internal_link->meta_key) }}">
                                        @error('meta_key')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_description">Meta Description</label>
                                        <input type="text"
                                            class="form-control @error('meta_descriotion') is-invalid @enderror"
                                            id="meta_description" name="meta_description" placeholder="Meta Description"
                                            value="{{ old('meta_descriotion', $internal_link->meta_description) }}">
                                        @error('meta_descriotion')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fb_title">Facebook Title</label>
                                        <input type="text" class="form-control @error('fb_title') is-invalid @enderror"
                                            id="fb_title" name="fb_title" placeholder="Facebook Title"
                                            value="{{ old('fb_title', $internal_link->fb_title) }}">
                                        @error('fb_title')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter_title">Twitter Title</label>
                                        <input type="text" class="form-control @error('fb_title') is-invalid @enderror"
                                            id="twitter_title" name="twitter_title" placeholder="Twitter Title"
                                            value="{{ old('twitter_title', $internal_link->twitter_title) }}">
                                        @error('twitter_title')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fb_description">Facebook Description</label>
                                        <textarea class="form-control @error('fb_description') is-invalid @enderror" id="fb_description" name="fb_description"
                                            placeholder="Facebook Description"><?php echo old('fb_description', $internal_link->fb_description); ?></textarea>
                                        @error('fb_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter_description">Twitter Description</label>
                                        <textarea class="form-control @error('twitter_description') is-invalid @enderror" id="twitter_description"
                                            name="twitter_description"
                                            placeholder="Twitter Description"><?php echo old('twitter_description', $internal_link->twitter_description); ?></textarea>
                                        @error('twitter_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fb_title">Facebook Image</label>
                                        <input type="text" class="form-control @error('fb_image') is-invalid @enderror"
                                            id="fb_image" name="fb_image" placeholder="Facebook Image URL Here"
                                            value="{{ old('fb_image', $internal_link->fb_image) }}">
                                        @error('fb_image')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter_image">Twitter Image</label>
                                        <input type="text"
                                            class="form-control @error('twitter_image') is-invalid @enderror"
                                            id="twitter_image" name="twitter_image" placeholder="Twitter Image URL Here"
                                            value="{{ old('twitter_image', $internal_link->twitter_image) }}">
                                        @error('twitter_image')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a class="btn btn-light" href="{{route('internal_links.index')}}">Cancel</a>
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
