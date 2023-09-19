@php
$enable_featured_image = isset($enable_featured_image) && $enable_featured_image ? true : false;
$enable_thumb_image = isset($enable_thumb_image) && $enable_thumb_image ? true : false;
$enable_banner_image = isset($enable_banner_image) && $enable_banner_image ? true : false;
$featured_image = isset($image_data->featured_image) ? $image_data->featured_image : '';
$thumb_image = isset($image_data->thumb_image) ? $image_data->thumb_image : '';
$banner_image = isset($image_data->banner_image) ? $image_data->banner_image : '';
@endphp
@if ($enable_thumb_image)
    <div class="form-group col-md-6">
        <label for="thumb_image">Thumb Image (370x306 px)</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('thumb_image') is-invalid @enderror" id="thumb_image"
                name="thumb_image" placeholder="Thumb Image URL Here" value="{{ old('thumb_image', $thumb_image) }}">
            <button class="btn btn-primary popup_selector" data-inputid="thumb_image" type="button">
                Select Image
            </button>
            @error('thumb_image')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>
@endif
@if ($enable_featured_image)
    <div class="form-group col-md-6">
        <label for="featured_image">Featured Image (770x430 px)</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image"
                name="featured_image" placeholder="Feature Image URL Here"
                value="{{ old('featured_image', $featured_image) }}">
            <button class="btn btn-primary popup_selector" data-inputid="featured_image" type="button">
                Select Image
            </button>
            @error('featured_image')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>
@endif
@if ($enable_banner_image)
    <div class="form-group col-md-6">
        <label for="banner_image">Banner Image (1894x328 px)</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image"
                name="banner_image" placeholder="Banner Image URL Here"
                value="{{ old('banner_image', $banner_image) }}">
            <button class="btn btn-primary popup_selector" data-inputid="banner_image" type="button">
                Select Image
            </button>
            @error('banner_image')
                <span class=" invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>
@endif
