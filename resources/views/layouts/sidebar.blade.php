<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">

            <a href="index.html" class="logo"><img src="{{ asset('assets/images/HRMS3.png') }}" height="50" alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                <li>
                    <a href="{{route('admin.dashboard') }}" class="waves-effect">
                        <i class="fa fa-dashboard"></i>
                        <span> {{ __('lang.Dashboard') }} </span>
                    </a>
                </li>
                @can('category_view')
                <li>
                    <a href="{{route('admin.category.dataTable') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span>  {{ __('lang.Category') }}  </span>
                    </a>
                </li>
                @endcan
                @can('subcategory_view')
                <li>
                    <a href="{{  route('admin.subcategory.dataTable') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span> {{ __('lang.SubCategory') }} </span>
                    </a>
                </li>
                @endcan
                @can('users_view')
                <li>
                    <a href="{{  route('admin.getuser') }}" class="waves-effect">
                        <i class="fa fa-users"></i>
                        <span> {{ __('lang.Users') }} </span>
                    </a>
                </li>
                @endcan
                @can('department_view')
                <li>
                    <a href="{{  route('admin.getdept') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span> {{ __('lang.Department') }} </span>
                    </a>
                </li>
                @endcan
                @can('employees_view')
                <li>
                    <a href="{{  route('admin.employee') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span> {{ __('lang.Employees') }} </span>
                    </a>
                </li>
                @endcan
                @can('employees-attendences_view')
                <li>
                    <a href="{{  route('admin.employee-attendences') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span> {{ __('lang.Employee Attendences') }} </span>
                    </a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('admin.blog.blog-view') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span>{{ __('lang.blog') }}</span>
                    </a>
                </li>
                
                @if(Auth::user()->is_admin == 1)
                <li>
                    <a href="{{ route('admin.roles') }}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span>{{ __('lang.Roles') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.admin-user-list')}}" class="waves-effect">
                        <i class="fa fa-list-alt"></i>
                        <span>{{ __('lang.Admin User') }}</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>