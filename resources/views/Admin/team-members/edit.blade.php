@extends('layouts.app')
@section('title')
    Team Members
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Add Team Member </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('team-members.index') }}">Team Members</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Team Member</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Team Member
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('team-members.update', $team_member) }}" method="POST">
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="team_members" name="table">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Name"
                                            value="{{ old('name', $team_member->name) }}">
                                        @error('name')
                                            <span class=" invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control @error('position') is-invalid @enderror"
                                            id="position" name="position" placeholder="Position"
                                            value="{{ old('position', $team_member->position) }}">
                                        @error('position')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="is_featured">Is Featured</label>
                                        <select class="form-control  @error('status') is-invalid @enderror"
                                            name="is_featured">
                                            <option value="no"
                                                {{ old('is_featured', $team_member->is_featured) == 'no' ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="yes"
                                                {{ old('is_featured', $team_member->is_featured) == 'no' ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>

                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="member_image">Member Image</label>
                                        <div class="input-group md-3">
                                            <input type="text"
                                                class="form-control @error('member_image') is-invalid @enderror"
                                                id="member_image" name="member_image" placeholder="Member Image"
                                                value="{{ old('member_image', $team_member->member_image) }}">
                                            <button class="btn btn-primary popup_selector" data-inputid="member_image"
                                                type="button">
                                                Select Image
                                            </button>
                                        </div>

                                        @error('member_image')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="message">Message</label>
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                                            placeholder="Message"><?php echo old('message', $team_member->message); ?></textarea>
                                        @error('message')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="active"
                                                {{ old('status', $team_member->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $team_member->status) == 'inactive' ? 'selected' : '' }}>
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
                                <a href="{{ route('team-members.index') }}" class="btn btn-light">Cancel</a>
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
            load_ckeditor('message', true);
        }
    </script>
@endsection
