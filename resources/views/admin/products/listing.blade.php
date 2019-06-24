@extends('layouts.admin.master')

@section('styles')

@endsection

@section('content')
@include('components.navigations.breadcrumb', [
    'links' =>
    [
        'Home' => route('admin.dashboard'),
        'Product Listing' => 'active',
    ]
])

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    List of Products
                    <small></small>
                </h2>
                <div class="header-dropdown m-r--5">
                    <a href="{{ route('admin.products.add') }}">
                        <button type="button" class="btn btn-primary waves-effect">New Product</button>
                    </a>
                </div>
            </div>

            @include('admin.partials.search')

            <div class="body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Quantity Sold</th>
                            <th>Base Price</th>
                            <th>Sell Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if($products->count() > 0)
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->quantity_sold }}</td>
                                    <td>{{ $product->pricing->base_price }}</td>
                                    <td>{{ $product->pricing->sell_price }}</td>
                                    <td>
                                        <div class="row">
                                            <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}">
                                                <button type="button" class="btn btn-default waves-effect"><i class="material-icons">create</i> <span>EDIT</span></button>
                                            </a>
                                            @if($product->status == 0)
                                            <a href="{{ route('admin.products.activate', ['pro_id' => $product->id]) }}">
                                                <button type="button" class="btn btn-default waves-effect"><i class="material-icons">done</i> <span>Enabled</span></button>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.products.deactivate', ['pro_id' => $product->id]) }}">
                                                <button type="button" class="btn btn-default waves-effect"><i class="material-icons">repeat</i> <span>Disabled</span></button>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="8" class="text-center">No Record</td>

                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection