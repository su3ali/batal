<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            @if(\App\Models\Setting::first()->logo != null)
            <li class="nav-item">
                <a href="{{route('dashboard.home')}}" class="nav-link logo">
                    <img src="{{asset(\App\Models\Setting::first()->logo)}}" class="flag-width" alt="flag">
                </a>
            </li>
            @endif
            <li class="nav-item theme-text">
                <a href="{{route('dashboard.home')}}" class="nav-link"> {{\App\Models\Setting::first()->$name}} </a>
            </li>
        </ul>
        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">
                @if(app()->getLocale() == 'ar')
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset(app()->getLocale().'/assets/img/ksa-circle.png')}}" class="flag-width" alt="flag">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <a class="dropdown-item d-flex" href="{{route('dashboard.lang', 'en')}}"><img
                                src="{{asset(app()->getLocale().'/assets/img/ca.png')}}" class="flag-width" alt="flag">
                            <span class="align-self-center">&nbsp;English</span></a>
                    </div>
                @else
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset(app()->getLocale().'/assets/img/ca.png')}}" class="flag-width" alt="flag">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <a class="dropdown-item d-flex" href="{{route('dashboard.lang', 'ar')}}"><img
                                src="{{asset(app()->getLocale().'/assets/img/ksa-circle.png')}}" class="flag-width" alt="flag">
                            <span class="align-self-center">&nbsp;English</span></a>
                    </div>
                @endif

            </li>

            {{--<li class="nav-item dropdown message-dropdown">--}}
                {{--<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown"--}}
                   {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                    {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
                         {{--stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
                         {{--class="feather feather-mail">--}}
                        {{--<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>--}}
                        {{--<polyline points="22,6 12,13 2,6"></polyline>--}}
                    {{--</svg>--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu position-absolute" aria-labelledby="messageDropdown">--}}
                    {{--<div class="">--}}
                        {{--@foreach($messages as $message)--}}
                            {{--<a class="dropdown-item" href="{{route('dashboard.core.contacts.show', $message->id)}}">--}}
                                {{--<div class="">--}}

                                    {{--<div class="media">--}}
                                        {{--<div class="user-img">--}}
                                            {{--<div class="avatar avatar-xl">--}}
                                                {{--<span class="avatar-title rounded-circle">--}}
                                                    {{--{{strtoupper(mb_substr($message->first_name, 0, 1)).strtoupper(mb_substr($message->last_name, 0, 1))}}--}}
                                                {{--</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="media-body">--}}
                                            {{--<div class="">--}}
                                                {{--<h5 class="usr-name">{{$message->first_name.' '.$message->last_name}}</h5>--}}
                                                {{--<p class="msg-title">{{substr($message->message, 0, 15)}}</p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                {{--</div>--}}
                            {{--</a>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}

            {{--<li class="nav-item dropdown notification-dropdown">--}}
                {{--<a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"--}}
                   {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                    {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"--}}
                         {{--stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"--}}
                         {{--class="feather feather-bell">--}}
                        {{--<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>--}}
                        {{--<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>--}}
                    {{--</svg>--}}
                    {{--@if(in_array(0, $notifies->pluck('is_seen')->toArray()))--}}
                        {{--<span class="badge badge-success"></span>--}}
                    {{--@endif--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">--}}
                    {{--<div class="notification-scroll">--}}
                        {{--@foreach($notifies as $notify)--}}
                            {{--<a class="dropdown-item" href="{{route('dashboard.core.notifications.show', $notify->id)}}">--}}
                                {{--<div class="media file-upload">--}}
                                    {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
                                         {{--fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                                         {{--stroke-linejoin="round" class="feather feather-file-text">--}}
                                        {{--<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>--}}
                                        {{--<polyline points="14 2 14 8 20 8"></polyline>--}}
                                        {{--<line x1="16" y1="13" x2="8" y2="13"></line>--}}
                                        {{--<line x1="16" y1="17" x2="8" y2="17"></line>--}}
                                        {{--<polyline points="10 9 9 9 8 9"></polyline>--}}
                                    {{--</svg>--}}
                                    {{--<div class="media-body">--}}
                                        {{--<div class="data-info">--}}
                                            {{--<h6 class="">{{$notify->title}}</h6>--}}
                                            {{--<p class="">{{substr($notify->description, 0, 25)}}</p>--}}
                                        {{--</div>--}}

                                        {{--<div class="icon-status">--}}
                                            {{--@if($notify->is_seen == 1)--}}
                                                {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
                                                     {{--viewBox="0 0 24 24" fill="none" stroke="currentColor"--}}
                                                     {{--stroke-width="2"--}}
                                                     {{--stroke-linecap="round" stroke-linejoin="round"--}}
                                                     {{--class="feather feather-check">--}}
                                                    {{--<polyline points="20 6 9 17 4 12"></polyline>--}}
                                                {{--</svg>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img
                        src="{{auth('dashboard')->user()->avatar? : asset(app()->getLocale().'/assets/img/90x90.jpg')}}"
                        alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{route('dashboard.core.administration.profile.edit', auth()->user()->id)}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                {{__('dash.profile')}}</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="{{route('dashboard.logout')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                {{__('dash.signout')}}</a>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </header>
</div>


