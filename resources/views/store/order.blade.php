@extends('layouts.store.master')

@section('content')
@include('layouts.store.partials.cart')
<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            My Orders
        </span>
    </div>
</div>
<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85" method="post" action="">
    <div class="container">
        @if($parentOrders->count() > 0)
        <div class="row">
            @if(true)
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Sell Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($parentOrders as $parentOrder)
                            <tr style="background:#f0f8ff">
                                <td colspan="4" class="text-left">
                                    Order ID : {{ $parentOrder->order_id }}
                                    <br/> Transaction ID : {{ $parentOrder->txn }}
                                    <br/> Payment Status : {{ $parentOrder->paymentStatus(true) }}
                                    <br/> Order Status : {{ $parentOrder->statusText(true) }}
                                    <br/> Total Amount : RM {{ $parentOrder->total_amount }}
                                </td>
                                <td colspan="1">
                                    @if($parentOrder->status == $parentOrder::ORDER_STATUS_CANCELLED)
                                        Order Cancelled
                                    @elseif($parentOrder->status == $parentOrder::ORDER_STATUS_OUT_FOR_SHIPPING)
                                        <div class="col-md-2">
                                                <a href="https://www.pos.com.my/postal-services/quick-access/?track-trace={{$parentOrder->tracking}}" target="_blank">
                                                    <input type="button" class="flex-c-m stext-90 cl5 size-104 bg2 bor1 hov-btn1 p-lr-15 trans-04" value="Tracker"/>
                                                </a>
                                                <input type="button" class="flex-c-m stext-90 cl5 size-104 bg2 bor1 hov-btn1 p-lr-15 trans-04 complete-btn" value="Complete" data-orderid="{{ $parentOrder->id}}" style="margin-top:15px"/>
                                        </div>
                                        {{-- <div class="col-md-6 text-left">
                                            <a href="https://www.pos.com.my/postal-services/quick-access/?track-trace={{$parentOrder->tracking}}" target="_blank">
                                                <input type="button" class="flex-c-m stext-90 cl5 size-104 bg2 bor1 hov-btn1 p-lr-15 trans-04" value="Complete"/>
                                            </a>
                                        </div> --}}
                                    @else

                                            @if($parentOrder->payment_status == 1)

                                                @if($parentOrder->status == $parentOrder::ORDER_STATUS_COMPLETED)
                                                <div class="col-md-6">
                                                    Fulfilled Order
                                                @elseif($parentOrder->status  != $parentOrder::ORDER_STATUS_OUT_FOR_SHIPPING && $parentOrder->status != $parentOrder::ORDER_STATUS_REFUNDED)
                                                <div class="col-md-2">
                                                    <input type="button" class="flex-c-m stext-90 cl5 size-104 bg2 bor1 hov-btn1 p-lr-15 trans-04 cancel-btn" data-orderid="{{ $parentOrder->id}}" value="Cancel"/>
                                                @endif

                                                <a href="{{ route('store.invoice.show', ['order_id' => $parentOrder->order_id]) }}" target="_blank">
                                                    <input type="button" class="flex-c-m stext-90 cl5 size-104 bg2 bor1 hov-btn1 p-lr-15 trans-04" value="Invoice" style="margin-top:10px;"/>
                                                </a>
                                                </div>
                                            @endif


                                        @if($parentOrder->payment_status == 0)
                                            Waiting for payment
                                        @endif
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach($parentOrder->orders as $order)
                                    <tr>
                                        <td>
                                            {{ $counter }}
                                        </td>
                                        <td>
                                            {{ $order->product->title }}
                                        </td>
                                        <td>
                                            {{ $order->quantity }}
                                        </td>

                                        <td>
                                            RM {{ $order->sell_price }}
                                        </td>

                                        <td></td>
                                    </tr>

                                    @php
                                        $counter++;
                                    @endphp
                                @endforeach
                            </tr>

                            <tr style="background:#2f4f4f">
                                <td colspan="5"></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="col-md-12 text-center">
                    <i class="zmdi zmdi-hc-4x zmdi-shopping-basket"></i>
                    <h3> No Order History </h3>
                </div>
            @endif
        </div>
        @else
        <div class="col-md-12 text-center">
            <i class="zmdi zmdi-hc-4x zmdi-checklist"></i>
            <h3> Your orders is empty </h3>
        </div>
        @endif
    </div>
</form>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('.cancel-btn').on('click', function(){
                swal({
                    title: "Are you sure?",
                    text: "Are you confirm to cancel your order ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).data('orderid');
                        console.log('id ' + id);
                        $.get('/store/orders/cancel/' + id, function(data, status){
                            console.log(data);
                            if(data.status == 'false')
                            {
                                swal("opps... there is some problem while updating status for order");
                            }
                        });
                        location.href = "{{ route('store.orders.show') }}"
                    }
                });
            });

            $('.complete-btn').on('click', function(){
                swal({
                    title: "Are you sure?",
                    text: "Have you received the item as ordered?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).data('orderid');
                        console.log('id ' + id);
                        $.get('/store/orders/complete/' + id, function(data, status){
                            console.log(data);
                            if(data.status == 'false')
                            {
                                swal("opps... there is some problem while updating status for order");
                            }
                        });
                        location.href = "{{ route('store.orders.show') }}"
                    }
                });
            });
        });
    </script>
@endsection