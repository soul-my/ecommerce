<div class="col-md-6 col-lg-7 p-b-30">
    <div class="p-l-25 p-r-30 p-lr-0-lg">
        <div class="wrap-slick3 flex-sb flex-w">
            <div class="wrap-slick3-dots"></div>
            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

            <div class="slick3 gallery-lb">
                <div class="item-slick3" data-thumb="{{ url('storage/' . $product->images->first()->url) }}">
                    <div class="wrap-pic-w pos-relative">
                        <img src="{{ url('storage/' . $product->images->first()->url) }}" alt="IMG-PRODUCT">

                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ url('storage/' . $product->images->first()->url) }}">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-5 p-b-30">
    <div class="p-r-50 p-t-5 p-lr-0-lg">
        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
            {{ $product->title }}
        </h4>

        <span class="mtext-106 cl2">
            RM {{ $product->pricing->sell_price }}
        </span>

        <p class="stext-102 cl3 p-t-23">
            {!! $product->description !!}
        </p>

        <!--  -->
        <form method="post" action="{{ route('store.cart.add') }}">
            @csrf
            @method('post')
            <input type="hidden" name="pro_id" value="{{ $product->id }}">
            <div class="p-t-33">
                <div class="flex-w flex-r-m p-b-10">
                    <div class="size-204 flex-w flex-m respon6-next">

                        @if($product->quantity > 0 || $product->allow_buy == 1)
                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m quantity-minus">
                                <i class="fs-16 zmdi zmdi-minus"></i>
                            </div>

                            <input class="mtext-104 cl3 txt-center num-product" id="detail-quantity" type="number" name="quantity" value="1">

                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m quantity-plus">
                                <i class="fs-16 zmdi zmdi-plus"></i>
                            </div>
                        </div>

                        <a href="{{ route('store.cart.add', ['pro_id' => $product->id]) }}">
                            <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                Add to cart
                            </button>
                        </a>
                        @else
                            <input type="button" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" value="Out Of Stocks" />

                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function(){
        $(".js-select2").each(function(){
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })

        $('.gallery-lb').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled:true
            },
            mainClass: 'mfp-fade'
            });
        });

        $('.quantity-plus').on('click', function(){
            var current = $('#detail-quantity').val();
            var quantity = parseInt(current) + 1;
            $('#detail-quantity').val(quantity);

        });

        $('.quantity-minus').on('click', function(){
            var current = $('#detail-quantity').val();
            current = parseInt(current);
            if(current > 1)
            {
                var quantity = current - 1;
                $('#detail-quantity').val(quantity);
            }
        });
    })
</script>