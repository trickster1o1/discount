@extends('layouts.app')

@section('title')
    Order
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Orders </h3>

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
            <table class="table bg-white list-data" id="list-data" data-url="{{ url('order_data') }}">
                <thead class="thead bg-primary text-white font-weight-bold">
                    <tr>
                        <!--data-column is field name that needs to be sort and data-filter check sorting is enabled or not-->
                        <th scope="col" width="30%" data-column="user_name" data-filter="1">Name</th>
                        <th scope="col" width="30%" data-column="oid" data-filter="1">Order Id</th>
                        <th scope="col" data-column="payment_method" data-filter="1">Payment Method </th>
                        <th scope="col" data-column="amount" data-filter="1">Amount</th>
                        <th scope="col" data-column="ref_id" data-filter="1">Refrence Id</th>
                        <th scope="col" data-column="status" data-filter="1">Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
