@extends('Frontend.layouts.app')
@section('body')
    @include('Frontend.page.includes.banner', ['title' => 'Cart'])
    <div class="container">
        @if ($user->carts && count($user->carts))

            <div class="row">
                    <div class="col-md-8 row item-body">
                        <div class="col-md-12 row item-container">
                            <div class="col-md-6">
                                Product
                            </div>
                            <div class="col-md-3">
                                Price
                            </div>
                            <div class="col-md-2">
                                Qty
                            </div>

                            <div class="col-md-1">
                                Act
                            </div>
                        </div>
                        @foreach ($user->carts as $cart)
                            <div class="col-md-12 row item-container" id="{{ 'c-' . $cart->id }}">
                                <div class="col-md-6">
                                    {{ $cart->product($cart->product_id)->title }}
                                </div>
                                <div class="col-md-3">
                                    Rs.{{ $cart->product($cart->product_id)->price }}
                                </div>
                                <div class="col-md-2">
                                    {{ $cart->quantity }}
                                </div>

                                <div class="col-md-1">
                                    <button class="btn btn-danger" title="Remove" onclick="delCart('{{ $cart->id }}',event)"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                <div class="col-md-4 order-body">
                    <div>
                        <h4>Order Summery <span id="total_qty">({{ $total_qty }})</span> </h4>
                        <div>Subtotal <span id="sub_total">Rs.{{ $sub_total }}</span></div>
                        <div class="border-bottom border-dark">Shipping Fee <span>0</span></div>
                        <div>Total<span id="total">Rs.{{ $sub_total }}</span></div>
                        <button class="btn btn-secondary w-100 mt-2" onclick="proceed()">Proceed</button>
                        <a class="btn btn-danger text-light w-100 mt-2" href="{{ route('cart.clear', $user->id)}}">Clear</a>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <h3 align='center' class="col-md-12 pt-5">Nothing in cart.</h3>
            </div>
        @endif
    </div>
    <div>
        <div class="login-pop-cont" id="log-pop">
            <div class="login-pop">
                <h3>Please Login <span id="exit-log">x</span> </h1>
                    <form action="{{ route('order.check') }}" method="POST">
                        @csrf
                        <input type="hidden" id="method" name="method" value="COD">
                        <input type="hidden" name="type" value="cart">
                        <ul class="cart-checkout-section" id="order">
                            <li onclick="selectMethod('COD', event)" class="list-active">
                                <a href="javascript:void(0)" {{-- style="color:#34403c;" --}}><i
                                        class="far fa-arrow-alt-circle-right"></i><span>Cash On Delivery</span></a>
                            </li>
                            @foreach ($methods as $method)
                                <li onclick="selectMethod('{{ $method->code }}', event)">
                                    <a href="javascript:void(0)" {{-- style="color:#34403c;" --}}><i
                                            class="far fa-arrow-alt-circle-right"></i><span>{{ $method->method }}</span></a>
                                </li>
                            @endforeach
                        </ul>
                        <button class="w-100 btn btn-warning mt-2">Checkout</button>
                    </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function delCart(id, event) {
            $('#c-' + id).hide();
            $.ajax({
                data: {
                    'cart': id,
                    '_token': '{{ csrf_token() }}'
                },
                type: 'POST',
                url: "{{ route('customer.rmvCart') }}",
                success: function(res) {
                    toastr['success'](res.action);
                    $('.cart-ping').html('Cart(' + res.cart + ')');
                    $('#total_qty').html('(' + res.total_qty + ')');
                    $('#sub_total').html('Rs.' + res.sub_total);
                    $('#total').html('Rs.' + res.sub_total);
                },
                error: function(e) {

                }
            });
        }

        function proceed() {
            $('#log-pop').css('display', 'flex');
        }

        $('#exit-log').click(() => {
            $('#log-pop').css('display', 'none');
        });

        function selectMethod(code, event) {
            $.each($('#order li'), function(index, element) {
                element.classList.remove('list-active');
            });
            event.target.classList.add('list-active');
            $('#method').val(code);
        }
    </script>
@endsection
