@extends('layouts.app')

@section('title')
    Payment Methods
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">Payment Methods </h3>

        @if (authorize($menucode, 'CREATE', false))
            <a href="{{ route('paymentmethod.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
        @endif
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
            <table class="table bg-white list-data" id="list-data" data-url="{{ url('paymentmethod/data_ajax') }}">
                <thead class="thead bg-primary text-white font-weight-bold">
                    <tr>
                        <!--data-column is field name that needs to be sort and data-filter check sorting is enabled or not-->
                        <th scope="col" width="30%" data-column="method" data-filter="1">Method</th>
                        <th scope="col" data-column="code" data-filter="1">Code</th>
                        <th scope="col" width="1%" data-column="order_by" data-filter="1">Sequence</th>
                        <th scope="col" data-column="status" data-filter="1">Status</th>
                        @if (authorize($menucode, 'UPDATE', false) || authorize($menucode, 'DELETE', false))
                            <th scope="col" width="5%">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
