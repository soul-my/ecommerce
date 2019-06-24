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
            Shoping Cart
        </span>
    </div>
</div>
<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85" method="post" action="{{ route('gateway.send') }}">
    <input type="hidden" name="order_id" value="{{ $cart->getIdentifier() }}">
    <input type="hidden" name="amount" value="{{ $cart->getTotalValue() }}">
    <input type="hidden" name="detail" value="{{ $hidden_detail }}">
    @csrf
    @method('post')
    <div class="container">
        <div class="row">
            @if($cart->getItems()->count() > 0)
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                    <th></th>
                                </tr>

                                @foreach($cart->getItems() as $item)
                                    @php
                                        $product = $item->product()->withAssociates()->first();
                                    @endphp
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="{{ Storage::url($product['images']['0']['url'])}}" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">{{ $item->product['title'] }}</td>
                                        <td class="column-3">RM {{ $product['pricing']['sell_price'] }}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus remove-btn"></i>
                                                </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" data-proid="{{ $item->product_id }}" value="{{$item->quantity}}">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus add-btn"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">RM {{ ($product['pricing']['sell_price'] * $item->quantity) }}</td>
                                        <td>
                                            <input type="button" class="col-md-2 flex-c-m stext-101 cl2 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10 delete-btn" value="x" data-productid="{{ $product->id }}" />

                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        {{-- <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Update Cart
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    SubTotal:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    RM {{ $cart->getTotalValue() }}
                                </span>
                            </div>
                        </div>
                        {{-- <div class="flex-w flex-t bor12 p-t-20 p-b-20">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Shipping :
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    RM {{ $shipping }}
                                </span>
                            </div>
                        </div> --}}

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    RM {{ $cart->getTotalValue() }}
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="w-full-ssm">
                                <span class="stext-110 cl2">
                                    Shipping Info:
                                </span>
                            </div>

                            <div class="p-r-18 p-r-0-sm w-full-ssm" style="width: 100%">
                                <div class="">
                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" placeholder="Receiver Name" required>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="addr_1" placeholder="Address Line 1" required>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="addr_2" placeholder="Address Line 2">
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="addr_3" placeholder="Address Line 3">
                                    </div>

                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="state" required>
                                            <option value="">Select a state...</option>
                                            <option> Johor </option>
                                            <option> Kedah </option>
                                            <option> Kelantan </option>
                                            <option> Kuala Lumpur </option>
                                            <option> Labuan </option>
                                            <option> Melaka </option>
                                            <option> Negeri Sembilan </option>
                                            <option> Pahang </option>
                                            <option> Perak </option>
                                            <option> Perlis </option>
                                            <option> Pulau Pinang </option>
                                            <option> Putrajaya </option>
                                            <option> Sabah </option>
                                            <option> Sarawak </option>
                                            <option> Selangor </option>
                                            <option> Terengganu </option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="city" placeholder="State /  country" required>
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip" required>
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="phone" placeholder="Phone number" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="">
                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Checkout
                            </button>
                        </a>
                    </div>
                </div>

            @else
            <div class="col-md-12 text-center">
                <i class="zmdi zmdi-hc-4x zmdi-shopping-basket"></i>
                <h3> Your cart is empty </h3>
            </div>
            @endif
        </div>
    </div>
</form>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('.delete-btn').on('click', function(){
                swal({
                    title: "Are you sure?",
                    text: "Are you confirm to delete this item from your cart ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).data('productid');
                        console.log('id ' + id);
                        $.get('/store/cart/remove-from-cart/' + id, function(data, status){
                            console.log(data);
                            if(data.status == 'false')
                            {
                                swal("opps... there is some problem while updating status for order");
                            }
                        });
                        location.href = "{{ route('store.cart.show', ['identifier' => $cart->getIdentifier()]) }}"
                    }
                });
            });

            $('.num-product').on('change', function(){
                var proID = $(this).data('proid');
                var quantity = $(this).val();

                $.get('/store/cart/update/' + proID + '/' + quantity, function(data, status){
                    location.href = "{{ route('store.cart.show', ['identifier' => $cart->getIdentifier()])}}";
                });
            });

        });
    </script>
@endsection