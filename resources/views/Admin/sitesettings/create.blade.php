@extends('layouts.app')
@section('title')
    Site Settings
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet" />
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #2196f3;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }

    </style>
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Site Settings </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">site settings</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social"
                                type="button" role="tab" aria-controls="social" aria-selected="false">Social Media</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="status-tab" data-bs-toggle="tab" data-bs-target="#status"
                                type="button" role="tab" aria-controls="status" aria-selected="false">Status</button>
                        </li>

                    </ul>
                    <form class="forms-sample" action="{{ route('site_settings.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">

                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- product  main --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Site Title </label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Site Title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Site Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Site Email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pri_phone">Primary Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="pri_phone" name="pri_phone" placeholder="Primary Phone Number"
                                            value="{{ old('pri_phone') }}">
                                        @error('pri_phone')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sec_phone">Secondary Phone Number</label>
                                        <input type="text"
                                            class="form-control @error('sec_phone') is-invalid @enderror"
                                            data-role="tagsinput" name="sec_phone"
                                            value="{{ old('sec_phone') }}">
                                        @error('sec_phone')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pri_email">Primary Email</label>
                                        <input type="email" class="form-control @error('pri_email') is-invalid @enderror"
                                            id="pri_email" name="pri_email" placeholder="Primary Email"
                                            value="{{ old('pri_email') }}">
                                        @error('pri_email')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sec_email">Secondary Email</label>
                                        <input type="text"
                                            class="form-control @error('sec_email') is-invalid @enderror"
                                            data-role="tagsinput" name="sec_email"
                                            value="{{ old('sec_email') }}">
                                        @error('sec_email')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pri_address">Primary Address</label>
                                        <textarea class="form-control @error('pri_address') is-invalid @enderror" id="pri_address" name="pri_address"
                                            placeholder="Primary Address"><?php echo old('pri_address'); ?></textarea>
                                        @error('pri_address')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sec_address">Secondary Address</label>
                                        <textarea class="form-control @error('sec_address') is-invalid @enderror" id="sec_address" name="sec_address"
                                            placeholder="Secondary Address"><?php echo old('sec_address'); ?></textarea>
                                        @error('sec_address')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="primary_logo">Primary Logo (130x96px)</label>
                                        <div class="input-group md-3">
                                            <input type="text" class="form-control @error('primary_logo') is-invalid @enderror"
                                                id="primary_logo" name="primary_logo" placeholder="Primary Logo" value="{{ old('primary_logo') }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="primary_logo"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>
                                        @error('primary_logo')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="secondary_logo">Logo For Mobile (130x96px)</label>
                                        <div class="input-group md-3">
                                            <input type="text" class="form-control @error('secondary_logo') is-invalid @enderror"
                                                id="secondary_logo" name="secondary_logo" placeholder="Select Logo For Mobile" value="{{ old('secondary_logo') }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="secondary_logo"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>
                                        @error('secondary_logo')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="loader">Loader Image (130x96px)</label>
                                        <div class="input-group md-3">
                                            <input type="text" class="form-control @error('loader') is-invalid @enderror"
                                                id="loader" name="loader" placeholder="Loader Image" value="{{ old('loader') }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="loader"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>
                                        @error('secondary_logo')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="url">Website URL</label>
                                        <input type="text" class="form-control @error('url') is-invalid @enderror" id="url"
                                            name="url" placeholder="Website URL" value="{{ old('url') }}">
                                        @error('url')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="google_map_html">Google Map HTML</label>
                                        <textarea class="form-control @error('google_map_html') is-invalid @enderror" name="google_map_html" placeholder="Google Map HTML">{{old('google_map_html')}}</textarea>
                                        @error('google_map_html')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade container" id="social" role="tabpanel" aria-labelledby="social-tab">
                                {{-- Social Info --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fb_link">Facebook link</label>
                                        <input type="text" class="form-control @error('fb_link') is-invalid @enderror"
                                            id="fb_link" name="fb_link" placeholder="Facebook link"
                                            value="{{ old('fb_link') }}">
                                        @error('fb_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="youtube_link">Youtube link</label>
                                        <input type="text" class="form-control @error('youtube_link') is-invalid @enderror"
                                            id="youtube_link" name="youtube_link" placeholder="Youtube link"
                                            value="{{ old('youtube_link') }}">
                                        @error('youtube_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter_link">Twitter link</label>
                                        <input type="text" class="form-control @error('twitter_link') is-invalid @enderror"
                                            id="twitter_link" name="twitter_link" placeholder="Twitter link"
                                            value="{{ old('twitter_link') }}">
                                        @error('twitter_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ig_link">Instagram link</label>
                                        <input type="text" class="form-control @error('ig_link') is-invalid @enderror"
                                            id="ig_link" name="ig_link" placeholder="Instagram link"
                                            value="{{ old('ig_link') }}">
                                        @error('ig_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="linkedin_link">LinkedIn link</label>
                                        <input type="text"
                                            class="form-control @error('linkedin_link') is-invalid @enderror"
                                            id="linkedin_link" name="linkedin_link" placeholder="LinkedIn link"
                                            value="{{ old('linkedin_link') }}">
                                        @error('linkedin_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="viber">Viber Number</label>
                                        <input type="text" class="form-control @error('viber') is-invalid @enderror"
                                            id="viber" name="viber" placeholder="Viber Number"
                                            value="{{ old('viber') }}">
                                        @error('viber')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pintrest_link">Pinterest</label>
                                        <input type="text"
                                            class="form-control @error('pintrest_link') is-invalid @enderror"
                                            id="pintrest_link" name="pintrest_link" placeholder="Pinterest Link"
                                            value="{{ old('pintrest_link') }}">
                                        @error('pintrest_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="skype_link">Skype</label>
                                        <input type="text" class="form-control @error('skype_link') is-invalid @enderror"
                                            id="skype_link" name="skype_link" placeholder="Skype Link"
                                            value="{{ old('skype_link') }}">
                                        @error('skype_link')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="facebook_page_id">Facebook Page ID</label>
                                        <input type="text"
                                            class="form-control @error('facebook_page_id') is-invalid @enderror"
                                            id="facebook_page_id" name="facebook_page_id" placeholder="Facebook Page ID"
                                            value="{{ old('facebook_page_id') }}">
                                        @error('facebook_page_id')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade container" id="mobile" role="tabpanel" aria-labelledby="mobile-tab">
                                {{-- Mobile Info --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="android">Android App Store</label>
                                        <input type="text" class="form-control @error('android') is-invalid @enderror"
                                            id="android" name="android" placeholder="Android App Store"
                                            value="{{ old('android') }}">
                                        @error('android')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ios">Apple App Store</label>
                                        <input type="text" class="form-control @error('ios') is-invalid @enderror" id="ios"
                                            name="ios" placeholder="Apple App Store" value="{{ old('ios') }}">
                                        @error('ios')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade container" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                {{-- SEO Info --}}

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="meta_key">Meta Key</label>
                                        <input type="text" class="form-control @error('meta_key') is-invalid @enderror"
                                            id="meta_key" name="meta_key" placeholder="Meta Key"
                                            value="{{ old('meta_key') }}">
                                        @error('meta_key')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea class="form-control @error('meta_descriotion') is-invalid @enderror" id="meta_description"
                                            name="meta_description"
                                            placeholder="Meta Description"><?php echo old('meta_description'); ?></textarea>
                                        @error('meta_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fb_title">Facebook Title</label>
                                        <input type="text" class="form-control @error('fb_title') is-invalid @enderror"
                                            id="fb_title" name="fb_title" placeholder="Facebook Title"
                                            value="{{ old('fb_title') }}">
                                        @error('fb_title')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter_title">Twitter Title</label>
                                        <input type="text" class="form-control @error('fb_title') is-invalid @enderror"
                                            id="twitter_title" name="twitter_title" placeholder="Twitter Title"
                                            value="{{ old('twitter_title') }}">
                                        @error('twitter_title')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="fb_description">Facebook Description</label>
                                        <textarea class="form-control @error('fb_description') is-invalid @enderror" id="fb_description" name="fb_description"
                                            placeholder="Facebook Description"><?php echo old('fb_description'); ?></textarea>
                                        @error('fb_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter_description">Twitter Description</label>
                                        <textarea class="form-control @error('fb_title') is-invalid @enderror" id="twitter_description"
                                            name="twitter_description"
                                            placeholder="Twitter Description"><?php echo old('twitter_description'); ?></textarea>
                                        @error('twitter_description')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="secondary_logo">Facebook Image</label>
                                        <div class="input-group md-3">
                                            <input type="text" class="form-control @error('fb_image') is-invalid @enderror"
                                                id="fb_image" name="fb_image" placeholder="Select Facebook Image" value="{{ old('fb_image') }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="fb_image"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>
                                        @error('fb_image')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="twitter_image">Twitter Image</label>
                                        <div class="input-group md-3">
                                            <input type="text" class="form-control @error('twitter_image') is-invalid @enderror"
                                                id="twitter_image" name="twitter_image" placeholder="Select Twitter Image" value="{{ old('twitter_image') }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="twitter_image"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>
                                        @error('twitter_image')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                </div>



                            </div>

                            <div class="tab-pane fade container" id="status" role="tabpanel" aria-labelledby="status-tab">
                                {{-- status Info --}}
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="active_status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="online"
                                                {{ old('active_status') == 'offline' ? 'selected' : '' }}>Online</option>
                                            <option value="offline"
                                                {{ old('active_status') == 'offline' ? 'selected' : '' }}>Offline
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="offline_msg">Offline Message</label>
                                        <input type="text" class="form-control @error('offline_msg') is-invalid @enderror"
                                            id="offline_msg" name="offline_msg" placeholder="Offline Message"
                                            value="{{ old('offline_msg') }}">
                                        @error('offline_msg')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
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
            load_ckeditor('pri_address', true);
            load_ckeditor('sec_address', true);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js">
    </script>
@endsection
