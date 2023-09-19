@extends('layouts.app')
@section('title')
    Bank Details
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Bank Details </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Bank Detail</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                    
                    <form class="forms-sample" action="{{ route('bank.store') }}" method="POST">
                        @csrf
                        <div class="tab-content col-md-12" id="myTabContent">
                                <div class="tab-pane fade show active container" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    {{-- Feature Details --}}
                                    <div class="row">
                                        {{-- <input type="hidden" value="introduction_settings" name="table"> --}}
                                        @include('inputs.textarea', [
                                            ($data = [
                                                'bank_detail',
                                                'Bank Detail',
                                                'Enter Description',
                                                '',
                                                'md-12',
                                                '4',
                                            ]),
                                        ]) 
                                    </div>                                         </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    </div>
                                </div>

                           
                        </div>
                        </div>

                    </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    window.onload = function() {
        load_ckeditor('bank_detail', false);
    }
</script>
@endsection
