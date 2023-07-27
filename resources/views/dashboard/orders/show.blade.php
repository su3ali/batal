@extends('dashboard.layout.layout')
@push('style')
    <link href="{{asset('css/VisitShowStyle.css')}}" rel="stylesheet" type="text/css"/>
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
                                <li class="breadcrumb-item active" aria-current="page">عرض الطلب</li>
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
                <div class="widget-content widget-content-area br-6">
                    <div class="card">
                        <div class="card-header">

                            <div class="row">
                                <div class="col-md-5">
                                    <h3 class="card-title">تفاصيل الطلب</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <table class="table table-bordered nowrap">

                                <thead>

                                <tr>
                                    <th>اسم العميل</th>
                                    <td>{{$order->user?->first_name . '' .$order->user?->last_name}}</td>
                                </tr>
                                <tr>
                                    <th>حاله الطلب</th>
                                    <td>{{$order->status?->name}}</td>
                                </tr>
                                <tr>
                                    <th>الاجمالي</th>
                                    <td>{{$order->sub_total}}</td>
                                </tr>
                                <tr>
                                    <th>الاجمالي بعد الخصم</th>
                                    <td>{{$order->total}}</td>
                                </tr>
                                <tr>
                                    <th>نوع الدفع</th>
                                    <td>{{$order->payment_status}}</td>
                                </tr>
                                @if($order->partial_amount > 0)
                                <tr>
                                    <th>الباقي</th>
                                    <td>{{$order->partial_amount}}</td>
                                </tr>
                                @endif

                                <tr>
                                        <th>اسماء الخدمات</th>

                                        <td>
                                            @foreach($order->services as $service)
                                                <button class="btn-sm btn-primary">{{$service->title}}</button>
                                            @endforeach
                                        </td>

                                </tr>

                                <tr>
                                    <th>صوره المرفقه</th>
                                    <td><img class="img-fluid" style="width: 40px;" src="{{asset($order->image)}}"></td>
                                </tr>

                                </thead>

                            </table><!-- end of table -->


                        </div>
                        <!-- /.card-body -->
                    </div>
                    @if($order->file != null)
                    <div class="card">
                        <div class="card-header">

                            <div class="row">
                                <div class="col-md-5">
                                    <h3 class="card-title">عرض الفيديو</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0" style="margin: auto">

                            <video width="500" height="240" controls>
                                <source src="{{URL::asset($order->file)}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    @endif

                </div>
            </div>




        </div>

    </div>
@endsection
