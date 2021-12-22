<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">
            <a href="#" class="logo"><img src="{{ asset('images/logo-emp.jpg') }}" height="60" width="90" alt="logo"></a>
        </div>
    </div>
    <nav class="navbar-custom">
        <li class="nav-item dropdown pull-right">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" style="color: black;"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{Auth::guard('employee')->user()->emp_name}}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('emp-logout')}}" 
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{route('emp-logout')}}" method="POST" class="d-none">
                    @csrf
                    <input name = "id" id = "id" type="hidden" value ="{{Auth::guard('employee')->user()->id}}"> 
                </form>
               
            </div>
        </li>
        <div class="clearfix"></div>
    </nav>
</div>