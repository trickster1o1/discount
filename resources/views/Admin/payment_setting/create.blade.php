@extends('layouts.app')
@section('title')
    Introduction Setting
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
        <h3 class="page-title"> Introduction Setting </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Payment Setting</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Esewa
                                </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="paypal-tab" data-bs-toggle="tab" data-bs-target="#paypal"
                                type="button" role="tab" aria-controls="paypal" aria-selected="true">Paypal
                                </button>
                        </li>
                        
                    </ul>
                    <form class="forms-sample" action="{{ route('paymentsetting.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                                <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    {{-- Feature Details --}}
                                    <div class="row">
                                        {{-- <input type="hidden" value="introduction_settings" name="table"> --}}
                                        @include('inputs.text',[$data=['merchant_id','Merchant Id','Enter Merchant Id','text']])
                                        <div class="form-group col-md-6 d-none">
                                            <label for="tag_line">Esewa ID</label>
                                            <input type="text-area" class="form-control @error('esewa_id') is-invalid @enderror"
                                                data-role="tagsinput" name="esewa_id" value="{{ old('esewa_id') }}">
                                            @error('esewa_id')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        

                                    </div>

                                </div>

                                <div class="tab-pane fade show container" id="paypal" role="tabpanel"
                                    aria-labelledby="paypal-tab">
                                    {{-- Feature Details --}}
                                    <div class="row">
                                        {{-- <input type="hidden" value="introduction_settings" name="table"> --}}
                                        @include('inputs.textarea', [
                                                ($data = [
                                                    'paypal_form',
                                                    'Paypal Donnate Button Form',
                                                    'Paypal Form',
                                                    '',
                                                    'md-6',
                                                    '4',
                                                ]),
                                            ]) 
                                        
                                        <div class="d-none">@include('inputs.mediainput',[$data=['paypal_qr','Paypal QRcode','Upload Paypal QRcode','']])</div>
                                        

                                    </div>

                                </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
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
       // load_ckeditor('description', true);
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>

@endsection
