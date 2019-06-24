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
                            @if($type == 0)
                                List of Categories
                            @else
                                Sub Categories
                            @endif
                            <small></small>
                        </h2>
                        <div class="header-dropdown m-r--5">
                            <a href="{{ request()->route('category_id') ? route('admin.categories.add', ['category_id' => request()->route('category_id')]) : route('admin.categories.add') }}">
                                <button type="button" class="btn btn-primary waves-effect">New Category</button>
                            </a>
                        </div>
                    </div>

                    @include('admin.partials.search')

                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>STATUS</th>
                                    @if($type == 0)
                                        <th>FEATURED</th>
                                    @endif
                                    <th>ACTION</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @if($categories->count() > 0)
                                    @foreach($categories as $category)
                                        <tr>
                                            <th scope="row">{{$category->id}}</th>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->statusName}}</td>

                                            @if($type == 0)
                                            <td>{{$category->featuredName}}</td>
                                            @endif

                                            <td>
                                                <div class="row">
                                                    @if($type == 0)
                                                        <a href="{{ route('admin.categories.show', ['parent_category' => $category->id]) }}">
                                                            <button type="button" class="btn btn-default waves-effect"><i class="material-icons">create</i> <span>EDIT</span></button>
                                                        </a>
                                                    @endif

                                                    @if($type == 1)
                                                    <a href="{{ route('admin.categories.show', ['parent_category' => $category->category_id, 'child_category' => $category->id]) }}">
                                                            <button type="button" class="btn btn-default waves-effect"><i class="material-icons">create</i> <span>EDIT</span></button>
                                                        </a>
                                                    @endif

                                                    @if($category->status == 0)
                                                        <a href="{{ route('admin.categories.activate', ['cat_id' => $category->id, 'type' => $type == 0 ? 'parent' : 'child']) }}">
                                                            <button type="button" class="btn btn-default waves-effect"><i class="material-icons">done</i> <span>Active</span></button>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.categories.deactivate', ['cat_id' => $category->id, 'type' => $type == 0 ? 'parent' : 'child']) }}">
                                                            <button type="button" class="btn btn-default waves-effect"><i class="material-icons">repeat</i> <span>In-Active</span></button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>

                                            @if($type == 0)
                                            <td>
                                                <div class="row">
                                                    <a href="{{route('admin.categories.listing', ['category_id' => $category->id])}}">
                                                        <button type="button" class="btn bg-deep-purple waves-effect"><i class="material-icons">subject</i> <span>Manage Sub Category</span></button>
                                                    </a>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No Record</td>

                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection

