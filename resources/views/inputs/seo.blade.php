<!--not necessary steps-->
@php
$meta_key = isset($seo_detail->meta_key) ? $seo_detail->meta_key : '';
$meta_description = isset($seo_detail->meta_description) ? $seo_detail->meta_description : '';
$fb_title = isset($seo_detail->fb_title) ? $seo_detail->fb_title : '';
$twitter_title = isset($seo_detail->twitter_title) ? $seo_detail->twitter_title : '';
$fb_description = isset($seo_detail->fb_description) ? $seo_detail->fb_description : '';
$twitter_description = isset($seo_detail->twitter_description) ? $seo_detail->twitter_description : '';
$fb_image = isset($seo_detail->fb_image) ? $seo_detail->fb_image : '';
$twitter_image = isset($seo_detail->twitter_image) ? $seo_detail->twitter_image : '';
@endphp
<div class="row">
    <div class="form-group col-md-6">
        <label for="meta_key">Meta Key</label>
        <input type="text" class="form-control @error('meta_key') is-invalid @enderror" id="meta_key" name="meta_key"
            placeholder="Meta Key" value="{{ old('meta_key', $meta_key) }}">
        @error('meta_key')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="meta_description">Meta Description</label>
        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
            name="meta_description" placeholder="Meta Description"><?php echo old('meta_description', $meta_description); ?></textarea>
        @error('meta_description')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="fb_title">Facebook Title</label>
        <input type="text" class="form-control @error('fb_title') is-invalid @enderror" id="fb_title" name="fb_title"
            placeholder="Facebook Title" value="{{ old('fb_title', $fb_title) }}">
        @error('fb_title')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="twitter_title">Twitter Title</label>
        <input type="text" class="form-control @error('fb_title') is-invalid @enderror" id="twitter_title"
            name="twitter_title" placeholder="Twitter Title" value="{{ old('twitter_title', $twitter_title) }}">
        @error('twitter_title')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="fb_description">Facebook Description</label>
        <textarea class="form-control @error('fb_description') is-invalid @enderror" id="fb_description" name="fb_description"
            placeholder="Facebook Description"><?php echo old('fb_description', $fb_description); ?></textarea>
        @error('fb_description')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="twitter_description">Twitter Description</label>
        <textarea class="form-control @error('twitter_description') is-invalid @enderror" id="twitter_description"
            name="twitter_description" placeholder="Twitter Description"><?php echo old('twitter_description', $twitter_description); ?></textarea>
        @error('twitter_description')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="fb_title">Facebook Image</label>
        <div class="input-group md-3">
            <input type="text" class="form-control @error('fb_image') is-invalid @enderror" id="fb_image"
                name="fb_image" placeholder="Facebook Image URL Here" value="{{ old('fb_image', $fb_image) }}">
            <button class="btn btn-primary popup_selector" data-inputid="fb_image" type="button">
                Select Image
            </button>
        </div>
        @error('fb_image')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="twitter_title">Twitter Image</label>
        <div class="input-group md-3">
            <input type="text" class="form-control @error('twitter_image') is-invalid @enderror" id="twitter_image"
                name="twitter_image" placeholder="Facebook Image URL Here"
                value="{{ old('twitter_image', $twitter_image) }}">
            <button class="btn btn-primary popup_selector" data-inputid="twitter_image" type="button">
                Select Image
            </button>
        </div>
        @error('twitter_image')
            <span class="invalid-feedback"> {{ $message }} </span>
        @enderror
    </div>


</div>
