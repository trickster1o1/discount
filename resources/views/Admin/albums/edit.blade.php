@extends('layouts.app')
@section('title')
    Albums
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Album </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('albums.index') }}">Albums</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Album</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Album
                                Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                type="button" role="tab" aria-controls="home" aria-selected="true">SEO
                            </button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('albums.update', $album) }}" method="POST">
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                        <div class="row">
                            <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
                            <input type="hidden" value="albums" name="table">
                            <div class="form-group col-md-4">
                                <label for="title">Album Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" placeholder="Title" value="{{ $album->title }}">
                                @error('name')
                                    <span class=" invalid-feedback"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="slug">Slug*</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                        name="slug" placeholder="example: burger-house"
                                        value="{{ old('slug', $album->slug) }}">
                                    <button class="btn btn-primary" type="button" onclick="generateSlug()"
                                        id="generate-slug">Generate
                                        Slug</button>
                                    @error('slug')
                                        <span class="invalid-feedback"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="active"
                                        {{ old('status', $album->status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $album->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback"> {{ $message }} </span>
                                @enderror
                            </div>

                            @include('inputs.text', [
                                ($data = ['tagline', 'Tagline', 'Enter Tagline', 'text', $album->tagline]),
                                ($md = '4'),
                            ])
                            @include('inputs.mediainput', [
                                ($data = ['thumb_image', 'Thumb Image (370x420px)', 'Enter Thumb Image', $album->thumb_image]),
                                ($md = '4'),
                            ])
                            @include('inputs.mediainput', [
                                ($data = ['banner_image', 'Banner Image (1894x328px)', 'Enter Banner Image', $album->banner_image]),
                                ($md = '4'),
                            ])

                            @include('inputs.textarea', [
                                ($data = [
                                    'album_short_description',
                                    'Short Description',
                                    'Enter Short Description',
                                    $album->album_short_description,
                                    'md-6',
                                    '4',
                                ]),
                            ])

                            @include('inputs.textarea', [
                                ($data = [
                                    'album_description',
                                    'Description',
                                    'Enter Description',
                                    $album->album_description,
                                    'md-6',
                                    '4',
                                ]),
                            ])

                            <div class="form-group col-md-12">
                                <center>
                                    <h4>Add/Edit Images</h4>
                                </center>
                            </div>
                            {{-- multiple inputs for images --}}
                            <div class="form-group col-md-12" id="image_multiple"
                                style="padding-left:0px; padding-right:0px;">
                                @php
                                    $data['data_image_url']     = '';
                                    $data['data_image_title']   = '';
                                    $data['data_description']   = '';
                                    $data['data_order_by']      = '';
                                    $data['data_video_url']     = '';
                                    $data['url_id']             = 0; //for unique id
                                @endphp
                                @if ($post_image_url != null)
                                    @foreach ($post_image_url as $k => $v)
                                        @php
                                            $data['url_id']             = $k;
                                            $data['data_image_url']     = $v;
                                            $data['data_image_url']     = $post_video_url[$k];
                                            $data['data_image_title']   = $post_image_title[$k];
                                            $data['data_description']   = $post_description[$k];
                                            $data['data_order_by']      = $post_order_by[$k];
                                        @endphp
                                        @include('Admin.albums.album_images', $data)
                                    @endforeach
                                @elseif (count($gallaries) > 0)
                                    @foreach ($gallaries as $k => $gallary)
                                        @php
                                            $data['url_id']             = $k;
                                            $data['data_image_url']     = $gallary->image_url;
                                            $data['data_image_title']   = $gallary->title;
                                            $data['data_description']   = $gallary->description;
                                            $data['data_video_url']     = $gallary->video_url;
                                            $data['data_order_by']      = $gallary->order_by;
                                        @endphp
                                        @include('Admin.albums.album_images', $data)
                                    @endforeach
                                @else
                                    @include('Admin.albums.album_images', $data)
                                @endif
                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade show container" id="seo" role="tabpanel"
                    aria-labelledby="home-tab">
                    @include('inputs.seo', ['seo_detail' => $album])


                    </div>

                            <div class="col-md-12">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a class="btn btn-light" href="{{ route('albums.index') }}">Cancel</a>
                            </div>
                        </div>
                            
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var i = 0;
            $(".btn-success").click(function() {
                i++;
                var additional_images =
                    '<div class="clone increment hide">' +
                    '<div class="hdtuto control-group lst input-group" style="margin-top:10px">' +
                    ' <div class="form-group col-md-4">' +
                    '<div class="input-group md-3">' +
                    '<input type="text" class="form-control " id="image_urls_' + i +
                    '" name="image_url[]" placeholder="Image URL*">' +
                    '<button class="btn btn-primary popup_selector"data-inputid = "image_urls_' + i +
                    '" type = "button" >Select Image</button>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<input type="text" class="form-control" name="image_title[]" placeholder="Title">' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<input type="text" class="form-control" name="video_url[]" placeholder="Video Url">' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<textarea class="form-control" rows="1" name="description[]" placeholder="Description"></textarea>' +
                    '</div>' +
                    '<div class="input-group-btn col-md-4">' +
                    '<div class="input-group md-3">' +
                    '<input type="number"  placeholder="Image Order" class="form-control" name="order_by[]" value="">' +
                    '<button class="btn btn-danger" type="button" title="Remove Image"> <i class="fa fa-trash"></i></button><div>' +
                    '</div>' +
                    '</div>';
                $("#image_multiple").append(additional_images);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).closest(".clone").remove();
            });
        });
    </script>
@endsection
