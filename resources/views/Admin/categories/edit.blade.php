@extends('layouts.app')
@section('title')
    Categories
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Category </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
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

                    <form class="forms-sample" action="{{ route('categories.update', $category) }}" method="POST">
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <input type="hidden" value="categories" name="table">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title"
                                            value="{{ old('title', $category->title) }}">
                                        @error('title')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="slug">Slug*</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                id="slug" name="slug" placeholder="example: burger-house"
                                                value="{{ old('slug', $category->slug) }}">
                                            <button class="btn btn-primary" type="button" onclick="generateSlug()"
                                                id="generate-slug">Generate
                                                Slug</button>
                                            @error('slug')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Category Type">Category Type*</label>
                                        <select
                                            class="form-control form-control @error('category_type') is-invalid @enderror"
                                            name="category_type">
                                            <option value="">Select Category Type</option>
                                            @foreach ($category_types as $category_type)
                                                @if ($category_type->slug == $category->category_type)
                                                    <option value="{{ $category_type->slug }}" selected>
                                                        {{ $category_type->title }}
                                                    </option>
                                                @elseif ($category_type->slug == old('category_type'))
                                                    <option value="{{ $category_type->slug }}" selected>
                                                        {{ $category_type->title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $category_type->slug }}">
                                                        {{ $category_type->title }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('category_type')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tag_line">Tag Line</label>
                                        <input type="text" class="form-control @error('tag_line') is-invalid @enderror"
                                            id="tag_line" name="tag_line" placeholder="Tag Line"
                                            value="{{ old('tag_line', $category->tag_line) }}">
                                        @error('tag_line')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    @include('inputs.file_input', [
                                        'enable_banner_image' => true,
                                        'enable_thumb_image' => true,
                                        'image_data' => $category,
                                    ])

                                    <div class="form-group col-md-6">
                                        <label for="short_descptrion">Short Descprition</label>
                                        <textarea class="form-control @error('short_descptrion') is-invalid @enderror" id="short_description"
                                            name="short_description"
                                            placeholder="Short Descprition"><?php echo $category->short_description; ?></textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="descprition">Descprition</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            placeholder="Descprition"><?php echo $category->description; ?></textarea>
                                        @error('description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="active"
                                                {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade container" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{-- SEO Details --}}
                                @include('inputs.seo', ['seo_detail' => $category])
                                <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
                            </div>
                            <div class="col-md-12">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    window.onload = function() {
        load_ckeditor('description', false);
        load_ckeditor('short_description', true);
    }
</script>
