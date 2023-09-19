@extends('layouts.app')
@section('title')
    Home Setting
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Update Home Setting </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Homesetting</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">
                                Top Sellers
                                {{-- Service --}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="donnation-tab" data-bs-toggle="tab" data-bs-target="#donnation"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Popular Products
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Overview
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Offers
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="testimonial-tab" data-bs-toggle="tab" data-bs-target="#testimonial"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Gallery
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fundraishing-tab" data-bs-toggle="tab"
                                data-bs-target="#fundraishing" type="button" role="tab" aria-controls="home"
                                aria-selected="true">Special Product
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="album-tab" data-bs-toggle="tab" data-bs-target="#album"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Recent
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-tab" data-bs-toggle="tab" data-bs-target="#tab"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Contact
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Pages
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cat-tab" data-bs-toggle="tab" data-bs-target="#cat"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Categories
                            </button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('homesetting.update', $homesetting->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="homesettings" name="table">

                                    @include('inputs.text', [
                                        ($data = ['top_title', 'Title', 'Enter Title', 'text',$homesetting->top_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['top_tag_line', 'Tag Line', 'Enter Title', 'text',$homesetting->top_tag_line]),
                                    ])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'top_desc',
                                            'Short Description',
                                            'Enter Short Description',
                                            $homesetting->top_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                    {{-- <div class="form-group col-md-6">
                                        <label for="service_content">Content </label>
                                        <select class="form-control select2 @error('service_content') is-invalid @enderror"
                                           style="width: 100%"  id="service_content" name="service_content[]" multiple>
                                            @foreach ($services as $c)
                                                <option value='{{$c->id}}'>
                                                    {{ $c->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('service_content')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror

                                    </div> --}}
                                    {{-- @include('inputs.file_input',array('enable_featured_image'=>true,'enable_thumb_image'=>true)) --}}
                                </div>

                            </div>

                            <div class="tab-pane fade show container" id="donnation" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="homesettings" name="table">

                                    @include('inputs.text', [
                                        ($data = ['popular_title', 'Title', 'Enter Title', 'text', $homesetting->popular_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['popular_tag_line', 'Tag Line', 'Enter Title', 'text', $homesetting->popular_tag_line]),
                                    ])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'popular_desc',
                                            'Short Description',
                                            'Enter Short Description', 
                                            $homesetting->popular_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                    {{-- <div class="form-group col-md-6">
                                            <label for="donner_content">Content </label>
                                            <select class="form-control select2 @error('donner_content') is-invalid @enderror"
                                            style="width: 100%" id="donner_content" name="donner_content[]" multiple>
                                                @foreach ($program as $c)
                                                    <option value="{{$c->id}}">
                                                        {{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('donner_content')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
    
                                        </div> --}}
                                    {{-- @include('inputs.file_input',array('enable_featured_image'=>true,'enable_thumb_image'=>true)) --}}
                                </div>

                            </div>


                            <div class="tab-pane fade show container" id="testimonial" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    @include('inputs.text', [
                                        ($data = ['gallery_title', 'Title', 'Enter Title', 'text', $homesetting->gallery_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['gallery_tag_line', 'Tag Line', 'Enter Title', 'text', $homesetting->gallery_tag_line]),
                                    ])

                                    @include('inputs.mediainput', [
                                        ($data = ['gallery_imgA', 'Image 1', 'Enter Image 1', $homesetting->gallery_imgA]),
                                    ])
                                    @include('inputs.mediainput', [
                                        ($data = ['gallery_imgB', 'Image 2', 'Enter Image 2', $homesetting->gallery_imgB]),
                                    ])
                                    @include('inputs.mediainput', [
                                        ($data = ['gallery_imgC', 'Image 3', 'Enter Image 3', $homesetting->gallery_imgC]),
                                    ])
                                    @include('inputs.mediainput', [
                                        ($data = ['gallery_imgD', 'Image 4', 'Enter Image 4', $homesetting->gallery_imgD]),
                                    ])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'gallery_desc',
                                            'Short Description',
                                            'Enter Short Description', 
                                            $homesetting->gallery_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                </div>

                            </div>
                            <div class="tab-pane fade show container" id="fundraishing" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">

                                    @include('inputs.text', [
                                        ($data = ['special_title', 'Title', 'Enter Title', 'text', $homesetting->special_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['special_tag_line', 'Tag Line', 'Enter Title', 'text', $homesetting->special_tag_line]),
                                    ])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'special_desc',
                                            'Short Description',
                                            'Enter Short Description',
                                            $homesetting->special_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                </div>
                            </div>

                            <div class="tab-pane fade show container" id="album" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">

                                    @include('inputs.text', [
                                        ($data = ['recent_title', 'Title', 'Enter Title', 'text', $homesetting->recent_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['recent_tag_line', 'Tag Line', 'Enter Title', 'text', $homesetting->recent_tag_line]),
                                    ])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'recent_desc',
                                            'Short Description',
                                            'Enter Short Description', 
                                            $homesetting->recent_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                </div>

                            </div>

                            <div class="tab-pane fade show dcontainer" id="content" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    @include('inputs.text', [
                                        ($data = ['offer_title', 'Title', 'Enter Title', 'text', $homesetting->offer_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['offer_tag_line', 'Tag Line', 'Enter Title', 'text', $homesetting->offer_tag_line]),
                                    ])
                                    @include('inputs.textarea', [
                                        ($data = [
                                            'offer_desc',
                                            'Short Description',
                                            'Enter Short Description',
                                            $homesetting->offer_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])

                                </div>
                            </div>
                            

                            <div class="tab-pane fade show dcontainer" id="additional" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">

                                    @include('inputs.text', [
                                        ($data = ['eval_title', 'Title', 'Enter Title', 'text', $homesetting->eval_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['eval_tag_line', 'Tag Line', 'Enter Title', 'text', $homesetting->eval_tag_line]),
                                    ])

                                    @include('inputs.mediainput', [
                                        ($data = ['eval_thumb', 'Thumbnail', 'Enter Title', $homesetting->eval_thumb]),
                                    ])

                                    @include('inputs.text', [
                                        ($data = ['eval_video', 'Video Link', 'Enter Video Link', 'text', $homesetting->eval_video]),
                                    ])

                                    @include('inputs.textarea', [
                                        ($data = [
                                            'eval_desc',
                                            'Short Description',
                                            'Enter Short Description',
                                            $homesetting->eval_desc,
                                            'md-6',
                                            '4',
                                        ]),
                                    ])
                                </div>
                            </div>


                            <div class="tab-pane fade show dcontainer" id="tab" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">

                                    @include('inputs.text', [
                                        ($data = ['contact_title', 'Title', 'Enter Title', 'text', $homesetting->contact_title]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['contact_btn', 'Button Title', 'Enter Button Title', 'text', $homesetting->contact_btn]),
                                    ])
                                    @include('inputs.text', [
                                        ($data = ['contact_link', 'Button Link', 'Enter Link', 'text', $homesetting->contact_link]),
                                    ])
                                    @include('inputs.mediainput', [
                                        ($data = ['contact_img', 'Thumbnail', 'Enter Thumbnail', $homesetting->contact_img]),
                                    ])
                                </div>


                            </div>
                            <div class="tab-pane fade show dcontainer" id="pages" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">

                                    @include('inputs.selectss', [
                                        $data = ['pagea', 'Page A'],
                                        $option = $pages,
                                        $default = $homesetting->pagea
                                    ])
                                    @include('inputs.selectss', [
                                        $data = ['pageb', 'Page B'],
                                        $option = $pages,
                                        $default = $homesetting->pageb
                                    ])
                                    @include('inputs.selectss', [
                                        $data = ['pagec', 'Page C'],
                                        $option = $pages,
                                        $default = $homesetting->pagec
                                    ])
                                   
                                </div>


                            </div>
                            <div class="tab-pane fade show dcontainer" id="cat" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">

                                    @include('inputs.selectss', [
                                        $data = ['cata', 'Category A'],
                                        $option = $categories,
                                        $default = $homesetting->cata
                                    ])
                                    @include('inputs.selectss', [
                                        $data = ['proda', 'Product A'],
                                        $option = $proda,
                                        $default = $homesetting->proda
                                    ])
                                    @include('inputs.selectss', [
                                        $data = ['catb', 'Category B'],
                                        $option = $categories,
                                        $default = $homesetting->catb
                                    ])
                                    @include('inputs.selectss', [
                                        $data = ['prodb', 'Product B'],
                                        $option = $prodb,
                                        $default = $homesetting->prodb
                                    ])
                                   
                                </div>


                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('homesetting.index') }}" class="btn btn-light">Cancel</a>
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
        $('#cata').change(()=> {
            $.ajax({
                    
                    type: "GET",
                    url: "/admin/getproduct/"+$('#cata').val(),
                    success: function(response) {
                        let pval = '';
                        response.products.forEach(p => {
                            pval += '<option value="'+p.id+'">'+p.title+'</option>';
                        });
                        $('#proda').html(pval);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
        });

        $('#catb').change(()=> {
            $.ajax({
                    
                    type: "GET",
                    url: "/admin/getproduct/"+$('#catb').val(),
                    success: function(response) {
                        let pval = '';
                        response.products.forEach(p => {
                            pval += '<option value="'+p.id+'">'+p.title+'</option>';
                        });
                        $('#prodb').html(pval);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
        });
    </script>
@endsection
