@extends('layouts.app')
@section('title')
    Review
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Review </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reviews.index') }}">Reviews</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Review</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Review Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="reviews" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="review_category">Review Category</label>
                                        <select class="form-control @error('review_category') is-invalid @enderror"
                                            id="review_category" name="review_category" id="review_category">
                                            <option value=>Select Category</option>
                                            <option value="tours"
                                                {{ old('review_category') == 'tours' ? 'selected' : '' }}>
                                                Tour
                                            </option>
                                            <option value="properties"
                                                {{ old('review_category') == 'properties' ? 'selected' : '' }}>
                                                Property
                                            </option>
                                            <option value="destinations"
                                                {{ old('review_category') == 'destinations' ? 'selected' : '' }}>
                                                Destination
                                            </option>
                                            <option value="rooms"
                                                {{ old('review_category') == 'rooms' ? 'selected' : '' }}>
                                                Room
                                            </option>
                                        </select>
                                        @error('review_category')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="review_for">Review For</label>
                                        <select class="form-control @error('review_for') is-invalid @enderror"
                                            id="review_for" name="review_for" id="review_for">
                                            <option>Select Review For</option>
                                        </select>
                                        @error('review_for')
                                            <span class="invalid-feedback"> {{ $message }} </span>
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
                                        <label for="review_rating">Review Rating</label>
                                        <select class="form-control @error('review_rating') is-invalid @enderror"
                                            id="review_rating" name="review_rating">
                                            <option value="1" {{ old('review_rating') == '1' ? 'selected' : '' }}>
                                                1
                                            </option>
                                            <option value="2" {{ old('review_rating') == '2' ? 'selected' : '' }}>
                                                2
                                            </option>
                                            <option value="3" {{ old('review_rating') == '3' ? 'selected' : '' }}>
                                                3
                                            </option>
                                            <option value="4" {{ old('review_rating') == '4' ? 'selected' : '' }}>
                                                4
                                            </option>
                                            <option value="5" {{ old('review_rating') == '5' ? 'selected' : '' }}>
                                                5
                                            </option>
                                        </select>
                                        @error('review_rating')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="review">Review</label>
                                        <textarea class="form-control @error('review') is-invalid @enderror" id="review" name="review"
                                            placeholder="Review">{{ old('review') }}</textarea>
                                        @error('review')
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
    <script>
        window.onload = function() {
            load_ckeditor('review', false);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#review_category').change(function() {
                let review_category = $(this).val()
                $.ajax({
                    url: '/getreviewfor',
                    type: 'post',
                    data: 'review_category=' + review_category + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#review_for').html(result)
                    }
                });
            });
        });
    </script>
@endsection
