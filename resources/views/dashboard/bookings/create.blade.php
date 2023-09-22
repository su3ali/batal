@extends('dashboard.layout.layout')

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

                                <li class="breadcrumb-item"><a
                                        href="{{route('dashboard.bookings.index')}}">الحجوزات</a></li>
                                <li class="breadcrumb-item active" aria-current="page">إنشاء حجز</li>
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
                <div class="widget-content widget-content-area br-6" style="min-height: 500px;">
                    <div class="col-md-12 text-left mb-3">
                        <h3>إنشاء حجز جديد</h3>
                    </div>
                    <div class="col-md-8">
                        <form action="{{route('dashboard.bookings.store')}}" method="post" class="form-horizontal"

                              enctype="multipart/form-data" id="create_order_status_form" data-parsley-validate="">
                            @csrf
                            <div class="box-body">

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">

                                        <label for="customer_name">الطلب</label>
                                        <select required class="select2 form-control pt-1"
                                                name="order_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($orders as $order)
                                                <option value="{{$order->id}}">{{'الطلب رقم: '.$order->id}}</option>
                                            @endforeach
                                        </select>
                                        @error('order_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-6">

                                        <label for="customer_name">{{__('dash.customer_name')}}</label>
                                        <select required id="customer_name" class="select2 form-control pt-1"
                                                name="user_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">

                                        <label for="service">الخدمة</label>
                                        <select required class="select2 form-control pt-1"
                                                name="service_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group col-md-6">

                                        <label>الفريق الفني</label>
                                        <select required class="select2 form-control pt-1"
                                                name="group_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('group_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                                <div class="form-row mb-3">


                                    <div class="form-group col-md-4">

                                        <label for="birth">التاريخ</label>
                                        <input required name="date" type="date" class="form-control datepicker"
                                               data-date-format="dd/mm/yyyy">
                                        @error('date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="birth">الوقت</label>
                                        <input required name="time" type="time" class="form-control timepicker"
                                               data-date-format="h:i">
                                        @error('time')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="form-group col-md-4">

                                        <label for="service">حالة الحجز</label>
                                        <select required class="select2 form-control pt-1"
                                                name="booking_status_id">
                                            <option selected disabled>{{__('dash.choose')}}</option>
                                            @foreach($statuses as $status)
                                                <option value="{{$status->id}}">{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('booking_status_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                                <div class="form-row mb-3">

                                    <div class="form-group col-md-12">

                                        <label for="notes">ملاحظات</label>
                                        <textarea name="notes" cols="30" rows="2" class="form-control"></textarea>
                                        @error('notes')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>

                            </div>
                            <div class="box-body">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label
                                            class="new-control new-checkbox new-checkbox-text checkbox-success">
                                            <input
                                                type="checkbox"
                                                name="notify"
                                                class="new-control-input perm-check perm-check-admins"
                                            >
                                            <span
                                                class="new-control-indicator"></span><span
                                                class="new-chk-content"><strong>إرسال إخطار SMS إلى العميل</strong></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-row mb-3">
                                    <div class="col-md-6">
                                    </div>

                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary">{{__('dash.save')}}</button>
                                        <button class="btn" data-dismiss="modal"><i
                                                class="flaticon-cancel-12"></i> {{__('dash.close')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection

