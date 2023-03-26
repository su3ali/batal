<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="#dashboard" data-active="true" data-toggle="collapse" aria-expanded="true"
                   class="dropdown-toggle noHover">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>{{__('dash.dashboard')}}</span>
                    </div>
                </a>
            </li>

            {{--            <li class="menu">--}}
            {{--                <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">--}}
            {{--                    <div class="">--}}
            {{--                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
            {{--                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
            {{--                             class="feather feather-cpu">--}}
            {{--                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>--}}
            {{--                            <rect x="9" y="9" width="6" height="6"></rect>--}}
            {{--                            <line x1="9" y1="1" x2="9" y2="4"></line>--}}
            {{--                            <line x1="15" y1="1" x2="15" y2="4"></line>--}}
            {{--                            <line x1="9" y1="20" x2="9" y2="23"></line>--}}
            {{--                            <line x1="15" y1="20" x2="15" y2="23"></line>--}}
            {{--                            <line x1="20" y1="9" x2="23" y2="9"></line>--}}
            {{--                            <line x1="20" y1="14" x2="23" y2="14"></line>--}}
            {{--                            <line x1="1" y1="9" x2="4" y2="9"></line>--}}
            {{--                            <line x1="1" y1="14" x2="4" y2="14"></line>--}}
            {{--                        </svg>--}}
            {{--                        <span>{{__('dash.core')}}</span>--}}
            {{--                    </div>--}}
            {{--                    <div>--}}
            {{--                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
            {{--                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
            {{--                             class="feather feather-chevron-right">--}}
            {{--                            <polyline points="9 18 15 12 9 6"></polyline>--}}
            {{--                        </svg>--}}
            {{--                    </div>--}}
            {{--                </a>--}}
            {{--                <ul class="collapse submenu list-unstyled" id="app" data-parent="#accordionExample">--}}
            {{--                    @can('view_setting')--}}
            {{--                        <li>--}}
            {{--                            <a href="{{route('dashboard.settings')}}"> {{__('dash.settings')}} </a>--}}
            {{--                        </li>--}}
            {{--                    @endcan--}}
            {{--                </ul>--}}
            {{--            </li>--}}
            <li class="menu">
                <a href="#admin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="admin" data-parent="#accordionExample">
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
            @can('view_setting')
                <li class="menu">
                    <a href="{{route('dashboard.settings')}}" aria-expanded="false"
                       class="dropdown-toggle">
                        <div class="">
                            <div class="icon-container">
                                <i data-feather="settings"></i><span
                                    class="icon-name">{{trans('dash.settings')}} </span>
                            </div>
                        </div>
                    </a>
                </li>
            @endcan

        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
