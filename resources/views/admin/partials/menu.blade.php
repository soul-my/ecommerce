<ul class="list">
    <li class="header">MAIN NAVIGATION</li>
    <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard')}}">
            <i class="material-icons">home</i>
            <span>Home</span>
        </a>
    </li>
    <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">category</i>
            <span>Categories</span>
        </a>
        <ul class="ml-menu">
            <li class="{{ Request::is('admin/categories/add') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.add') }}">
                    <i class="material-icons">add</i> <span class="child-list">Add Category</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/categories/listing') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.listing') }}">
                    <i class="material-icons">list</i> <span class="child-list">Manage Categories</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="{{ Request::is('admin/products*') ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">shopping_basket</i>
            <span>Products</span>
        </a>
        <ul class="ml-menu">
            <li class="{{ Request::is('admin/products/add') ? 'active' : '' }}">
                <a href="{{ route('admin.products.add') }}">
                    <i class="material-icons">add</i> <span class="child-list">Add Product</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/products/listing') ? 'active' : '' }}">
                <a href="{{ route('admin.products.listing') }}">
                    <i class="material-icons">list</i> <span class="child-list">Manage Product</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="{{ Request::is('admin/orders*') ? 'active' : '' }}">
        <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">group</i>
            <span>Orders</span>
        </a>
        <ul class="ml-menu">
            <li class="{{ !Request::input('status') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.listing') }}">
                    <i class="material-icons">list</i> <span class="child-list">All</span>
                </a>
            </li>

            <li class="{{ Request::input('status') == 2 ? 'active' : '' }}">
                <a href="{{ route('admin.orders.listing') }}?status=2">
                    <i class="material-icons">local_shipping</i> <span class="child-list">Shipped</span>
                </a>
            </li>

            <li class="{{ Request::input('status') == 4 ? 'active' : '' }}">
                <a href="{{ route('admin.orders.listing') }}?status=4">
                    <i class="material-icons">check_circle</i> <span class="child-list">Completed</span>
                </a>
            </li>

            <li class="{{ Request::input('status') == 3 ? 'active' : '' }}">
                <a href="{{ route('admin.orders.listing') }}?status=3">
                    <i class="material-icons">remove_circle</i> <span class="child-list">Cancelled</span>
                </a>
            </li>

            <li class="{{ Request::input('status') == 5 ? 'active' : '' }}">
                <a href="{{ route('admin.orders.listing') }}?status=5">
                    <i class="material-icons">remove_circle</i> <span class="child-list">Refunded</span>
                </a>
            </li>
        </ul>
    </li>
</ul>
<div class="legal">
        <div class="version">
            <b>build : </b>{{env('APP_BUILD')}} | <b>version : </b> {{env('APP_VERSION')}}
        </div>
    </div>