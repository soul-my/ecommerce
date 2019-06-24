@extends('layouts.admin.master')

@section('content')
@include('components.navigations.breadcrumb', [
    'links' => 
    [
        'Home' => route('admin.dashboard'),
        'Categories' => route('admin.categories.listing'),
        'Add New Category' => 'active',
    ]
])

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Create New Category
                </h2>
            </div>
            <div class="body">
                <form class="form-horizontal" method="POST" action="{{ request()->route('category_id') ? route('admin.categories.add.child.submit', ['category_id' => request()->route('category_id')]) : route('admin.categories.add.submit')}}">
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
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="">
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
                                <input type="radio" name="status" value="1" id="active" class="with-gap" aria-required="true" {{old('status')=='1' || empty(old('status'))?'checked':''}}>
                                <label for="active">Active</label>

                                <input type="radio" name="status" value="0" id="inactive" class="with-gap" {{old('status')=='1' || empty(old('status'))?'checked':''}}>
                                <label for="inactive" class="m-l-20">Inactive</label>
                            </div>
                        </div>
                    </div>

                    @if(!request()->route('category_id'))
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password_2">Featured Category</label>
                        </div>
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5 m-t-5">
                                <input type="radio" name="featured" value="1" id="featured" class="with-gap" aria-required="true" {{old('featured')=='1'?'checked':''}}>
                                <label for="featured">Featured</label>

                                <input type="radio" name="featured" value="0" id="no" class="with-gap" {{old('featured')=='0' || empty(old('featured'))?'checked':''}}>
                                <label for="no" class="m-l-20">Non-featured</label>
                        </div>
                    </div>
                    @endif
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Create</button>
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