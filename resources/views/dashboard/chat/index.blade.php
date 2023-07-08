@extends('dashboard.layout.layout')
@push('style')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
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

    {{--    @include('dashboard.orders.create')--}}
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3 message-threads px-1">
                                <ul class="list-group">
                                    @foreach($rooms as $room)
                                        @if(class_basename(get_class($room->sender)) == 'User')
                                                <?php
                                                $user = $room->sender;
                                                ?>
                                            <li class="list-group-item" data-thread-id="{{$room->id}}">
                                                {{$user->phone .' - '.  'عميل  '}}
                                                <br>{{$user->first_name.' '.$user->last_name}}
                                            </li>

                                        @else
                                                <?php
                                                $tech = $room->sender;
                                                ?>
                                            <li class="list-group-item" data-thread-id="{{$room->id}}">
                                                <img class="img-fluid mx-1"
                                                     style="border-radius: 50%; width: 20px; height: 20px"
                                                     src="{{asset($tech->image)}}" alt="">{{$tech->phone.' - '.'فني  '}}
                                                <br>{{$tech->name}}
                                            </li>

                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-9 messages px-1" id="big-box" data-room="{{$rooms->first()?->id}}">
                                <div class="message-box" id="message-box" style="overflow-y: scroll; max-height: 300px">
                                    @foreach($rooms->first()->messages as $message)
                                        @if($message->sent_by_admin)
                                            <div class="message sent">
                                                <div class="message-content">
                                                    <p class="text-white">{{$message->message}}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="message received">
                                                <div class="message-content">
                                                    <p>{{$message->message}}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="form-group row">
                                    <form class="col-md-12 message-form" id="message-form">
                                        <div class="col-md-8 p-0">
                                            <textarea id="sent-message" class="form-control m-0"
                                                      placeholder="اكتب رسالتك"></textarea>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                $('#big-box').attr('data-room', threadId)
                $.ajax({
                    url: '{{route('dashboard.chat.loadChat')}}',
                    type: 'get',
                    data: {room_id: threadId},
                    success: function (response) {
                        $('.message-box').empty();
                        $.each(response.messages, function (index, message) {
                            var messageClass = message.sent_by_admin ? 'sent' : 'received';
                            var color = message.sent_by_admin ? 'text-white' : '';
                            var messageContent = '<div class="message ' + messageClass + '"><div class="message-content"><p class="' + color + '">' + message.message + '</p></div></div>';
                            $('.message-box').append(messageContent);
                        });
                    }
                })
            });
        });
    </script>
    <script src="{{asset('js/app.js')}}"></script>
@endpush
