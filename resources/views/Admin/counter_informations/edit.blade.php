@extends('layouts.app')
@section('title')
    Counter Informations
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Counter Information </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('counter_infos.index') }}">Counter Informations</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Counter Information</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Counter Information
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('counter_infos.update', $counter_info) }}"
                        method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="counter_information" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="title"
                                            value="{{ old('title', $counter_info->title) }}">
                                        @error('title')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="icon_class">Icon Class</label>
                                        <input type="text" class="form-control @error('icon_class') is-invalid @enderror"
                                            id="icon_class" name="icon_class" placeholder="Icon Class"
                                            value="{{ old('icon_class', $counter_info->icon_class) }}">
                                        @error('icon_class')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="counter_number">Counter Number</label>
                                        <input type="text"
                                            class="form-control @error('counter_number') is-invalid @enderror"
                                            id="counter_number" name="counter_number" placeholder="Counter Number"
                                            value="{{ old('counter_number', $counter_info->counter_number) }}">
                                        @error('counter_number')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="thumb_image">Thumb Image</label>
                                        <div class="input-group md-3">
                                            <input type="text"
                                                class="form-control @error('thumb_image') is-invalid @enderror"
                                                id="thumb_image" name="thumb_image" placeholder="Thumb Image"
                                                value="{{ old('thumb_image', $counter_info->thumb_image) }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="thumb_image"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>

                                        @error('thumb_image')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="active"
                                                {{ old('status', $counter_info->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $counter_info->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-12">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a href="{{ route('counter_infos.index') }}" class="btn btn-light">Cancel</a>
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
            load_ckeditor('short_description', false);
        }
    </script>
@endsection
