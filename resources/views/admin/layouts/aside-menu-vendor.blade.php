    <aside class="app-sidebar">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="{{ url('/vendor/dashboard' . ($page = '')) }}">
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
            <a href="{{route('vendor-account')}}">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <img src="{{ URL::asset('assets/images/users/user_icon.png') }}" alt="user-img"
                        class="avatar-xl rounded-circle mb-1">
                </div>
                <div class="user-info">
                    <h5 class=" mb-1"> {{$store_name->name ?? ''}} &nbsp;<i
                            class="ion-checkmark-circled  text-success fs-12"></i></h5>
                    <span class="text-muted app-sidebar__user-name text-sm">{{ Auth::guard("vendor")->user()->firstname ?? '' }} {{   Auth::guard("vendor")->user()->lastname ?? '' }}</span>
            </div>
            </div>
        </a>
        </div>

        <ul class="side-menu app-sidebar3 mt-4">
            <li class="slide">
                <a class="side-menu__item mt-4" href="{{ url('/vendor/dashboard') }}">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                        width="24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                    </svg>
                    <span class="side-menu__label">Dashboard</span></a>
            </li>

            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.09-.16-.26-.25-.44-.25-.06 0-.12.01-.17.03l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.06-.02-.12-.03-.18-.03-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.09.16.26.25.44.25.06 0 .12-.01.17-.03l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
                    <span class="side-menu__label">General</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('vendor-account') }}">My Data</a>
                            <a class="slide-item" href="{{ url('/vendor/employee') }}">My Users</a>
                            <a class="slide-item" href="{{ url('/vendor/role') }}">My User Group</a>
                    </li>
                </ul>
            </li>

            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                        width="24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M17.63 5.84C17.27 5.33 16.67 5 16 5L5 5.01C3.9 5.01 3 5.9 3 7v10c0 1.1.9 1.99 2 1.99L16 19c.67 0 1.27-.33 1.63-.84L22 12l-4.37-6.16zM16 17H5V7h11l3.55 5L16 17z"></path>
                    </svg>
                    <span class="side-menu__label">Products</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                            <a class="slide-item" href="{{ url('/vendor/product') }}">All Products</a>
                            <a class="slide-item" href="{{ url('/vendor/product/pending') }}">Pending Product</a>
                            <a class="slide-item" href="{{ url('/vendor/product/verified') }}">Verified Product</a>
                            <a class="slide-item" href="{{ url('/vendor/product/add') }}">Add a Product</a>
                    </li>
                </ul>
            </li>

           <!-- <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                         width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41s-.23-1.06-.59-1.42zM13 20.01L4 11V4h7v-.01l9 9-7 7.02z"/><circle cx="6.5" cy="6.5" r="1.5"/></svg>
                         <span class="side-menu__label">Suggest Category</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/vendor/category') }}">Categories</a>
                    </li>
                </ul>
            </li>-->

            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                         width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                         <span class="side-menu__label">Orders</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/vendor/order/to-verify') }}">Order To Verify</a>

                       <!--<a class="slide-item" href="{{ url('/vendor/order/waiting-approval') }}">Waiting For
                            Approval</a>-->
                        <a class="slide-item" href="{{ url('/vendor/order/approved') }}">Order Approved</a>
                        <a class="slide-item" href="{{ url('/vendor/order/waiting-shipping') }}">Order Shipped</a>
                        <a class="slide-item" href="{{ url('/vendor/order/clarified') }}">Order To clarify</a>
                        <a class="slide-item" href="{{ url('/vendor/order/canceled') }}">Order Canceled</a>
                        <a class="slide-item" href="{{ url('/vendor/order/finished') }}">Order Finished</a>
                    </li>
                </ul>
            </li>

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
                        <a class="slide-item" href="{{ url('/vendor/orders/approved') }}">Order Opened</a>
                        <a class="slide-item" href="{{ url('/vendor/orders/shipped') }}">Order Shipped</a>
                        <a class="slide-item" href="{{ url('/vendor/orders/finished') }}">Order Compelete</a>
                    </li>
                </ul>
            </li>

            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><g><path d="M20,2H4C2.9,2,2,2.9,2,4v18l4-4h14c1.1,0,2-0.9,2-2V4C22,2.9,21.1,2,20,2z M20,16H5.17L4,17.17V4h16V16z"/><polygon points="12,15 13.57,11.57 17,10 13.57,8.43 12,5 10.43,8.43 7,10 10.43,11.57"/></g></g></svg>
                    <span class="side-menu__label">Review</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/vendor/review') }}">Your Review</a>
                        <a class="slide-item" href="{{ url('/vendor/product/review') }}">Product Review</a>
                    </li>
                </ul>
            </li>

            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                         width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path
                            d="M15 11V5l-3-3-3 3v2H3v14h18V11h-6zm-8 8H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm6 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm6 12h-2v-2h2v2zm0-4h-2v-2h2v2z"/>
                    </svg>
                    <span class="side-menu__label">Manufacturer</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/vendor/manufacturer') }}">Manufacturer</a>
                    </li>
                </ul>
            </li>

            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg  class="side-menu__icon"  xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                    <span class="side-menu__label">Supplier</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/vendor/supplier') }}">Supplier</a>
                    </li>
                </ul>
            </li>
            
            <li class="slide mt-3">
                <a class="side-menu__item" data-toggle="slide">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg"
                            enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0,0h24v24H0V0z" fill="none" /><path d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5zM19 19.09H5V4.91h14v14.18zM6 15h12v2H6zm0-4h12v2H6zm0-4h12v2H6z"/></svg>
                    <span class="side-menu__label">Archive</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="{{ url('/vendor/invoice') }}">Archive</a>
                    </li>
                </ul>
            </li>

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
                      
                        <a class="slide-item" href="{{ url('/vendor/stock/search-product') }}">Stock Management</a>
                    </li>
                </ul>
            </li>
        
        </ul>
    </aside>
    <!--aside closed-->
