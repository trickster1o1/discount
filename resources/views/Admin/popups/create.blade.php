@extends('layouts.app')
@section('title')
    Popups
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Popup </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('popups.index') }}">Popups</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add popup</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Popups</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('popups.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="popups" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" placeholder="Title" value="{{ old('title') }}">
                                        @error('title')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
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

                                    <div class="form-group col-md-6">
                                        <label for="start_date">Start Date *</label>
                                        <input type="text" class="datepicker form-control @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date" placeholder="Start Date"
                                            value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="start_time">Start Time</label>
                                        <input type="text" class="timepicker form-control @error('start_time') is-invalid @enderror"
                                            id="start_time" name="start_time" placeholder="Start Time"
                                            value="{{ old('start_time') }}">
                                        @error('start_time')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_date">End Date</label>
                                        <input type="text" class="form-control datepicker @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date" placeholder="End Date"
                                            value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_time">End Time</label>
                                        <input type="text" class="form-control timepicker @error('end_time') is-invalid @enderror"
                                            id="end_time" name="end_time" placeholder="End Time"
                                            value="{{ old('end_time') }}">
                                        @error('end_time')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="popup_description">Popup Description *</label>
                                        <textarea class="form-control @error('popup_description') is-invalid @enderror" id="popup_description"
                                            name="popup_description"
                                            placeholder="Popup Description">{{ old('popup_description') }}</textarea>
                                        @error('popup_description')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a class="btn btn-light" href="{!! URL::previous() !!}">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/form-input-mask.min.js') }}"></script>
    <script>
        $(".datepicker").inputmask("y-m-d", {
            placeholder: "yyyy-mm-dd"
        });
        //Inputmask("time", { jitMasking: true }).mask('.timepicker');
        window.onload = function() {
            load_ckeditor('popup_description', false);
        }
    </script>
@endsection
