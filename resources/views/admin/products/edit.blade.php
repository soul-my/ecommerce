@extends('layouts.admin.master')

@section('styles')

<link href="{{ asset('admin/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

<!-- Bootstrap Select Css -->
<link href="{{ asset('admin/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
@include('components.navigations.breadcrumb', [
    'links' =>
    [
        'Products' => route('admin.products.listing'),
        'Edit Product' => 'active',
    ]
])

<form class="form-horizontal" action="{{ route('admin.products.edit.submit', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
@csrf
@method('put')
    <div class="col-md-8 m-b-5">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Edit Product
                        </h2>
                    </div>

                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="title" id="title" class="form-control" value="{{ $product->title }}" placeholder="" required>
                                            <label class="form-label">Title</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="category" required>
                                                <option value="">Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $product->category->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea id="tinymce" name="description">{!! $product->description !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Images
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($product->images as $image)
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" name="files[]" id="file">
                                                <input type="hidden" name="file_id_{{ $i }}" value="{{ $image->id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <a href="javascript:void(0);" class="thumbnail">
                                            <img src="{{ Storage::url($image->url) }}" class="img-responsive">
                                        </a>
                                    </div>

                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                @if($i < 3)
                                    @for ($current = $i; $current <= 3; $current++)
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="file" name="files[]" id="file">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-md-2">
                                            <a href="javascript:void(0);" class="thumbnail">
                                                <img src="http://placehold.it/200x150" class="img-responsive">
                                            </a>
                                        </div>
                                    @endfor
                                @endif
                                {{-- <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="files[]" id="file">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">
                                    <a href="javascript:void(0);" class="thumbnail">
                                        <img src="http://placehold.it/200x150" class="img-responsive">
                                    </a>
                                </div>

                                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="files[]" id="file">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2 col-md-2">
                                    <a href="javascript:void(0);" class="thumbnail">
                                        <img src="http://placehold.it/200x150" class="img-responsive">
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Pricing & Inventory
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="base" id="base" class="form-control" value="{{ $product->pricing->base_price }}" placeholder="Base price" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="sell" id="sell" class="form-control" value="{{ $product->pricing->sell_price }}" placeholder="Sell price" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" placeholder="SKU">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="barcode" id="barcode" class="form-control" value="{{ $product->barcode }}" placeholder="Barcode">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity }}" placeholder="Quantity">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="checkbox" name="allowbuy" id="allowbuy" value="1" class="filled-in" {{ $product->allow_buy == 1 ? 'checked' : '' }}>
                                    <label for="allowbuy">Allow customers to purchase this product when it's out of stock</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Search Engine Optimization (SEO)
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" name="pagetitle" id="pagetitle" class="form-control" value="{{ $product->seo ? $product->seo->page_title : '' }}" placeholder="Page Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="metadescription" id="metadescription" class="form-control" placeholder="Meta Description" maxlength="500">{{ $product->seo ? $product->seo->meta_description : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 m-b-5">
            <div class="row clearfix pull-right">
                <button type="submit" class="btn btn-primary waves-effect">Edit Product</button>
            </div>
        </div>
    </div> <!-- end of col-md-12 -->
</form>
@endsection

@section('scripts')
<!-- TinyMCE -->
<script src="{{ asset('admin/plugins/tinymce/tinymce.js') }}"></script>

<!-- Dropzone Plugin Js -->
<script src="{{ asset('admin/plugins/dropzone/dropzone.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('admin/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<script>
    $(function () {
        $('select').selectpicker();

        //TinyMCE
        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{asset('admin/plugins/tinymce')}}';
    });

    Dropzone.options.frmFileUpload = {
        paramName: "file",
        maxFilesize: 2
    };

    $("#dropzone").dropzone({ url: "/file/post" });
</script>
@endsection