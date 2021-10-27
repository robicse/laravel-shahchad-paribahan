<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #303641;  min-height: 600px!important;">
    <!-- Brand Logo -->
{{--<a href="#" class="brand-link">
    <img src="{{asset('backend/images/logo.png')}}" width="150" height="100" alt="Aamar Bazar" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    --}}{{--<span class="brand-text font-weight-light">Farazi Home Care</span>--}}{{--
</a>--}}
<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-2 pl-2 mb-2 d-flex">
            <div class="">
                <img src="{{asset('frontend/logo_sazidmart.png')}}" class="" alt="User Image" width="100%">
            </div>
        </div>

    @if (Auth::check()  && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')  )
        <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}"
                           class="nav-link {{Request::is('admin/dashboard') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/vendors*') ) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Vendors
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.vendors.index')}}"
                                   class="nav-link {{Request::is('admin/vendors') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/vendors') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Vendors List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/drivers*') ) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Drivers
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.drivers.index')}}"
                                   class="nav-link {{Request::is('admin/drivers') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/drivers') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Drivers List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin.customer*') ) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Customers
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.customers.index')}}"
                                   class="nav-link {{Request::is('admin/customers') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/customers') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Customer List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/brands*')
                        || Request::is('admin/categories*')
                        || Request::is('admin/subcategories*')
                        //|| Request::is('admin/sub-subcategories*')
                        //|| Request::is('admin/products*')
                        )
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Vehicle Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.brands.index')}}"
                                   class="nav-link {{Request::is('admin/brands*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/brands*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Brands</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.categories.index')}}"
                                   class="nav-link {{Request::is('admin/categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.subcategories.index')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/subcategories*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/subcategories*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Subcategories</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.sub-subcategories.index')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/sub-subcategories*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/sub-subcategories*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Sub Subcategories</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="nav-item">
                                <a href="{{route('admin.vehicles.index')}}"
                                   class="nav-link {{Request::is('admin/vehicles*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/vehicles*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Vehicles</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/roles*') || Request::is('admin/staffs*')) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Role & permission
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.staffs.index')}}"
                                   class="nav-link {{Request::is('admin/staffs*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/staffs*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Staff Manage</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.roles.index')}}"
                                   class="nav-link {{Request::is('admin/role*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/roles*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Role Manage</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{(Request::is('admin/profile*') ) ? 'menu-open' : '' || (Request::is('admin/payment*') ) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>
                                Admin
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.profile.index')}}"
                                   class="nav-link {{Request::is('admin/profile') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/profile') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
{{--                            <li class="nav-item">--}}
{{--                                <a href=""--}}
{{--                                   class="nav-link {{Request::is('admin/payment/history*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/payment/history*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Admin Payments History</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </li>


{{--                    <li class="nav-item has-treeview {{(Request::is('admin/frontend_settings*') ) || (Request::is('admin/logo*') ) ? 'menu-open' : ''}}">--}}
{{--                        <a href="#" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-desktop"></i>--}}
{{--                            <p>--}}
{{--                                Frontend Settings--}}
{{--                                <i class="right fa fa-angle-left"></i>--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                        <ul class="nav nav-treeview">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.home_settings.index')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/frontend_settings*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/frontend_settings*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Home</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.generalsettings.logo')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/logo') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/logo') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Logo Settings</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    <li class="nav-item ">

                        <a href="{{route('admin.site.optimize')}}" class="nav-link {{Request::is('admin/site-optimize*') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>
                                Site Optimize
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        @endif
    </div>
    <!-- /.sidebar -->
</aside>


