@extends('layouts.app')
@section('title')
    Email Template
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
        <h3 class="page-title"> Edit Email Template </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('email_templates.index') }}">Email Templates</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Email Template</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Email Templates
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('email_templates.update', $email_template) }}"
                        method="post">
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="<?php echo $email_template->getTable() ?>" name="table">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="template_name">Template Name*</label>
                                            <input type="text" class="form-control @error('template_name') is-invalid @enderror"
                                                id="template_name" name="template_name" placeholder="Template Name"
                                                value="{{ old('template_name', $email_template->template_name) }}">
                                            @error('template_name')
                                                <span class=" invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                         <div class="form-group">
                                            <label for="admin_user">Select Admin Users</label>
                                            <select class="form-control select2 @error('admin_user') is-invalid @enderror"
                                                id="admin_user" name="admin_user[]" multiple style="width: 100%">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        @if (old('admin_user') != null && in_array($user->id, old('admin_user'))) selected @endif>{{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('admin_user')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="custom_email">Custom Emails</label>
                                            <input type="text-area"
                                                class="form-control @error('custom_email') is-invalid @enderror"
                                                data-role="tagsinput" name="custom_email"
                                                value="{{ old('custom_email', $email_template->custom_email) }}">
                                            @error('custom_email')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="admin_subject">Admin Subject</label>
                                            <input type="text" class="form-control @error('admin_subject') is-invalid @enderror"
                                                id="admin_subject" name="admin_subject" placeholder="Admin Subject"
                                                value="{{ old('admin_subject', $email_template->admin_subject) }}">
                                            @error('admin_subject')
                                                <span class=" invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="admin_message">Admin Message</label>
                                            <textarea class="form-control @error('admin_message') is-invalid @enderror" id="admin_message" name="admin_message"
                                                placeholder="Admin Message">{{ old('admin_message', $email_template->admin_message) }}</textarea>
                                            @error('admin_message')
                                                <span class=" invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>  

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="user_subject">User Subject</label>
                                            <input type="text" class="form-control @error('user_subject') is-invalid @enderror"
                                                id="user_subject" name="user_subject" placeholder="User Subject"
                                                value="{{ old('user_subject', $email_template->user_subject) }}">
                                            @error('user_subject')
                                                <span class=" invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="user_message">User Message</label>
                                            <textarea class="form-control @error('user_message') is-invalid @enderror" id="user_message" name="user_message"
                                                placeholder="User Message">{{ old('user_message', $email_template->user_message) }}</textarea>
                                            @error('user_message')
                                                <span class=" invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                                name="status">
                                                <option value="active"
                                                    {{ old('status', $email_template->status) == 'active' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="inactive"
                                                    {{ old('status', $email_template->status) == 'inactive' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                <a href="{{ route('email_templates.index') }}" class="btn btn-light">Cancel</a>
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
            load_ckeditor('user_message', false);
            load_ckeditor('admin_message', false);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
@endsection
