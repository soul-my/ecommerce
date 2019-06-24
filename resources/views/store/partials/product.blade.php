
<!-- Product -->
<section class="bg0 p-t-23 p-b-140">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">
                Product Catalogue
            </h3>
        </div>

        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                    All Category
                </button>

                @foreach($categories as $category)
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".{{ $category->id }}">
                        {{ ucfirst($category->name) }}
                    </button>
                @endforeach
            </div>

            <div class="flex-w flex-c-m m-tb-10">

                <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                    <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                    <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Search
                </div>
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="mtext-107 cl2 size-114 plh2 p-r-15 search" type="text" name="search-product" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="row isotope-grid">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->category->id}}">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ Storage::url($product->images->first()->url) }}" alt="IMG-PRODUCT">

                            <button class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-product={{ $product->id }}>
                                View Product
                            </button>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>

                                <span class="stext-105 cl3">
                                    Name : {{ $product->title }}

                                </span>
                                <span class="stext-105 cl3">
                                        Price : RM {{ $product->pricing->sell_price }}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="{{ asset('frontend/images/icons/icon-heart-01.png') }}" alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('frontend/images/icons/icon-heart-02.png') }}" alt="ICON">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal1 -->
<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
    <div class="overlay-modal1 js-hide-modal1"></div>

    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                <img src="{{ asset('frontend/images/icons/icon-close.png') }}" alt="CLOSE">
            </button>

            <div class="row" id="modal-body">

            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $('.js-show-modal1').on('click', function(){
            $('#modal-body').html('');
            var id = $(this).data('product');
            $.get('store/detail/' + id, function(data, status){
                $('#modal-body').html(data);
            });
        });

        $('.search').keypress(function(event){
            input = $(this).val();
            var keycode = (event.keyCode ? event.keyCode : event.which);

            if(keycode == '13'){
                window.location.href = "?search=" + input;
            }
        });
    </script>
@endsection