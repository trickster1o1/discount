@extends('layouts.app')
@section('title')
    Services
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Service </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Service</li>
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
                    <form class="forms-sample" action="{{ route('services.update', $service) }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="services" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title"
                                            value="{{ old('title', $service->title) }}">
                                        @error('title')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="slug">Slug*</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                id="slug" name="slug" placeholder="example: burger-house"
                                                value="{{ old('slug', $service->slug) }}">
                                            <button class="btn btn-primary" type="button" onclick="generateSlug()"
                                                id="generate-slug">Generate
                                                Slug</button>
                                            @error('slug')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="icon_class">Icon Class</label>
                                        <input type="text" class="form-control @error('icon_class') is-invalid @enderror"
                                            id="icon_class" name="icon_class" placeholder="Icon Class" value="{{ old('icon_class',$service->icon_class) }}">
                                        @error('icon_class')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                        <i class="text-info">Eg: fa fa-users <a href="https://fontawesome.com/v5/search" target="_blank">Click here to choose icons</a></i>
                                    </div>

                                    @include('inputs.file_input', [
                                        'enable_banner_image' => true,
                                        'enable_thumb_image' =>true,
                                        'enable_featured_image' =>true,
                                        'image_data' => $service,
                                    ])

                                    <div class="form-group col-md-6 d-none">
                                        <label for="gallery_id">Gallary</label>
                                        <select class="form-control @error('gallery_id') is-invalid @enderror"
                                            id="gallery_id" name="gallery_id">
                                            <option value="">Select</option>
                                            @foreach ($albums as $album)
                                                <option value="{{ $album->id }}"
                                                    {{ old('gallary_id', $service->gallary_id) == $album->id ? 'selected' : '' }}>
                                                    {{ $album->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('gallery_id')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="short_descptrion">Short Descprition</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_descptrion"
                                            name="short_description"
                                            placeholder="Short Description"><?php echo old('short_description', $service->short_description); ?></textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="descprition">Descprition</label>
                                        <textarea class="form-control @error('descptrion') is-invalid @enderror" id="summary-ckeditor" name="description"
                                            placeholder="Descprition"><?php echo old('description', $service->description); ?></textarea>
                                        @error('description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 d-none">
                                        <label for="related_services">Related Services</label>
                                        <select class="form-control select2 @error('related_services') is-invalid @enderror"
                                            id="related_services" name="related_services[]" multiple style="width: 100%">
                                            @foreach ($services as $rs)
                                                <option value="{{ $rs->id }}"
                                                    @if (old('related_services') != null && in_array($rs->id, old('related_services'))) selected
                                                    @elseif(old('related_services') == null && strpos($service->related_services, $rs->id) !== false)
                                                    selected @endif>
                                                    {{ $rs->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('related_services')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="is_featured">Is Featured</label>
                                        <select class="form-control @error('is_featured') is-invalid @enderror"
                                            id="is_featured" name="is_featured">

                                            <option value="Yes"
                                                {{ old('is_featured', $service->is_featured) == 'Yes' ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="No"
                                                {{ old('is_featured', $service->is_featured) == 'No' ? 'selected' : '' }}>
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
                                            <option value="active"
                                                {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>
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
                                @include('inputs.seo', ['seo_detail' => $service])
                            </div>
                            <div class="col-md-12">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a href="{{ route('services.index') }}" class="btn btn-light">Cancel</a>
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
