<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>&nbsp;</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row p-5">
                                <div class="col-md-6">
                                    <img src="{{ asset('frontend/images/logo/logo_small.png') }}">
                                </div>

                                <div class="col-md-6 text-right">
                                    <p class="font-weight-bold mb-1">Invoice No : #{{$parentOrder->order_id}}</p>
                                    <p class="text-muted">Issue date: {{ (new \Carbon\Carbon($parentOrder->created_at))->toDayDateTimeString() }}</p>
                                </div>
                            </div>

                            <hr class="my-5">

                            <div class="row pb-5 p-5">
                                <div class="col-md-6">
                                    <p class="font-weight-bold mb-4">Client Information</p>
                                    <p class="mb-1">{{ $parentOrder->shippinglocation->receiver_name }}</p>
                                    <p>{{ $parentOrder->shippinglocation->address_1}}</p>
                                    <p>{{ $parentOrder->shippinglocation->address_2}}</p>
                                    <p>{{ $parentOrder->shippinglocation->address_3}}</p>
                                    <p class="mb-1">{{ $parentOrder->shippinglocation->state}}, {{ $parentOrder->shippinglocation->city}}</p>
                                    <p class="mb-1">{{ $parentOrder->shippinglocation->phone_no}}</p>
                                </div>

                                <div class="col-md-6 text-right">
                                    <p class="font-weight-bold mb-4">Payment Details</p>
                                    <p class="mb-1"><span class="text-muted">Payment Via: </span> FPX Banking</p>
                                    <p class="mb-1"><span class="text-muted">Payer Name: </span> {{ $parentOrder->user->name }}</p>
                                </div>
                            </div>

                            <div class="row p-5">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">Item</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">Quantity</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">Unit Cost</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($parentOrder->orders as $order)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $order->product->title }}</td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>RM {{ $order->sell_price }}</td>
                                                    <td>RM {{ $order->total() }}</td>
                                                </tr>

                                                @php
                                                    $i++;
                                                @endphp

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                                <div class="py-3 px-5 text-right">
                                    <div class="mb-2">Grand Total</div>
                                    <div class="h2 font-weight-light">RM {{ $parentOrder->grandTotal() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function(){
                window.print();
            });
        </script>
    </body>
</html>

