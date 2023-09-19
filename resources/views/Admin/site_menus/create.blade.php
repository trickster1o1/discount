@extends('layouts.app')
@section('title')
    Site Menus
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Site Menu </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site_menus.index') }}">Site Menus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Site Menu</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Site Menus</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('site_menus.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            {{-- Property Information --}}
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="row">
                                    <input type="hidden" value="site_menus" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="link_type">Link Type *</label>
                                        <select class="form-control" name="link_type" id="link_type">
                                            <option value="none">None</option>
                                            @if(is_array($link_types) && count($link_types)>0)
                                                @foreach($link_types as $key=>$value)
                                                    <option value="{{$key}}" {{(old('link_type') == $key)?'selected':''}}>{{$value}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('link_type')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="parent">Parent *</label>
                                        <div class="input-group mb-3">
                                            <select name="parent" class="form-control">
                                                <option value="0" data-location="">Self</option>
                                                @php 
                                                    if($site_menu){
                                                        echo $site_menu::getParent(old('parent'));
                                                    }
                                                @endphp
                                            </select>
                                            @error('parent')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6" id="category-p">
                                        <label for="category">Category *
                                            <input type="hidden" id="old_category" value="{{old('category')}}">
                                        </label>
                                        <select class="form-control" name="category" id="category_list">
                                            <option value="">Select Category</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6" id="sub_category-p">
                                        <label for="sub_category">Sub Category *
                                            <input type="hidden" id="old_sub_category" value="{{old('sub_category')}}">
                                        </label>
                                        <select class="form-control" name="sub_category" id="sub_category_list">
                                            <option value="">Select Sub-category</option>
                                        </select>
                                        @error('sub_category')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6" id="topic-p">
                                        <label for="topic">Topic *
                                             <input type="hidden" id="old_topic" value="{{old('topic')}}">
                                        </label>
                                        <select class="form-control" name="topic" id="topic_list">
                                            <option value="">Select Topic</option>
                                        </select>
                                        @error('topic')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="location">Location *</label>
                                        <select class="form-control" name="location">
                                            <option value="header" {{ old('location') == 'header' ? 'selecte' : '' }}>
                                                Header
                                            </option>
                                            <option value="footer" {{ old('location') == 'footer' ? 'selecte' : '' }}>
                                                Footer</option>
                                        </select>
                                        @error('location')
                                            <span class="    invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class="    invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6" id="external_url_p">
                                        <label for="title">URL *</label>
                                        <input type="text" class="form-control @error('external_url') is-invalid @enderror"
                                            id="external_url" name="external_url" placeholder="URL" value="{{ old('external_url') }}">
                                        @error('external_url')
                                            <span class="    invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">Status *</label>
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
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <a class="btn btn-light" href="{{route('site_menus.index')}}">Cancel</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('Admin.site_menus.sitemenu_script');
@endsection
