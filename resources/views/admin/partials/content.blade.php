
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">shop_two</i>
                </div>
                <div class="content">
                    <div class="text">DAILY ORDERS</div>
                    <div class="number count-to">{{ $report->dailyOrders()->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">done_all</i>
                </div>
                <div class="content">
                    <div class="text">ORDERS COMPLETED</div>
                    <div class="number count-to">{{ $report->completedOrders()->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">Monthly Sales</div>
                    <div class="number count-to">RM {{ $report->monthlySales() }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->

    <div class="row clearfix">
        <!-- Popular Info -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>The Most Popular Products</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Quantity Sold</th>
                                    <th>Quantity Left</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report->getPopularProducts() as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->quantity_sold }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.listing') }}?search={{ $product->title }}">
                                                <button type="button" class="btn btn-primary waves-effect add-tracker"> See Product </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Popular Info -->
    </div>

    <div class="row clearfix">
        <!-- Popular Info -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Sold Out Products</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Sold Out Since</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($report->getSoldOutProducts()->count() > 0)
                                    @foreach($report->getSoldOutProducts() as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.listing') }}?search={{ $product->title }}">
                                                <button type="button" class="btn btn-primary waves-effect add-tracker"> Edit Product </button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No Record</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Popular Info -->
    </div>
</div>
