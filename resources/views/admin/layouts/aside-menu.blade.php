    <aside class="app-sidebar">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="{{ url('/' . ($page = '')) }}">
                <img src="{{ URL::asset('assets/images/brand/logo.png') }}" style='height:3rem'
                    class="header-brand-img desktop-lgo" alt="Ariba logo">
                <img src="{{ URL::asset('assets/images/brand/logo1.png') }}" class="header-brand-img dark-logo"
                    alt="Ariba logo">
                <img src="{{ URL::asset('assets/images/brand/favicon.png') }}" class="header-brand-img mobile-logo"
                    alt="Ariba logo">
                <img src="{{ URL::asset('assets/images/brand/favicon1.png') }}"
                    class="header-brand-img darkmobile-logo" alt="Ariba logo">
            </a>
        </div>
        <style>@media (min-width: 767px){
                .sidebar-mini.sidenav-toggled .app-sidebar {
                    max-height: 100%;
                }}
        </style>
        <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <img src="{{ URL::asset('assets/images/users/user_icon.png') }}" alt="user-img"
                        class="avatar-xl rounded-circle mb-1">
                </div>
                <div class="user-info">
                    <h5 class=" mb-1">{{ Auth::guard("web")->user()->firstname ?? '' }} {{ Auth::guard("web")->user()->lastname ?? '' }} <i
                            class="ion-checkmark-circled  text-success fs-12"></i></h5>
                    <span class="text-muted app-sidebar__user-name text-sm"></span>
                </div>
            </div>
            <!--	<div class="sidebar-navs">
       <ul class="nav nav-pills-circle">
        <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Support">
         <a class="icon" href="{{ url('/' . ($page = '#')) }}" >
          <i class="las la-life-ring header-icons"></i>
         </a>
        </li>
        <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Documentation">
         <a class="icon" href="{{ url('/' . ($page = '#')) }}">
          <i class="las  la-file-alt header-icons"></i>
         </a>
        </li>
        <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Projects">
         <a href="{{ url('/' . ($page = '#')) }}" class="icon">
          <i class="las la-project-diagram header-icons"></i>
         </a>
        </li>
        <li class="nav-item" data-placement="top" data-toggle="tooltip" title="Settins">
         <a class="icon" href="{{ url('/' . ($page = '#')) }}">
          <i class="las la-cog header-icons"></i>
         </a>
        </li>
       </ul>
      </div>-->
        </div>
        <ul class="side-menu app-sidebar3">
            <li class="side-item side-item-category mt-4">Main</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ url('/admin/dashboard') }}">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                        width="24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                    </svg>
                    <span class="side-menu__label">Dashboard</span></a>
            </li>

            <li class="side-item side-item-category  mt-4">Ariba Management</li>
            @if (Auth::user()->hasAnyPermission(['product-list', 'product-edit', 'product-create', 'product-check']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M17.63 5.84C17.27 5.33 16.67 5 16 5L5 5.01C3.9 5.01 3 5.9 3 7v10c0 1.1.9 1.99 2 1.99L16 19c.67 0 1.27-.33 1.63-.84L22 12l-4.37-6.16zM16 17H5V7h11l3.55 5L16 17z">
                        </svg>
                        <span class="side-menu__label">Products</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('product-list')
                                <a class="slide-item" href="{{ url('/admin/product') }}">All Products</a>
                                <a class="slide-item" href="{{ url('/admin/product/pending') }}">Pending Product</a>
                                <a class="slide-item" href="{{ url('/admin/product/verified') }}">Verified Product</a>
                            @endcan
                            @can('product-create')
                                <a class="slide-item" href="{{ url('/admin/product/add') }}">Add a Product</a>
                            @endcan
                            @can('product-check')
                                <a class="slide-item" href="{{ url('/admin/product/check') }}">Check Product</a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['category-list', 'category-edit', 'category-create']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Categories</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('category-list')
                                <a class="slide-item" href="{{ url('/admin/category') }}">All Categories</a>
                            @endcan
                            @can('category-create')
                                <a class="slide-item" href="{{ url('/admin/category/add') }}">Add Category</a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['vendor-list', 'vendor-edit', 'vendor-create', 'vendor-approve', 'vendor-disapprove']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7-.25c.22 0 .41.1.55.25.12.13.2.31.2.5 0 .41-.34.75-.75.75s-.75-.34-.75-.75c0-.19.08-.37.2-.5.14-.15.33-.25.55-.25zM19 19H5V5h14v14zM12 6c-1.65 0-3 1.35-3 3s1.35 3 3 3 3-1.35 3-3-1.35-3-3-3zm0 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-6 6.47V18h12v-1.53c0-2.5-3.97-3.58-6-3.58s-6 1.07-6 3.58zM8.31 16c.69-.56 2.38-1.12 3.69-1.12s3.01.56 3.69 1.12H8.31z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Vendors</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('vendor-list')
                                <a class="slide-item" href="{{ url('/admin/vendor') }}">All Vendors</a>
                                <a class="slide-item" href="{{ url('/admin/vendor/first-approval') }}">First Approval</a>
                                <a class="slide-item" href="{{ url('/admin/vendor/pending') }}">Pending Vendors</a>
                                <a class="slide-item" href="{{ url('/admin/vendor/second-approval') }}">Second Approval</a>
                                <a class="slide-item" href="{{ url('/admin/vendor/verified') }}">Verified Vendors</a>
                            @endcan
                            @can('vendor-create')
                                <a class="slide-item" href="{{ url('/admin/vendor/add') }}">Add Vendor</a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['review-list']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><g><path d="M20,2H4C2.9,2,2,2.9,2,4v18l4-4h14c1.1,0,2-0.9,2-2V4C22,2.9,21.1,2,20,2z M20,16H5.17L4,17.17V4h16V16z"/><polygon points="12,15 13.57,11.57 17,10 13.57,8.43 12,5 10.43,8.43 7,10 10.43,11.57"/></g></g></svg>
                    <span class="side-menu__label">Review</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/admin/review') }}">Vendor Review</a>
                        
                        <a class="slide-item" href="{{ url('/admin/product/review') }}">Product Review</a>
                    </li>
                </ul>
            </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['depot-list', 'depot-edit', 'depot-create', 'archive-list', 'archive-edit','archive-create']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                    d="M11,6C12.38,6 13.63,6.56 14.54,7.46L12,10H18V4L15.95,6.05C14.68,4.78 12.93,4 11,4C7.47,4 4.57,6.61 4.08,10H6.1C6.56,7.72 8.58,6 11,6M16.64,15.14C17.3,14.24 17.76,13.17 17.92,12H15.9C15.44,14.28 13.42,16 11,16C9.62,16 8.37,15.44 7.46,14.54L10,12H4V18L6.05,15.95C7.32,17.22 9.07,18 11,18C12.55,18 14,17.5 15.14,16.64L20,21.5L21.5,20L16.64,15.14Z" />
                        </svg>
                        <span class="side-menu__label">Product Movement</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('depot-list')
                                <a class="slide-item" href="{{ url('/admin/depot') }}">Depot</a>
                            @endcan
                            @can('archive-list')
                                <a class="slide-item" href="{{ url('/admin/reseller-archive') }}">Product Movement</a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->hasAnyPermission(['employee-list', 'employee-create', 'company-list']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3z"></path>
                        </svg>
                        <span class="side-menu__label">Employees</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('employee-list')
                                <a class="slide-item" href="{{ url('/admin/employee') }}">Employees List</a>
                            @endcan
                            @can('employee-create')
                                <a class="slide-item" href="{{ url('/admin/employee/add') }}">Add Employee</a>
                            @endcan
                            @can('company-list')
                                <a class="slide-item" href="{{ url('/admin/company') }}">Companies List</a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endif()
            @if (Auth::user()->hasAnyPermission(['salesagent-first-approve', 'salesagent-pending', 'salesagent-second-approve', 'salesagent-approved', 'salesagent-blocked']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z">
                        </svg>
                        <span class="side-menu__label">Sales Agents</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('salesagent-first-approve')
                                <a class="slide-item" href="{{ url('/admin/sales-agent/first-approval') }}">First
                                    Approval</a>
                            @endcan
                            @can('salesagent-pending')
                                <a class="slide-item" href="{{ url('/admin/sales-agent/pending') }}">Pending List</a>
                            @endcan
                            @can('salesagent-second-approve')
                                <a class="slide-item" href="{{ url('/admin/sales-agent/second-approval') }}">Second
                                    Approval</a>
                            @endcan
                            @can('salesagent-approved')
                                <a class="slide-item" href="{{ url('/admin/sales-agent/approved') }}">Approved List</a>
                            @endcan
                            @can('salesagent-blocked')
                                <a class="slide-item" href="{{ url('/admin/sales-agent/blocked') }}">Blocked List</a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endif()
            @if (Auth::user()->hasAnyPermission(['customer-list', 'customer-edit', 'customer-create']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M11 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm-1 12H5c.2-.63 2.55-1.67 4.93-1.94h.03l.46-.45L12 14.06c-.39-.04-.68-.06-1-.06-2.67 0-8 1.34-8 4v2h9l-2-2zm10.6-5.5l-5.13 5.17-2.07-2.08L12 17l3.47 3.5L22 13.91z">
                        </svg>
                        <span class="side-menu__label">Customers</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('customer-list')
                                <a class="slide-item" href="{{ url('/admin/customer') }}">Customers List</a>
                                <a class="slide-item" href="{{ url('/admin/customer/blocked') }}">Blocked Customer</a>
                            @endcan
                            @can('customer-create')
                                <a class="slide-item" href="{{ url('/admin/customer/add') }}">Add Customer</a>
                            @endcan
                    </ul>
                </li>
            @endif()
            @if (Auth::user()->hasAnyPermission(['order-to-verify', 'order-list']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                            width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                        </svg>
                        <span class="side-menu__label">Orders</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('order-to-verify')
                                <a class="slide-item" href="{{ url('/admin/order/to-verify') }}">Order To Verify</a>
                            @endcan
                            @can('order-list')
                                <a class="slide-item" href="{{ url('/admin/order/waiting-approval') }}">Waiting For
                                    Approval</a>
                                <a class="slide-item" href="{{ url('/admin/order/approved') }}">Order Approved</a>
                                <a class="slide-item" href="{{ url('/admin/order/waiting-shipping') }}">Waiting for Shipping</a>
                                <a class="slide-item" href="{{ url('/admin/order/denied') }}">Order To clarify</a>
                                <a class="slide-item" href="{{ url('/admin/order/canceled') }}">Order Canceled</a>
                                <a class="slide-item" href="{{ url('/admin/order/finished') }}">Order Finished</a>
                            @endcan
                    </ul>
                </li>
            @endif()
             <!--<li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                        width="24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M17,11V3H7v4H3v14h8v-4h2v4h8V11H17z M7,19H5v-2h2V19z M7,15H5v-2h2V15z M7,11H5V9h2V11z M11,15H9v-2h2V15z M11,11H9V9h2 V11z M11,7H9V5h2V7z M15,15h-2v-2h2V15z M15,11h-2V9h2V11z M15,7h-2V5h2V7z M19,19h-2v-2h2V19z M19,15h-2v-2h2V15z">
                    </svg>
                    <span class="side-menu__label">Master Database</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/admin/master/to-verify') }}">Product To Verified</a>
                        <a class="slide-item" href="{{ url('/admin/master/waiting-approval') }}">Verified</a>
                        <a class="slide-item" href="{{ url('/admin/master/product') }}">Master Product</a>
                </ul>
            </li>-->
            @if (Auth::user()->hasAnyPermission(['user-list', 'user-edit', 'user-create', 'role-list', 'role-edit', 'role-create', 'permission-list', 'permission-edit', 'permission-create']))
                <li class="slide mt-3">
                    <a class="side-menu__item" data-toggle="slide">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg"
                            enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0,0h24v24H0V0z" fill="none" />
                                    <path
                                        d="M4,18v-0.65c0-0.34,0.16-0.66,0.41-0.81C6.1,15.53,8.03,15,10,15c0.03,0,0.05,0,0.08,0.01c0.1-0.7,0.3-1.37,0.59-1.98 C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26c-0.42-0.6-0.75-1.28-0.97-2H4z" />
                                    <path
                                        d="M10,12c2.21,0,4-1.79,4-4s-1.79-4-4-4C7.79,4,6,5.79,6,8S7.79,12,10,12z M10,6c1.1,0,2,0.9,2,2s-0.9,2-2,2 c-1.1,0-2-0.9-2-2S8.9,6,10,6z" />
                                    <path
                                        d="M20.75,16c0-0.22-0.03-0.42-0.06-0.63l1.14-1.01l-1-1.73l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49 c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49l-1,1.73l1.14,1.01c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1.01 l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1.01 C20.72,16.42,20.75,16.22,20.75,16z M17,18c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S18.1,18,17,18z" />
                        </svg>

                        <span class="side-menu__label">User Roles</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            @can('user-list')
                                <a class="slide-item" href="{{ url('/admin/user') }}">Users</a>
                            @endcan
                            @can('role-list')
                                <a class="slide-item" href="{{ url('/admin/role') }}">Roles</a>
                            @endcan
                            @can('permission-list')
                                <a class="slide-item" href="{{ url('/admin/permission') }}">Permissions</a>
                            @endcan
                    </ul>
                </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['zone-list', 'city-list']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg"
                        enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                        <g>
                            <path d="M0,0h24v24H0V0z" fill="none" />
                        </g>
                        <g>
                            <g>
                                <path
                                    d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z" />
                            </g>
                        </g>
                    </svg>

                    <span class="side-menu__label">City / Zones</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        @can('zone-list')
                            <a class="slide-item" href="{{ url('/admin/zone') }}">Zone List</a>
                        @endcan
                        @can('city-list')
                            <a class="slide-item" href="{{ url('/admin/city') }}">City List</a>
                        @endcan
                </ul>
            </li>
            @endif()
            @if (Auth::user()->hasAnyPermission(['stock-list', 'stock-add']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg"
                        enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                        <g>
                            <path d="M0,0h24v24H0V0z" fill="none" />
                        </g>
                        <g>
                            <g>
                                <path
                                d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM12 17.5L6.5 12H10v-2h4v2h3.5L12 17.5zM5.12 5l.81-1h12l.94 1H5.12z">
                            </g>
                        </g>
                    </svg>

                    <span class="side-menu__label">Stock</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                      
                            <a class="slide-item" href="{{ url('/admin/stock/search-product') }}">Stock Management</a>
                     
                </ul>
            </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['order-approved','order-shipped','order-complete']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" 
                        fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0
                        1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zm-.5 1.5l1.96 2.5H17V9.5h2.5zM6 18c-.55 
                        0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2.22-3c-.55-.61-1.33-1-2.22-1s-1.67.39-2.22 
                        1H3V6h12v9H8.22zM18 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
                    </svg>
                    <span class="side-menu__label">Delivery</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        @can('order-approved')
                            <a class="slide-item" href="{{ url('/admin/orders/approved') }}">Order Opened</a>
                        @endcan
                        @can('order-shipped')
                            <a class="slide-item" href="{{ url('/admin/orders/shipped') }}">Order Shipped</a>
                        @endcan
                        @can('order-complete')
                            <a class="slide-item" href="{{ url('/admin/orders/finished') }}">Order Compelete</a>
                        @endcan
                </ul>
            </li>
            @endif()

            @if (Auth::user()->hasAnyPermission(['courier']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24" y="0"/></g><g><g><g><path d="M19,7c0-1.1-0.9-2-2-2h-3v2h3v2.65L13.52,14H10V9H6c-2.21,0-4,1.79-4,4v3h2c0,1.66,1.34,3,3,3s3-1.34,3-3h4.48L19,10.35 V7z M4,14v-1c0-1.1,0.9-2,2-2h2v3H4z M7,17c-0.55,0-1-0.45-1-1h2C8,16.55,7.55,17,7,17z"/><rect height="2" width="5" x="5" y="6"/><path d="M19,13c-1.66,0-3,1.34-3,3s1.34,3,3,3s3-1.34,3-3S20.66,13,19,13z M19,17c-0.55,0-1-0.45-1-1s0.45-1,1-1s1,0.45,1,1 C20,16.55,19.55,17,19,17z"/></g></g></g></svg>
                    <span class="side-menu__label">Courier</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        @can('courier')
                            <a class="slide-item" href="{{ url('/admin/courier') }}">Courier Services List</a>
                        @endcan
                        @can('customer-create')
                            <a class="slide-item" href="{{ url('/admin/courier/add') }}">Add Courier Service</a>
                        @endcan
                </ul>
            </li>
            @endif()
            
            @if (Auth::user()->hasAnyPermission(['invoice-list','invoice-create']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg"
                            enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0,0h24v24H0V0z" fill="none" /><path d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5zM19 19.09H5V4.91h14v14.18zM6 15h12v2H6zm0-4h12v2H6zm0-4h12v2H6z"/></svg>
                    <span class="side-menu__label">Archive</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/admin/invoice') }}">Archive</a>
                    </li>
                </ul>
            </li>
            @endif()
            
    
            @if (Auth::user()->hasAnyPermission(['invoice-list','invoice-create']))
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24" y="0"/></g><g><path d="M19.48,12.35c-1.57-4.08-7.16-4.3-5.81-10.23c0.1-0.44-0.37-0.78-0.75-0.55C9.29,3.71,6.68,8,8.87,13.62 c0.18,0.46-0.36,0.89-0.75,0.59c-1.81-1.37-2-3.34-1.84-4.75c0.06-0.52-0.62-0.77-0.91-0.34C4.69,10.16,4,11.84,4,14.37 c0.38,5.6,5.11,7.32,6.81,7.54c2.43,0.31,5.06-0.14,6.95-1.87C19.84,18.11,20.6,15.03,19.48,12.35z M10.2,17.38 c1.44-0.35,2.18-1.39,2.38-2.31c0.33-1.43-0.96-2.83-0.09-5.09c0.33,1.87,3.27,3.04,3.27,5.08C15.84,17.59,13.1,19.76,10.2,17.38z"/></g></svg>
                    <span class="side-menu__label">Firewall</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/admin/firewall/blacklist') }}">Blacklist</a>
                        <a class="slide-item" href="{{ url('/admin/firewall/whitelist') }}">Whitelist</a>
                    </li>
                </ul>
            </li>
            @endif()

           
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    <span class="side-menu__label">Accountancy</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/admin/muhasebe/cpc') }}">CPC</a>
                        <a class="slide-item" href="{{ url('/admin/muhasebe/bilan-passif') }}">Bilan Passif</a>
                        <a class="slide-item" href="{{ url('/admin/muhasebe/bilan-actif') }}">Bilan Actif</a>
                    </li>
                </ul>
            </li>
         

    </aside>
    <!--aside closed-->
