@extends('layouts.app')
@section('title')
    FAQs
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Faq </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">FAQs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Faq</li>
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

                    </ul>
                    <form class="forms-sample" action="{{ route('faqs.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="faqs" name="table">


                                    <div class="form-group col-md-6">
                                        <label for="category">Category *</label>
                                        <select class="form-control" name="category" id="category">
                                            <option>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('route')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sub_category">Sub Category *</label>
                                        <input type="hidden" id="old_subcategory" value="{{ old('sub_category') }}">
                                        <select class="form-control" name="sub_category" id="sub_category">
                                            <option>Select Sub-category</option>
                                        </select>
                                        @error('sub_category')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="question">Question *</label>
                                        <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question"
                                            placeholder="Question"><?php echo old('question'); ?></textarea>
                                        @error('question')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="answer">Answer</label>
                                        <textarea class="form-control @error('answer') is-invalid @enderror" id="answer" name="answer"
                                            placeholder="Answer"><?php echo old('answer'); ?></textarea>
                                        @error('answer')
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
                                </div>

                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('blogs.index') }}" class="btn btn-light">Cancel</a>
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
            load_ckeditor('answer', false);
           // load_ckeditor('question', false);
        }
    </script>
@endsection
