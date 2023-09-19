@extends('layouts.app')
@section('title')
    Smtp
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title"> Update Smtp Setting</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('smtp.index') }}">SMTP</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add SMTP</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                   
                    <form class="forms-sample" action="{{isset($smtp) ? route('smtp.update',$smtp->id) : route('smtp.store') }}" enctype='multipart/form-data' method="POST" >
                        @csrf
                        @if (isset($smtp)) @method('put') @endif

                                {{-- product  main --}}
                                <div class="row">                        
                                   
                                    @include('inputs.text',[$data=['hostname','Hostname*','Enter Hostname','text', isset($smtp) ? $smtp->hostname : '']])
                                   
                                    @include('inputs.text',[$data=['port','Port Number*','Enter Port Number','text', $default = isset($smtp) ? $smtp->port : '']])
                                    @include('inputs.selects',[$data=['auth','Authentication'], $option=['Yes','No'], $default = isset($smtp) ? $smtp->auth : ''])
                                    @include('inputs.selects',[$data=['encryption','Encryption'], $option=['None','SSL','TSL'], $default =  isset($smtp) ? $smtp->encryption : '' ])
                                    
                                    @include('inputs.text',[$data=['username','Username','Enter Username','text', isset($smtp) ? $smtp->username : '']])
                                    @include('inputs.text',[$data=['password','Password','Enter Password','password', isset($smtp) ? $smtp->password : '']])


                                   
                                    
                                </div>
                               



                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
