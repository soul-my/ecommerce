<div class="image">
    <img src="{{asset("admin/images/user.png")}}" width="48" height="48" alt="User" />
</div>
<div class="info-container">
    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ucfirst(Auth::guard('admin')->user()->name)}}</div>
    <div class="email">{{Auth::guard('admin')->user()->email}}</div>
    <div class="btn-group user-helper-dropdown">
        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
        <ul class="dropdown-menu pull-right">
            <li><a href="{{ route('admin.logout') }}"><i class="material-icons">input</i>Sign Out</a></li>
        </ul>
    </div>
</div>