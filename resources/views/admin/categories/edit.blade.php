@extends('layouts.admin.master')

@section('content')
@include('components.navigations.breadcrumb', [
    'links' =>
    [
        'Home' => route('admin.dashboard'),
        'Categories' => route('admin.categories.listing'),
        'Edit Category' => 'active',
    ]
])

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Edit Category
                </h2>
            </div>
            <div class="body">
                <form class="form-horizontal" method="POST" action="{{ $type == 0 ? route('admin.categories.update.parent',
                ['parent_category' => $category->id ]) : route('admin.categories.update.child',
                ['child_category' => $category->id ])
                }}">
                    @csrf
                    @method('POST')

                    @if(request()->route('category_id'))
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="name">Parent Category</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 m-t-5">
                                <label for="name">{{ $category->name }}</label>
                            </div>
                        </div>
                    @endif

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Name</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password_2">Status</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group m-t-5">
                                <input type="radio" name="status" value="1" id="active" class="with-gap" aria-required="true" {{ $category->status == '1' ?'checked':''}}>
                                <label for="active">Active</label>

                                <input type="radio" name="status" value="0" id="inactive" class="with-gap" {{ $category->status == 0 ?'checked':''}}>
                                <label for="inactive" class="m-l-20">Inactive</label>
                            </div>
                        </div>
                    </div>

                    @if($type == 0)
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password_2">Featured Category</label>
                        </div>
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5 m-t-5">
                                <input type="radio" name="featured" value="1" id="featured" class="with-gap" aria-required="true" {{ $category->featured=='1'?'checked':''}}>
                                <label for="featured">Featured</label>

                                <input type="radio" name="featured" value="0" id="no" class="with-gap" {{ $category->featured== '0' ? 'checked' : ''}}>
                                <label for="no" class="m-l-20">Non-featured</label>
                        </div>
                    </div>
                    @endif
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection