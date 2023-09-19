@extends('Frontend.layouts.app')
@section('body')
    @include('Frontend.page.includes.banner', [
       'style'=> 'height:70vh;',
       'title' => Session::has('user') ? Session::get('user')['name'] : 'User',
    ])
    <div class="container">
        @if (count($orders))
            <h3 align='center'>Orders</h3>
            <ul class="order-list">
                <li><div>Date</div> <b>Order Id </b>
                    <span><b>Status</b></span>
                    <span><b>Amount</b></span>
                </li>
                @foreach ($orders as $order)
                    <li><div>{{ \Carbon\Carbon::parse($order->created_at)->format('M D') }}</div>{{ $order->oid }}
                    <span>{{strtoupper($order->status)}}</span>
                    <span>Rs.{{strtoupper($order->amount)}}</span>
                    </li>
                @endforeach
            </ul>
        @else 
            <h3>You Have No Orders.</h3>
        @endif

        <div class="d-flex justify-content-center pt-4" style="padding-left: 1.5em;">
            {{ $orders->links() }}

        </div>
    </div>
@endsection
