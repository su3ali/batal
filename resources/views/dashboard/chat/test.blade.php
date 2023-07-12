@extends('dashboard.layout.layout')
@push('style')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="{{asset(app()->getLocale().'/assets/css/chat.css')}}" rel="stylesheet" type="text/css"/>
@endpush
@section('sub-header')
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">

            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.home')}}">{{__('dash.home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">الرسائل</li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>


        </header>
    </div>
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <div id="frame">
                    <div id="sidepanel">
                        <div id="profile">
                            <p> {{\App\Models\Setting::query()->first()?\App\Models\Setting::query()->first()->name : 'site name'}} </p>
                        </div>
                        <div id="search">
                            <input type="text" name="search" placeholder="بحث"/>
                            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                        </div>
                        <div id="message-threads" class="message-threads"
                             data-admin="{{\Illuminate\Support\Facades\Auth::user()->id}}">

                            <ul id="message-thread">

                                @foreach($rooms as $room)
                                    @if(class_basename(get_class($room->sender)) == 'User')
                                            <?php
                                            $user = $room->sender;
                                            ?>
                                        <li class="contact" data-thread-id="{{$room->id}}">
                                            <div class="wrap">
                                                <span class="contact-status online"></span>

                                                @if($user->image)
                                                    <img src="{{asset($user->image)}}" alt=""/>
                                                @else
                                                    <img src="{{asset('images/user.jpg')}}" alt=""/>
                                                @endif
                                                <div class="meta">
                                                    <p class="name">{{$user->phone .' - '.  'عميل  '}}
                                                        <br>{{$user->first_name.' '.$user->last_name}}</p>
                                                    {{--<p class="preview">هنا يوجد جزء من اخر رسالة</p>--}}
                                                </div>
                                            </div>
                                        </li>

                                    @else
                                            <?php
                                            $tech = $room->sender;
                                            ?>
                                        <li class="contact" data-thread-id="{{$room->id}}">
                                            <div class="wrap">
                                                <span class="contact-status online"></span>
                                                @if($tech->image)
                                                    <img src="{{asset($tech->image)}}" alt=""/>
                                                @else
                                                    <img src="{{asset('images/techn.png')}}" alt=""/>

                                                @endif
                                                <div class="meta">
                                                    <p class="name">{{$tech->phone .' - '.  'فني'}}
                                                        <br>{{$tech->name}}</p>
                                                    {{--<p class="preview">هنا يوجد جزء من اخر رسالة</p>--}}
                                                </div>
                                            </div>
                                        </li>

                                    @endif
                                @endforeach

                            </ul>
                        </div>

                    </div>

                    <div class="content">
                        <div class="contact-profile">
                            @if(class_basename(get_class($rooms->first()->sender)) == "User")
                                    <?php
                                    $user = $rooms->first()->sender;
                                    ?>
                                @if($user->image)
                                    <img src="{{asset($user->image)}}" alt=""/>
                                @else
                                    <img src="{{asset('images/user.jpg')}}" alt=""/>

                                @endif
                            <p style="margin-top: 15px;" class="name-choose">{{$user->first_name .' '. $user->last_name}} </p>
                            @else
                                    <?php
                                    $tech = $rooms->first()->sender;
                                    ?>
                                @if($tech->image)
                                    <img src="{{asset($tech->image)}}" alt=""/>
                                @else
                                    <img src="{{asset('images/techn.png')}}" alt=""/>

                                @endif
                                <p style="margin-top: 15px;" class="name-choose">{{$tech->name}} </p>
                            @endif
                        </div>
                        <div class="messages" id="big-box" data-room="{{$rooms->first()?->id}}">
                            <ul class="message-box" id="message-box">

                                @if($rooms->first())
                                    @foreach($rooms->first()->messages as $message)
                                        @if($message->sent_by_admin)
                                            <li class="message sent">
                                                <img src="{{asset('images/user.jpg')}}" alt=""/>
                                                <p>{{$message->message}}</p>
                                            </li>
                                        @else
                                            <li class="message replies received">
                                                <img src="{{asset('images/user.jpg')}}" alt=""/>
                                                <p>{{$message->message}}</p>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        @if($rooms->first())
                            <form class="message-form" id="message-form">
                                <div class="message-input">
                                    <div class="wrap">
                                        <input id="sent-message" placeholder="اكتب رسالتك ...."/>
{{--                                        <i class="fa fa-paperclip attachment" aria-hidden="true"></i>--}}
                                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function () {
// Select the first thread by default
            $('.message-threads li:first-child').addClass('active');
            //load messages

// Handle thread selection
            $('.message-threads li').click(function () {
                $('.message-threads li').removeClass('active');
                $(this).addClass('active');
                let threadId = $(this).data('thread-id');
                let senderId = $(this).data('sender-id');
                $('#big-box').attr('data-room', threadId)
                $.ajax({
                    url: '{{route('dashboard.chat.loadChat')}}',
                    type: 'get',
                    data: {room_id: threadId},
                    success: function (response) {
                        $('.name-choose').empty();
                        $('.message-box').empty();

                            if(response.sender.model_name == 'User'){
                                $('.name-choose').html(response.sender.first_name  + ' ' + response.sender.last_name);
                            }else if(response.sender.model_name == 'Technician'){
                                $('.name-choose').html(response.sender.name);
                            }

                        $.each(response.messages, function (index, message) {
                            var messageClass = message.sent_by_admin ? 'sent' : 'received replies';
                            var color = message.sent_by_admin ? 'text-white' : '';
                            var img = '{{asset('images/user.jpg')}}';
                            // var messageContent = '<div class="message ' + messageClass + '"><div class="message-content"><p class="' + color + '">' + message.message + '</p></div></div>';
                            var messageContent = '<li class="message ' + messageClass + '"><img src="'+img+'" alt=""/> <p>' + message.message + '</p></li>';
                            $('.message-box').append(messageContent);
                        });
                    }
                })
            });
        });
    </script>
    <script src="{{asset('js/app.js')}}"></script>
@endpush
