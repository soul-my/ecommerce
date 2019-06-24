@extends('layouts.admin.master')

@section('content')
@include('components.navigations.breadcrumb', [
    'links' =>
    [
        'Home' => route('admin.dashboard'),
        'Listing' => 'active',
    ]
])

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    List of Orders
                    <small></small>
                </h2>
            </div>

            @include('admin.partials.search')

            <div class="body table-responsive">
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

                        @if($parentOrders->count() > 0)
                            <tr style="background:#2f4f4f">
                                <td colspan="5"></td>
                            </tr>
                            @foreach($parentOrders as $parentOrder)
                                <tr style="background:#f0f8ff">
                                    <td colspan="4" class="text-left">
                                        Order ID : {{ $parentOrder->order_id }}
                                        <br/> Transaction ID : {{ $parentOrder->txn }}

                                        <br/> Payment Status : {{ $parentOrder->paymentStatus(true) }}
                                        <br/>Order Status : {{ $parentOrder->statusText(true) }}
                                        <br/>Total Amount : RM {{ $parentOrder->total_amount }}
                                    </td>
                                    <td colspan="1">
                                        @if($parentOrder->payment_status == $parentOrder::PAYMENT_SUCCESSFUL && $parentOrder->status != $parentOrder::ORDER_STATUS_CANCELLED)
                                            <a href="{{ route('store.invoice.show', ['order_id' => $parentOrder->order_id]) }}" target="_blank">
                                                <button type="button" class="btn btn-primary waves-effect">
                                                    Invoice
                                                </button>
                                            </a>

                                            @if($parentOrder->status == $parentOrder::ORDER_STATUS_RECEIVED)
                                                <button type="button" class="btn btn-primary waves-effect add-tracker" data-toggle="modal" data-target="#defaultModal" data-order-id="{{ $parentOrder->id }}"> {{ !$parentOrder->tracking ? 'Add Tracking No' : 'Update Tracking No' }} </button>
                                            @endif
                                        @endif

                                        @if($parentOrder->status == $parentOrder::ORDER_STATUS_CANCELLED)
                                        <button type="button" class="btn btn-primary waves-effect refund-btn" data-order-id="{{ $parentOrder->order_id }}"> Refund </button>
                                        @endif

                                        <button type="button" class="btn btn-primary waves-effect view-shipping-location" data-toggle="modal" data-target="#defaultModal" data-shipping-id="{{ $parentOrder->shippinglocation->id }}"> Shipping Location </button>

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
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No Record</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Tracking No</h4>
                </div>
                <div id="modal-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('.add-tracker').on('click', function(){
                $('#modal-body').html('');
                var id = $(this).data('order-id');
                console.log('trackerid :' + id);

                $.get('tracker-modal/' + id, function(data, status){
                    console.log(data);
                    $('#modal-body').html(data);
                });
            });

            $('.view-shipping-location').on('click', function(){
                $('#modal-body').html('');
                var id = $(this).data('shipping-id');
                $.get('shipping-modal/' + id, function(data, status){
                    console.log(data);
                    $('#modal-body').html(data);
                });
            });

            $('.refund-btn').on('click', function(){
                swal({
                    title: "Are you sure?",
                    text: "Are you confirm to perform refund ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).data('order-id');
                        console.log('id ' + id);
                        $.get('/admin/orders/refund/' + id, function(data, status){
                            console.log(data);
                            if(data.status == 'false')
                            {
                                swal("opps... there is some problem while updating status for order");
                            }
                        });
                        location.href = "{{ route('admin.orders.listing') }}?status=3"
                    }
                });
            });
        });
    </script>
@append