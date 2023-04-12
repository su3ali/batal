<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>

        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu">
                <a href="{{route('dashboard.home')}}"  aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>{{__('dash.dashboard')}}</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-lock">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>{{__('dash.administration')}}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="app" data-parent="#accordionExample">
                    @can('view_admins')
                        <li>
                            <a href="{{route('dashboard.core.administration.admins.index')}}"> {{__('dash.admins')}} </a>
                        </li>
                    @endcan
                    @can('view_roles')
                        <li>
                            <a href="{{route('dashboard.core.administration.roles.index')}}"> {{__('dash.roles')}} </a>
                        </li>
                    @endcan

                </ul>
            </li>


            <li class="menu">
                <a href="#admin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>

                        <span>{{__('dash.categories')}}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="admin" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.core.category.index')}}"> {{__('dash.category')}} </a>
                    </li>
                </ul>
            </li>


            <li class="menu">
                <a href="#service" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>

                        <span>{{__('dash.Service Management')}}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="service" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.core.service.index')}}"> {{__('dash.Services')}} </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#tech" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <div class="icon-container">
                            <i data-feather="users"></i>
                            <span class="icon-name">{{__('dash.technicians')}}</span>
                        </div>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="tech" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.core.technician.index')}}"> {{__('dash.technicians')}} </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.core.group.index')}}"> {{__('dash.technicians_groups')}} </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.core.tech_specializations.index')}}"> تخصصات الفنيين </a>
                    </li>
                </ul>
            </li>
            <li class="menu">
                <a href="#orders" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <div class="icon-container">
                            <i data-feather="archive"></i><span class="icon-name"> الطلبات </span>
                        </div>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="orders" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.orders.index')}}"> الطلبات </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.order_statuses.index')}}"> حالات الطلب </a>
                    </li>
                </ul>
            </li>
            <li class="menu">
                <a href="#booking" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <div class="icon-container">
                            <i data-feather="archive"></i><span class="icon-name"> الحجوزات </span>
                        </div>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="booking" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.bookings.index')}}"> الحجوزات </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.booking_statuses.index')}}"> حالات الحجز </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.booking_setting.index')}}"> اعدادات الحجوزات </a>
                    </li>
                </ul>
            </li>



            <li class="menu">
                <a href="#wallet" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>

                        <span>{{__('dash.Wallet Management')}}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="wallet" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.core.customer_wallet.index')}}"> {{__('dash.customers wallet')}} </a>
                    </li>

                    <li>
                        <a href="{{route('dashboard.core.technician_wallet.index')}}"> {{__('dash.technicians wallet')}} </a>
                    </li>

                </ul>
            </li>

            <li class="menu">
                <a href="#customer" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>

                        <span>{{__('dash.Customer Management')}}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="customer" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.core.customer.index')}}"> {{__('dash.Customers')}} </a>
                    </li>


                </ul>
            </li>


            <li class="menu">
                <a href="#contract" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>

                        <span>إدارة العقود</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="contract" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.contract_packages.index')}}"> باقات العقود </a>
                    </li>

                    <li>
                        <a href="{{route('dashboard.contracts.index')}}"> العقود </a>
                    </li>


                </ul>
            </li>


            <li class="menu">
                <a href="#setting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>

                        <span>{{__('dash.System settings')}}</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="setting" data-parent="#accordionExample">
                    <li>
                        <a href="{{route('dashboard.country.index')}}"> {{__('dash.Countries')}} </a>
                    </li>

                    <li>
                        <a href="{{route('dashboard.city.index')}}"> {{__('dash.Cities')}} </a>
                    </li>

                    <li>
                        <a href="{{route('dashboard.region.index')}}"> {{__('dash.Regions')}} </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.core.measurements.index')}}"> وحدات القياس </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.faqs.index')}}">الأسئلة الشائعة</a>
                    </li>



                </ul>
            </li>



            {{--@can('view_setting')--}}
                {{--<li class="menu">--}}
                    {{--<a href="{{route('dashboard.settings')}}" aria-expanded="false"--}}
                       {{--class="dropdown-toggle">--}}
                        {{--<div class="">--}}
                            {{--<div class="icon-container">--}}
                                {{--<i data-feather="settings"></i><span--}}
                                    {{--class="icon-name">{{trans('dash.settings')}} </span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--@endcan--}}

        </ul>

    </nav>

</div>

<!--  END SIDEBAR  -->
