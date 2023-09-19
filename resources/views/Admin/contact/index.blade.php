@extends('layouts.app')

@section('title')
    Contact Us
@endsection

@section('css')
<style type="text/css">
    .text-wrap{
        white-space:normal;
    }
    .max-width-350{
        width:350px;
        line-height: 25px;
    }
    .hide-message{
        display: none;
    }
    .show-message{
        display: block;
    }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">Contacts </h3>

        {{-- @if (authorize($menucode, 'CREATE', false))
            <a href="{{ route('contact.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
        @endif --}}
    </div>

    @if (session('status'))
    @endif

    @if (session('status'))
        <div class="px-3">{!! session('status') !!}</div>
    @endif
    
    <div class="row">
        <div class="col-3" id="data-filter">
            <div class="input-group mb-3" id="search_value">
                <!--filter class is necessary to build data for filter-->
                <input type="text" class="form-control input-sm filter" placeholder="Search Text" name="filter_search_text"
                    value="">
                <button class="btn btn-outline-secondary" type="button" id="btn-search"><i class="fa fa-search"></i>
                    Search</button>
            </div>
        </div>
        <div class="col-12 grid-margin stretch-card table-responsive">
            <table class="table bg-white list-data" id="list-data" data-url="{{ url('contact/data_ajax') }}">
                <thead class="thead bg-primary text-white font-weight-bold">
                    <tr>
                        <!--data-column is field name that needs to be sort and data-filter check sorting is enabled or not-->
                        <th scope="col" width="30%" data-column="fullName" data-filter="1">Full Name</th>
                        <th scope="col" data-column="number" data-filter="1">Number</th>
                        <th scope="col" width="1%" data-column="email" data-filter="1">Email</th>
                        <th scope="col" width="1%" data-column="subject" data-filter="1">Subject</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $('#list-data').on('click','.read-full-message',function(){
        $('.full-message').removeClass('show-message').addClass('hide-message');
        $('.short-message').removeClass('hide-message').addClass('show-message');

        $(this).closest('div.text-wrap').find('.short-message').removeClass('show-message').addClass('hide-message');
        $(this).closest('div.text-wrap').find('.full-message').removeClass('hide-message').addClass('show-message');
    });

    $('#list-data').on('click','.hide-full-message',function(){
        $(this).closest('div.text-wrap').find('.full-message').removeClass('show-message').addClass('hide-message');
        $(this).closest('div.text-wrap').find('.short-message').removeClass('hide-message').addClass('show-message');
    });
</script>
@endsection
