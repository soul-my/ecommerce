<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Your Cart
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>
        
        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                @if($cart->getItems()->count() > 0)
                    @foreach($cart->getItems() as $item)
                        @php
                            $product = $item->product()->withAssociates()->first();
                        @endphp

                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <div class="header-cart-item-img">
                                <img src="{{ Storage::url($product['images']['0']['url'])}}" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    {{$item->product['title']}}
                                </a>
                                
                                <span class="header-cart-item-info">
                                RM {{$product['pricing']['sell_price']}}
                                </span>
                            </div>
                        </li>
                        
                    @endforeach
                @else
                    <li></li>
                @endif
                {{-- <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="images/item-cart-03.jpg" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt p-t-8">
                        <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                            Nixon Porter Leather
                        </a>

                        <span class="header-cart-item-info">
                            1 x $17.00
                        </span>
                    </div>
                </li> --}}
            </ul>
            
            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: RM {{ $cart->getTotalValue() }}
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="{{ route('store.cart.show', ['identifier' => $cart->getIdentifier()])}}" class="col-md-12 flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>