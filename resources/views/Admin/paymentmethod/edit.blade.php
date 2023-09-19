@extends('layouts.app')
@section('title')
    Payment Methods
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Edit Payment Method </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('paymentmethod.index') }}">Payment Methods</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Payment Method</li>
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
                                type="button" role="tab" aria-controls="home" aria-selected="true">Payment
                                Details</button>
                        </li>
                    </ul>
                    <form class="forms-sample" action="{{ route('paymentmethod.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                {{-- Feature Details --}}
                                <div class="row">
                                <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
                                    <input type="hidden" value="payment_methods" name="table">
                                    @include('inputs.text',$data=['method','Payment Method*','Enter Payment Method','text',$payment->method])
                                    @include('inputs.text',$data=['code','Code*','Enter Code','text',$payment->code])
                                    @include('inputs.mediainput',$data=['logo','Logo','Upload Payment Logo',$payment->logo])
                                    @include('inputs.selects',[$data=['status','Status'], $option=['Active','Inactive'], $default=$payment->status])
                                    
                                    {{-- @include('inputs.file_input',array('enable_featured_image'=>true,'enable_thumb_image'=>true)) --}}
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('paymentmethod.index') }}" class="btn btn-light">Cancel</a>
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
    // window.onload = function() {
    //     load_ckeditor('description', false);
    //     load_ckeditor('short_description', true);
    // }
</script>
@endsection
