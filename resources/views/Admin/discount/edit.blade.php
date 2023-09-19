@extends('layouts.app')
@section('title')
    Discount
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Update Discount </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('discount.index') }}">Discounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Discount</li>
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
                    <form class="forms-sample" action="{{ route('discount.update',$discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                    <input type="hidden" value="discounts" name="table">

                                    <div class="form-group col-md-6">
                                        <label for="type">Type *</label>
                                        <select class="form-control @error('type') is-invalid @enderror" name="type"
                                            id="type">
                                            <option value="">Select Type</option>
                                            <option value="fixed" {{old('type',$discount->type) == 'fixed' ? 'selected' : null}}>Fixed</option>
                                            <option value="percent" {{old('type',$discount->type) == 'percent' ? 'selected' : null}}>Percent</option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="value">Value</label>
                                        <input type="text" class="form-control @error('value') is-invalid @enderror"
                                            id="value" name="value" placeholder="Price" value="{{ old('value',$discount->value) }}">
                                        @error('value')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>



                                    <div class="form-group col-md-6">
                                        <label for="product_id">Product *</label>
                                        <select class="form-control @error('product_id') is-invalid @enderror"
                                            name="product_id" id="product_id">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ $product->id == old('product_id',$discount->product->id) ? 'selected' : null }}>
                                                    {{ $product->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <span class="invalid-feedback"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="active" {{ old('status',$discount->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive" {{ old('status',$discount->statuss) == 'inactive' ? 'selected' : '' }}>
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
                                <a href="{{ route('discount.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
